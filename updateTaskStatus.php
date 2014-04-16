<?php
include './Template.php';
include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();

$head = '<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="ModalPopupWindow.js" type="text/javascript"></script>';

$header = new Template("./header.php", array(head => $head, title => "Update Task status"));
$header->out();
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
		$connect = mysql_connect("$db_hostname", "$db_usrname", "$db_passwrd") or die (mysql_error()); 
  			mysql_select_db("$db_name");
  			
  		$selectedTask = $_POST['radio'];

        $query="SELECT name, Task_id, status, Priority, Description, start_date, end_date, Project_id  FROM Tasks WHERE Task_id like '$selectedTask'";
		$result= mysql_query($query) or die (mysql_error());

  		$row= mysql_fetch_row($result);
	
			 $name = $row[0];
			 $id = $row[1];
			 $sts = $row[2];
			 $prio = $row[3];
			 $desc = $row[4];
			 $sDate = $row[5];
			 $eDate = $row[6];
			 $proj = $row[7];
?>                        
                    <label>Name</label>
                    <label><?php echo $name ?></label>
                    <label>Task ID</label>
                    <label><?php echo $id ?></label>
                    <input type="hidden" name="taskId" value="<?php echo $id ?>">
                    <!-- Description -->

                    <label for="exampleInputEmail1">Description</label>
                    <p><?php echo $desc; ?></p>
                    <label>Project</label>
                    <p><?php echo $proj ?></p>

                    <!-- dates -->

                    <label for="exampleInputEmail1">Start Date</label>
                    <p><?php echo date("m/d/Y", strtotime($sDate)); ?></p>
                    <label for="exampleInputEmail1">End Date</label>
                    <p><?php echo date("m/d/Y", strtotime($eDate)); ?></p>
                    <?php 
	if ($sts === "Open")
		{
?>
                    
    <label for='exampleInputEmail1'>Status</label>
	<select class='form-control' name='status' style='width: 165px'>
		<option value='Open' <?php echo($sts === "Open")?"selected":"" ?>>Open</option>
		<option value='In Progress' <?php echo ($sts === "In Progress")?"selected":""; ?>>In Progress</option>
  </select>

  		

	<input type='submit' name= 'submit' value= 'Update Task' class='btn btn-info'>
<?php 
		}
		else if ( $sts == "In Progress")
		{
?>
        
    <label for='exampleInputEmail1'>Status</label>
	<select class='form-control' name='status' style='width: 165px'>
		<option value='In Progress' <?php echo($sts === "In Progress")?"selected":"" ?>>In Progress</option>
		<option value='Completed' <?php echo ($sts === "Completed")?"selected":""; ?>>Completed</option>
  </select>
    <?php
		}
		else 
		{
?>              
                    
                    <label>Status</label>
                    <select disabled="" style="width: 165px" name="status" class="form-control">
                        <option value="<?php echo $sts ?>"><?php echo $sts ?></option>
                    </select>
                    <label>You can not update task status</label>
<?php 
		}
?>
                    <!-- Priority -->

                    <label for="exampleInputEmail1">Priority</label>	
                    <p><?php echo $prio; ?></p>
                    <label for="exampleInputEmail1">Assignees</label>
                    <div id="divShowChildWindowValues">
                        <dl id="empList">
                            <?php 
    	$query = "SELECT first_name, last_name FROM Users WHERE EXISTS 
	    	(SELECT assignee FROM jobs WHERE Users.uid = jobs.assignee and task_id like '$selectedTask')";
		$result= mysql_query($query) or die (mysql_error());
		while ($row = mysql_fetch_row($result))
		{
	    	echo "<p>" .$row[0] . " " . $row[1]. "</p>";
	    }
?>  </dl></div>
     <?php 
		mysql_close($connect);
?>               
                    <input type="submit" class="btn btn-info" value="Update Status" name="submit">
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
<?php 
else:
 		header("Location:viewTasks.php");
 		exit;
endif;
?>