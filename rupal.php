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
// $(function() {
//    $( "#start_date" ).datepicker();
//    $( "#end_date" ).datepicker();
//  });  
function fun1()
{
//alert('hii');                                      
var cost_value  = document.getElementById("cost").value;  
if(cost_value < 1)
{
   alert('Enter estimation value more than zero') ;
   return false;
}
else
{
   //alert('hii');
   document.getElementById("form1").submit();
   return true;
}
}

function fun2()
{
   window.location = 'http://localhost/homework_462/index.php';
}
</script>
</head>
<body>
<?php
//DebugBreak();
$project_id =  $_POST['project_id'];
$project_name =  $_POST['project_name'];
$description =  $_POST['description'];
$brief_description =  $_POST['brief_description'];
$priority =  $_POST['priority'];
$status =  $_POST['Status'];
$uid =  $_POST['uid'];
$date =  $_POST['from'];
$cost =  $_POST['cost'];
$end_date =  $_POST['to'];
$t_id =  $_POST['t_id'];
if($_POST)
{
$link = mysql_connect('localhost', 'root', '');
mysql_select_db("homework_462",$link);
$query_project_id = "Select * from project where pid= '$project_id'" ;
$result1 = mysql_query($query_project_id,$link);  
if (mysql_numrows($result1)) {
   $message =  "Invalid Projectid" ;
}
else
{
$query = "insert into project (pid,name,description,brief_description,start_date,end_date,status,priority,asignee,task_id,cost) values ('$project_id','$project_name','$description','$brief_description','$date','$end_date','$status','$priority','$uid','$t_id','$cost')";
$result = mysql_query($query,$link);    
   
}
}
?>
<table border="1" width="100%">
<form action="index.php" method="post" id="form1" onsubmit="return fun1()">
<tr>
<td>
Create New Project
</td>
</tr>
<tr>
<td>
Project Id
</td>
</tr>
<tr>
<td>
<input type="text" id="project_id" name="project_id" value=""></input>
<?php
   if($message)
   {
       //DebugBreak();
       echo $message ;
       $message = "";
   }
?>
</td>
</tr>
<tr>
<td>
Project Name
</td>
</tr>
<tr>
<td>
<input type="text" id="project_name" name="project_name" value=""></input>
</td>
</tr>
<tr>
<td>
Project Description
</td>
</tr>
<tr>
<td>
<textarea cols="165" rows="5" name="description" id="description"></textarea>
</td>
</tr>
<tr>
<td>
Project Brief Description
</td>
</tr>
<tr>
<td>
<textarea cols="165" rows="5" name="brief_description" id="brief_description"></textarea>
</td>
</tr>
<tr>
<td>
Priority
</td>
</tr>
<tr>
<td>
<select id="priority" name="priority">
 <option value="Low">Low</option>
 <option value="High">High</option>
</select>
</td>
</tr>
<tr>
<td>
Status
</td>
</tr>
<tr>
<td>
<select id="Status" name="Status">
 <option value="open">Open</option>
 <option value="completed">Completed</option>
</select>
</td>
</tr>
<tr>
<td>
Users
</td>
</tr>
<tr>
<td>
<select id="uid" name="uid">
 <option value="user1">User 1</option>
 <option value="user2">User 2</option>
 <option value="user3">User 3</option>
 <option value="user4">User 4</option>
</select>
</td>
</tr>
<tr>
<td>
Tasks
</td>
</tr>
<tr>
<td>
<select id="tid" name="tid">
 <option value="task1">Task 1</option>
 <option value="task2">Task 2</option>
 <option value="task3">Task 3</option>
 <option value="task4">Task 4</option>
</select>
</td>
</tr>
<tr>
<td>
Start Date
</td>
<tr>
<td>
<input type="text" id="from" name="from"></input>
</td>
</tr>
<tr>
<td>
End Date
</td>
<tr>
<td>
<input type="text" id="to" name="to"> </input>
</td>
</tr>
<tr>
<td>
Cost
</td>
<tr>
<td>
<input type="text" id="cost" name="cost"></input>
</td>
</tr>
<tr>
<td>
<input type="submit" id="submit" name="submit" value="Submit"></input>
<input type="button" id="Cancel" name="Cancel" value="Cancel" onclick="fun2()"></input>
</td>
</tr>
</form>
</table>

</body>
</html>