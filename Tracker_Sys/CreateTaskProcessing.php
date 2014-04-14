<?php
	SESSION_START();
	include ('dbConfig.php');
				//header('Location: viewTasks.php');
	//Validating Inputs
	if(!empty($_POST))
 	{
 	$error = 0;
    if(empty($_POST['taskname'])){
    	$_SESSION['nameError'] = "Task name is required"; $error = 1;}
    else if (!preg_match("/^[-a-zA-Z0-9 ]*$/",$_POST['taskname'])){
     	$_SESSION['nameError'] = "Only letters and white space allowed"; $error = 1;}
     else
     {
     	$_SESSION['nameError']="";
     }
    if(empty($_POST['descr'])){
    	$_SESSION['tDescError'] = "Task description is required"; $error = 1;}
    else if (!preg_match("/^[\n-()*,'.a-zA-Z0-9 ]*$/",$_POST['descr']))
    {
     	$_SESSION['tDescError'] = "Only letters and white space allowed"; $error = 1;
    }
     else
     {
     	$_SESSION['tDescError']="";
     }
    if (empty($_POST["proj_id"]))
    	{$_SESSION['tProjError'] = "Project is required"; $error = 1;}
    else
    {
  		$_SESSION['tProjError'] = "";
    }
    if (empty($_POST['startdate'])){
     	$_SESSION['sDateError'] = "Start Date is required"; $error = 1;}
    else
    {
    	$_SESSION['tSDateError'] = "";
    }
    if (empty($_POST['enddate'])){
     	$_SESSION['tEDateError'] = "End Date is required"; $error = 1;}
    else
    {
    	$_SESSION['tEDateError'] = "";
    }
    if (empty($_POST['emp'])){
    	$_SESSION['empError'] = "Please assign task to employees"; $error = 1;}
    else
    {
       	$_SESSION['empError'] = "";
    }

    	if ($error == 1)
    	{
    		$_SESSION['tName'] = $_POST['taskname'];
    		$_SESSION['tDesc']= $_POST['descr'];
    		$_SESSION['tProjId'] = $_POST["proj_id"];
    		$_SESSION['tSDate']= $_POST['startdate'];
    		$_SESSION['tEDate']= $_POST['enddate'];
    		$_SESSION['tSts'] = $_POST['status'];
    		$_SESSION['tPrio'] = $_POST['priority'];
    		$_SESSION['uEmpId'] = $_POST['emp'];
    		$_SESSION['uEmpName']= $_POST['empName'];
    		header("Location:createTask.php");
    		exit;
    	}
	
    	if ($_POST['status'] === "Default")
    	{
    		if (strtotime($_POST['enddate']) > strtotime($_POST['clientTime']))
    			$sts = "Closed";
    		else 
    			$sts = "Open";
    	}

		$sql="INSERT INTO Tasks ( Name, Project_id, Description, start_date, end_date, status, Priority)
		VALUES
		('".$_POST['taskname']."','".$_POST['proj_id']."','".$_POST['descr']."',STR_TO_DATE('".$_POST['startdate']."','%m/%d/%Y'), 
		STR_TO_DATE('".$_POST['enddate']."','%m/%d/%Y'), '".$sts."','".$_POST['priority']."')";
		
		mysql_query($sql);
			
		$holdTaskId = mysql_insert_id();
		foreach ($_POST['emp'] as $emp)
		{
			$sql2="INSERT INTO jobs (task_id, assignee) VALUES ('$holdTaskId','$emp')";
			mysql_query($sql2);
			//Email Notification
			$sql3 ="SELECT username FROM Users WHERE uid like ".$emp;
			$result = mysql_query($sql3);
			$row= mysql_fetch_row($result);
			$to = $row[0];
            $subject = 'New Task';
            $message = 'A new task has been assigned to you';
                    
            $headers = 'From: test@example.com' . "\r\n" .
                    'Reply-To: webmaster@example.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);
		}
		header("Location:viewTasks.php");
		exit;
		
 	}
 	else
 	{
 		header("Location:createTask.php");
 		exit;
 	}
?>
		
