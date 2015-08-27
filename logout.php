<?php	
	require_once("include/functions.php");
		session_start();
       		if($_SESSION["username"] != null || $_SESSION["userid"] != null || $_SESSION["email"] != null)
				{
						$_SESSION["userid"] = null;
						$_SESSION["email"] = null;
						$_SESSION["username"] = null;
						$_SESSION["type"] = null;
						$_SESSION["deptid"] = null;
						$_SESSION["aadhar"] = null;
						$_SESSION["status"] = null;
						$_SESSION["verificationkey"] = null;
						$_SESSION["block"] = null;
						$_SESSION["address"] = null;
						$_SESSION["phno"] = null;
						$_SESSION["gender"] = null;
						
						$_SESSION["logout_message"] = "Logged out sucessfully!";
						redirect_to("login.php");
				}
			else
				{
			$_SESSION["logout_message"] = "First Login!";
			redirect_to("login.php");
				}
?>