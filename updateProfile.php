<?php
SESSION_START();

include './Template.php';
include './DBConfig.php';
$Err1 = $Err2 = $Err3 = $Err4 = $Err5 = $Err6 = $Err7 = $Err8 = $Err9 = $Err10 = $Err11 = "";
$mysql = new DBConfig();
$db = $mysql->getDBConfig();
$head='';
$header = new Template("./header.php", array('head' => $head, 'title' => "Update Profile",'return'=>"updateProfile.php",'current_page'=>4));
$header->out();

if(!empty($_SESSION['Erremail'])){
	$Err3 = $_SESSION['Erremail'];
	$_SESSION['Erremail']="";}
if(!empty($_SESSION['Errpassword'])){
	$Err4 = $_SESSION['Errpassword'];
	$_SESSION['Errpassword']="";}
if(!empty($_SESSION['Erraddress1'])){
	$Err5 = $_SESSION['Erraddress1'];
	$_SESSION['Erraddress1']="";}
if(!empty($_SESSION['Errcity'])){
	$Err7 = $_SESSION['Errcity'];
	$_SESSION['Errcity']="";}
if(!empty($_SESSION['Errzipcode'])){
	$Err8 = $_SESSION['Errzipcode'];
	$_SESSION['Errzipcode']="";}
if(!empty($_SESSION['Errstate'])){
	$Err9 = $_SESSION['Errstate'];
	$_SESSION['Errstate']="";}
if(!empty($_SESSION['Errphone'])){
	$Err6 = $_SESSION['Errphone'];
    $_SESSION['Errphone']="";	
}
	
?>

        <!-- content-wrap -->
        <div id="content-wrap">

            <!-- content -->
            <div id="content" class="clearfix">

                <!-- main -->
                <div id="main">

                    <div class="main-content">
                    <form method="post" action="updateProfileProcessing.php">
                    
 <?php                   
		
$query = "SELECT *
         FROM users
         INNER JOIN address
         ON users.uid = address.user_uid AND users.uid like '".$_SESSION['user_uid']."'";

		$result= $db->query($query);

$row = mysqli_fetch_array($result);

	$fname = $row['first_name'];
        
	$lname = $row['last_name'];
	
if(!empty($_SESSION['Eemail']))
{
	$email = $_SESSION['Eemail'];
	$_SESSION['Eemail']="";
}
else
	$email = $row['email'];	

if(!empty($_SESSION['Epassword']))
{
	$password = $_SESSION['Epassword'];
	$_SESSION['Epassword']="";
}
else
	$password = $row['password'];	

if(!empty($_SESSION['Eaddress1']))
{
	$address1 = $_SESSION['Eaddress1'];
	$_SESSION['Eaddress1']="";
}
else
	$address1 = $row['address1'];
	
if(!empty($_SESSION['Eaddress2']))
{
	$address2 = $_SESSION['Eaddress2'];
	$_SESSION['Eaddress2']="";
}
else
	$address2 = $row['address2'];
	
if(!empty($_SESSION['Ecity']))
{
	$city = $_SESSION['Ecity'];
	$_SESSION['Ecity']="";
}
else
	$city = $row['city'];
	
if(!empty($_SESSION['Ezipcode']))
{
	$zipcode = $_SESSION['Ezipcode'];
	$_SESSION['Ezipcode']="";
}
else
	$zipcode = $row['zipcode'];
	
if(!empty($_SESSION['Estate']))
{
	$state = $_SESSION['Estate'];
	$_SESSION['Estate']="";
}
else
	$state = $row['state'];
	
if(!empty($_SESSION['Ecountry']))
{
	$country = $_SESSION['Ecountry'];
	$_SESSION['Ecountry']="";
}
else
	$country = $row['country'];

if(!empty($_SESSION['Ephone']))
{
	$phone = $_SESSION['Ephone'];
	$_SESSION['Ephone']="";
}
else
	$phone = $row['phone'];
	
    $role = $row['role'];
	
    $status = $row['status'];

?>

<!--ID-->
<label>User Id: <?=$_SESSION['user_uid']?></label>
<input name="userid" type="hidden" value="<?=$_SESSION['user_uid']?>">

<label>First Name: <?php echo $fname ?></label>

<label>Last Name: <?php echo $lname ?></label>

<label>Role: <?php echo $role ?></label>

<label>Email</label>
<input name="email" type="text" value="<?=$email?>">
<span class="error"><?php echo $Err3; ?></span>

<label>Password</label>
<input name="password" type="password" value="<?=$password?>">
<span class="error"><?php echo $Err4; ?></span>

<label>Address 1</label>
<input name="address1" type="text" value="<?=$address1?>">
<span class="error"><?php echo $Err5; ?></span>

<label>Address 2</label>
<input name="address2" type="text" value="<?=$address2?>">
<!--<span class="error">/*<?php //echo $Err7; ?>*/</span>-->

<label>City</label>
<input name="city" type="text" value="<?=$city?>">
<span class="error"><?php echo $Err7; ?></span>

<label>Zip Code</label>
<input name="zipcode" type="text" value="<?=$zipcode?>">
<span class="error"><?php echo $Err8; ?></span>

<label>State</label>
<input name="state" type="text" value="<?=$state?>">
<span class="error"><?php echo $Err9; ?></span>

<label>Country</label>
<input name="country" type="text" value="<?=$country?>">
<span class="error"><?php echo $Err10; ?></span>

<label>Phone</label>
<input name="phone" type="text" <?php echo ($status == "Inactive")? 'disabled="disabled"':"";?> value="<?=$phone?>">
<span class="error"><?php echo $Err6; ?></span>

<div>
<input name="update" type="submit" value="Update My Profile">
</div>
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