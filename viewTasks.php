<?php
include './Template.php';
include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();

$head = '<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="ModalPopupWindow.js" type="text/javascript"></script>';

$header = new Template("./header.php", array(head => $head, title => "View Tasks"));
$header->out();
$nextForm = "";
if ($_SESSION['access_level'] == 2)
    $nextForm = "updateTask.php";
else
    $nextForm = "updateTaskStatus.php";
?>

<!-- content-wrap -->
<div id="content-wrap">

    <!-- content -->
    <div id="content" class="clearfix">

        <!-- main -->
        <div id="main">

            <div class="main-content">
                <form method="post" action="<?php echo $nextForm ?>">
                    <table class="table">
                        <tbody>
                            <?php
                            if ($_SESSION[username] === "Manager") {
                                $query = "SELECT uid, name FROM tasks";
                            } else {
                                $query = "SELECT uid, name FROM tasks WHERE EXISTS 
	    	(SELECT task_uid FROM user_tasks WHERE tasks.uid = user_tasks.task_uid and user_uid like '".$_SESSION['user_uid']."')";
                            }

                            $result = $db->query($query);

                            while ($row = mysqli_fetch_row($result)) {

                                $id = $row[0];
                                $n = $row[1];
                                echo'<tr><td>';
                                echo "<input type='radio' name='radio' value= '$id' >  ";
                                echo $id . " " . $n;
                                echo '</td></tr>';
                            }
                            ?>

                            <tr>
                                <td><input type="submit" class="btn btn-info" value="Select Task" name="submit"></td>
                            </tr>
                        </tbody></table></form>
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