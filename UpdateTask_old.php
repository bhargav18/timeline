<?php
include './Template.php';
include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();

$head = '<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="ModalPopupWindow.js" type="text/javascript"></script>
  <script src="js/UpdateTask.js" type="text/javascript"></script>';

$header = new Template("./header.php", array(head => $head, title => "Update Task"));
$header->out();
session_start();
if (!empty($_POST) || !empty($_SESSION['tId'])) {
    
}
$id = $descErr = $sdateErr = $edateErr = $empErr = "";
if (!empty($_SESSION['tId'])) {
    $id = $_SESSION['tId'];
    $_SESSION['tId'] = "";
}
if (!empty($_SESSION['uTDescErr'])) {
    $descErr = $_SESSION['uTDescErr'];
    $_SESSION['uTDescErr'] = "";
}
if (!empty($_SESSION['uTSDateError'])) {
    $sdateErr = $_SESSION['uTSDateError'];
    $_SESSION['uTSDateError'] = "";
}
if (!empty($_SESSION['uTEDateError'])) {
    $edateErr = $_SESSION['uTEDateError'];
    $_SESSION['uTEDateError'] = "";
}
if (!empty($_SESSION['uEmpError'])) {
    $empErr = $_SESSION['uEmpError'];
    $_SESSION['uEmpError'] = "";
}
?>	



<form action= "updateTaskProcessing.php" method= "post">

<?php
if ($_POST['radio'])
    $selectedTask = $_POST['radio'];
else
    $selectedTask = $id;

$query = "SELECT name, uid, status, priority, Description, start_date, end_date, project_uid 
        		FROM tasks WHERE uid like '$selectedTask'";
$result = $db->query($query);
$row = mysqli_fetch_row($result);
$name = $row[0];
$id = $row[1];
if (!empty($_SESSION['uTSts'])) {
    $sts = $_SESSION['uTSts'];
    $_SESSION['uTSts'] = "";
} else
    $sts = $row[2];
if (!empty($_SESSION['uTPrio'])) {
    $prio = $_SESSION['uTPrio'];
    $_SESSION['uTPrio'] = "";
} else
    $prio = $row[3];
if (!empty($_SESSION['uTDesc'])) {
    $desc = $_SESSION['uTDesc'];
    $_SESSION['uTDesc'] = "";
} else
    $desc = $row[4];
if (!empty($_SESSION['uTSDate'])) {
    echo "Got YOU";
    $sDate = $_SESSION['uTSDate'];
    $_SESSION['uTSDate'] = "";
} else
    $sDate = $row[5];
if (!empty($_SESSION['uTEDate'])) {
    $eDate = $_SESSION['uTEDate'];
    $_SESSION['uTEDate'] = "";
} else
    $eDate = $row[6];
$proj = $row[7];
?> 


    <label>Task ID</label>
    <label><?php echo $id ?></label>
    <input type='hidden' value='<?php echo $id ?>' name='taskId'>



    <label>Task Name</label>
    <label><?php echo $name ?></label>


    <!-- Description -->

    <label for='exampleInputEmail1'>Description</label>
    <textarea rows='10' cols='50' name='descr' ><?php echo $desc; ?></textarea>
    <span class='err'><?php echo $descErr; ?></span>



    <label>Project</label>
    <label><?php echo $proj ?></label>


    <!-- dates -->

    <div>
        <label for="exampleInputEmail1">Start Date</label>
        <input  class="form-control" name="startdate" id="from" value='<?php echo date("m/d/Y", strtotime($sDate)); ?>' readonly="true"></input>
        <span class="error"><?php echo $sdateErr; ?></span>
    </div>



    <div>
        <label for="exampleInputEmail1">End Date</label>
        <input type="text" class="form-control" name="enddate" id="to" value='<?php echo date("m/d/Y", strtotime($eDate)); ?>' readonly="true"></input>
        <span class="err"><?php echo $edateErr; ?></span>
    </div>


    <!-- Status -->

    <label for='exampleInputEmail1'>Status</label>
    <select class='form-control' name='status' style='width: 165px'>
        <option value='Open' <?php echo($sts === "Open") ? "selected" : ""; ?>>Open</option>
        <option value='In Progress' <?php echo ($sts === "In Progress") ? "selected" : ""; ?>>In Progress</option>
        <option value='Completed' <?php echo ($sts === "Completed") ? "selected" : ""; ?>>Completed</option>
        <option value='Closed' <?php echo ($sts === "Closed") ? "selected" : ""; ?>>Closed</option>
    </select>


    <!-- Priority -->

    <label for='exampleInputEmail1'>Priority</label>	
    <select class='form-control' name='priority' style='width: 165px'>
        <option value='High' <?php echo ($prio === "High") ? "selected" : ""; ?>>High</option>
        <option value='Mid' <?php echo ($prio === "Mid") ? "selected" : ""; ?>>Mid</option>
        <option value='Low' <?php echo ($prio === "Low") ? "selected" : ""; ?>>Low</option>
    </select>



    <label for='exampleInputEmail1'>Assignees</label>
    <input type="button" class="btn btn-info" onclick="ShowNewPage()" value="Edit Assignees" />
    <span id="divShowChildWindowValues">
        <dl id='empList'>

<?php
//NEED - Validate Emp
if (!empty($_SESSION['uEmpId'])) {
    $i = 0;
    foreach ($_SESSION['uEmpId'] as $emp) {
        echo "<input type='hidden' name='emp[]' id='" . $i . "' value = '" . $emp . "'/>";
        $i++;
    }
    $_SESSION['uEmpId'] = "";
}
if (!empty($_SESSION['uEmpName'])) {
    $i = 0;
    foreach ($_SESSION['uEmpName'] as $emp) {
        echo "<input type='hidden' name='empName[]' id='n" . $i . "' value = '" . $emp . "'/>";
        echo "<p>" . $emp . "</p>";
        $i++;
    }
    $_SESSION['uEmpName'] = "";
}
//	    else
//	    {
//	    $query = "SELECT first_name, last_name FROM users WHERE EXISTS 
//	    	(SELECT assignee FROM jobs WHERE Users.uid = jobs.assignee and task_id like '$selectedTask')";
//		$result= $db->query($query);
//		$i=0;
//		while ($row = mysql_fetch_row($result))
//		{
//			echo "<input type='hidden' name='empName[]' id='n". $i ."' value = '" .$row[0] . " " . $row[1]. "'/>";
//	    	echo "<p>" .$row[0] . " " . $row[1]. "</p>";
//	    	$i++;
//		}
//	    }
?>
        </dl>




        <input type='submit' name='update' value= 'Update Task' class='btn btn-info'>
        <input type='submit' name='delete' value= 'Delete Task' class='btn btn-info'>

            <?php
            ?>
        </form>
            <? include './sidebar.php'; ?>
        <!-- content -->
        </div>

        <!-- /content-out -->
        </div>

        <!-- extra -->
<?php
include './footer.php';
?>