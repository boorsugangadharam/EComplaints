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
		
		
		
		
	if(isset($_POST["verificationkey"]))
		{
			$verificationkey = $_POST["verificationkey"];
			$errors = array();
			$q = fetch_data(verificationkey, $ref_column, $ref_value, $table_name);
			if($q!=null)
				{
				$verificationkey_db = $q;
				if($verificationkey_db == $verificationkey)
					{
						$update_result = update_field(verificationkey, 0, username, $username, $table_name);
						if($update_result == true)
							{
								$update_result = update_field(status, 1, username, $username, $table_name);
								if($update_result == true)
									{
										$success["email"] = "Email is sucessfully validated!";
									}
								else
									{
										$errors["status"] = "Failed to set status";
									}
							}
						else
							{
								$errors["validationkey"] = "failed to set verification key";
							}
					}
				else
					{
						$errors["validationkey1"] = "Invalid verification key!";
					}
				}
			else
				{
				$errors["validationkey2"] = "failed fetch verification key details";
				}
		}
	
	
echo header_page();	
		
echo navigation($block, $aadhar, $username, $deptid, $status, $verificationkey);
echo sidebar($block, $aadhar, $username, $deptid, $status, $verificationkey);
echo "<div class=\"col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main\">";
		
          echo "<h2 class=\"sub-header\">Validate Email</h2>";
		  
		  
		  
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
				
			if(isset($success["email"]))
				{
				echo "<div class=\"form-group\">";
            	echo "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
  				echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
  				echo "<strong>";
				
    			echo $success["email"];
				echo "<br>please press F5 Functional key (or) refresh page";
				echo "</strong>";
				
				echo "</div>";
            
            	echo "</div>";
				
				}
			else{	
					$error_mesasge = "<p>Please verify email address and entercode</p>";
					echo $error_mesasge;
					
					echo "<form role=\"form\" method=\"POST\" action=\"validateemail.php\" name=\"verify_email\">";
					echo"<div class=\"form-group\">";
					echo "<input type=\"text\" name=\"verificationkey\" id=\"verificationkey\" class=\"form-control input-lg\" placeholder=\"Verification Code\" tabindex=\"3\"  required>";
            		echo "</div>";
					echo "<div class=\"row\">";
					echo "<div class=\"col-xs-12 col-md-6\"><input type=\"submit\" value=\"verificationkey\" class=\"btn btn-primary btn-block btn-lg\" tabindex=\"7\" name=\"login\"></div>";
				
					echo "</form>";
					
					
			}
			
		}
	else
		{
			redirect_to("dashboard.php");
		}
				
		}
				
echo "</div>";
echo footer();


?>