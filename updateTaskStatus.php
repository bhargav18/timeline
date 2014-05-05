<?php
SESSION_START();
if (!empty($_POST)):
include './Template.php';
date_default_timezone_set('America/Los_Angeles');
include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();

$head = '<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="ModalPopupWindow.js" type="text/javascript"></script>';

$header = new Template("./header.php", array('head' => $head, 'title' => "Update Task status", 'return'=>"updateTaskStatus.php", 'current_page'=>3));
$header->out();
if($_POST['radio'] == NULL){
    header("Location: viewTasks.php");
}
?>

<!-- content-wrap -->
<div id="content-wrap">

    <!-- content -->
    <div id="content" class="clearfix">

        <!-- main -->
        <div id="main">

            <div class="main-content">
                <form method="post" action="updateTStatusProc.php">
                    <?php
  			
  		$selectedTask = $_POST['radio'];

        $query="SELECT name, uid, status, priority, description, start_date, end_date, project_uid  FROM tasks WHERE uid like '$selectedTask'";
     	$result= $db->query($query);
		
  		$row= mysqli_fetch_row($result);
	
			 $name = $row[0];
			 $id = $row[1];
			 $sts = $row[2];
			 $prio = $row[3];
			 $desc = $row[4];
			 $date = DateTime::createFromFormat('Y-m-d', $row[5]);
    		 $sDate = $date->format('m/d/Y');
			 $date = DateTime::createFromFormat('Y-m-d', $row[6]);
    		 $eDate = $date->format('m/d/Y');
			 $proj = $row[7];
?>
<table class="empTask">
                    <tr>
                        <td class="bold">Task ID:   </td><td><?php echo $id ?></td>
                    </  tr>
                    <input type="hidden" name="taskId" value="<?php echo $id ?>">
                    <tr>
                        <td class="bold">Name:    </td><td>   <?php echo $name ?></td>
                    </tr>
                    <tr>
                        <td class="bold">Project:    </td><td>   <?php echo $proj ?></td>
                    </tr>
                    <tr>
                        <td class="bold">Start Date:   </td><td>   <?php echo $sDate ?></td>
                    </tr>
                    <tr>
                            <td class="bold">End Date:   </td><td>   <?php echo $eDate  ?></td>
                    </tr>
                    <tr>
                        <td class="bold">Priority:   </td><td>   <?php echo $prio ?></td>
                    </tr>
                    <tr>
                            <td class="bold">Description:   </td><td>   <?php echo $desc ?></td>
                    </tr>
</table>


                    <?php 
	if ($sts === "Open")
		{
?>
                    
    <label  class="bold">Status</label>
	<select class='form-control' name='status' style='width: 165px'>
		<option value='Open' <?php echo($sts === "Open")?"selected":"" ?>>Open</option>
		<option value='In Progress' <?php echo ($sts === "In Progress")?"selected":""; ?>>In Progress</option>
  </select>

  		

<?php 
		}
		else if ( $sts == "In Progress")
		{
?>
        
    <label class="bold">Status</label>
	<select name='status' style='width: 165px'>
		<option value='In Progress' <?php echo($sts === "In Progress")?"selected":"" ?>>In Progress</option>
		<option value='Completed' <?php echo ($sts === "Completed")?"selected":""; ?>>Completed</option>
  </select>
    <?php
		}
		else 
		{
?>              
                    
                    <label class="bold">Status</label>
                    <select disabled="" style="width: 165px" name="status" class="form-control">
                        <option value="<?php echo $sts ?>"><?php echo $sts ?></option>
                    </select>
<?php 
		}
?>

                    <label class="bold">Assignees</label>
                    <table>
<?php 
    	$query = "SELECT first_name, last_name, email FROM users WHERE EXISTS
	    	(SELECT user_uid FROM user_tasks WHERE users.uid = user_tasks.user_uid and task_uid like '$selectedTask')";
     	$result= $db->query($query);
    	while ($row = mysqli_fetch_row($result))
		{
	    	echo "<tr><td>" .$row[0] . " " . $row[1]. "</td><td>" . $row[2]. "</td><tr>";
	    }
?>
				</table>              
                    <input type="submit" value="Update Status" name="submit" class='btn btn-info1'
                    	<?php echo ($sts === "Completed" || $sts === "Closed")? "disabled":""?>>
                    <a href="viewTasks.php"><input type="button" value="Cancel" class='btn btn-info2'/></a>
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