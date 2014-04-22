<?php
include './Template.php';
include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();
$head="<script src='/js/myProfile.js'></script>";
$header = new Template("./header.php", array("head" => $head, "title" => "My Profile"));
$header->out();
?>

        <!-- content-wrap -->
        <div id="content-wrap">

            <!-- content -->
            <div id="content" class="clearfix">

                <!-- main -->
                <div id="main">

                    <div class="main-content">
                        <form onsubmit="return fun1()" method="post" action="functions.php?action=update_profile">





                            <label>First Name:</label>

<input type="text" value="<?php echo $_SESSION['first_name']; ?>" maxlength="20" name="firstName" size="40">



<label>Last Name:</label>

<input type="text" value="<?php echo $_SESSION['last_name']; ?>" maxlength="20" name="lastName">



<label>Email:</label>

<input type="text" value="<?php echo $_SESSION['email']; ?>" maxlength="40" id="email" name="email">



<label>Password:</label>

<input type="text" value="<?php echo $_SESSION['password']; ?>" maxlength="20" name="password">



<label>Role:</label>

<input type="text" value="<?php if($_SESSION['access_level'] == 2){echo 'Manager';}else{echo 'Employee';} ?>" readonly="readonly" maxlength="20" name="role">



<label>Phone:</label>

<input type="text" value="<?php echo $_SESSION['phone']; ?>" maxlength="20" name="phone" id="phone">



<label>Address:</label>

<input type="text" value="<?php echo $_SESSION['address']; ?>" maxlength="20" name="address" id="address">

           
        

        <input type="submit" name="submit" value="Update">
        <input type="button" onclick="window.location.href='index.php'" name="cancel" value="Cancel">
 
    
    
</form>
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