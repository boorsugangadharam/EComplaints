<?php
session_start();
require_once("include/configuration.php");
require_once("include/functions.php");
error_reporting_mode();
$error_number = $_GET["error_number"];
$error_message = $_GET["error_message"];
if($error_number == null && $error_message == null && $_SESSION["error_number"] == null && $_SESSION["error_message"] == null)
	{
		redirect_to("index.php");
	}
	
$error_number = $_SESSION["error_number"];
$error_message = $_SESSION["error_message"];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>
     Error!
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="css/ecomplaints.min.css" rel="stylesheet" id="bootstrap-css" type="text/css" />
    <style type="text/css">
/*<![CDATA[*/
    body { background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABZ0RVh0Q3JlYXRpb24gVGltZQAxMC8yOS8xMiKqq3kAAAAcdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3JrcyBDUzVxteM2AAABHklEQVRIib2Vyw6EIAxFW5idr///Qx9sfG3pLEyJ3tAwi5EmBqRo7vHawiEEERHS6x7MTMxMVv6+z3tPMUYSkfTM/R0fEaG2bbMv+Gc4nZzn+dN4HAcREa3r+hi3bcuu68jLskhVIlW073tWaYlQ9+F9IpqmSfq+fwskhdO/AwmUTJXrOuaRQNeRkOd5lq7rXmS5InmERKoER/QMvUAPlZDHcZRhGN4CSeGY+aHMqgcks5RrHv/eeh455x5KrMq2yHQdibDO6ncG/KZWL7M8xDyS1/MIO0NJqdULLS81X6/X6aR0nqBSJcPeZnlZrzN477NKURn2Nus8sjzmEII0TfMiyxUuxphVWjpJkbx0btUnshRihVv70Bv8ItXq6Asoi/ZiCbU6YgAAAABJRU5ErkJggg==);}
    .error-template {padding: 40px 15px;text-align: center;}
    .error-actions {margin-top:15px;margin-bottom:15px;}
    .error-actions .btn { margin-right:10px; }
	


    /*]]>*/
    </style>
   <script src="js/jquery.min.js" type="text/javascript">
   </script>
   <script src="js/ecomplaints.min.js" type="text/javascript">
   </script>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="error-template">
            <h1>
              Oops!
            </h1>
            
            <h2>
            <p class="text-warning">Selected operation doesn't performed!</p>
         
            </h2>
            <div class="error-details">
              <p class="text-danger">
                Sorry, an error has occured, Your request not
                processed!
              </p>
            </div>
            
            <div class="error-details">
              <p class="text-success">
                Please send mail to <?php echo $support_email; ?>
                followed with <br>Error code : <?php echo $error_number; ?> <br>Error message : <?php echo $error_message; ?>.
              </p>
            </div>
            
            
           
          
              <div class="error-details">
                <div class="panel panel-danger">
                  <div class="panel-heading">
                    <h3 class="panel-title">
                      Error details
                    </h3>
                  </div>
                  <div class="panel-body">
                  
                  	
                    <div class="col-sm-4">
    							<img src="images/sad.jpg" alt="Note" style="height:150px;width:150px">
                    </div>
                    <div class="col-sm-4">
  							
    							 <?php echo "Error code : ". $error_number ." <br>Error Message : ". $error_message;   ?>.
                                 <div class="error-actions">
                                 <?php
								 $string = $support_email."?subject=";
								 $string .= rawurlencode("An error has occured.Please solve it.");
								 $string .= "&body=";
								 $string .= rawurlencode("Error code :");
								 $string .= rawurlencode($error_number);
								 $string .= rawurlencode("Error message</b> : ");
								 $string .= rawurlencode($error_message);
								 $string .= $error_message;
					
								 ?>
                                 
                                 	<a href="mailto:<?php echo $string; ?> " class="btn btn-success btn-lg">Send mail</a>
              					 </div>
  					</div>	
                  <div class="col-sm-4"></div>
                  </div>
                </div>
              
             
              
              
              
              
              
              <div class="error-actions">
              <a href="index.php" class=
              "btn btn-primary btn-lg">Take Me Home</a> <a href=
              "help.php" class="btn btn-default btn-lg">Contact
              Support</a>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
<?php
$_SESSION["error_number"] = null;
$_SESSION["error_message"] = null;
die();
?>