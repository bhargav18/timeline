<?php
SESSION_START();
if (!empty($_POST) || !empty($_SESSION['pId']))
{
include('header.php');

$id = $descErr = $edateErr ="";

if( !empty($_SESSION['pId']))
{
	$id = $_SESSION['pId'];
	$_SESSION['pId'] ="";
}
if(!empty($_SESSION['uPDescErr']))
{
	$descErr = $_SESSION['uPDescErr'];
	$_SESSION['uPDescErr']="";
}
if (!empty($_SESSION['uPEDateError']))
{
	$edateErr = $_SESSION['uPEDateError'];
	$_SESSION['uPEDateError'] = "";
}
?>	
<html>
<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  
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

	<title>Update Project</title>
</head>

<body>
<div class="container">
<h3>
	<font color="#0283bd" />
	<br></br>
	Update Project
</h3>
<form action= "updateProjProc.php" method= "post">
 	<div id="main">
<table class="table" style="width: 300px">

<?php 

		$connect = mysql_connect("$db_hostname", "$db_usrname", "$db_passwrd") or die (mysql_error()); 
  			mysql_select_db("$db_name");
  		if ($_POST['radio'])	
  			$selectedProj = $_POST['radio'];
  		else 
			$selectedProj = $id;
			
        $query="SELECT name, project_id, status, Priority, Description, start_date, end_date 
        		FROM Projects WHERE project_id like '$selectedProj'";
		$result= mysql_query($query) or die (mysql_error());
  		$row= mysql_fetch_row($result);
		$name = $row[0];
		$id = $row[1];
		if (!empty($_SESSION['uPSts']))
		{
			$sts = $_SESSION['uPSts'];
			$_SESSION['uTSts'] = "";
		}
		else
			$sts = $row[2];

		if (!empty($_SESSION['uPDesc']))
		{
			$desc = $_SESSION['uPDesc'];
			$_SESSION['uTDesc'] = "";
		}
		else
			$desc = $row[4];
		$sDate = $row[5];
		if (!empty($_SESSION['uPEDate']))
		{
			$eDate = $_SESSION['uPEDate'];
			$_SESSION['uPEDate'] = "";
		}
		else
			$eDate = $row[6];
?> 

<tr>
	<td><label>Project ID</label></td>
	<td><label><?php echo $id; ?></label></td>
	<input type='hidden' value='<?php echo $id; ?>' name='projId'/>
</tr>

<tr>
	<td><label>Project Name</label></td>
	<td><label><?php echo $name; ?></label></td>
</tr>

<!-- Description -->
 <tr>
    <td><label for='exampleInputEmail1'>Description</label></td>
    <td><textarea rows='10' cols='50' name='descr' ><?php echo $desc; ?></textarea></td>
    <td><span class='err'><?php echo $descErr;$descErr =""; ?></span></td>
</tr>

<!-- dates -->
<tr>
	<div>
	  <td><label for="exampleInputEmail1">Start Date</label></td>
      <td><input  class="form-control" name="startdate" value='<?php echo date("m/d/Y", strtotime($sDate)); ?>' readonly="true"></input></td>
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
		<option value='Open' <?php echo ($sts === "Open")?"selected":""; ?>>Open</option>
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
  <td><input type='submit' name='update' value= 'Update Project' class='btn btn-info'></td>
  <td><input type='submit' name='delete' value= 'Delete Project' class='btn btn-info'></td>
</tr>  
</table>
  </form></div>     		
<?php 		
		mysql_close($connect);
}
else
{
	header("Location:viewProjects.php");
 		exit;
}
?>

</body>
</html>