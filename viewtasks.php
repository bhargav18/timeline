<?php
include './Template.php';
include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();

$head = '<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="ModalPopupWindow.js" type="text/javascript"></script>';

$header = new Template("./header.php", array(head => $head, title => "Update Task status"));
$header->out();
?>

        <!-- content-wrap -->
        <div id="content-wrap">

            <!-- content -->
            <div id="content" class="clearfix">

                <!-- main -->
                <div id="main">

                    <div class="main-content">
<form method="post" action="updateTaskStatus.php">
	<table class="table">	
	<tbody><tr><td><input type="radio" value="128" name="radio"> 128 ds</td></tr><tr><td><input type="radio" value="120" name="radio"> 120 Another Test</td></tr><tr><td><input type="radio" value="121" name="radio"> 121 delete fomat</td></tr><tr><td><input type="radio" value="127" name="radio"> 127 sad</td></tr><tr><td><input type="radio" value="131" name="radio"> 131 testdate</td></tr><tr><td><input type="radio" value="133" name="radio"> 133 testdate</td></tr><tr><td><input type="radio" value="142" name="radio"> 142 dsaf</td></tr><tr><td><input type="radio" value="144" name="radio"> 144 dsaf</td></tr><tr><td><input type="radio" value="145" name="radio"> 145 dsaf</td></tr><tr><td><input type="radio" value="148" name="radio"> 148 new Task</td></tr><tr><td><input type="radio" value="149" name="radio"> 149 new Task</td></tr><tr><td><input type="radio" value="151" name="radio"> 151 new Task</td></tr>
	<tr>
	<td><input type="submit" class="btn btn-info" value="Select Task" name="submit"></td>
	</tr>
	</tbody></table></form>
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