<?php
	SESSION_START();
    include './DBConfig.php';
    $mysql = new DBConfig();
    $db = $mysql->getDBConfig();

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
    		$_SESSION['tProjId'] = $_POST['proj_id'];
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
    		if (strtotime($_POST['enddate']) < strtotime($_POST['clientTime']))
    			$sts = "Closed";
    		else 
    			$sts = "Open";
    	}

		
                $stmt = $db->prepare('insert into tasks( name, project_uid, description, start_date, end_date, est_end_date, status, priority)'
                        . 'VALUES (?,?,?,STR_TO_DATE(?,"%m/%d/%Y"),STR_TO_DATE(?,"%m/%d/%Y"),STR_TO_DATE(?,"%m/%d/%Y"),?,?)');
               
                $stmt->bind_param('sdsssssd',$_POST['taskname'],$_POST['proj_id'],$_POST['descr'],$_POST['startdate'],$_POST['enddate'],$_POST['enddate'],$sts,$_POST['priority']);
                $stmt->execute();
		$holdTaskId =  mysqli_insert_id($db);                        
		foreach ($_POST['emp'] as $emp)
		{
                        
//			$sql2="INSERT INTO user_tasks (task_uid, user_uid) VALUES ('$holdTaskId','$emp')";
//			$db->query($sql2);
			$stmt = $db->prepare('INSERT INTO user_tasks (task_uid, user_uid) VALUES (?,?)');
                        $stmt->bind_param('dd',$holdTaskId,$emp);
                        $stmt->execute();
                        //Email Notification
			$sql3 ="SELECT email FROM users WHERE uid like ".$emp;			
                        $result = $db->query($sql3);
			$row= mysqli_fetch_row($result);
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
		
