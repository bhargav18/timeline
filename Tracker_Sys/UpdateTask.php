<?php
SESSION_START();
if (!empty($_POST) || !empty($_SESSION['tId'])):
include('header.php');

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
<html>
<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="ModalPopupWindow.js" type="text/javascript"></script>
  
<!--<script src="jquery.js"></script> -->
<script>
 $(function() {
    $( "#from" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
</script>

	<title>Update Task</title>
</head>

<body>
<div class="container">
<h3>
	<font color="#0283bd" />
	<br></br>
	Update Task
</h3>
<form action= "updateTaskProcessing.php" method= "post">
<table class="table" style="width: 300px">

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

<tr>
	<td><label>Task ID</label></td>
	<td><label><?php echo $id ?></label></td>
	<input type='hidden' value='<?php echo $id ?>' name='taskId'>
</tr>

<tr>
	<td><label>Task Name</label></td>
	<td><label><?php echo $name ?></label></td>
</tr>

<!-- Description -->
 <tr>
    <td><label for='exampleInputEmail1'>Description</label></td>
    <td><textarea rows='10' cols='50' name='descr' ><?php echo $desc; ?></textarea></td>
    <td><span class='err'><?php echo $descErr; ?></span></td>
</tr>

<tr>
	<td><label>Project</label></td>
	<td><label><?php echo $proj ?></label></td>
</tr>

<!-- dates -->
<tr>
	<div>
	  <td><label for="exampleInputEmail1">Start Date</label></td>
      <td><input  class="form-control" name="startdate" id="from" value='<?php echo date("m/d/Y", strtotime($sDate)); ?>' readonly="true"></input></td>
      <td><span class="error"><?php echo $sdateErr;?></span></td>
    </div>
</tr>

<tr>
	<div>
	  <td><label for="exampleInputEmail1">End Date</label></td>
      <td><input type="text" class="form-control" name="enddate" id="to" value='<?php echo date("m/d/Y", strtotime($eDate)); ?>' readonly="true"></input></td>
      <td><span class="err"><?php echo $edateErr;?></span></td>
     </div>
</tr>
    
<!-- Status -->
<tr>
    <td><label for='exampleInputEmail1'>Status</label></td>
	<td><select class='form-control' name='status' style='width: 165px'>
		<option value='Open' <?php echo($sts === "Open")?"selected":""; ?>>Open</option>
		<option value='In Progress' <?php echo ($sts === "In Progress")?"selected":""; ?>>In Progress</option>
		<option value='Completed' <?php echo ($sts === "Completed")?"selected":""; ?>>Completed</option>
  		<option value='Closed' <?php echo ($sts === "Closed")?"selected":""; ?>>Closed</option>
  </select></td>
</tr>

<!-- Priority -->
 <tr>
    <td><label for='exampleInputEmail1'>Priority</label></td>	
	<td><select class='form-control' name='priority' style='width: 165px'>
		<option value='High' <?php echo ($prio === "High")?"selected":""; ?>>High</option>
		<option value='Mid' <?php echo ($prio === "Mid")?"selected":""; ?>>Mid</option>
  		<option value='Low' <?php echo ($prio === "Low")?"selected":""; ?>>Low</option>
  </select></td>
</tr>

<tr>
    <td><label for='exampleInputEmail1'>Assignees</label></td>
    <td><input type="button" class="btn btn-info" onclick="ShowNewPage()" value="Edit Assignees" /></td>
    <td><div id="divShowChildWindowValues">
    <dl id='empList'>
	
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
	</dl></div></td>
</tr>
	

<tr>
  <td><input type='submit' name='update' value= 'Update Task' class='btn btn-info'></td>
  <td><input type='submit' name='delete' value= 'Delete Task' class='btn btn-info'></td>
</tr>       		
<?php 		
		mysql_close($connect);
else:
 		header("Location:viewTasks.php");
 		exit;
endif;
?>
</table>
  </form></div>

<script>
//PopUp Window
 var modalWin = new CreateModalPopUpObject();
 modalWin.SetLoadingImagePath("images/loading.gif");
 modalWin.SetCloseButtonImagePath("images/remove.gif");

function ShowNewPage(){
 var callbackFunctionArray = new Array(Assign, Cancel);
 modalWin.Draggable=false;
 modalWin.ShowURL('assignEmp.php',320,470,'Assign Employees to Task',null,callbackFunctionArray);
 }
 
//This is for Assign button
function Assign(msg){
modalWin.HideModalPopUp();
}

//This for cancel button
function Cancel(){
modalWin.HideModalPopUp();
}

function ShowChildWindowValues(names, ids) {
    var displayString = "";
    var div = document.getElementById("divShowChildWindowValues");
	//var x = document.getElementById("main");
	var empList = document.getElementById("empList");
	var arr = new Array();
	if (arr = document.getElementsByName("emp[]")){
	for (var i = 0; i < arr.length; i++)
	{
		var emp = document.getElementById(i);
		emp.parentNode.removeChild(emp); 
		emp = document.getElementById("n"+i);
		emp.parentNode.removeChild(emp); 
		i++;
	}}
	var x = document.createElement('div');
    x.setAttribute('id', 'main');
    div.appendChild(x);
    var c=0;
    for (var i=0; names.length>i; i++)
    {      
        var newElm = document.createElement("input");
        newElm.setAttribute("type", "hidden");
        var elmName = 'emp[]';
        newElm.setAttribute("name",elmName);
        newElm.setAttribute("id",''+i);
        newElm.setAttribute("value", ""+ids[i]);
        x.appendChild(newElm);

        //Keep Names
        var newElm = document.createElement("input");
        newElm.setAttribute("type", "hidden");
        newElm.setAttribute("name",'empName[]');
        newElm.setAttribute("id",''+ "n"+i);
        newElm.setAttribute("value", ""+names[i]);
        x.appendChild(newElm);
        
        displayString += names[i] + "<br><br>";
        c=i;
    }
    var lm = document.createElement("input");
    lm.setAttribute("type", "hidden");
    var name = 'assignees_count';
    lm.setAttribute("name",name);
    lm.setAttribute("value", "fd");
    x.appendChild(lm);
    //div.innerHTML = displayString;
    empList.innerHTML = displayString;
}
 </script>
</body>
</html>