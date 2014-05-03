<?php
 	SESSION_START();
    include './DBConfig.php';
    $mysql = new DBConfig();
    $db = $mysql->getDBConfig();
    
    function test_input($data)  
	{
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}
	
 	function isEmpty($data) 
   {
      if (empty(trim($data)))
          return true;
      else
          return false;
   }
   
    //Validation
	if(!empty($_POST))
	{
	if ($_POST['update']) 
 	{
 		$error = 0;
 		$holdDesc = $holdED = $holdCost="";
    if(isEmpty($_POST['descr'])){
    	$_SESSION['uPDescErr'] = "Project description is required"; $error=1;}
     else
     {
     	$holdDesc= test_input($_POST['descr']);     	
     	$_SESSION['uPDescErr']="";
     }
    if (empty($_POST['enddate'])){
     	$_SESSION['uPEDateError'] = "End Date is required"; $error = 1;}
    else if (strtotime($_POST['enddate']) <= strtotime($_POST['startdate']))
    {	 $_SESSION['uPEDateError'] = "End date can not be same or before the start date"; $error = 1;}
    else
    {
    	$holdED = $_POST['enddate'];
    	$_SESSION['uPEDateError'] = "";
    }
 	if (isEmpty($_POST['cost']))
	{	$_SESSION['uPCostErr'] = "Project budget is required"; $error = 1;}
	elseif (!preg_match("/^[,.0-9]*$/",$_POST['cost']))
	{	$_SESSION['uPCostErr'] = "Please enter a valid value"; 
		$holdCost = $_POST['cost'];
		$error = 1;
	}
	else
	{
		$_SESSION['uPCostErr'] = "";
		$holdCost = $_POST['cost'];
	}

    if ($error == 1)
    {
    	$_SESSION['pId'] = $_POST[projId];
    	$_SESSION['uPSts'] = $_POST['status'];
    	$_SESSION['uPPrio'] = $_POST['priority'];
    	$_SESSION['uPDesc']= $holdDesc;
    	$_SESSION['uPEDate']= $holdED;
    	$_SESSION['uPCost'] = $holdCost;
   		header("Location:updateProject.php");
   		exit;
   	}
    else	
    {
     	$sql= "SELECT status, priority, description, cost, end_date FROM project WHERE uid like '".$_POST['projId']."'";
     	$result= $db->query($sql);
  		$row= mysqli_fetch_row($result);
     				$t = $row[0];
		
     	$date = DateTime::createFromFormat('m/d/Y', $holdED);
    	$holdED = $date->format('Y-m-d');
     	if ($_POST['status'] != $row[0] || $_POST['priority'] != $row[1] || $holdDesc != $row[2] || $holdCost != $row[3] || $holdED != $row[4])
     	{
    	$stmt = $db->prepare("UPDATE project SET status = ?, priority = ?, description = ?, cost = ?, end_date = ? WHERE uid like '".$_POST['projId']."'"); 
		$stmt->bind_param('sssss', $_POST['status'], $_POST['priority'], $holdDesc, $holdCost, $holdED);
		$stmt->execute();
		if ( $_POST['status'] == 'Completed' || $_POST['status'] == 'Closed')
		{
			$query5 = "UPDATE tasks SET status='Closed' WHERE (status='Open' OR status='In Progress') and project_uid like '".$_POST['projId']."'";
			$db->query($query5);
			$query6 = "SELECT users.email, tasks.uid FROM users
					LEFT JOIN user_tasks ON users.uid = user_tasks.user_uid
					LEFT JOIN tasks ON tasks.uid = user_tasks.task_uid
					WHERE tasks.project_uid = '".$_POST['projId']."'
					AND (tasks.status='Open' OR tasks.status='In Progress')";
			$result= $db->query($query6);
			if (mysqli_num_rows($result) > 0) 
			{
			while ($row = mysqli_fetch_row($result))
			{
				$to = $row[0];
		        $subject = 'Task Update';
		        $message = 'Task "'.$row[1].'" has been closed';
		                    
		        $headers = 'From: test@example.com' . "\r\n" .
		                    'Reply-To: webmaster@example.com' . "\r\n" .
		                    'X-Mailer: PHP/' . phpversion();
		
		        mail($to, $subject, $message, $headers);
			}}
		}
		$msg = 'The project has been updated';
        echo '<script type="text/javascript">alert("' . $msg . '");</script>';
     }
        echo "<script>setTimeout(\"location.href = 'viewProjects.php';\",500);</script>";
		exit;
    }
	}
	//Ddelete the project 
	elseif ($_POST['delete']) 
	{
		//Delete the project
		$query5 = "UPDATE project SET `deleted`='Y' WHERE uid like '".$_POST['projId']."'";
                error_log( "UPDATE project SET `delete`='yes' WHERE uid like '".$_POST['projId']."'");
			$db->query($query5);
		$query5 = "UPDATE tasks SET deleted='Y' WHERE project_uid like '".$_POST['projId']."'";
			$db->query($query5);
			
		//delete emp and notify them
		$query5 = "UPDATE user_tasks INNER JOIN tasks 
				ON user_tasks.task_uid = tasks.uid and tasks.project_uid like '".$_POST['projId']."'
				SET user_tasks.deleted='Y'";
			$db->query($query5);
		$query6 = "SELECT users.email FROM users
				LEFT JOIN user_tasks ON users.uid = user_tasks.user_uid
				LEFT JOIN tasks ON tasks.uid = user_tasks.task_uid
				WHERE tasks.project_uid = '".$_POST['projId']."'";
		$result= $db->query($query6);
		if (mysqli_num_rows($result) > 0) 
		{
		while ($row = mysqli_fetch_row($result))
		{
			$to = $row[0];
	        $subject = 'Task Update';
	        $message = 'Project "'.$_POST['projId'].'" and all related tasks has been deleted';
	                    
	        $headers = 'From: test@example.com' . "\r\n" .
	                    'Reply-To: webmaster@example.com' . "\r\n" .
	                    'X-Mailer: PHP/' . phpversion();
	
	        mail($to, $subject, $message, $headers);
		}
		}
		$msg = 'The project has been deleted';
        echo '<script type="text/javascript">alert("' . $msg . '");</script>';
        echo "<script>setTimeout(\"location.href = 'viewProjects.php';\",1500);</script>";
		exit;
	}
	}
 	else
 	{
 		header("Location:viewProjects.php");
 		exit;
 	}
?>