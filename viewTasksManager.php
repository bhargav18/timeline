<?php
//SESSION_START();
//include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();

$head = '<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>'
;
//  <script src="ModalPopupWindow.js" type="text/javascript"></script>'
include './Template.php';

$header = new Template("./header.php", array('head' => $head, 'title' => "View Tasks",'return'=>"viewTasks.php",'current_page'=>3));
$header->out();
$nextForm = "";


?>

<!-- content-wrap -->
<div id="content-wrap">

    <!-- content -->
    <div id="content" class="clearfix">

        <!-- main -->
        <div id="main">

            <div class="main-content">
                <form method=post name='emp-form' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                
                <?php 
                
                $query= "SELECT uid, name FROM project WHERE deleted='N' ORDER BY uid";   
                
                $result= $db->query($query);
					
					if(mysqli_num_rows($result) > 0) {
					echo "<tr><td> Projects: </td></tr>";
					echo'<select name="proj">';
					while($row= mysqli_fetch_row($result))
					{
					
						 echo '<option  value="'.$row[0].'">'.$row[1].'</option>';
					}   
					echo '<option value="individual">Individual Tasks</option>';
					echo'</select>';
										
?>     
            	<input type="submit" value="View Tasks"/>
            	</form>
            	<?php
					} else
					 echo "You have no projects";
if ('POST' === $_SERVER['REQUEST_METHOD']){?>
                <form method="post" action="updateTask.php">
                <table class="view" >
                
                </tr>
                
                            <?php 
                            if ($_POST['proj'] === "individual")
                                $query = "SELECT uid, name, status FROM tasks WHERE deleted = 'N' AND ISNULL(project_uid) ORDER BY uid";
                            else
                                $query = "SELECT uid, name, status FROM tasks WHERE deleted = 'N' AND project_uid ='".$_POST['proj']."' ORDER BY uid";
                            
                            $result = $db->query($query);
                            if(mysqli_num_rows($result) > 0)
                            {
                            echo '<tr>
                <td  class="bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Task ID</td>
                <td class="bold">Task Name</td>
                <td class="bold">Task Status</td>';
                            while ($row = mysqli_fetch_row($result)) {

                                $id = $row[0];
                                $n = $row[1];
                                echo "<tr><td>";
                                echo "<input type='radio' name='radio' value= '$id'/>&nbsp;&nbsp;".$id."</td>";
                                echo "<td>".$n . " </td><td>" . $row[2];
                                echo '</td></tr>';
                                
                            }?>
							</table>
							<table>
                            <tr>
                                <td><input type="submit" class="btn btn-info" value="Select Task" name="submit"></td>
                            </tr></table>
<?php 
}
else
	echo "You have no tasks";
}

?>
                        </table></form>
            </div>

            <!-- /main -->
        </div>

        <!-- sidebar -->
<?php include './sidebar.php'; ?>
        <!-- content -->
    </div>

    <!-- /content-out -->
</div>

<!-- extra -->
<?php
include './footer.php';
?>