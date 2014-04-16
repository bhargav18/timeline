<?php
include './Template.php';
$head = '<style>#content {background:none;}</style>';
$header = new Template('./header.php',array(head=>$head));
include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();
$header->out();
?>

<!-- content-wrap -->
<div id="content-wrap">

    <!-- content -->
    <div id="content" class="clearfix">

        <!-- main -->
        <div id="main">

            <div class="main-content">
                <table border="2" align="center">
                    <tr><td>USERNAME</td><td>FIRSTNAME</td><td>LASTNAME</td><td>ROLE</td><td>PHONE</td><td>EMAIL</td><td>ADDRESS</td></tr>
                    <?php
                    $result = $db->query("SELECT * FROM users WHERE employee_status='Active'");
                    while (($row = mysqli_fetch_array($result)) != null) {
                        ?>
                        <tr><td><?php if ($row['username'] == "") {
                        echo "&nbsp;";
                    } else {
                        echo $row['username'];
                    } ?></td><td><?php if ($row['first_name'] == "") {
                        echo "&nbsp;";
                    } else {
                        echo $row['first_name'];
                    } ?></td><td><?php if ($row['last_name'] == "") {
                        echo "&nbsp;";
                    } else {
                        echo $row['last_name'];
                    } ?></td><td><?php if ($row['access_level'] == "") {
                        echo "&nbsp;";
                    } else {
                        echo $row['access_level'];
                    } ?></td><td><?php if ($row['phone'] == "") {
                        echo "&nbsp;";
                    } else {
                        echo $row['phone'];
                    } ?></td><td><?php if ($row['email'] == "") {
                        echo "&nbsp;";
                    } else {
                        echo $row['email'];
                    } ?></td><td><?php if ($row['address'] == "") {
                        echo "&nbsp;";
                    } else {
                        echo $row['address'];
                    } ?></td></tr>

    <?php }
?>
                </table>
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