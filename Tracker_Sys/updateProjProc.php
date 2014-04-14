<?php
 	SESSION_START();
	include ('dbConfig.php');	
 		//Validation
	if(!empty($_POST))
	{
	if ($_POST['update']) 
 	{
 		$error = 0;
    if(empty($_POST['descr'])){
    	$_SESSION['uPDescErr'] = "Project description is required"; $error=1;}
    else if (!preg_match("/^[\n-()*,'.a-zA-Z0-9 ]*$/",$_POST['descr'])){
     	$_SESSION['uPDescErr'] = "Only letters and white space allowed"; $error=1;}
     else
     {
     	$_SESSION['uPDesc']= $_POST['descr'];
     	$_SESSION['uPDescErr']="";
     }
    if (empty($_POST['enddate'])){
     	$_SESSION['uPEDateError'] = "End Date is required"; $error = 1;}
    else if (strtotime($_POST['enddate']) <= strtotime($_POST['startdate']))
    {	 $_SESSION['uPEDateError'] = "End Date can not be same or before the start date"; $error = 1;}
    else
    {
    	$_SESSION['uPEDate']= $_POST['enddate'];
    	$_SESSION['uPEDateError'] = "";
    }

    if ($error == 1)
    {
    	$_SESSION['pId'] = $_POST[projId];
    	$_SESSION['uPSts'] = $_POST['status'];
    	$_SESSION['uPPrio'] = $_POST['priority'];
   		header("Location:updateProject.php");
   		exit;
   	}
    else	
    {
     	$sql= "SELECT status, Priority, Description FROM Projects WHERE Project_id like '".$_POST['projId']."'";
     	$result= mysql_query($sql) or die (mysql_error());
  		$row= mysql_fetch_row($result);
     				$t = $row[0];
		if (!($_POST['status'] == $row[0]))
		{
			$query1 = "UPDATE Projects SET status='".$_POST['status']."' WHERE Project_id like '".$_POST['projId']."'";
			mysql_query($query1);
		}
		if (!($_POST['priority'] == $row[1]))
		{
			$query2 = "UPDATE Projects SET Priority='".$_POST['priority']."' WHERE Project_id like '".$_POST['projId']."'";
			mysql_query($query2);
		}
		if (!($_POST['descr'] == $row[2]))
		{
			$query3 = "UPDATE Projects SET Description='".$_POST['descr']."' WHERE Project_id like '".$_POST['projId']."'";
			mysql_query($query3);
		}
     	if ($_POST['enddate'])
		{
			$query5 = "UPDATE Projects SET end_date=STR_TO_DATE('".$_POST['enddate']."','%m/%d/%Y') 
					WHERE Project_id like '".$_POST['projId']."'";
			mysql_query($query5);
		}
		header("Location:viewProjects.php");
 		exit;
    }
	}
	//Do we need to delete projects? or move tem to another table
	elseif ($_POST['delete']) 
	{
		//Delete the project
		$query1 = "INSERT INTO ProjectsStorge (Project_id, Name, status, Priority, Description, start_date, end_date) 
			SELECT * FROM Projects WHERE Project_id like '".$_POST['projId']."'";
		mysql_query($query1);
		$query1 = "DELETE FROM Projects WHERE Project_id like '".$_POST['projId']."'";
		//mysql_query($query1);
		//Delete project's tasks
		$query1 = "INSERT INTO jobsStorge (assignee, Tasks_id)
			SELECT assignee FROM jobs WHERE EXISTS 
	    	(SELECT Task_id FROM Tasks WHERE Tasks.Task_id = jobs.task_id and Project_id like '".$_POST['projId']."')";
		mysql_query($query1);
		$query1 = "DELETE FROM jobs WHERE Task_id in 
	    	(SELECT Task_id FROM Tasks WHERE Tasks.Task_id = jobs.task_id and Project_id like '".$_POST['projId']."')";
		//mysql_query($query1);
		$sql1 = "SELECT * FROM Tasks WHERE Project_id like '".$_POST['projId']."'";
		$result = mysql_query($sql1);
		while($row= mysql_fetch_row($result))
		{	$query1 = "INSERT INTO TasksStorge (Task_id, Project_id, Name, Priority, status, start_date, end_date, Description) 
				VALUES
				('".$row[0]."','".$row[1]."','".$row[2]."','".$row[3]."', 
				'".$row[4]."', '".$row[5]."','".$row[6]."')";
			mysql_query($query1);
		}
		$query1 = "DELETE FROM Tasks WHERE Project_id like '".$_POST['projId']."'";
		//mysql_query($query1);
		header("Location:viewProjects.php");
 		exit;
	}
	}
 	else
 	{
 		header("Location:viewProjects.php");
 		exit;
 	}
?>