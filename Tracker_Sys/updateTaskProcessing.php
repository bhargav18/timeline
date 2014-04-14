<?php
 	SESSION_START();
	include ('dbConfig.php');	
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
    if (empty($_POST['startdate'])){
     	$_SESSION['uTSDateError'] = "Start Date is required"; $error = 1;}
    else
    {
    	$_SESSION['uTSDate']= $_POST['startdate'];
    	$_SESSION['uTSDateError'] = "";
    }
    if (empty($_POST['enddate'])){
     	$_SESSION['uTEDateError'] = "End Date is required"; $error = 1;}
 	else if ($_POST['enddate'] <= $_POST['startdate']){
        $_SESSION['uTEDateError'] = "End Date can not be same or before the start date"; $error = 1;}
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
    	

     	$sql= "SELECT status, Priority, Description FROM Tasks WHERE Task_id like '".$_POST['taskId']."'";
     	$result= mysql_query($sql) or die (mysql_error());
  		$row= mysql_fetch_row($result);
     				$t = $row[0];
		if (!($_POST['status'] == $row[0]))
		{
			$query1 = "UPDATE Tasks SET status='$_POST[status]' WHERE Task_id like '".$_POST['taskId']."'";
			mysql_query($query1);
		}
		if (!($_POST['priority'] == $row[1]))
		{
			$query2 = "UPDATE Tasks SET Priority='$_POST[priority]' WHERE Task_id like '".$_POST['taskId']."'";
			mysql_query($query2);
		}
		if (!($_POST['descr'] == $row[2]))
		{
			$query3 = "UPDATE Tasks SET Description='$_POST[descr]' WHERE Task_id like '".$_POST['taskId']."'";
			mysql_query($query3);
		}
		if ($_POST['startdate'])
		{
			$query4 = "UPDATE Tasks SET start_date=STR_TO_DATE('".$_POST['startdate']."','%m/%d/%Y') 
					WHERE Task_id like '".$_POST['taskId']."'";
			mysql_query($query4);
		}
     	if ($_POST['enddate'])
		{
			$query5 = "UPDATE Tasks SET end_date = STR_TO_DATE('".$_POST['enddate']."','%m/%d/%Y') WHERE Task_id like '".$_POST['taskId']."'";
			mysql_query($query5);
		}
	 	if (!empty($_POST['emp']))
	 	{
	 		$sql4 = "SELECT assignee FROM jobs WHERE Task_id like '".$_POST['taskId']."'";
	 		$result = mysql_query($sql4);
	 		$newArr = $removedArr = ""; $i=0;
			while ($row= mysql_fetch_row($result))
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
	 			$sql3 ="SELECT username FROM Users WHERE uid like '$emp'";
				$result = mysql_query($sql3);
				$row= mysql_fetch_row($result);
				$to = $row[0];
	            $subject = 'Task Update';
	            $message = 'You have been removed from task '.$selectedTask;
	                    
	            $headers = 'From: test@example.com' . "\r\n" .
	                    'Reply-To: webmaster@example.com' . "\r\n" .
	                    'X-Mailer: PHP/' . phpversion();
	
	            mail($to, $subject, $message, $headers);
			}
			
			$query6 = "DELETE FROM jobs WHERE Task_id like '".$_POST['taskId']."'";
			mysql_query($query6);
		 	foreach ($_POST['emp'] as $emp)
			{
				$query6="INSERT INTO jobs (task_id, assignee) VALUES ('".$_POST['taskId']."','".$emp."')";
				mysql_query($query6);
			}
	 	}
	 	
	 	//Email Notification
			$sql3 ="SELECT username FROM Users WHERE EXISTS 
	    			(SELECT assignee FROM jobs WHERE Users.uid = jobs.assignee and task_id like '$selectedTask')";
			$result = mysql_query($sql3);
			while ($row= mysql_fetch_row($result))
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
		$query1 = "DELETE FROM Tasks WHERE Task_id like '".$_POST['taskId']."'";
			mysql_query($query1);
		$query2 = "DELETE FROM jobs WHERE task_id like '".$_POST['taskId']."'";
			mysql_query($query2);
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