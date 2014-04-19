<?php
include './Template.php';
include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();
$head="";
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