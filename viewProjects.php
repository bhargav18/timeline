<?php
include './Template.php';
include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();

$head = '<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">    
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>';

$header = new Template("./header.php", array("current_page"=>2,"head" => $head, "title" => "View Projects"));
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
                        $query = "SELECT uid, name FROM project";

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
                            <td><input type="submit" class="btn btn-info" value="Select Project" name="submit"></td>
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