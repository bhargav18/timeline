<?php
 	SESSION_START();
    include './DBConfig.php';
    $mysql = new DBConfig();
    $db = $mysql->getDBConfig();
    
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
     	$sql= "SELECT status, priority, description FROM project WHERE uid like '".$_POST['projId']."'";
     	$result= $db->query($sql);
  		$row= mysqli_fetch_row($result);
     				$t = $row[0];
		if (!($_POST['status'] == $row[0]))
		{
			$query1 = "UPDATE project SET status='".$_POST['status']."' WHERE uid like '".$_POST['projId']."'";
                        $db->query($query1);
		}
		if (!($_POST['priority'] == $row[1]))
		{
			$query2 = "UPDATE project SET priority='".$_POST['priority']."' WHERE uid like '".$_POST['projId']."'";
			$db->query($query2);
		}
		if (!($_POST['descr'] == $row[2]))
		{
			$query3 = "UPDATE project SET description='".$_POST['descr']."' WHERE uid like '".$_POST['projId']."'";
			$db->query($query3);
		}
     	if ($_POST['enddate'])
		{
			$query5 = "UPDATE project SET end_date=STR_TO_DATE('".$_POST['enddate']."','%m/%d/%Y')
					WHERE uid like '".$_POST['projId']."'";
			$db->query($query5);
		}
		header("Location:viewProjects.php");
 		exit;
    }
	}
	//Do we need to delete projects? or move tem to another table
	elseif ($_POST['delete']) 
	{
		//Delete the project
		$query5 = "UPDATE project SET `delete`='yes' WHERE uid like '".$_POST['projId']."'";
                error_log( "UPDATE project SET `delete`='yes' WHERE uid like '".$_POST['projId']."'");
			$db->query($query5);
		$query5 = "UPDATE tasks SET delete='yes' WHERE project_uid like '".$_POST['projId']."'";
			$db->query($query5);
		//delete emp
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