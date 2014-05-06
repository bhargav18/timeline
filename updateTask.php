<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
if ((!empty($_POST)&&!empty($_POST['radio'])) || !empty($_SESSION['tId'])):
include './Template.php';
include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();
$head = '<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="ModalPopupWindow.js" type="text/javascript"></script>
  
  <script src="js/updateTask3.js" type="text/javascript"></script>
  ';

$header = new Template("./header.php", array(head => $head, title => "Update Task"));
$header->out();

$id = $descErr = $sdateErr = $edateErr = $empErr = "";
if( !empty($_SESSION['tId']))
{
	$id = $_SESSION['tId'];
	$_SESSION['tId'] ="";
}
if(!empty($_SESSION['uTDescErr']))
{
	$descErr = $_SESSION['uTDescErr'];
	$_SESSION['uTDescErr']="";
}
/* Start date
if (!empty($_SESSION['uTSDateError']))
{
	$sdateErr = $_SESSION['uTSDateError'];
	$_SESSION['uTSDateError'] = "";
}
*/
if (!empty($_SESSION['uTEDateError']))
{
	$edateErr = $_SESSION['uTEDateError'];
	$_SESSION['uTEDateError'] = "";
}
if (!empty($_SESSION['uEmpError']))
{
	$empErr = $_SESSION['uEmpError'];
	$_SESSION['uEmpError'] = "";
}

?>

<!-- content-wrap -->
<div id="content-wrap">

    <!-- content -->
    <div id="content" class="clearfix">

        <!-- main -->
        <div id="main">

            <div class="main-content">
                <form method="post" action="updateTaskProcessing.php">
<?php 
                    
  			
  		if ($_POST['radio'])	
  			$selectedTask = $_POST['radio'];
  		else 
			$selectedTask = $id;

        $query="SELECT name, uid, status, priority, description, start_date, end_date, project_uid
        		FROM tasks WHERE uid like '$selectedTask'";
		$result= $db->query($query);
  		$row= mysqli_fetch_row($result);
		$name = $row[0];
		$id = $row[1];
		if (!empty($_SESSION['uTSts']))
		{
			$sts = $_SESSION['uTSts'];
			$_SESSION['uTSts'] = "";
		}
		else
			$sts = $row[2];
		if (!empty($_SESSION['uTPrio']))
		{
			$prio = $_SESSION['uTPrio'];
			$_SESSION['uTPrio'] = "";
		}
		else
			$prio = $row[3];
		if (!empty($_SESSION['uTDesc']))
		{
			$desc = $_SESSION['uTDesc'];
			$_SESSION['uTDesc'] = "";
		}
		else
			$desc = $row[4];
		/* Start date
		if (!empty($_SESSION['uTSDate']))
		{
			 = $_SESSION['uTSDate'];
			$_SESSION['uTSDate'] = "";			
			
		}
		else*/
		$date = DateTime::createFromFormat('Y-m-d', $row[5]);
    	$sDate = $date->format('m/d/Y');
		if (!empty($_SESSION['uTEDate']))
		{
			$eDate = $_SESSION['uTEDate'];
			$_SESSION['uTEDate'] = "";
		}
		else{
		$date = DateTime::createFromFormat('Y-m-d', $row[6]);
    	$eDate = $date->format('m/d/Y');
		}
		$proj = $row[7];
?> 
                    
                    <label>Task ID: <?php echo $id ?></label>
                    
                    <input type="hidden" name="taskId" value="<?php echo $id ?>">
                    <label>Task Name: <?php echo $name ?></label>                    
                    <!-- Description -->

                    <label >Description</label>
                    <textarea name="descr" cols="50" rows="10" maxlength = "20000" required><?php echo $desc; ?></textarea>
                    <span class="error"><?php echo $descErr; ?></span>
                    
                    <label>Project: <?php echo empty($proj)?"None":$proj ?></label> 
                    <?php 
                    if (!empty($proj)){
                    $query="SELECT end_date FROM project WHERE uid like '$proj'";
					$result= $db->query($query);
  					$row= mysqli_fetch_row($result);
  					$date = DateTime::createFromFormat('Y-m-d', $row[0]);
    				$projED = $date->format('m/d/Y');
                    echo '<input type="hidden" name="projED" value="'.$projED.'">';
                    } 
                    ?>                  
                    
                    <!-- dates -->
                    <label >Start Date</label>
                    <input readonly="true" value="<?php echo $sDate; ?>"  name="startdate">
                    <!--  Start date <span class="error"--><?php //echo $sdateErr;?><!--  /span>--> <!--id="from"-->
                    <label >End Date</label>
                    <input  readonly="true" value="<?php echo $eDate; ?>" id="to" name="enddate" >
                    <span class="error"><?php echo $edateErr;?></span>
                    
                    <!-- Status -->
                    <label >Status</label>
                    <span id='sts'></span>
                    <select style="width: 165px" name="status">
                        <option value="Open" <?php echo($sts === "Open")?"selected":""; ?>>Open</option>
                        <option value="In Progress" <?php echo ($sts === "In Progress")?"selected":""; ?>>In Progress</option>
                        <option value="Completed" <?php echo ($sts === "Completed")?"selected":""; ?>>Completed</option>
                        <?php 
                        if ($sts === "Completed")
                        	echo '<option value="Completion Approved">Completion Approved</option>';
                        elseif ($sts === "Completion Approved")
                        	echo '<option value="Completion Approved" selected >Completion Approved</option>';
                        	?>
                        <option value="Closed" <?php echo ($sts === "Closed")?"selected":""; ?>>Closed</option>
                    </select>
                    
                    <!-- Priority -->
                    <label >Priority</label>	
                    <select style="width: 165px" name="priority" >
                        <option selected="" value="High" <?php echo ($prio === "High")?"selected":""; ?>>High</option>
                        <option value="Mid" <?php echo ($prio === "Mid")?"selected":""; ?>>Mid</option>
                        <option value="Low" <?php echo ($prio === "Low")?"selected":""; ?>>Low</option>
                    </select>

                    <label >Assignees</label>
                    <input type="button" value="Edit Assignees" onclick="ShowNewPage()">
                    <span id="divShowChildWindowValues">
                        <dl id="empList">
                         <?php
		if (!empty($_SESSION['uEmpId']))
		{	$i = 0;
	    	foreach ($_SESSION['uEmpId'] as $emp)
	    	{
	    		echo "<input type='hidden' name='emp[]' id='". $i . "' value = '" .$emp. "'/>";
	    		$i++;
	    	}
	    	$_SESSION['uEmpId'] = "";
	    }
	    if (!empty($_SESSION['uEmpName']))
	    {
	    	$i = 0;
	    	foreach ($_SESSION['uEmpName'] as $emp)
	    	{	
	    		echo "<input type='hidden' name='empName[]' id='n". $i ."' value = '" .$emp. "'/>";
	    		echo "<p>" .$emp. "</p>";
	    		$i++;
	    	}	    	
	    	$_SESSION['uEmpName'] = "";
	    }
	    else
	    {
	    $query = "SELECT first_name, last_name FROM users WHERE EXISTS	
	    	(SELECT user_uid FROM user_tasks WHERE users.uid = user_tasks.user_uid and task_uid like '$selectedTask')";
		$result= $db->query($query);
		$i=0;
		while ($row = mysqli_fetch_row($result))
		{
			echo "<input type='hidden' name='empName[]' id='n". $i ."' value = '" .$row[0] . " " . $row[1]. "'/>";
	    	echo "<p>" .$row[0] . " " . $row[1]. "</p>";
	    	$i++;
		}
	    }
?>   

                 </dl></span>
                    <input type="submit" class="btn btn-info1" value="Update Task" name="update" onclick='getTime()'>
                    <input type="submit" class="btn btn-info2" value="Delete Task" name="delete"
                    		onclick='return confirm("You are about to delete the task. Do you want to continue?");'>
                    </br>
					<a href="viewTasks.php"><input type="button" value="Cancel" class='btn btn-info'/></a>
                </form>
            </div>

            <!-- /main -->
        </div>

        <!-- sidebar -->
        <? include './sidebar.php'; ?>
        <!-- content -->
    </div>

    <!-- /content-out -->
</div>

<!-- extra -->
<?php
include './footer.php';

else:
 		header("Location:viewTasks.php");
 		exit;
endif;
?>