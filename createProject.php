<?php
include './Template.php';
include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();
$head = '<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
 
 <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
 <script src="/js/createProject.js"></script>';

$header = new Template("./header.php", array(head => $head, title => "Title"));
$header->out();
?>

<!-- content-wrap -->
<div id="content-wrap">

    <!-- content -->
    <div id="content" class="clearfix">

        <!-- main -->
        <div id="main">

            <div class="main-content">                      

                <form onsubmit="return fun1()" id="form1" method="post" action="functions.php?action=add_project">
                    <label>Project Id</label>
                    <input type="text" value="" name="project_id" id="project_id">

                    <label>Project Name</label>
                    <input type="text" value="" name="project_name" id="project_name">

                    <label>Project Description</label>
                    <textarea id="description" name="description" style="width: 400px;"></textarea>

                    <label>Priority</label>
                    <select name="priority" id="priority">
                        <option value="Low">Low</option>
                        <option value="High">High</option>
                    </select>

                    <label>Status</label>
                    <select name="Status" id="Status">
                        <option value="open">Open</option>
                        <option value="completed">Completed</option>
                    </select>

                    <label>Start Date</label>
                    <input type="text" readonly="readonly" name="from" id="from" class="hasDatepicker">

                    <label>End Date</label>
                    <input type="text" readonly="readonly" name="to" id="to" class="hasDatepicker"> 

                    <label>Cost</label>
                    <input type="text" name="cost" id="cost">
                    <br/>
                    <input type="submit" value="Submit" name="submit" id="submit">
                    <input type="button" onclick="fun2()" value="Cancel" name="Cancel" id="Cancel">

                </form>
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