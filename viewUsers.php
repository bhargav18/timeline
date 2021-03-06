<?php
session_start();
    include './Template.php';
    include './DBConfig.php';
    $mysql = new DBConfig();
    $db = $mysql->getDBConfig();
    
    $head = '';
    
    $header = new Template("./header.php", array("head" => $head, "title" => "View Users","return"=>"viewUser.php","current_page"=>5));
    $header->out();
  		
?>
<!-- content-wrap -->
<div id="content-wrap">

<!-- content -->
<div id="content" class="clearfix">

<!-- main -->
<div id="main">

<div class="main-content">
<form action= "manageUser.php" method= "post">
<table class="view">
<tr><td class="bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Employee ID</td><td class="bold">Employee Name</td></tr>

<?php

	$query= "SELECT first_name, last_name, uid FROM users WHERE access_level = '1' ORDER BY employee_status ASC, last_name ASC";   

    $result = $db->query($query);
	if(mysqli_num_rows($result) != 0)
    {
	while($row= mysqli_fetch_row($result))
	{
		$n = $row[0] ." " . $row[1];
		$id = $row[2];
		echo'<tr><td>';
		echo "<input type='radio' name='radio' value= '$id' >  " ;
		echo "&nbsp;&nbsp;&nbsp;" . $id . "</td><td> " . $n;
		echo '</td></tr>'; 
	}      
?>
</table><table>
<tr>
<td><input type="submit" class="btn btn-info" value="Select User" name="submit"></td>
</tr></table>

<?php 
	}
else 
		echo "<tr>You have no users</tr>";
?>
</tbody>
</table></form>
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