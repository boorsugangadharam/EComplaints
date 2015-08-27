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
					//view Complaints that user is posted
					?>
                    
                    
                    
<?php                    
//show user indetail about complaint
if(isset($_POST["complaintidread"]))
	{
	$complaintid = $_POST["complaintid"];
	databaseconnectivity_open();
		
	global $connection;
	//select * from complaints,departments where complaints.deptid = departments.deptid;
	$query = "SELECT * FROM complaints,departments where complaints.complaintid =". $complaintid ." AND complaints.deptid = departments.deptid LIMIT 1";
	$result = mysqli_query($connection, $query);
	if(!$result)
		{
		$_SESSION["error_number"] = "2012";
		$_SESSION["error_message"] = "Query failed while getting complaints";

		$string = "error.php?error_number=";
		$string .= urlencode("DB_Query_Failed");
		$string .= "&error_message=";
		$string .= urlencode("Query failed while getting complaints");
		
		redirect_to($string);
		}
	else
		{
			?>
			<div class="panel panel-success">
  			<div class="panel-heading">
    		<h3 class="panel-title">Complaint Details</h3>
  			</div>
  			<div class="panel-body">
    		<?php
			echo"<div class=\"row\">";
            echo"<table class=\"table table-striped table-bordered\">";
			while($row = mysqli_fetch_assoc($result))
				{
	
				 echo "<tr><td>Complaint id</td><td>". $row['complaintid']. "</td></tr>";
				 echo "<tr><td>Username</td><td>".$username. "</td></tr>";
				 echo "<tr><td>User id</td><td>". $row['userid']. "</td></tr>";
				 echo "<tr><td>Department name</td><td>". $row['deptname']. "</td></tr>";
				 echo "<tr><td>Department id</td><td>". $row['deptid'] . "</td></tr>";
				 echo "<tr><td>Status</td><td>". $row['status']. "</td></tr>";
				 echo "<tr><td>Subject</td><td>". $row['subject']. "</td></tr>";
				 echo "<tr><td>Body</td><td>". $row['body']. "</td></tr>";
				 echo "<tr><td>Feedback</td><td>". $row['feedback']. "</td></tr>";
				 echo "<tr><td>Traversal details</td><td>". $row['traversaldetails']. "</td></tr>";
				 echo "<tr><td>Date</td><td>". $row['date']. "</td></tr>";

				}
		  echo "</table></div> </div>
			</div>";
		}
	mysqli_free_result($result);
				
	databaseconnectivity_close();


	}
    
    ?>
   <?php
    if(!isset($_POST["complaintidread"]))
	
		{
	
	?>
                    <div class="row">
                    <table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Complaint id</th>
		                  
		                  <th>Department name</th>
		                  <th>Status</th>
                          <th>Subject</th>
                          <th>Body</th>
                          <th>Feedback</th>
                          <th>Date</th>
		                </tr>
		              </thead>
		              <tbody>
                      <?php
					  			databaseconnectivity_open();
		
								global $connection;
								//select * from complaints,departments where complaints.deptid = departments.deptid;
								$query = "SELECT * FROM complaints,departments where complaints.userid =". $userid ." AND complaints.deptid = departments.deptid ORDER BY date DESC";
								$result = mysqli_query($connection, $query);
								if(!$result)
									{
									$_SESSION["error_number"] = "2012";
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
							
								echo '<td>'. $row['deptname'] . '</td>';
							
								echo '<td>'. $row['status'] . '</td>';
								echo '<td>'. $row['subject'] . '</td>';
								echo '<td>'. $row['body'] . '</td>';
								echo '<td>'. $row['feedback'] . '</td>';
								echo '<td>'. $row['date'] . '</td>';
							   	echo '<td width=50>';
							   	echo "<form method=\"post\" action=\"viewcomplaint.php\"> <input type=\"hidden\" name= \"complaintid\" value=\"". $row["complaintid"] ."\"> <button type=\"submit\" class=\"btn btn-outline btn-success\" name=\"complaintidread\">Read</button></form>";
							   	echo '</td>';
							   	echo '</tr>';
											}
									}
								mysqli_free_result($result);
											
								databaseconnectivity_close();
					  
					  
		}
		
		?>
                      
                    
					<?php
				}
			
		}
	
		
		
	  echo"</div>";
	  
	  echo footer();

?>

