<?php
include('header.php');
include ('dbConfig.php');
//This page is for manager only
/*
$db_hostname= "localhost";
$db_usrname= "root";
$db_passwrd= "";
$db_name= "Testing";
		
$connect = mysql_connect("$db_hostname", "$db_usrname", "$db_passwrd") or die (mysql_error());
  		mysql_select_db("$db_name");*/
  		
?>
<head>

<title>Projects</title>

</head>

<body>
		
<div class="container">
<h3>
	<font color="#0283bd">
	<br></br>
	Tasks
</h3>
<form action= "updateProject.php" method= "post">
<table class="table">

<?php

	$query= "SELECT Project_id, Name FROM Projects";   
	
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
			<td><input type='submit'  name= 'submit' value= 'Select Project' class='btn btn-info'></td>
		</tr>
		</table></form></div>
</body>
