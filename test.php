<?php
include './Template.php';
include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();
$head='<script src="js/comment.js"></script>';
$header = new Template("./header.php", array(head => $head, title => "Title"));
$header->out();
if($_SESSION['access_level'] == 2){
    $tasks = $db->query('select * from tasks where project_uid='.$_GET['project'].'');
}else{
    $tasks = $db->query('select * from tasks where uid in(select task_uid from user_tasks where user_uid='.$_SESSION['user_uid'].')');   
}
?>

        <!-- content-wrap -->
        <div id="content-wrap">

            <!-- content -->
            <div id="content" class="clearfix">

                <!-- main -->
                <div id="main">

                    <div class="main-content">
                        <label>Task name:</label>
                        <select name="tasks" id="tasks_list" onchange="get_comments();">
                    <?php
                    echo '<option name="task" value="0">--Select Task--</option>';
                        while (($task = mysqli_fetch_array($tasks)) != NULL){                            
                            echo '<option name="task" value='.$task['uid'].'>'.$task["name"].'</option>';
                        }
                    ?>
                </select>

                            <div class="post-bottom-section">
                    

                            
                            <!-- /comment-list -->


                </div>
                        
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