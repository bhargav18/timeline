<?php
	SESSION_START();
        date_default_timezone_set('America/Los_Angeles');
    include './DBConfig.php';
    $mysql = new DBConfig();
    $db = $mysql->getDBConfig();

    //Validating Inputs
	if(!empty($_POST))
 	{
 	$error = 0;
 	$holdName = $holdDesc = $holdSD = $holdED = $holdEmp = $holdEmpNames = $projId = "";
 	function test_input($data)   // to test input
	{
   		$data = stripslashes($data);
   		$data = htmlspecialchars($data);
   		return $data;
	}
	
 	function isEmpty($data)   
   {
       $data = trim($data);
       if (empty($data))
           return true;
      else
          return false;
   }
    if(isEmpty($_POST['taskname'])){
    	$_SESSION['nameError'] = "Task name is required"; $error = 1;}
    else if (!preg_match("/^[-a-zA-Z0-9 ]*$/",$_POST['taskname'])){
     	$_SESSION['nameError'] = "Only letters and whitespaces are allowed"; $error = 1;
     	$holdName = $_POST['taskname'];
    }
     else
     {
     	$_SESSION['nameError']="";
     	$holdName = $_POST['taskname'];
     }
    if(isEmpty($_POST['descr'])){
    	$_SESSION['tDescError'] = "Task description is required"; $error = 1;}
    else 
    {
     	$_SESSION['tDescError'] = "";
     	$holdDesc = test_input($_POST['descr']);
    }
    if (!empty($_POST['proj_id']))
    	$projId = $_POST['proj_id'];
    	
    if (empty($_POST['startdate'])){
     	$_SESSION['tSDateError'] = "Start Date is required"; $error = 1;}
    elseif (!empty($projId) && ($_POST['s'.$projId] > $_POST['startdate']))
    {
    	 $_SESSION['tSDateError'] = "Task cannot start before the project"; $error = 1;
    }
 	elseif (!empty($projId) && ($_POST['e'.$projId] < $_POST['startdate']))
    {
    	 $_SESSION['tSDateError'] = "Task cannot start after the project ends"; $error = 1;
    }
    else
    {
    	$_SESSION['tSDateError'] = "";
    	$holdSD = $_POST['startdate'];
    }
    if (empty($_POST['enddate'])){
     	$_SESSION['tEDateError'] = "End Date is required"; $error = 1;}
    elseif (!empty($projId) && $_POST['e'.$projId] < $_POST['enddate'])
    {
    	 $_SESSION['tEDateError'] = "Task cannot end after the project"; $error = 1;
    }
 	elseif (!empty($projId) && ($_POST['s'.$projId] > $_POST['enddate']))
    {
    	 $_SESSION['tEDateError'] = "Task cannot end before the project starts"; $error = 1;
    }
    else
    {
    	$_SESSION['tEDateError'] = "";
    	$holdED = $_POST['enddate'];
    }
    if (empty($_POST['emp'])){
    	$_SESSION['empError'] = "Please assign task to employees"; $error = 1;}
    else
    {
       	$_SESSION['empError'] = "";
       	$holdEmp = $_POST['emp'];
       	$holdEmpNames = $_POST['empName'];
    }

    	if ($error == 1)
    	{
    		$_SESSION['tName'] = $_POST['taskname'];
    		$_SESSION['tDesc']= $holdDesc;
    		$_SESSION['tProjId'] = !empty($_POST['proj_id'])?$_POST['proj_id']:"";
    		$_SESSION['tSDate']= $holdSD;
    		$_SESSION['tEDate']= $holdED;
    		$_SESSION['tSts'] = $_POST['status'];
    		$_SESSION['tPrio'] = $_POST['priority'];
    		$_SESSION['uEmpId'] = $holdEmp;
    		$_SESSION['uEmpName']= $holdEmpNames;
    		header("Location:createTask.php");
    		exit;
    	}
		$date = DateTime::createFromFormat('m/d/Y', $holdSD);
    	$holdSD = $date->format('Y-m-d');
    	$date = DateTime::createFromFormat('m/d/Y', $holdED);
    	$holdED = $date->format('Y-m-d');
    	if ($_POST['status'] === "Default")
    	{
    		if (strtotime($_POST['enddate']) < strtotime($_POST['clientTime']))
    			$sts = "Closed";
    		else 
    			$sts = "Open";
    	}
        else
            $sts = $_POST['status'];

		if (!empty($_POST['proj_id']))
		{
	        $stmt = $db->prepare('insert into tasks( name, project_uid, description, start_date, end_date, est_end_date, status, priority)'
	              . 'VALUES (?,?,?,?,?,?,?,?)');
	               
	        $stmt->bind_param('sdssssss',$_POST['taskname'],$_POST['proj_id'],$holdDesc,$holdSD,$holdED,$holdED,$sts,$_POST['priority']);
		}
		else // Individual task
		{
			$stmt = $db->prepare('insert into tasks( name, description, start_date, end_date, est_end_date, status, priority)'
	              . 'VALUES (?,?,?,?,?,?,?)');
	               
	        $stmt->bind_param('sssssss',$_POST['taskname'],$holdDesc,$holdSD,$holdED,$holdED,$sts,$_POST['priority']);
		}
		$stmt->execute();
		$holdTaskId =  mysqli_insert_id($db);                        
		foreach ($_POST['emp'] as $emp)
		{
                        
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
		$msg = 'A new task has been created';
        echo '<script type="text/javascript">alert("' . $msg . '");</script>';
        echo "<script>setTimeout(\"location.href = 'viewTasks.php';\",1500);</script>";
		exit;		
 	}
 	else
 	{
 		header("Location:createTask.php");
 		exit;
 	}
?>
		
