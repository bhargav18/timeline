<?php
 	SESSION_START();
    include './DBConfig.php';
    $mysql = new DBConfig();
    $db = $mysql->getDBConfig();
    
    //Validation
	if(!empty($_POST))
	{
	if ($_POST['update']) 
 	{
 		$error = 0;
 		$holdDesc = $holdED = "";
    if(empty($_POST['descr'])){
    	$_SESSION['uPDescErr'] = "Project description is required"; $error=1;}
    else if (!preg_match("/^[\n-()*,'.a-zA-Z0-9 ]*$/",$_POST['descr'])){
     	$_SESSION['uPDescErr'] = "Only letters and white space allowed"; $error=1;}
     else
     {
     	$holdDesc= $_POST['descr'];
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
 	if (empty($_POST['cost']))
	{	$_SESSION['pCostErr'] = "Project budget is required"; $error = 1;}
	elseif (!preg_match("/^[0-9]*$/",$_POST['cost']))
	{	$_SESSION['pCostErr'] = "Please enter numbers only"; $error = 1;}
	else
	{
		$_SESSION['pCostErr'] = "";
		$holdCost = $_POST['cost'];
	}

    if ($error == 1)
    {
    	$_SESSION['pId'] = $_POST[projId];
    	$_SESSION['uPSts'] = $_POST['status'];
    	$_SESSION['uPPrio'] = $_POST['priority'];
    	$_SESSION['uPDesc']= $holdDesc;
    	$_SESSION['uPEDate']= $holdED;
    	$_SESSION['cost'] = $holdCost;
   		header("Location:updateProject.php");
   		exit;
   	}
    else	
    {
     	$sql= "SELECT status, priority, description, cost FROM project WHERE uid like '".$_POST['projId']."'";
     	$result= $db->query($sql);
  		$row= mysqli_fetch_row($result);
     				$t = $row[0];
		if (!($_POST['status'] == $row[0]))
		{
			$query1 = "UPDATE project SET status='".$_POST['status']."' WHERE uid like '".$_POST['projId']."'";
                        $db->query($query1);
		}
		if (!($_POST['priority'] == $row[1]))
		{
			$query2 = "UPDATE project SET priority='".$_POST['priority']."' WHERE uid like '".$_POST['projId']."'";
			$db->query($query2);
		}
		if (!($_POST['descr'] == $row[2]))
		{
			$query3 = "UPDATE project SET description='".$_POST['descr']."' WHERE uid like '".$_POST['projId']."'";
			$db->query($query3);
		}
     	if ($_POST['enddate'])
		{
			$query5 = "UPDATE project SET end_date=STR_TO_DATE('".$_POST['enddate']."','%m/%d/%Y')
					WHERE uid like '".$_POST['projId']."'";
			$db->query($query5);
		}
    	if (!($_POST['cost'] == $row[3]))
		{
			$query1 = "UPDATE project SET status='".$_POST['cost']."' WHERE uid like '".$_POST['projId']."'";
                        $db->query($query1);
		}
		$msg = 'The project has been updated';
        echo '<script type="text/javascript">alert("' . $msg . '");</script>';
        echo "<script>setTimeout(\"location.href = 'viewProjects.php';\",1500);</script>";
		exit;
    }
	}
	//Do we need to delete projects? or move tem to another table
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
		$query5 = "SELECT users.email FROM users
				LEFT JOIN user_tasks ON users.uid = user_tasks.user_uid
				LEFT JOIN tasks ON tasks.uid = user_tasks.task_uid
				WHERE tasks.project_uid =  '2' '".$_POST['projId']."')";
		$result= $db->query($query5);
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