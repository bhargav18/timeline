<?php
SESSION_START();
    include './DBConfig.php';
    $mysql = new DBConfig();
    $db = $mysql->getDBConfig();
	if(!empty($_POST))
 	{
     	$sql= "SELECT status FROM tasks WHERE uid LIKE " . $_POST['taskId'] . "";
     	$result= $db->query($sql);
		$row= mysqli_fetch_row($result);
		if (!($_POST[status] === $row[0]))
		{
			$query = "UPDATE tasks SET status='$_POST[status]' WHERE uid like '".$_POST['taskId']."'";
			$db->query($query);
		}
		
		$msg = 'Tasks status has been updated';
        echo '<script type="text/javascript">alert("' . $msg . '");</script>';
        echo "<script>setTimeout(\"location.href = 'viewTasks.php';\",1500);</script>";
		exit;
 	}
 	else
 	{
 		header("Location:viewTasks.php");
 		exit;
 	}
?>
