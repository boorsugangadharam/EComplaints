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
						
						if(isset($_POST["solvecomplaint"]))
							{
								$complaintid = $_POST["complaintid"];
								$feedback = $_POST["feedback"];
								$traversaldetails .="Complaint is closed by ". $_SESSION["username"]. "by user id" .$_SESSION["userid"];
								$traversaldetails .= $_POST["traversaldetails"];
								if($type == "managers" || $type == "assoc managers")
									{
									databaseconnectivity_open();
									global $connection;
									$feedback = mysqli_real_escape_string($connection, $feedback);
									$traversaldetails = mysqli_real_escape_string($connection, $traversaldetails);
									$query = "UPDATE `complaints` SET `status`=\"solved\",`feedback`=\"". $feedback ."\",`traversaldetails`=\"". $traversaldetails ."\"  WHERE `complaintid`=\"". $complaintid ."\" LIMIT 1";
									echo $query;
									
									$result = mysqli_query($connection, $query);
									mysqli_free_result($result);
		
									databaseconnectivity_close();
									}
								else
									{
										$_SESSION["warning_message"] = "Only department managers / associate managers can perform this operation";
										redirect_to("managers-dashboard.php");
									}
								
								
							}
						
						
							
						if(isset($_POST["reply"]))
							{
								if($type == "managers" || $type == "assoc managers")
									{
										$complaintid = $_POST["complaintid"];	
										
										
										databaseconnectivity_open();
		
										global $connection;
										
										$username = mysqli_real_escape_string($connection, $username);
										$query = "SELECT * FROM complaints,users WHERE complaintid=\"";
										$query .= $complaintid;
										$query .= "\" AND complaints.userid = users.userid LIMIT 1";
										
										$result = mysqli_query($connection, $query);
										while($row = mysqli_fetch_assoc($result))
											{
												$complaintid = $row["complaintid"];
												$userid = $row["userid"];
												$deptid = $row["deptid"];
												$status = $row["status"];
												$subject = $row["subject"];
												$body = $row["body"];
												$feedback = $row["feedback"];
												$traversaldetails = $row["traversaldetails"];
												$date = $row["date"];
												$username = $row["username"];
												$email = $row["email"];
												
												print_r($row);
											}
										mysqli_free_result($result);
				
										databaseconnectivity_close();
							
										?>
                                          
                                        
<h2 class="sub-header">Reply to complaint</h2>
                                        <form action="managers-dashboard.php" method="post" role="form" class="form-horizontal col-sm-6">
                      					<div class="control-group">
                        				<label for = "complaintid" class = "control-label">Complaint ID</label>
                       					<div class="controls">
                            			<input name="complaintid" class="form-control" type="text"  id = "complaintid" placeholder="Complaint ID" value="<?php echo $complaintid;?>" readonly>    
                    					</div>
                      					</div>
                      
                     	 				<div class="control-group">
                        				<label for = "userid" class = "control-label">User ID</label>
                        				<div class="controls">
                            			<input name="userid" class="form-control" type="text" id = "userid" placeholder="User ID" value="<?php echo $userid; ?>" disabled>
                     					</div>
                      					</div>
                      
                      					<div class="control-group">
                        				<label for="deptid" class ="control-label">Department ID</label>
                       					<div class="controls">
                            			<input name="deptid" class="form-control" type="text" id = "deptid" placeholder="Dept ID" value="<?php echo $deptid; ?>" disabled>
                          
                     					</div>
                      					</div>
                                        <div class="control-group">
                        				<label for="status" class ="control-label">Status</label>
                       					<div class="controls">
                            			<input name="status" class="form-control" type="text" id = "status" placeholder="Status" value="<?php echo $status; ?>" disabled>
                          
                     					</div>
                      					</div>
                  
                     					<div class="control-group">
                        				<label for="subject" class ="control-label">Subject</label>
                       					<div class="controls">
                            			<textarea name="subject" class="form-control" id = "subject" disabled="disabled"><?php echo $subject; ?></textarea>
                          
                     					</div>
                      					</div>
                                        <div class="control-group">
                        				<label for="body" class ="control-label">Body</label>
                       					<div class="controls">
                            			<textarea name="body" class="form-control" id = "body" disabled="disabled"><?php echo $body; ?></textarea>
                          
                     					</div>
                      					</div>
                                        <div class="control-group">
                        				<label for="feedback" class ="control-label">Feedback</label>
                       					<div class="controls">
                            			<textarea name="feedback" class="form-control" id = "feedback" required><?php echo $feedback; ?></textarea>
                          
                     					</div>
                      					</div>
                                        <div class="control-group">
                        				<label for="traversaldetails" class ="control-label">Traversal Details</label>
                       					<div class="controls">
                            			<textarea name="traversaldetails" class="form-control" id = "traversaldetails" disabled="disabled"><?php echo $traversaldetails; ?></textarea>
                          
                     					</div>
                      					</div>
                                        <div class="control-group">
                        				<label for = "date" class = "control-label">Date</label>
                        				<div class="controls">
                            			<input name="date" class="form-control" type="text" id = "date" placeholder="Date" value="<?php echo $date; ?>" disabled>
                     					</div>
                      					</div>
                                        <div class="control-group">
                        				<label for = "username" class = "control-label">Username</label>
                        				<div class="controls">
                            			<input name="username" class="form-control" type="text" id = "username" placeholder="Username" value="<?php echo $username; ?>" disabled>
                     					</div>
                      					</div>
                                        <div class="control-group">
                        				<label for = "email" class = "control-label">Email</label>
                        				<div class="controls">
                            			<input name="email" class="form-control" type="text" id = "email" placeholder="email" value="<?php echo $email; ?>" disabled>
                     					</div>
                      					</div>
                                    
                                        
                                      	<hr />
                                         
                                         <p>
                                          <div>
                                        <button type="submit" name="solvecomplaint" class="btn btn-success">Solve Complaint</button>
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                   		  </div>
                     					</p>  
                                     
                                      
                                      </form>
                                                        
							<?php			
									}
								else
									{
										$_SESSION["warning_message"] = "Only department managers / associate managers can perform this operation";
										redirect_to("managers-dashboard.php");
									}
							}
						
				if(!isset($_POST["Reply"]))
					{	
						
						if($type == "complainer")
							{
								redirect_to("dashboard.php");
							}
						if($type == "monitors")
							{
								redirect_to("dashboard.php");
							}
						if($type == "managers" || $type == "assoc managers")
							{
								?>
                                <?php
                               if(!isset($_POST["reply"]))
                               		{
										
										?>
                                  <div class="table-responsive">
                                    <table class="table table-striped">
                                              <thead>
                                                <tr>
                                                  <th>Complaint ID</th>
                                                  
                                                  <th>User ID</th>
                                               
                                                  <th>Username</th>
                                                  <th>Subject</th>
                                                  <th>Date</th>
                                                  <th>Action</th>
                                             
                                                </tr>
                                              </thead>
                                              <tbody>
                                            <?php
											databaseconnectivity_open();
		
											global $connection;
											//select * from complaints,departments where complaints.deptid = departments.deptid;
											$query = "SELECT * FROM complaints,users where complaints.status=\"active\" AND complaints.deptid=\"". $deptid ."\" GROUP BY complaintid ORDER BY date DESC";
											
											$result = mysqli_query($connection, $query);
											if(!$result)
												{
												$_SESSION["error_number"] = "3000";
												$_SESSION["error_message"] = "Query failed while getting complaints {$query}";
			
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
										
											
										
											echo '<td>'. $row['username'] . '</td>';
											echo '<td>'. $row['subject'] . '</td>';
											echo '<td>'. $row['date'] . '</td>';
											
											echo '<td>';
											echo "<form method=\"post\" action=\"managers-dashboard.php\"> <input type=\"hidden\" name= \"complaintid\" value=\"". $row["complaintid"] ."\"> <button type=\"submit\" class=\"btn btn-outline btn-success\" name=\"reply\">Solve</button></form>";
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
                                <?php
                               	}
                                ?>
                                
                                <?php
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
