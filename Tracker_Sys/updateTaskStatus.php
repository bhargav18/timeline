<?php
SESSION_START();
if (!empty($_POST)):
include('header.php');
?>
<html>
<head>
	<title>Update Task Status</title>
</head>

<body>
<div class="container">
<h3>
	<font color="#0283bd">
	<br></br>
	Update Task Status
</h3>
<form action= "updateTStatusProc.php" method= "post">
<table class="table" style="width: 300px">

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
<tr>
	<td><label>Name</label></td>
	<td><label><?php echo $name ?></label></td>
</tr>

<tr>
	<td><label>Task ID</label></td>
	<td><label><?php echo $id ?></label></td>
	<input type='hidden' value='<?php echo $id ?>' name='taskId'>
</tr>

<!-- Description -->
 <tr>
    <td><label for='exampleInputEmail1'>Description</label></td>
    <td><p><?php echo $desc; ?></p></td>
</tr>

<tr>
	<td><label>Project</label></td>
	<td><p><?php echo $proj ?></p></td>
</tr>

<!-- dates -->
<tr>
	<div>
	  <td><label for="exampleInputEmail1">Start Date</label></td>
      <td><p><?php echo date("m/d/Y", strtotime($sDate)); ?></p></td>
    </div>
</tr>

<tr>
	<div>
	  <td><label for="exampleInputEmail1">End Date</label></td>
      <td><p><?php echo date("m/d/Y", strtotime($eDate)); ?></p></td>
     </div>
</tr>

<?php 
	if ($sts === "Open")
		{
?>			 
<tr>
    <td><label for='exampleInputEmail1'>Status</label>	</td>
	<td><select class='form-control' name='status' style='width: 165px'>
		<option value='Open' <?php echo($sts === "Open")?"selected":"" ?>>Open</option>
		<option value='In Progress' <?php echo ($sts === "In Progress")?"selected":""; ?>>In Progress</option>
  </select></td>
</tr>
  		
<tr>
	<td><input type='submit' name= 'submit' value= 'Update Task' class='btn btn-info'></td>
</tr>
<?php 
		}
		else if ( $sts == "In Progress")
		{
?>

<tr>
    <td><label for='exampleInputEmail1'>Status</label>	</td>
	<td><select class='form-control' name='status' style='width: 165px'>
		<option value='In Progress' <?php echo($sts === "In Progress")?"selected":"" ?>>In Progress</option>
		<option value='Completed' <?php echo ($sts === "Completed")?"selected":""; ?>>Completed</option>
  </select></td>
</tr>
  		
<?php
		}
		else 
		{
?>
<tr>
	<td><label>Status</label></td>
	<td><select class='form-control' name='status' style='width: 165px' disabled>
		<option value='<?php echo $sts ?>'><?php echo $sts ?></option>
  </select></td>
	<td><label>You can not update task status</label></td>
</tr>

<?php 
		}
?>
<!-- Priority -->
 <tr>
    <td><label for='exampleInputEmail1'>Priority</label></td>	
	<td><p><?php echo $prio; ?></p></td>
</tr>

<tr>
    <td><label for='exampleInputEmail1'>Assignees</label></td>
    <td><div id="divShowChildWindowValues">
    <dl id='empList'>
<?php 
    	$query = "SELECT first_name, last_name FROM Users WHERE EXISTS 
	    	(SELECT assignee FROM jobs WHERE Users.uid = jobs.assignee and task_id like '$selectedTask')";
		$result= mysql_query($query) or die (mysql_error());
		while ($row = mysql_fetch_row($result))
		{
	    	echo "<p>" .$row[0] . " " . $row[1]. "</p>";
	    }
?>
	</dl></div></td>
    	
<tr>

<?php 
		mysql_close($connect);
?>
	<td><input type='submit' name= 'submit' value= 'Update Status' class='btn btn-info'></td>
</tr>
</table>
</form>       
</div>
</body>
</html>
<?php 
else:
 		header("Location:viewTasks.php");
 		exit;
endif;
?>
