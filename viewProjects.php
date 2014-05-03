<?php
session_start();
    include './Template.php';
    include './DBConfig.php';
    $mysql = new DBConfig();
    $db = $mysql->getDBConfig();
    
    $head = '<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">    
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>';
    
    $header = new Template("./header.php", array('head' => $head, 'title' => "View Projects",'return'=>"viewProjects.php",'current_page'=>2));
    $header->out();
  		
?>
<!-- content-wrap -->
<div id="content-wrap">

<!-- content -->
<div id="content" class="clearfix">

<!-- main -->
<div id="main">

<div class="main-content">
<form action= "updateProject.php" method= "post">
<table class="table">

<?php

	$query= "SELECT uid, name FROM project WHERE deleted='N' ORDER BY name";   
	$result= $db->query($query);
	if(mysqli_num_rows($result) != 0) 
	{
	    while($row= mysqli_fetch_row($result))
	    {
			$id = $row[0];
			$n = $row[1];
			echo'<tr><td>';
			echo "<input type='radio' name='radio' value= '$id' >  " ;
			echo $id . " " . $n;
			echo '</td></tr>';
		}        
?>
<tr>
<td><input type="submit" class="btn btn-info" value="Select Project" name="submit"></td>
</tr>

<?php 
	}
else 
		echo "<tr>You have no projects</tr>";
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