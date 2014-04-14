<?php
include('header.php');
include ('dbConfig.php');
$_SESSION[username] = "Manger";
$_SESSION[uid] = "3";
$nextForm = "";
if ($_SESSION[username] === "Manager")
	$nextForm = "updateTask.php";
else
	$nextForm = "updateTaskStatus.php";
?>
<head>

<title>Tasks</title>

</head>

<body>
		
<div class="container">
<h3>
	<font color="#0283bd">
	<br></br>
	Tasks
</h3>
<form action= "<?php echo $nextForm ?>" method= "post">
<table class="table">

<?php
if ($_SESSION[username] === "Manager")
{
	$query= "SELECT Task_id, Name FROM Tasks";   
}
else
{
	$query = "SELECT Task_id, Name FROM Tasks WHERE EXISTS 
	    	(SELECT task_id FROM jobs WHERE Tasks.Task_id = jobs.task_id and assignee like '$_SESSION[uid]')";   
	
}
	
$result= mysql_query($query) or die (mysql_error());

while($row= mysql_fetch_row($result)){

 $id = $row[0];
 $n = $row[1];
echo'<tr><td>';
 echo "<input type='radio' name='radio' value= '$id' >  " ;
 echo $id . " " . $n;
 echo '</td></tr>';
}        
?>

		<tr>
			<td><input type='submit'  name= 'submit' value= 'Select Task' class='btn btn-info'></td>
		</tr>
		</table></form></div>
</body>
