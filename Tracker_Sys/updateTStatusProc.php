<?php
SESSION_START();
	include ('dbConfig.php');
	if(!empty($_POST))
 	{
     	$sql= "SELECT status FROM Tasks WHERE Task_id LIKE " . $_POST['taskId'] . "";
     	$result= mysql_query($sql) or die (mysql_error());
		$row= mysql_fetch_row($result);
		if (!($_POST[status] === $row[0]))
		{
			$query = "UPDATE Tasks SET status='$_POST[status]' WHERE Task_id like '$_POST[taskId]'";
			mysql_query($query);
		}
		
		mysql_close($connect);
		header("Location:viewTasks.php");
 		exit;
 	}
 	else
 	{
 		header("Location:viewTasks.php");
 		exit;
 	}
?>
