<?php
SESSION_START();
        date_default_timezone_set('America/Los_Angeles');
    include './DBConfig.php';
    $mysql = new DBConfig();
    $db = $mysql->getDBConfig();
	if(!empty($_POST))
 	{
     	$sql= "SELECT status FROM tasks WHERE uid LIKE " . $_POST['taskId'] . "";
     	$result= $db->query($sql);
		$row= mysqli_fetch_row($result);
		if (!($_POST['status'] === $row[0]))
		{
			$query = "UPDATE tasks SET status='$_POST[status]' WHERE uid like '".$_POST['taskId']."'";
			$db->query($query);
		
			$query6 = "SELECT email FROM users WHERE access_level = '2'";
			$result= $db->query($query6);
			if (mysqli_num_rows($result) > 0) 
			{
			while ($row = mysqli_fetch_row($result))
			{
				$to = $row[0];
		        $subject = 'Task Update';
		        $message = 'Task "'.$_POST['taskId'].'" has been completed';
		                    
		        $headers = 'From: test@example.com' . "\r\n" .
		                    'Reply-To: webmaster@example.com' . "\r\n" .
		                    'X-Mailer: PHP/' . phpversion();
		
		        mail($to, $subject, $message, $headers);
			}}
		
			
		$msg = 'Tasks status has been updated';
        echo '<script type="text/javascript">alert("' . $msg . '");</script>';
		}
        echo "<script>setTimeout(\"location.href = 'viewTasks.php';\",50);</script>";
		exit;
 	}
 	else
 	{
 		header("Location:viewTasks.php");
 		exit;
 	}
?>
