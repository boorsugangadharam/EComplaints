<?php
session_start();
require_once("include/configuration.php");
require_once("include/functions.php");
error_reporting_mode();
getsiteconfiguration();


  
	$table_name = "users";
	$ref_column = "username";
	$ref_value = $_SESSION["username"];
	$userid = $_SESSION["userid"];
	$email = $_SESSION["email"];
	$username = $_SESSION["username"];
	$type = $_SESSION["type"];
	$deptid = $_SESSION["deptid"];
	$aadhar = null;$status = null;$verificationkey = null;$block = null; $address = null; $phno = null; $gender = null;
if(isset($_SESSION["username"]))
	{
		$q = fetch_data(aadhar, $ref_column, $ref_value, $table_name);
	if($q!=null)
		{
			$aadhar = $q;
		}
	else
		{
			echo "failed fetch aadhar details";
		}
		
	$q = fetch_data(status, $ref_column, $ref_value, $table_name);
	if($q!=null)
		{
			$status = $q;
		}
	else
		{
			echo "failed fetch status details";
		}
	$q = fetch_data(verificationkey, $ref_column, $ref_value, $table_name);
	if($q!=null)
		{
			$verificationkey = $q;
		}
	else
		{
			echo "failed fetch verification key details";
		}
	$q = fetch_data(block, $ref_column, $ref_value, $table_name);
	if($q!=null)
		{
			$block = $q;
		}
	else
		{
			echo "failed fetch block details";
		}
	$q = fetch_data(address, $ref_column, $ref_value, $table_name);
	if($q!=null)
		{
			$address = $q;
		}
	else
		{
			echo "failed fetch address details";
		}
		
	$q = fetch_data(phno, $ref_column, $ref_value, $table_name);
	if($q!=null)
		{
			$phno = $q;
		}
	else
		{
			echo "failed fetch phone number details";
		}
	$q = fetch_data(gender, $ref_column, $ref_value, $table_name);
	if($q!=null)
		{
			$gender = $q;
		}
	else
		{
			echo "failed fetch gender details";
		}
		
	}



echo header_page();
echo navigation($block, $aadhar, $username, $deptid, $status, $verificationkey);
echo sidebar($block, $aadhar, $username, $deptid, $status, $verificationkey);


if(isset($_POST["contact"]))
	{
		$name = $_POST["name"];
		$email = $_POST["email"];
		$message = $_POST["message"];
		
		$clientipaddress = $_POST["clientipaddress"];
		$clientipaddressbyipserver = $_POST["clientipaddressbyipserver"];
		$clientipaddressbyipenv = $_POST["clientipaddressbyipenv"];
		$clientipaddress = ipaddress_details($clientipaddress);
		$clientipaddressbyipserver = ipaddress_details($clientipaddressbyipserver);
		$clientipaddressbyipenv = ipaddress_details($clientipaddressbyipenv);
		
		$errors = array();
		if(!isset($name[2]) || isset($name[25]))
			{
    		$errors["name"] = "Name is too long / too short!";
			}
		if(!isset($email[4]) || isset($email[30]))
			{
    		$errors["email"] = "Email is too long / short!";
			}
		if(!isset($message[10]) || isset($message[35]))
			{
    		$errors["message"] = "Message is too long / too short!";
			}
		
		if(empty($errors))
		{
				databaseconnectivity_open();
				global $connection;
		
				$name = mysqli_real_escape_string($connection, $name);
				$message = mysqli_real_escape_string($connection, $message);
				$email = mysqli_real_escape_string($connection, $email);
				
				$clientipaddress = mysqli_real_escape_string($connection, $clientipaddress);
				$clientipaddressbyipserver = mysqli_real_escape_string($connection, $clientipaddressbyipserver);
				$clientipaddressbyipenv = mysqli_real_escape_string($connection, $clientipaddressbyipenv);
				if(!isset($userid))
					{
						$userid = "0";
					}
				$date = date("d-m-Y")." ".date("h:i:s a")." ".date("l");
				
				$reply = "0";
		$query = "INSERT INTO `contact`(`username`, `subjects`, `ipaddress1`, `ipaddress2`, `ipaddress3`, `userid`, `email`, `date`, `reply`) VALUES (\"";
		$query .= $name ."\",\"";
		$query .= $message ."\",\"";
		$query .= $ipaddress1 ."\",\"";
		$query .= $ipaddress2."\",\"";
		$query .= $ipaddress3."\",\"";
		$query .= $userid."\",\"";
		$query .= $email."\",\"";
		$query .= $date."\",\"";
		$query .= $reply."\")";
	
		
		$result = mysqli_query($connection, $query);
		if(!$result)
			{
			$_SESSION["error_number"] = "2007";
			$_SESSION["error_message"] = "Query failed while inserting contact in database". mysqli_error($connection);
			
			$string = "error.php?error_number=";
			$string .= urlencode("DB_Query_Failed");
			$string .= "&error_message=";
			$string .= urlencode("Query failed while inserting contact in database");
			
			redirect_to($string);
			}
	
		mysqli_free_result($result);
		
		databaseconnectivity_close();
		
		$to = "{$_SESSION['supportemail']} , {$email}" ;
		$subject = "Support is needed to {$name} !";
		$result = sendmail($to, $subject, $message);
		$status = "success";
		}
		
	}



?>



<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

<?php


if(!empty($errors))
				{
				echo "<div class=\"form-group\">";
            	echo "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
  				echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
  				echo "<strong>";
				echo " Please review following errors<br>";
				 foreach ($errors as $error) 
					{
    				echo $error . "<br>";
					} 
				echo "</strong>";
				
				echo "</div>";
            
            	echo "</div>";
				
				}
				
				
				if($status=="success")
				{
				echo "<div class=\"form-group\">";
            	echo "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
  				echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
  				echo "<strong> Contact request sucessfully taken with your email address.";
				
				echo "</strong>";
				
				echo "</div>";
            
            	echo "</div>";
				
				}

?>

          <h2 class="sub-header">Contact us</h2>
          <form role="form" class="form-horizontal col-sm-6" name="contact" method="post" action="contact.php">
        		<div class="form-group">
          			<label for="name">Name:</label>
          			<input type="text" name="name" class="form-control" id="name" placeholder="Enter name" size="20" value="<?php echo $_SESSION["username"]; ?>">
        		</div>
        		<div class="form-group">
          			<label for="email">Email:</label>
          			<input type="email" name="email" class="form-control" id="email" placeholder="Enter email" size="20" value="<?php echo $_SESSION["email"]; ?>">
        		</div>
              <div class="form-group">
      				<label for="message">Message:</label>
      				<textarea class="form-control" rows="5" id="message" name="message"></textarea>
    			</div>
                	<input type="hidden" name="clientipaddress" class="form-control" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
                    <input type="hidden" name="clientipaddressbyipserver" class="form-control" value="<?php echo get_client_ip_server(); ?>">
                    <input type="hidden" name="clientipaddressbyipenv" class="form-control" value="<?php echo get_client_ip_env(); ?>">
                    
                    <!--label for="reply">Reply:</label>
                    <textarea class="form-control" rows="5" id="reply" name="reply"></textarea-->
                    
        			<button type="submit" class="btn btn-default" name="contact">Submit</button>
                    <button type="reset" class="btn btn-danger" name="reset">Reset</button>
		 </form>
       
        </div>
      </div>
    </div>
    
<?php

echo footer();
?>