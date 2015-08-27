<?php
session_start();
require_once("include/configuration.php");
require_once("include/functions.php");
error_reporting_mode();
getsiteconfiguration();
echo header_page();

if($_SESSION["username"] != null || $_SESSION["userid"] != null || $_SESSION["email"] != null)
		{
			$_SESSION["warning_message"] = "First Logout then signin with another account.";
			redirect_to("dashboard.php");
			
		}

if(isset($_POST["login"]))
	{
		$username = $_POST["username"];
		$password = $_POST["password"];
		if(isset($username)&&isset($password))
			{
				$result = perform_login($username, $password);
				if($result == false)
					{
						$_SESSION["login_error"] = "Invalid Email ID / Password!";
					}
					
			}
	}
?>
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

<div class="container">

<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
		<form role="form" method="POST" action="login.php" name="login">
			<h2>Please Login</h2>
			<hr class="colorgraph">
            <?php
			if($_SESSION["registration_message"] != null)
				{
				echo "<div class=\"form-group\">";
            	echo "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
  				echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
  				echo "<strong>". $_SESSION["registration_message"] ."</strong>";
				$_SESSION["registration_message"] = null;
				echo "</div>";
            
            	echo "</div>";
				
				}
			
			if($_SESSION["login_error"] != null)
				{
				echo "<div class=\"form-group\">";
            	echo "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
  				echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
  				echo "<strong>". $_SESSION["login_error"] ."</strong>";
				$_SESSION["login_error"] = null;
				echo "</div>";
            
            	echo "</div>";
				
				}
			
			
			if($_SESSION["logout_message"] != null)
				{
				echo "<div class=\"form-group\">";
            	echo "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
  				echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
  				echo "<strong>{$_SESSION["logout_message"]}</strong>";
				echo "</div>";
            
            	echo "</div>";
				$_SESSION["logout_message"] = null;
				}
				
			if($_SESSION["warning_message"] != null)
				{
				echo "<div class=\"form-group\">";
            	echo "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\">";
  				echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
  				echo "Please Login!";
				echo "</div>";
            
            	echo "</div>";
				$_SESSION["warning_message"] = null;
				}
			?>
			<div class="form-group">
				<input type="text" name="username" id="username" class="form-control input-lg" placeholder="Username" tabindex="3"  required>
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="5"  required>
			</div>
			
			<hr class="colorgraph">
			<div class="row">
				<div class="col-xs-12 col-md-6"><input type="submit" value="Login" class="btn btn-primary btn-block btn-lg" tabindex="7" name="login"></div>
				<div class="col-xs-12 col-md-6"><a href="register.php" class="btn btn-success btn-block btn-lg">Register</a></div>
                
                <!--div class="col-xs-12 col-md-6"><a href="forgetpassword.php" class="btn btn-danger btn-block btn-lg">Forget password</a></div>
			</div-->
		</form>
	</div>
</div>

</div>

<?php
echo footer();
?>