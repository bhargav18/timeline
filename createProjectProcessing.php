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
 	$holdName = $holdDesc = $holdSD = $holdED = $holdCost = "";
 	function test_input($data)   // to test input
	{
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}
	
 	function isEmpty($data)   // to test input!!
   {
       $data = trim($data);
       if (empty($data))
          return true;
      else
          return false;
   }
   
    if(isEmpty($_POST['projname'])){
    	$_SESSION['pNameErr'] = "Project name is required"; $error = 1;}
    else if (!preg_match("/^[-a-zA-Z0-9 ]*$/",$_POST['projname'])){
     	$_SESSION['pNameErr'] = "Only letters and white space allowed"; $error = 1;
     	$holdName = $_POST['projname'];
    }
     else
     {
     	$_SESSION['pNameErr']="";
     	$holdName = $_POST['projname'];
     }
     
    if(isEmpty($_POST['descr'])){
    	$_SESSION['pDescErr'] = "Project description is required"; $error = 1;}
     else
     {
     	$_SESSION['pDescErr']="";
     	$holdDesc = test_input($_POST['descr']);
     }
    if (empty($_POST['startdate'])){
     	$_SESSION['pSDateErr'] = "Start Date is required"; $error = 1;}
    else
    {
    	$_SESSION['pSDateErr'] = "";
    	$holdSD = $_POST['startdate'];
    }
    if (empty($_POST['enddate'])){
     	$_SESSION['pEDateErr'] = "End Date is required"; $error = 1;}
    elseif (strtotime($_POST['enddate']) == strtotime($_POST['startdate']))
    {
    	$_SESSION['pEDateErr'] = "End date cannot be same as start date";   $error = 1;
    }
 	else
    {
    	$_SESSION['pEDateErr'] = "";
    	$holdED = $_POST['enddate'];
    }
	if (empty($_POST['cost']))
	{	$_SESSION['pCostErr'] = "Project budget is required"; $error = 1;}
	elseif (!preg_match("/^[,.0-9]*$/",$_POST['cost']))
	{	$_SESSION['costErr'] = "Please enter a valid cost"; 
		$holdCost = $_POST['cost'];
		$error = 1;}
	else
	{
		$_SESSION['costErr'] = "";
		$holdCost = $_POST['cost'];
	}
	
    	if ($error == 1)
    	{
    		$_SESSION['pName'] = $_POST['projname'];
    		$_SESSION['pDesc']= $holdDesc;
    		$_SESSION['pSDate']= $holdSD;
    		$_SESSION['pEDate']= $holdED;
    		$_SESSION['pSts'] = $_POST['status'];
    		$_SESSION['pPrio'] = $_POST['priority'];
    		$_SESSION['pCost'] = $holdCost;
    		header("Location:createProject.php");
    		exit;
    	}
		$sts = "";
    	if ($_POST['status'] === "Default")
    	{
    		if (strtotime($_POST['enddate']) < strtotime($_POST['clientTime']))
    			$sts = "Closed";
    		else 
    			$sts = "Open";
    	}
    	else
    		$sts = $_POST['status'];

                $stmt = $db->prepare('insert into project( name,cost, description, start_date, end_date, est_end_date, status, priority)'
                        . 'VALUES (?,?,?,STR_TO_DATE(?,"%m/%d/%Y"),STR_TO_DATE(?,"%m/%d/%Y"),STR_TO_DATE(?,"%m/%d/%Y"),?,?)');
               
                $stmt->bind_param('ssssssss',$_POST['projname'],$holdCost,$holdDesc,$_POST['startdate'],$_POST['enddate'],$_POST['enddate'],$sts,$_POST['priority']);
                $stmt->execute();

		$msg = 'A new project has been created';
        echo '<script type="text/javascript">alert("' . $msg . '");</script>';
        echo "<script>setTimeout(\"location.href = 'viewProjects.php';\",1500);</script>";
		exit;
 	}
 	else
 	{
 		header("Location:createProject.php");
 		exit;
 	}
?>
		
