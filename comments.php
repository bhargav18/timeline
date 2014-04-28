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
                        <div class="primary">

                            <form id="commentform" method="post" action="functions.php?action=submit_comment" style="margin-left: -80px;">               
                                <input type="hidden" id="taskid" name="taskid" value=""/>
                    <div>
						<label for="message">Your Message <span>*</span></label>
						<textarea tabindex="4" cols="18" rows="10" name="text" id="message"></textarea>
					</div>
                    <div class="no-border">
					    <input type="submit" tabindex="5" value="Submit Comment" class="button">
					</div>

               </form>

            </div>
                        
                    </div>

                    <!-- /main -->
                </div>

                <!-- sidebar -->

                <!-- content -->
            </div>

            <!-- /content-out -->
        </div>

        <!-- extra -->
<?php 
include './footer.php';
?>