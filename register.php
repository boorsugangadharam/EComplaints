<?php
session_start();
require_once("include/configuration.php");
require_once("include/functions.php");
error_reporting_mode();
getsiteconfiguration();
echo header_page();

if($_SESSION["username"] != null || $_SESSION["userid"] != null || $_SESSION["email"] != null)
		{
			$_SESSION["warning_message"] = "First Logout then register for another account.";
			redirect_to("dashboard.php");
			
		}

if(isset($_POST["register"]))
	{
		$username = $_POST["username"];
		$email = $_POST["email"];
		$password = $_POST["password"];
		$password_confirmation = $_POST["password_confirmation"];
		//print_r($_POST);
		$errors = array();
		if(!isset($username[5]) || isset($name[20]))
			{
    		$errors["username"] = "Username too short or too long !";
			}
		$username_result = check_username($username);
		if($username_result == true)
			{
			$errors["username_exists"] = "username is already taken. Please enter another username !";
			}
  		if(!isset($password[5]) || isset($password[16]))
			{
    		$errors["password"] = "Password too short or too long !";
			}
		if(!isset($email[5]) || isset($email[24]))
			{
			$errors["email"] = "Email is too short or too long !";	
			}
		if(!isset($password_confirmation[5]) || isset($password_confirmation[16]))
			{
    		$errors["password_confirmation"] = "Confirmation password too short or too long !";
			}
		if(!($password === $password_confirmation))
			{
			$errors["passwordsmatch"] = "Passwords doesn't match !";
			}
		$email_result = check_email_db($email);
		if($email_result == true)
			{
			$errors["emailaddress"] = "Email is already taken. Please enter another email !";
			}
			
		if(empty($errors))
			{
				$add_user = add_user_db($username, $password, $email);
				//add query result
				if($add_user == true)
					{
						$_SESSION["registration_message"] = "Registration sucessfully done! Please login !";
					}
			}
			
		else
			{
				$_SESSION["registration_message"] = "Registration failed !";
			}
	}



?>


<script language="javascript">

</script>
<style>

.colorgraph {
  height: 5px;
  border-top: 0;
  background: #c4e17f;
  border-radius: 5px;
  background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
}
</style>
<link href="js/SpryAssetsRegister/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="js/SpryAssetsRegister/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="js/SpryAssetsRegister/SpryValidationPassword.css" rel="stylesheet" type="text/css">
<link href="js/SpryAssetsRegister/SpryValidationConfirm.css" rel="stylesheet" type="text/css">
<script src="js/SpryAssetsRegister/SpryValidationTextField.js" type="text/javascript"></script>
<script src="js/SpryAssetsRegister/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="js/SpryAssetsRegister/SpryValidationPassword.js" type="text/javascript"></script>
<script src="js/SpryAssetsRegister/SpryValidationConfirm.js" type="text/javascript"></script>

<body>

<div class="container">

<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
		<form role="form" method="POST" action="register.php" name="register">
        
        	<?php
			if(!empty($errors))
				{
				echo "<div class=\"form-group\">";
            	echo "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
  				echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
  				echo "<strong>";
				echo $_SESSION["registration_message"] . " Please review following errors<br>";
				 foreach ($errors as $error) 
					{
    				echo $error . "<br>";
					} 
				echo "</strong>";
				$_SESSION["registration_message"] = null;
				echo "</div>";
            
            	echo "</div>";
				
				}
		
			?>
			<h2>Please Sign Up <small>It's free and always will be.</small></h2>
			<hr class="colorgraph">
	
			<div class="form-group">
				<span id="username">
				<input name="username" type="text" class="form-control input-lg" id="username" placeholder="Username" tabindex="3" maxlength="20">
				<span class="textfieldRequiredMsg">Please enter username.</span></span>
				
			</div>
			<div class="form-group">
           	  <span id="email">
              <input name="email" type="text" class="form-control input-lg" id="email" placeholder="Email Address" tabindex="4" maxlength="22">
              <span class="textfieldRequiredMsg">Please enter email address.</span><span class="textfieldInvalidFormatMsg">Invalid email format.</span></span>
           	  
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
                    	<span id="password">
                        <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="5">
                        <span class="passwordRequiredMsg">Please  enter password.</span><span class="passwordMinCharsMsg">Minimum number of characters not met.</span><span class="passwordMaxCharsMsg">Exceeded maximum number of characters.</span></span>
                   	  
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
                    	<span id="password_confirmation">
                    	<input name="password_confirmation" type="password" class="form-control input-lg" id="password_confirmation" placeholder="Confirm Password"  tabindex="6" maxlength="16" >
                    	<span class="confirmRequiredMsg">Please enter password.</span><span class="confirmInvalidMsg">The values don't match.</span></span>
                   	  
					</div>
				</div>
			</div>
			<div class="row">
				
				<div class="col-xs-8 col-sm-9 col-md-9">
					 By clicking <strong class="label label-primary">Register</strong>, you agree to the <a href="#" data-toggle="modal" data-target="#t_and_c_m">Terms and Conditions</a> set out by this site, including our Cookie Use.
				</div>
			</div>
			
			<hr class="colorgraph">
			<div class="row">
				<div class="col-xs-12 col-md-6"><input type="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="7" name="register"></div>
				<div class="col-xs-12 col-md-6"><a href="login.php" class="btn btn-success btn-block btn-lg">Sign In</a></div>
			</div>
		</form>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
			</div>
			<div class="modal-body">
				<p> Terms and Conditions</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">I Agree</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>


<script type="text/javascript">
var username = new Spry.Widget.ValidationTextField("username");
var password = new Spry.Widget.ValidationPassword("password", {minChars:6, maxChars:16, validateOn:["change"]});
var password_confirmation = new Spry.Widget.ValidationConfirm("password_confirmation", "password", {validateOn:["change"]});
var email = new Spry.Widget.ValidationTextField("email", "email", {validateOn:["change"]});
</script>
<?php
echo footer();
?>