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
		
echo header_page();
//echo set_user_details_variables();
	
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
			echo"</div><br>";
			
			
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
				if($aadhar == "0")
					{
					//send control to profile page of user
					echo"<div class=\"col-lg-8\">";
					echo"<div class=\"panel panel-danger\">";
            		echo"<div class=\"panel-heading\">";
            		echo"Message";
            		echo"</div>";
            		echo"<div class=\"panel-body\">";
           	 		echo"<p>Please enter Aadhar number in profile</p>";
            		echo"</div>";
            		echo"<div class=\"panel-footer\">";
            		echo"<a href=\"profile.php\">Click Here</a>";            
            		echo"</div>";
            		echo"</div>";
					echo"</div><br>";
			
					}
				else
					{
					//display dashboard options
					
					if($_SESSION["warning_message"] != null)
						{
							echo "<div class=\"form-group\">";
            				echo "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\">";
  							echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
  							echo "<strong>";
							echo $_SESSION["warning_message"];
							echo "</strong>";
				
							echo "</div>";
            
            				echo "</div>";
							$_SESSION["warning_message"] = null;
				
						}
						
						if(isset($_POST["monitors_block"]))
							{
								if($type == "monitors")
									{
									$monitors_userid_block = $_POST["monitors_userid_block"];
									databaseconnectivity_open();
									global $connection;
									$query = "UPDATE `users` SET `block`=1 WHERE `userid`=". $monitors_userid_block ."  LIMIT 1";
									$result = mysqli_query($connection, $query);
									mysqli_free_result($result);
		
									databaseconnectivity_close();
									
									}
								else
									{
										$_SESSION["warning_message"] = "Only Monitors can perform this operation";
										redirect_to("dashboard.php");
									}
							}
							
						if(isset($_POST["monitors_unblock"]))
							{
								if($type == "monitors")
									{
									$monitors_userid_block = $_POST["monitors_userid_block"];
									databaseconnectivity_open();
									global $connection;
									$query = "UPDATE `users` SET `block`=0 WHERE `userid`=". $monitors_userid_block ."  LIMIT 1";
									$result = mysqli_query($connection, $query);
									mysqli_free_result($result);
		
									databaseconnectivity_close();
									
									}
								else
									{
										$_SESSION["warning_message"] = "Only Monitors can perform this operation";
										redirect_to("dashboard.php");
									}
							}
						
						if($type == "complainer")
							{
								
							}
						if($type == "monitors")
							{
								?>
                                
                               
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="" aria-expanded="true" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Turn block on / off users</a>
                                        </h4>
                                    </div>
                                    <div style="" aria-expanded="true" id="collapseOne" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                        
                                        	 <div class="table-responsive">
                                			<table class="table table-striped">
                                              <thead>
                                                <tr>
                                                  <th>User id</th>
                                                  
                                                  <th>Username</th>
                                                  <th>Email</th>
                                                  <th>Block</th>
                                                  <th>Action</th>
                                             
                                                </tr>
                                              </thead>
                                              <tbody>
                                            <?php
											databaseconnectivity_open();
		
											global $connection;
											//select * from complaints,departments where complaints.deptid = departments.deptid;
											$query = "SELECT userid,username,email,block FROM users where type=\"complainer\" ORDER BY username";
											$result = mysqli_query($connection, $query);
											if(!$result)
												{
												$_SESSION["error_number"] = "3000";
												$_SESSION["error_message"] = "Query failed while getting users";
			
												$string = "error.php?error_number=";
												$string .= urlencode("DB_Query_Failed");
												$string .= "&error_message=";
												$string .= urlencode("Query failed while getting users");
												
												redirect_to($string);
												}
											else
												{
													while($row = mysqli_fetch_assoc($result))
														{
											echo '<tr>';
											echo '<td>'. $row['userid'] . '</td>';
										
											echo '<td>'. $row['username'] . '</td>';
										
											echo '<td>'. $row['email'] . '</td>';
											echo '<td>'. $row['block'] . '</td>';
											
											echo '<td>';
											echo "<form method=\"post\" action=\"dashboard.php\"> <input type=\"hidden\" name= \"monitors_userid_block\" value=\"". $row["userid"] ."\"> <button type=\"submit\" class=\"btn btn-outline btn-danger\" name=\"monitors_block\">Block</button>&nbsp;&nbsp;&nbsp;<button type=\"submit\" class=\"btn btn-outline btn-success\" name=\"monitors_unblock\">Unblock</button></form>";
											echo '</td>';
											echo '</tr>';
														}
												}
											mysqli_free_result($result);
														
											databaseconnectivity_close();
					  
											?>
                                        </div>
                                    </div>
                                </div>
                               </div>
                                
                                
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a aria-expanded="false" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Reply contact request</a>
                                        </h4>
                                    </div>
                                    <div style="height: 0px;" aria-expanded="false" id="collapseTwo" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a aria-expanded="false" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Approve complaints</a>
                                        </h4>
                                    </div>
                                    <div aria-expanded="false" id="collapseThree" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            
                                        </div>
                                    </div>
                                </div>
                           
                                <?php
							}
						if($type == "managers")
							{
								
							}
						if($type == "assoc managers")
							{
								
							}
						
						?>
						
                        
					
				
				
				<?php
					}
				}
		
		}

	
						/*echo is_string($userid)."<br>" .is_string($email)."<br>". is_string($username)."<br>". is_string($type)."<br>". is_string($deptid)."<br>". is_string($aadhar)."<br>". is_string($status)."<br>" .is_string($verificationkey)."<br>". is_string($block)."<br>" .is_string($address)."<br>". is_string($phno)."<br>". is_string($gender);*/


echo "</div>";
echo footer();
?>

	
					<div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">13</div>
                                    <div>Support Tickets!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>