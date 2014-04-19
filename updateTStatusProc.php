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
		
		header("Location:viewTasks.php");
 		exit;
 	}
 	else
 	{
 		header("Location:viewTasks.php");
 		exit;
 	}
?>
