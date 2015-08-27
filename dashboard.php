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

?>
<?php

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
		
?>
<?php
		
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
						
						if(isset($_POST["approvecompliant"]))
							{
								
								$complaintid = $_POST["complaintid"];
								if($type == "monitors")
									{
									databaseconnectivity_open();
									global $connection;
									$query = "UPDATE `complaints` SET `status`=\"active\" WHERE `complaintid`=". $complaintid ."  LIMIT 1";
									
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
						
						if(isset($_POST["replycontact"]))
							{
								$contactuid = $_POST["contactuid"];
								$reply = $_POST["reply"];
							
								if($type == "monitors")
									{
									databaseconnectivity_open();
									global $connection;
									$query = "UPDATE `contact` SET `reply`=\"{$reply}\" WHERE `contactuid`=". $contactuid ."  LIMIT 1";
									
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
							
						if(isset($_POST["monitors_contact_reply"]))
							{
								if($type == "monitors")
									{
										$monitors_contact = $_POST["monitors_contact"];	
										
										
										databaseconnectivity_open();
		
										global $connection;
										
										$username = mysqli_real_escape_string($connection, $username);
										$query = "SELECT * FROM `contact` WHERE contactuid=\"";
										$query .= $monitors_contact;
										$query .= "\" LIMIT 1";
										
										$result = mysqli_query($connection, $query);
										while($row = mysqli_fetch_assoc($result))
											{
												$contactuid = $row["contactuid"];
												$username = $row["username"];
												$subjects = $row["subjects"];
												$ipaddress1 = $row["ipaddress1"];
												$ipaddress2 = $row["ipaddress2"];
												$ipaddress3 = $row["ipaddress3"];
												$userid = $row["userid"];
												$email = $row["email"];
												$date = $row["date"];
												$reply = $row["reply"];
											}
										mysqli_free_result($result);
				
										databaseconnectivity_close();
							
										?>
                                       
                                        
<h2 class="sub-header">Reply to contact</h2>
                                        <form action="dashboard.php" method="post" role="form" class="form-horizontal col-sm-6">
                      					<div class="control-group">
                        				<label for = "contactuid" class = "control-label">Contact UID</label>
                       					<div class="controls">
                            			<input name="contactuid" class="form-control" type="text"  id = "contactuid" placeholder="Contact UID" value="<?php echo $contactuid; ?>" readonly>    
                    					</div>
                      					</div>
                      
                     	 				<div class="control-group">
                        				<label for = "username" class = "control-label">Username</label>
                        				<div class="controls">
                            			<input name="username" class="form-control" type="text" id = "username" placeholder="Username" value="<?php echo $username; ?>" disabled>
                     					</div>
                      					</div>
                      
                      					<div class="control-group">
                        				<label for="subject" class ="control-label">Subject</label>
                       					<div class="controls">
                            			<textarea name="subjects" class="form-control" id = "subject" placeholder="Subject" disabled><?php echo $subjects; ?></textarea>
                          
                     					</div>
                      					</div>
                  
                     					<div class="control-group">
                        				<label for="ipaddress1" class ="control-label">IP Address 1</label>
                       					<div class="controls">
                            			<textarea name="ipaddress1" class="form-control" id = "ipaddress1" disabled="disabled"><?php echo $ipaddress1; ?></textarea>
                          
                     					</div>
                      					</div>
                                        <div class="control-group">
                        				<label for="ipaddress2" class ="control-label">IP Address 2</label>
                       					<div class="controls">
                            			<textarea name="ipaddress2" class="form-control" id = "ipaddress2" disabled="disabled"><?php echo $ipaddress2; ?></textarea>
                          
                     					</div>
                      					</div>
                                        <div class="control-group">
                        				<label for="ipaddress3" class ="control-label">IP Address 3</label>
                       					<div class="controls">
                            			<textarea name="ipaddress3" class="form-control" id = "ipaddress3" disabled="disabled"><?php echo $ipaddress3; ?></textarea>
                          
                     					</div>
                      					</div>
                                        <div class="control-group">
                        				<label for = "userid" class = "control-label">User ID</label>
                        				<div class="controls">
                            			<input name="userid" class="form-control" type="text" id = "userid" placeholder="User ID" value="<?php echo $userid; ?>" disabled>
                     					</div>
                      					</div>
                                        <div class="control-group">
                        				<label for = "email" class = "control-label">Email</label>
                        				<div class="controls">
                            			<input name="email" class="form-control" type="text" id = "email" placeholder="Email" value="<?php echo $email; ?>" disabled>
                     					</div>
                      					</div>
                                        <div class="control-group">
                        				<label for = "date" class = "control-label">Date</label>
                        				<div class="controls">
                            			<input name="date" class="form-control" type="text" id = "date" placeholder="Username" value="<?php echo $date; ?>" disabled>
                     					</div>
                      					</div>
                                        <hr />
                                         <div class="control-group">
                        				<label for="reply" class ="control-label">Reply</label>
                       					<div class="controls">
                            			<textarea name="reply" class="form-control" id = "reply" required><?php echo $reply; ?></textarea>
                          
                     					</div>
                      					</div>
                                      	<hr />
                                         
                                         <p>
                                          <div>
                                        <button type="submit" name="replycontact" class="btn btn-success">Reply</button>
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                   		  </div>
                     					</p>  
                                     
                                      
                                      </form>
                                                        
							<?php			
									}
								else
									{
										$_SESSION["warning_message"] = "Only Monitors can perform this operation";
										redirect_to("dashboard.php");
									}
							}
						
				if(!isset($_POST["monitors_contact_reply"]))
					{	
						
						if($type == "complainer")
							{
								
							}
						if($type == "monitors")
							{
								?>
                                   
                                   <?php
								   //Turn users block / unblock
								   ?>
                                 <div class="bs-example">
    <p>
      <button class="btn btn-danger collapsed" type="button" data-toggle="collapse" data-target="#collapseTurnuserblockunblock" aria-expanded="false" aria-controls="collapseExample">
        Turn users Block / Unblock
      </button>
    </p>
    <div class="collapse" id="collapseTurnuserblockunblock" aria-expanded="false" style="height: 0px;">
      <div class="well">
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
                                         </tbody>
                                        </table>
                                  
          								</div>
      </div>
    </div>
  </div>       
                                        
                                        
                                        

						<?php
						//Reply to contact
						?>
                                      
                                      <div class="bs-example">
    <p>
   
      <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#collapseReplytocontact" aria-expanded="false" aria-controls="collapseExample">
        Reply to contact
      </button>
    </p>
    <div class="collapse" id="collapseReplytocontact" aria-expanded="false" style="height: 0px;">
      <div class="well">
        <div class="table-responsive">
                                			<table class="table table-striped">
                                              <thead>
                                                <tr>
                                                  <th>Contact uid</th>
                                                  
                                                  <th>Username</th>
                                                  <th>Subjects</th>
                                                  <th>Email</th>
                                                  <th>Action</th>
                                             
                                                </tr>
                                              </thead>
                                              <tbody>
                                      
                                       <?php
											databaseconnectivity_open();
		
											global $connection;
											//select * from complaints,departments where complaints.deptid = departments.deptid;
											$query = "SELECT * FROM contact where reply=\"0\" ORDER BY date";
											$result = mysqli_query($connection, $query);
											if(!$result)
												{
												$_SESSION["error_number"] = "4000";
												$_SESSION["error_message"] = "Query failed while getting contact";
			
												$string = "error.php?error_number=";
												$string .= urlencode("DB_Query_Failed");
												$string .= "&error_message=";
												$string .= urlencode("Query failed while getting contact");
												
												redirect_to($string);
												}
											else
												{
													while($row = mysqli_fetch_assoc($result))
														{
											echo '<tr>';
											echo '<td>'. $row['contactuid'] . '</td>';
										
											echo '<td>'. $row['username'] . '</td>';
										
											echo '<td>'. $row['subjects'] . '</td>';
											echo '<td>'. $row['email'] . '</td>';
											
											echo '<td>';
											echo "<form method=\"post\" action=\"dashboard.php\"> <input type=\"hidden\" name= \"monitors_contact\" value=\"". $row["contactuid"] ."\"> 
										
											
											<button type=\"submit\" class=\"btn btn-outline btn-success\" name=\"monitors_contact_reply\" data-toggle=\"modal\" data-target=\"#exampleModal\" data-whatever=\"@getbootstrap\">Reply</button></form>";
											echo '</td>';
											echo '</tr>';
														}
												}
											mysqli_free_result($result);
														
											databaseconnectivity_close();
					  
											?>
                                      </tbody>
                                        </table>
                                      </div>
      </div>
    </div>
  </div>        
                                      
                               
                                 <?php
								 //Approve complaints section
								 
								 ?>
                                        <div class="bs-example">
    <p>
      <a class="btn btn-success collapsed" data-toggle="collapse" href="#collapseApproveComplaints" aria-expanded="false" aria-controls="collapseExample">
        Approve complaints
      </a>
    </p>
    <div class="collapse" id="collapseApproveComplaints" aria-expanded="false" style="height: 0px;">
      <div class="well">
      <div class="table-responsive">
        <table class="table table-striped">
                                              <thead>
                                                <tr>
                                                  <th>Complaint ID</th>
                                                  
                                                  <th>User ID</th>
                                               
                                                  <th>Dept ID</th>
                                                  <th>Subject</th>
                                                  <th>Action</th>
                                             
                                                </tr>
                                              </thead>
                                              <tbody>
                                            <?php
											databaseconnectivity_open();
		
											global $connection;
											//select * from complaints,departments where complaints.deptid = departments.deptid;
											$query = "SELECT complaintid,userid,deptid,subject FROM complaints where status=\"inactive\" ORDER BY date";
											
											$result = mysqli_query($connection, $query);
											if(!$result)
												{
												$_SESSION["error_number"] = "3000";
												$_SESSION["error_message"] = "Query failed while getting complaints";
			
												$string = "error.php?error_number=";
												$string .= urlencode("DB_Query_Failed");
												$string .= "&error_message=";
												$string .= urlencode("Query failed while getting complaints");
												
												redirect_to($string);
												}
											else
												{
													while($row = mysqli_fetch_assoc($result))
														{
											echo '<tr>';
											echo '<td>'. $row['complaintid'] . '</td>';
											echo '<td>'. $row['userid'] . '</td>';
										
											
										
											echo '<td>'. $row['deptid'] . '</td>';
											echo '<td>'. $row['subject'] . '</td>';
											
											echo '<td>';
											echo "<form method=\"post\" action=\"dashboard.php\"> <input type=\"hidden\" name= \"complaintid\" value=\"". $row["complaintid"] ."\"> <button type=\"submit\" class=\"btn btn-outline btn-success\" name=\"approvecompliant\">Approve</button></form>";
											echo '</td>';
											echo '</tr>';
														}
												}
											mysqli_free_result($result);
														
											databaseconnectivity_close();
					  
											?>
                                            
                                            </tbody>
                                        </table>
                                         </div>
      </div>
    </div>
  </div>
                               

                                 
                                 
                                 
<?php
							}
						if($type == "managers")
							{
								redirect_to("managers-dashboard.php");
							}
						if($type == "assoc managers")
							{
								
							}
							
							
					}
						
						?>
						
                        
					
				
				
				<?php
					}
				}
		
		}

	
						/*echo is_string($userid)."<br>" .is_string($email)."<br>". is_string($username)."<br>". is_string($type)."<br>". is_string($deptid)."<br>". is_string($aadhar)."<br>". is_string($status)."<br>" .is_string($verificationkey)."<br>". is_string($block)."<br>" .is_string($address)."<br>". is_string($phno)."<br>". is_string($gender);*/


echo "</div>";

?>



<?php
echo footer();
?>
