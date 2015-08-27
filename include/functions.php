<?php
function header_page()
	{
	global $sitename;	
	$output = "<!DOCTYPE html>";
	$output .="<html lang=\"en\">";
  	$output .="<head>";
    $output .="<meta charset=\"utf-8\">";
    $output .="<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">";
    $output .="<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";
    $output .="<meta name=\"description\" content=\"Admin Login\">";
    $output .="<meta name=\"author\" content=\"sadak pramodh\">";
    $output .="<link rel=\"icon\" href=\"images/favicon.ico\">";

    $output .="<title>". $_SESSION["sitename"] ."</title>";

    $output .="<!-- Bootstrap core CSS -->";
    $output .="<link href=\"css/ecomplaints.min.css\" rel=\"stylesheet\">";
	$output .="<link href=\"css/font-awesome.min.css\" rel=\"stylesheet\">";

    $output .="<!-- Custom styles for this template -->";
    $output .="<link href=\"css/ecomplaints-main.css\" rel=\"stylesheet\">";

    $output .="<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->";
    $output .="<!--[if lt IE 9]><script src=\"js/ie8-responsive-file-warning.js\"></script><![endif]-->";
    $output .="<script src=\"js/ie-emulation-modes-warning.js\"></script>";

    $output .="<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->";
    $output .="<!--[if lt IE 9]>";
    $output .="<script src=\"https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js\"></script>";
    $output .="<script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>";
    $output .="<![endif]-->";
  	$output .="</head>";
		
	return $output;
	}
function footer()
	{
		$output =  "<!-- Bootstrap core JavaScript";
    $output .="================================================== -->";
    $output .="<!-- Placed at the end of the document so the pages load faster -->";
    $output .="<script src=\"js/jquery.min.js\"></script>";
    $output .="<script src=\"js/ecomplaints.min.js\"></script>";
    $output .="<script src=\"js/docs.min.js\"></script>";
    $output .="<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->";
    $output .="<script src=\"js/ie10-viewport-bug-workaround.js\"></script>";
  	$output .="</body>";
	$output .="</html>";
	
	return $output;
	}
function navigation($block,$aadhar,$username,$deptid,$status,$verificationkey)
	{
	global $sitename;
	
	$output = "<nav class=\"navbar navbar-inverse navbar-fixed-top\">";
	$output .= "<div class=\"container-fluid\">";
	$output .="<div class=\"navbar-header\">";
	$output .="<button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#navbar\" aria-expanded=\"false\" aria-controls=\"navbar\">";
	$output .= "<span class=\"sr-only\">Toggle navigation</span>";
	$output .= "<span class=\"icon-bar\"></span>";
	$output .= "<span class=\"icon-bar\"></span>";
	$output .= "<span class=\"icon-bar\"></span>";
	$output .= "</button>";
	$output .= "<a class=\"navbar-brand\" href=\"index.php\">". $_SESSION["sitename"] ."</a></div>";
	$output .= "<div id=\"navbar\" class=\"navbar-collapse collapse\">";
	$output .= "<ul class=\"nav navbar-nav navbar-right\">";
	$output .= "<li><a href=\"index.php\">Home</a></li>";
	
	if($aadhar != "0" && $username !=null && $_SESSION["username"] != null && $status !=0 && $verificationkey == "0")
	{
	$output .= "<li><a href=\"dashboard.php\">Dashboard</a></li>";
	if($block != 1)
	{
	$output .=  "<li><a href=\"postcomplaint.php\">Post Complaint</a></li>";
	$output .=  "<li><a href=\"viewcomplaint.php\">View Complaints</a></li>";
	}
	}
	if($username !=null || $_SESSION["username"] != null)
	{
	$output .= "<li><a href=\"profile.php\">Profile</a></li>";
	}
	$output .= "<li><a href=\"contact.php\">Contact</a></li>";
	$output .= "<li><a href=\"help.php\">Help</a></li>";
	if($username !=null || $_SESSION["username"] != null)
	{
	$output .=   "<li><a href=\"logout.php\">Logout</a></li>";
	}
	$output .= "</ul>";
	$output .= "<form class=\"navbar-form navbar-right\">";
	$output .= "<input type=\"text\" class=\"form-control\" placeholder=\"Search...\">";
	$output .= "</form>";
	$output .= "</div>";
	$output .= "</div>";
	$output .= "</nav>";
   
   return $output;
	}
function sidebar($block,$aadhar,$username,$deptid,$status,$verificationkey)
	{
	
	$output = "<div class=\"container-fluid\">";
	$output .= "<div class=\"row\">";
	$output .=  "<div class=\"col-sm-3 col-md-2 sidebar\">";
	$output .=  "<ul class=\"nav nav-sidebar\">";
	//class=\"active\" in li to active
	
	if($aadhar != "0" && $username !=null && $_SESSION["username"] != null && $status !=0 && $verificationkey == "0")
	{
	$output .= "<li><a href=\"dashboard.php\">Overview <span class=\"sr-only\">(current)</span></a></li>";
	$output .= "</ul>";
	
	$output .=  "<ul class=\"nav nav-sidebar\">";
	$output .=  "<li><a href=\"index.php\">Home</a></li>";
	if($block != 1)
	{
	$output .=  "<li><a href=\"postcomplaint.php\">Post Complaint</a></li>";
	$output .=  "<li><a href=\"viewcomplaint.php\">View Complaints</a></li>";
	}
	}
	if($username !=null || $_SESSION["username"] != null)
	{
	$output .=  "<li><a href=\"profile.php\">Profile</a></li>";
	}
	if($username !=null || $_SESSION["username"] != null)
	{
	$output .=   "<li><a href=\"logout.php\">Logout</a></li>";
	}
	$output .=  "</ul>";
	
	$output .=  "<ul class=\"nav nav-sidebar\">";
	$output .=  "<li><a href=\"contact.php\">Contact</a></li>";
	$output .=   "<li><a href=\"help.php\">Help</a></li>";
	$output .=   "</ul>";
	
	$output .=   "</div>";
	$output .=   "</div>";
	$output .=   "</div>";
	  
	return $output;
		
	}
	
function databaseconnectivity_open()
	{
	global $dbhost, $dbusername,$dbpassword, $dbname, $connection;
	
	$connection = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
	if(mysqli_connect_errno())
		{
			$_SESSION["error_number"] = mysqli_connect_errno();
			$_SESSION["error_message"] = "Database connection failed ".mysqli_connect_error();
			
			$string = "error.php?error_number=";
			$string .= urlencode("DB_CONN_1");
			$string .= "&error_message=";
			$string .= urlencode("Connection with database server failed!");
			
			redirect_to($string);
		}
	return $connection;
	}

function databaseconnectivity_close()
	{
		global $connection;
		if(isset($connection))
			{
			mysqli_close($connection);
			}
	}


function sendmail($to, $subject, $message)
	{

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Additional headers
	$headers .= "To: {$to} \r\n";
	/*
	$headers .= 'From: Birthday Reminder <birthday@example.com>' . "\r\n";
	$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
	$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
	*/
	// Mail it
	$result = mail($to, $subject, $message, $headers);
	return $result;
	}
	
// Function to get the client ip address	
function get_client_ip_env() 
	{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
	}

// Function to get the client ip address
function get_client_ip_server() 
	{
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
	}

function ipaddress_details($ipaddress)
	{
	$address = "http://ipinfo.io/{$ipaddress}/json";
	$ipaddress_details = file_get_contents($address);
	$ipaddress_details = json_decode($ipaddress_details, true); 
	$ipaddress_details = "IP : {$ipaddress_details["ip"]} , Host Name : {$ipaddress_details["hostname"]} , City : {$ipaddress_details["city"]},  Region : {$ipaddress_details["region"]}, Country : {$ipaddress_details["country"]}, Location : {$ipaddress_details["loc"]}, Organization : {$ipaddress_details["org"]}";
	return $ipaddress_details;
	}

function redirect_to($location)
	{
		header("Location: {$location}");
		exit;
	}
function error_reporting_mode()
	{
		return error_reporting(0);
	}
	
function getsiteconfiguration()
	{
		databaseconnectivity_open();
		
		global $connection;
		$query = "SELECT * FROM configuration LIMIT 1";
		$result = mysqli_query($connection, $query);
		if(!$result)
			{
			$_SESSION["error_number"] = "2001";
			$_SESSION["error_message"] = "Query failed while getting site configuration";
			
			$string = "error.php?error_number=";
			$string .= urlencode("DB_Query_Failed");
			$string .= "&error_message=";
			$string .= urlencode("site configuration didn't received");
			
			redirect_to($string);
			}
		else
			{
				while($row = mysqli_fetch_assoc($result))
					{
						$_SESSION['sitename'] = $row["sitename"];
						$_SESSION['sitestatus'] = $row["sitestatus"];
						$_SESSION['alloregister'] = $row["allowregister"];
						$_SESSION['allologin'] = $row["allowlogin"];
						$_SESSION['stopaddingcomplaints'] = $row["stopaddingcomplaints"];
						$_SESSION['supportemail'] = $row["supportemail"];
				
					}
			}
			
		mysqli_free_result($result);
		
		databaseconnectivity_close();
	}
	
function set_user_details_variables()
	{
		$q = fetch_data(aadhar, $ref_column, $ref_value, $table_name);
	if($q!=null)
		{
			global $aadhar;
			$aadhar = $q;
		}
	else
		{
			echo "failed fetch aadhar details";
		}
		
	$q = fetch_data(status, $ref_column, $ref_value, $table_name);
	if($q!=null)
		{
			global $status;
			$status = $q;
		}
	else
		{
			echo "failed fetch status details";
		}
	$q = fetch_data(verificationkey, $ref_column, $ref_value, $table_name);
	if($q!=null)
		{
			global $verificationkey;
			$verificationkey = $q;
		}
	else
		{
			echo "failed fetch verification key details";
		}
	$q = fetch_data(block, $ref_column, $ref_value, $table_name);
	if($q!=null)
		{
			global $block;
			$block = $q;
		}
	else
		{
			echo "failed fetch block details";
		}
	$q = fetch_data(address, $ref_column, $ref_value, $table_name);
	if($q!=null)
		{
			global $address;
			$address = $q;
		}
	else
		{
			echo "failed fetch address details";
		}
		
	$q = fetch_data(phno, $ref_column, $ref_value, $table_name);
	if($q!=null)
		{
			global $phno;
			$phno = $q;
		}
	else
		{
			echo "failed fetch phone number details";
		}
	$q = fetch_data(gender, $ref_column, $ref_value, $table_name);
	if($q!=null)
		{
			global $gender;
			$gender = $q;
		}
	else
		{
			echo "failed fetch gender details";
		}
		
	}
function perform_login($username, $password)
	{
		databaseconnectivity_open();
		
		global $connection;
		
		$username = mysqli_real_escape_string($connection, $username);
		$password = mysqli_real_escape_string($connection, $password);
		$query = "SELECT * FROM `users` WHERE username=\"";
		$query .= $username;
		$query .= "\" AND password =\"";
		$query .= $password;
		$query .= "\" LIMIT 1";
		
		$result = mysqli_query($connection, $query);
		//if login query fails
		if(!$result)
			{
			$_SESSION["error_number"] = "2003";
			$_SESSION["error_message"] = "Query failed while login";
			
			$string = "error.php?error_number=";
			$string .= urlencode("DB_Query_Failed");
			$string .= "&error_message=";
			$string .= urlencode("Query failed while login");
			//redirect to error page
			redirect_to($string);
			}
		else
			{
				//fetch user login details
				while($row = mysqli_fetch_assoc($result))
					{
						$username_db = $row["username"];
						$password_db = $row["password"];
						//check login
						if($username == $username_db && $password == $password_db)
							{
								//if login success get userdetails
								$userdetails_result = get_set_userdetails($username_db);
								if($userdetails_result == true)
									{
										//if getting userdetails sucessfully redirect to dashboard.
										redirect_to("dashboard.php");
									}
								else
									{
										$_SESSION["error_number"] = "2004";
										$_SESSION["error_message"] = "Didn't getting user details";
			
										$string = "error.php?error_number=";
										$string .= urlencode("FAIL_GET_USERDETAILS");
										$string .= "&error_message=";
										$string .= urlencode("Didn't getting user details");
			
										redirect_to($string);
									}
								
							}
						else
							{
								$queryresult = false;
							}
					}
			}
			
		mysqli_free_result($result);
		
		databaseconnectivity_close();
		
		return $queryresult;
	}
	
function get_set_userdetails($username)
	{
		$returnvalue = false;
		databaseconnectivity_open();
		
		global $connection;
		
		$username = mysqli_real_escape_string($connection, $username);
		$query = "SELECT * FROM `users` WHERE username=\"";
		$query .= $username;
		$query .= "\" LIMIT 1";
		
		$result = mysqli_query($connection, $query);
		if(!$result)
			{
				$_SESSION["error_number"] = "2005";
				$_SESSION["error_message"] = "Didn't getting user details while assigning to session";
			
				$string = "error.php?error_number=";
				$string .= urlencode("FAIL_GET_USERDETAILS_SESSION");
				$string .= "&error_message=";
				$string .= urlencode("Didn't getting user details while assigning to session");
			
				redirect_to($string);
			}
		else
			{
				while($row = mysqli_fetch_assoc($result))
					{
						/*
						$userid = $row["userid"];
						$email = $row["email"];
						$username = $row["username"];
						$type = $row["type"];
						$deptid = $row["deptid"];
						$aadhar = $row["aadhar"];
						$status = $row["status"];
						$verificationkey = $row["verificationkey"];
						$block = $row["block"];
						$address = $row["address"];
						$phno = $row["phno"];
						$gender = $row["gender"];
						*/
						$_SESSION["userid"] = $row["userid"];
						$_SESSION["email"] = $row["email"];
						$_SESSION["username"] = $row["username"];
						$_SESSION["type"] = $row["type"];
						$_SESSION["deptid"] = $row["deptid"];
					}
					
					//user details assigned and return true
			$returnvalue = true;
			}
			
		mysqli_free_result($result);
		
		databaseconnectivity_close();
		
		return $returnvalue;
	}
	
function check_email_db($email)
	{
		databaseconnectivity_open();
		
		global $connection;
		$email = mysqli_real_escape_string($connection, $email);
		$query = "SELECT `email` FROM `users` WHERE `email` = \"";
		$query .= $email;
		$query .= "\" LIMIT 1";
		$result = mysqli_query($connection, $query);
		if(!$result)
			{
			$_SESSION["error_number"] = "2006";
			$_SESSION["error_message"] = "Query failed while checking email in user registration";
			
			$string = "error.php?error_number=";
			$string .= urlencode("DB_Query_Failed");
			$string .= "&error_message=";
			$string .= urlencode("Query failed while checking email in user registration");
			
			redirect_to($string);
			}
		else
			{
				while($row = mysqli_fetch_assoc($result))
					{
						if(!($email == $row["email"]))
							{
								$check_email = "false";
							}
						else
							{
								$check_email = "true";
							}
					}
			}
			
		mysqli_free_result($result);
		
		databaseconnectivity_close();
		
		return $check_email;
	}
function add_user_db($username, $password, $email)
	{
		databaseconnectivity_open();
		$add_user_db = false;
		global $connection;
		$email1 = $email;
		$username = mysqli_real_escape_string($connection, $username);
		$password = mysqli_real_escape_string($connection, $password);
		$email = mysqli_real_escape_string($connection, $email);
		$query = "INSERT INTO `users`(`username`, `password`, `email`, `type`, `deptid`, `status`, `verificationkey`, `block`, `aadhar`, `address`, `phno`, `gender`) VALUES (\"";
		$query .= $username ."\",\"";
		$query .= $password ."\",\"";
		$query .= $email ."\",\"";
		$query .= "complainer\",0,0,\"";
		$verificationkey = rand(1,99999);
		$query .= $verificationkey ."\",0,\"0\",\"0\",\"0\",\"0\")";
		
		$result = mysqli_query($connection, $query);
		if(!$result)
			{
			$_SESSION["error_number"] = "2007";
			$_SESSION["error_message"] = "Query failed while user is registering and inserting details in database". mysqli_error($connection);
			
			$string = "error.php?error_number=";
			$string .= urlencode("DB_Query_Failed");
			$string .= "&error_message=";
			$string .= urlencode("Query failed while user is registering and inserting details in database");
			
			redirect_to($string);
			}
		else
			{
			$_SESSION["registration_message"] = "Registration sucessfully done! Please login !";
			$subject = "You are sucessfully registered on ".$_SESSION["sitename"].", Please verify your email address";
			$message = "Your verification code is : ".$verificationkey;
			sendmail($email1, $subject, $message);
			redirect_to("login.php");
			$add_user_db = true;
			}
			
		mysqli_free_result($result);
		
		databaseconnectivity_close();
		return $add_user_db;
	}
	
function check_username($username)
	{
		databaseconnectivity_open();
		
		global $connection;
		$username = mysqli_real_escape_string($connection, $username);
		$query = "SELECT `username` FROM `users` WHERE `username` = \"";
		$query .= $username;
		$query .= "\" LIMIT 1";
		$result = mysqli_query($connection, $query);
		if(!$result)
			{
			$_SESSION["error_number"] = "2006";
			$_SESSION["error_message"] = "Query failed while checking username in user registration";
			
			$string = "error.php?error_number=";
			$string .= urlencode("DB_Query_Failed");
			$string .= "&error_message=";
			$string .= urlencode("Query failed while checking username in user registration");
			
			redirect_to($string);
			}
		else
			{
				while($row = mysqli_fetch_assoc($result))
					{
						if(!($email == $row["username"]))
							{
								$check_username = "false";
							}
						else
							{
								$check_username = "true";
							}
					}
			}
			
		mysqli_free_result($result);
		
		databaseconnectivity_close();
		
		return $check_username;
	}
	
function fetch_data($need_column, $ref_column, $ref_value, $table_name)
	{
		databaseconnectivity_open();
		$needed_value = null;
		global $connection;
		$field = mysqli_real_escape_string($connection, $ref_value);
		$query = "SELECT ";
		$query .= $need_column." FROM `".$table_name."` WHERE `".$ref_column."` = \"";
		$query .= $ref_value;
		$query .= "\" LIMIT 1";
		
		
		$result = mysqli_query($connection, $query);
		if(!$result)
			{
			$_SESSION["error_number"] = "2008";
			$_SESSION["error_message"] = "Query failed while feching ".$need_column." from ".$table_name."!";
			
			$string = "error.php?error_number=";
			$string .= urlencode("DB_Query_Failed");
			$string .= "&error_message=";
			$string .= urlencode("Query failed while feching ".$need_column." from ".$table_name."!");
			
			redirect_to($string);
			}
		else
			{
				while($row = mysqli_fetch_assoc($result))
					{
						$needed_value = $row[$need_column];
					}
			}
			
		mysqli_free_result($result);
		
		databaseconnectivity_close();
		
		return $needed_value;
	}
function update_field($update_column,$update_value, $ref_column, $ref_value, $table_name)
	{
		$update_result = false;
		databaseconnectivity_open();
		global $connection;
		$ref_value = mysqli_real_escape_string($connection, $ref_value);
		$update_value = mysqli_real_escape_string($connection, $update_value);
		$query = "UPDATE `".$table_name."` SET `".$update_column."`=".$update_value." WHERE `".$ref_column."` = \"".$ref_value."\" LIMIT 1";
		
		$result = mysqli_query($connection, $query);
		
		if($result && mysqli_affected_rows($connection) == 1)
			{
				$update_result = true;
			}
		else
			{
			$_SESSION["error_number"] = "2008";
			$_SESSION["error_message"] = "Query failed while updating ".$update_column." from ".$table_name."!";
			
			$string = "error.php?error_number=";
			$string .= urlencode("DB_Query_Failed");
			$string .= "&error_message=";
			$string .= urlencode("Query failed while updating ".$update_column." from ".$table_name."!");
			
			redirect_to($string);
			}
			
		mysqli_free_result($result);
		
		databaseconnectivity_close();
		
		return $update_result;
	}