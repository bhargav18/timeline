<?php
include './Template.php';
include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();
session_start();
$head = '<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="ModalPopupWindow.js" type="text/javascript"></script>
  <script src="js/updateTask.js" type="text/javascript"></script>';

$header = new Template("./header.php", array(head => $head, title => "Create a task"));
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
if (!empty($_SESSION['uTSDateError']))
{
	$sdateErr = $_SESSION['uTSDateError'];
	$_SESSION['uTSDateError'] = "";
}
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
                    
		$connect = mysql_connect("$db_hostname", "$db_usrname", "$db_passwrd") or die (mysql_error()); 
  			mysql_select_db("$db_name");
  			
  		if ($_POST['radio'])	
  			$selectedTask = $_POST['radio'];
  		else 
			$selectedTask = $id;

        $query="SELECT name, Task_id, status, Priority, Description, start_date, end_date, Project_id 
        		FROM Tasks WHERE Task_id like '$selectedTask'";
		$result= mysql_query($query) or die (mysql_error());
  		$row= mysql_fetch_row($result);
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
		if (!empty($_SESSION['uTSDate']))
		{echo "Got YOU";
			$sDate = $_SESSION['uTSDate'];
			$_SESSION['uTSDate'] = "";			
			
		}
		else
			$sDate = $row[5];
		if (!empty($_SESSION['uTEDate']))
		{
			$eDate = $_SESSION['uTEDate'];
			$_SESSION['uTEDate'] = "";
		}
		else
			$eDate = $row[6];
		$proj = $row[7];
?> 
                    ?>
                    <label>Task ID</label>
                    <label>151</label>
                    <input type="hidden" name="<?php echo $id ?>" value="151">
                    <label>Task Name</label>
                    <label><?php echo $name ?></label>
                    <!-- Description -->

                    <label for="exampleInputEmail1">Description</label>
                    <textarea name="descr" cols="50" rows="10"><?php echo $desc; ?></textarea>
                    <span class="err"><?php echo $descErr; ?></span>
                    <label>Project</label>
                    <label><?php echo $proj ?></label>
                    <!-- dates -->

                    <label for="exampleInputEmail1">Start Date</label>
                    <input readonly="true" value="<?php echo date("m/d/Y", strtotime($sDate)); ?>" id="from" name="startdate" class="form-control hasDatepicker">
                    <span class="error"><?php echo $sdateErr;?></span>
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" readonly="true" value="<?php echo date("m/d/Y", strtotime($eDate)); ?>" id="to" name="enddate" class="form-control hasDatepicker">
                    <span class="err"><?php echo $edateErr;?></span>
                    <!-- Status -->

                    <label for="exampleInputEmail1">Status</label>
                    <select style="width: 165px" name="status" class="form-control">
                        <option value="Open" <?php echo($sts === "Open")?"selected":""; ?>>Open</option>
                        <option value="In Progress" <?php echo ($sts === "In Progress")?"selected":""; ?>>In Progress</option>
                        <option value="Completed" <?php echo ($sts === "Completed")?"selected":""; ?>>Completed</option>
                        <option selected="" value="Closed" <?php echo ($sts === "Closed")?"selected":""; ?>>Closed</option>
                    </select>
                    <!-- Priority -->

                    <label for="exampleInputEmail1">Priority</label>	
                    <select style="width: 165px" name="priority" class="form-control">
                        <option selected="" value="High" <?php echo ($prio === "High")?"selected":""; ?>>High</option>
                        <option value="Mid" <?php echo ($prio === "Mid")?"selected":""; ?>>Mid</option>
                        <option value="Low" <?php echo ($prio === "Low")?"selected":""; ?>>Low</option>
                    </select>

                    <label for="exampleInputEmail1">Assignees</label>
                    <input type="button" value="Edit Assignees" onclick="ShowNewPage()" class="btn btn-info">
                    <div id="divShowChildWindowValues">
                        <dl id="empList">
                         <?php
//NEED - Validate Emp
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
	    $query = "SELECT first_name, last_name FROM Users WHERE EXISTS 
	    	(SELECT assignee FROM jobs WHERE Users.uid = jobs.assignee and task_id like '$selectedTask')";
		$result= mysql_query($query) or die (mysql_error());
		$i=0;
		while ($row = mysql_fetch_row($result))
		{
			echo "<input type='hidden' name='empName[]' id='n". $i ."' value = '" .$row[0] . " " . $row[1]. "'/>";
	    	echo "<p>" .$row[0] . " " . $row[1]. "</p>";
	    	$i++;
		}
	    }
?>   

                            <input type="hidden" value="qwer sadsdf" id="n0" name="empName[]"><p>qwer sadsdf</p><input type="hidden" value="Ddnsmfg jdfbhv." id="n1" name="empName[]"><p>Ddnsmfg jdfbhv.</p>	</dl></div>
                    <input type="submit" class="btn btn-info" value="Update Task" name="update">
                    <input type="submit" class="btn btn-info" value="Delete Task" name="delete">
                <?php 		
		mysql_close($connect);
else:
 		header("Location:viewTasks.php");
 		exit;
endif;
?>
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
?>