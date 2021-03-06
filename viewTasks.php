<?php
SESSION_START();
include './DBConfig.php';
if ($_SESSION['access_level'] == 2)
{ include 'viewTasksManager.php';
 exit; }
else if ($_SESSION['access_level'] == 1)
{$nextForm = "";
$nextForm = "updateTaskStatus.php";
$mysql = new DBConfig();
$db = $mysql->getDBConfig();

$head = '<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>'
;
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
                <form method="post" action="updateTaskStatus.php">
                <table class="view" >
                <tr>
                <td  class="bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Task ID</td>
                <td class="bold">Task Name</td>
                <td class="bold">Task Status</td>
                </tr>
                
                            <?php 
                            
                                $query = "SELECT uid, name, status FROM tasks WHERE EXISTS 
	    								(SELECT task_uid FROM user_tasks 
	    								WHERE tasks.uid = user_tasks.task_uid and user_tasks.deleted='N' and user_uid = '".$_SESSION['user_uid']." ORDER BY uid')";

                            $result = $db->query($query);
                            if(mysqli_num_rows($result) != 0)
                            {
                            while ($row = mysqli_fetch_row($result)) {

                                $id = $row[0];
                                $n = $row[1];
                                echo "<tr><td>";
                                echo "<input type='radio' name='radio' value= '$id'/> &nbsp;&nbsp;".$id."</td>";
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
}
?>