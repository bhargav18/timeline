<?php
 	SESSION_START();
    include './DBConfig.php';
    $mysql = new DBConfig();
    $db = $mysql->getDBConfig();
 	
 		//Check for correctness
	if(!empty($_POST))
	{
	if ($_POST[update]) 
 	{
 		$error = 0;
    if(empty($_POST['descr'])){
    	$_SESSION['uTDescErr'] = "Task description is required"; $error=1;}
    else if (!preg_match("/^[\n-()*,'.a-zA-Z0-9 ]*$/",$_POST['descr'])){
     	$_SESSION['uTDescErr'] = "Only letters and white space allowed"; $error=1;}
     else
     {
     	$_SESSION['uTDesc']= $_POST['descr'];
     	$_SESSION['uTDescErr']="";
     }
     /* Start date
    if (empty($_POST['startdate'])){
     	$_SESSION['uTSDateError'] = "Start Date is required"; $error = 1;}
    else
    {
    	$_SESSION['uTSDate']= $_POST['startdate'];
    	$_SESSION['uTSDateError'] = "";
    }
    */
    if (empty($_POST['enddate'])){
     	$_SESSION['uTEDateError'] = "End Date is required"; $error = 1;}
 	else if ($_POST['enddate'] <= $_POST['startdate']){
        $_SESSION['uTEDateError'] = "End Date can not be before the start date"; $error = 1;}
    else
    {
    	$_SESSION['uTEDate']= $_POST['enddate'];
    	$_SESSION['uTEDateError'] = "";
    }
    if (empty($_POST['empName'])){
    	$_SESSION['uEmpError'] = "Please assign task to emplyees"; $error = 1;}
    else
    {
    	$_SESSION['uEmpError'] = "";
    }

    if ($error == 1)
    {
    	$_SESSION['tId'] = $_POST['taskId'];
    	$_SESSION['uTSts'] = $_POST['status'];
    	$_SESSION['uTPrio'] = $_POST['priority'];
    	$_SESSION['uEmpName']= $_POST['empName'];
    	$_SESSION['uEmpId']= (empty($_POST['emp'])?"":$_POST['emp']);
   		header("Location:UpdateTask.php");
   		exit;
   	}
    	

     	$sql= "SELECT status, priority, description FROM tasks WHERE uid like '".$_POST['taskId']."'";
     	$result= $db->query($sql);
  		$row= mysqli_fetch_row($result);
     				$t = $row[0];
		if (!($_POST['status'] == $row[0]))
		{
			$query1 = "UPDATE tasks SET status='".$_POST['status']."' WHERE uid like '".$_POST['taskId']."'";
			$db->query($query1);
		}
		if (!($_POST['priority'] == $row[1]))
		{
			$query2 = "UPDATE tasks SET priority='.".$_POST['priority']."' WHERE uid like '".$_POST['taskId']."'";
			$db->query($query2);
		}
		if (!($_POST['descr'] == $row[2]))
		{
			$query3 = "UPDATE tasks SET description='".$_POST['descr']."' WHERE uid like '".$_POST['taskId']."'";
			$db->query($query3);
		}
		/* Start date
		if ($_POST['startdate'])
		{
			$query4 = "UPDATE tasks SET start_date=STR_TO_DATE('".$_POST['startdate']."','%m/%d/%Y')
					WHERE uid like '".$_POST['taskId']."'";
			$db->query($query4);
		}
		*/
     	if ($_POST['enddate'])
		{
			$query5 = "UPDATE tasks SET end_date = STR_TO_DATE('".$_POST['enddate']."','%m/%d/%Y') WHERE uid like '".$_POST['taskId']."'";
			$db->query($query5);
		}
	 	if (!empty($_POST['emp']))
	 	{
	 		$sql4 = "SELECT user_uid FROM user_tasks WHERE task_uid like '".$_POST['taskId']."'";
	 		$result = $db->query($sql4);
	 		$newArr = $removedArr = ""; $i=0;
			while ($row= mysqli_fetch_row($result))
			{
				foreach ($_POST['emp'] as $emp)
					if ($emp == $row[0])
						$found = 1;
					if ($found != 1)
					{
						$removedArr[i] = $row[0];
						$i++;
					}
			}
	 		//Notify removed employees
	 		foreach ($removedArr as $emp)
	 		{	
	 			$sql3 ="SELECT email FROM users WHERE uid like '$emp'";
				$result = $db->query($sql3);
				$row= mysqli_fetch_row($result);
				$to = $row[0];
	            $subject = 'Task Update';
	            $message = 'You have been removed from task '.$selectedTask;
	                    
	            $headers = 'From: test@example.com' . "\r\n" .
	                    'Reply-To: webmaster@example.com' . "\r\n" .
	                    'X-Mailer: PHP/' . phpversion();
	
	            mail($to, $subject, $message, $headers);
			}
			
			$query6 = "DELETE FROM user_tasks WHERE task_uid like '".$_POST['taskId']."'";
			$db->query($query6);
		 	foreach ($_POST['emp'] as $emp)
			{
				$query6="INSERT INTO user_tasks (task_uid, user_uid) VALUES ('".$_POST['taskId']."','".$emp."')";
				$db->query($query6);
			}
	 	}
	 	
	 	//Email Notification
			$sql3 ="SELECT email FROM users WHERE EXISTS
	    			(SELECT user_uid FROM user_tasks WHERE users.uid = user_tasks.user_uid and task_uid like '$selectedTask')";
			$result = $db->query($sql3);
			while ($row= mysqli_fetch_row($result))
			{
				$to = $row[0];
	            $subject = 'Task Update';
	            $message = 'Task '.$selectedTask.' has been updated';
	                    
	            $headers = 'From: test@example.com' . "\r\n" .
	                    'Reply-To: webmaster@example.com' . "\r\n" .
	                    'X-Mailer: PHP/' . phpversion();
	
	            mail($to, $subject, $message, $headers);
			}
	    
		header("Location:viewTasks.php");
 		exit;
	}
	elseif ($_POST[delete]) 
	{
		$query1 = "DELETE FROM tasks WHERE uid like '".$_POST['taskId']."'";
			$db->query($query1);
		$query2 = "DELETE FROM user_tasks WHERE task_uid like '".$_POST['taskId']."'";
			$db->query($query2);
		header("Location:viewTasks.php");
 		exit;
	}
 	}
 	else
 	{
 		header("Location:viewTasks.php");
 		exit;
 	}
?>