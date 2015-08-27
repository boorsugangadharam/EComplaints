<?php
	session_start();
	require_once("include/configuration.php");
	require_once("include/functions.php");
	error_reporting_mode();
	getsiteconfiguration();
	
	if($_SESSION["username"] == null || $_SESSION["userid"] == null || $_SESSION["email"] == null)
		{
			$_SESSION["warning_message"] = "Please Login!";
			redirect_to("login.php");
			
		}
	
	
	$table_name = "users";
	$ref_column = "username";
	$ref_value = $_SESSION["username"];
	$userid = $_SESSION["userid"];
	$email = $_SESSION["email"];
	$username = $_SESSION["username"];
	$type = $_SESSION["type"];
	$deptid = $_SESSION["deptid"];
	
	if(isset($_POST["postcomplaint"]))
		{
			$userid_client = $_POST["userid"];
			$subject = $_POST["subject"];
			$subject1 = $subject;
			$body = $_POST["body"];
			$body1 = $body;
			
			$deptid = $_POST["deptid"];
			$clientipaddress = $_POST["clientipaddress"];
		
			//validation
			
			$errors = array();
			if($userid_client == $userid)
				{
					$errors["cheating"] = "You are cheating Complaint is posted to admin";
					databaseconnectivity_open();
					global $connection;
					$query = "UPDATE `users` SET `block`= 1 WHERE `username` = \"".$username."\" LIMIT 1";
					
					$result = mysqli_query($connection, $query);
					mysqli_free_result($result);
		
					databaseconnectivity_close();
				}
			if(!isset($subject[5]) || isset($subject[30]))
				{
    			$errors["subject"] = "subject is too long / short!";
				}
			if(!isset($body[15]) || isset($email[140]))
				{
    			$errors["body"] = "Body is too long / short!";
				}
			if(!isset($deptid))
				{
    			$errors["dept"] = "Please select department!";
				}
				
			if(empty($errors))
				{
					databaseconnectivity_open();
					global $connection;
			
					$subject = mysqli_real_escape_string($connection, $subject);
					$body = mysqli_real_escape_string($connection, $body);
					
					$clientipaddress = mysqli_real_escape_string($connection, $clientipaddress);
					$date = date("d-m-Y")." ".date("h:i:s a")." ".date("l");
					$status = "inactive"; $feedback = "0"; $traversaldetails = $clientipaddress;
					$query = "INSERT INTO `complaints`(`userid`, `deptid`, `status`, `subject`, `body`, `feedback`, `traversaldetails`, `date`) VALUES (";
					$query .= $userid .",";
					$query .= $deptid .",\"";
					$query .= $status ."\",\"";
					$query .= $subject."\",\"";
					$query .= $body."\",\"";
					$query .= $feedback."\",\"";
					$query .= $traversaldetails."\",\"";
					$query .= $date."\")";
					
					$result = mysqli_query($connection, $query);
					if(!$result)
						{
						$_SESSION["error_number"] = "2010";
						$_SESSION["error_message"] = "Query failed while posting complaint in database".$query . mysqli_error($connection);
						
						$string = "error.php?error_number=";
						$string .= urlencode("DB_Query_Failed");
						$string .= "&error_message=";
						$string .= urlencode("Query failed while posting complaint in database");
						
						redirect_to($string);
						}
				
					mysqli_free_result($result);
					
					databaseconnectivity_close();
					
					$to = "{$email}" ;
					//send email to users who has dept id is equal to posted complaint department id
					$result = sendmail($to, $subject1, $body1);
					
					$_SESSION["postcomplaint"] = "success";
			 }
			
		}
	echo header_page();

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
		
		
	
		
		
//sidebar and navigation bar
echo navigation($block, $aadhar, $username, $deptid, $status, $verificationkey);
echo sidebar($block, $aadhar, $username, $deptid, $status, $verificationkey);


echo "<div class=\"col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main\">";






	if($block == "1")
		{
			$error_message = "Admin is blocked you please contact us in contact areas about your problem!";
			echo"<div class=\"col-lg-8\">";
			echo"<div class=\"panel panel-danger\">";
            echo"<div class=\"panel-heading\">";
            echo"You are blocked";
            echo"</div>";
            echo"<div class=\"panel-body\">";
            echo"<p>{$error_message}</p>";
            echo"</div>";
            echo"<div class=\"panel-footer\">";
            echo"<a href=\"contact.php\">Contact Admin</a>";            
            echo"</div>";
            echo"</div>";
			echo"</div>";
			
			
		}
	else
		{
			if($status == "0" && $verificationkey != "0")
				{
					//check verification key and status
					redirect_to("validateemail.php");
				}
			else
				{
					//display post complaint form
					
					
                    
                    
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
						
						if($_SESSION["postcomplaint"] == "success")
                        {
                        echo "<div class=\"form-group\">";
                        echo "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
                        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
                        echo "<strong>";
                        echo "Complaint successfully posted!";
                        echo "</strong>";
                        
                        echo "</div>";
                    
                        echo "</div>";
                        $_SESSION["postcomplaint"] = null;
                        }
                    ?>
                     <form role="form" class="form-horizontal col-sm-6" name="postcomplaint" method="post" action="postcomplaint.php">
                     
                  <div class="form-group">
                        <label for="userid" class ="control-label">User ID</label>
                       	
                            <input name="userid" type="text" class="form-control" id = "userid" placeholder="User ID" value="<?php echo $userid; ?>" disabled>
                          
                     	
                      </div>
                      
        		<div class="form-group">
          			<label for="subject">Subject:</label>
          			<input type="text" name="subject" class="form-control" id="subject" placeholder="Enter name" size="20" required>
        		</div>
        	
              <div class="form-group">
      				<label for="body">Body:</label>
      				<textarea class="form-control" rows="5" id="body" name="body" required></textarea>
    			</div>
                
                 <div class="form-group">
                        <label for="datetime" class ="control-label">Date & Time</label>
                       		
                            <input name="datetime" type="text" class="form-control" id = "datetime" placeholder="Date & Time" value="<?php $date = date("d-m-Y")." ".date("h:i:s a")." ".date("l"); echo $date; ?>" disabled>
                          
                     		
                      </div>
                      
                  <div class="form-group">
                                            <label>Select Department</label>
                                            <select class="form-control" name="deptid" required>
                                            <option></option>
                                            <?php
                                            databaseconnectivity_open();
		
											global $connection;
											$query = "SELECT * FROM departments where visibility !=0";
											$result = mysqli_query($connection, $query);
											if(!$result)
												{
												$_SESSION["error_number"] = "2011";
												$_SESSION["error_message"] = "Query failed while getting departments";
			
												$string = "error.php?error_number=";
												$string .= urlencode("DB_Query_Failed");
                                                $string .= "&error_message=";
                                                $string .= urlencode("Query failed while getting departments");
                                                
                                                redirect_to($string);
                                                }
                                            else
                                                {
                                                    while($row = mysqli_fetch_assoc($result))
                                                        {
															echo "<option value=\"".$row["deptid"]."\">".$row["deptname"]."</option>";
														}
												}
												
											mysqli_free_result($result);
											
											databaseconnectivity_close();
                                                  ?>      
                                            
                                            </select>
                  </div>
                	<input type="hidden" name="clientipaddress" class="form-control" value="<?php echo $_SERVER['REMOTE_ADDR']; echo get_client_ip_server(); echo get_client_ip_env();?>">
                    
        			<button type="submit" class="btn btn-default" name="postcomplaint">Submit</button>
                    <button type="reset" class="btn btn-danger" name="reset">Reset</button>
		 </form>
       
                   <?php
				}
			
		}
	
		
		
	  echo"</div>";
	  
	  echo footer();

?>

