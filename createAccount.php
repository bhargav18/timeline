<?php
SESSION_START();

include './Template.php';
include './DBConfig.php';
$Err1 = $Err2 = $Err3 = $Err4 = $Err5 = $Err6 = $Err7 = $Err8 = $Err9 = $ErrCountry = $Err11 = $ErrRole = "";
$mysql = new DBConfig();
$db = $mysql->getDBConfig();
$head='<script src="js/manageUser.js"> type="text/javascript"> </script>
';
$header = new Template("./header.php", array("head" => $head, "title" => "Title","current_page"=>5,"return"=>"createAccount.php"));
$header->out();

$id =""; 
if($_SESSION['AccountExist_error']){
    $AccountExist = "Account already exist.";
     $_SESSION['AccountExist_error']  = 0;
}
if(!empty($_SESSION['cErrfname'])){
	$Err1 = $_SESSION['cErrfname'];
	$_SESSION['cErrfname'] = "";}
if(!empty($_SESSION['cErrlname'])){
	$Err2 = $_SESSION['cErrlname'];
	$_SESSION['cErrlname']="";}
if(!empty($_SESSION['cErremail'])){
	$Err3 = $_SESSION['cErremail'];
	$_SESSION['cErremail']="";}
if(!empty($_SESSION['cErraddress1'])){
	$Err5 = $_SESSION['cErraddress1'];
	$_SESSION['cErraddress1']="";}
if(!empty($_SESSION['cErrcity'])){
	$Err7 = $_SESSION['cErrcity'];
	$_SESSION['cErrcity']="";}
if(!empty($_SESSION['cErrzipcode'])){
	$Err8 = $_SESSION['cErrzipcode'];
	$_SESSION['cErrzipcode']="";}
if(!empty($_SESSION['cErrstate'])){
	$Err9 = $_SESSION['cErrstate'];
	$_SESSION['cErrstate']="";}
if(!empty($_SESSION['cErrphone'])){
	$Err6 = $_SESSION['cErrphone'];
    $_SESSION['cErrphone']="";	
}
if(!empty($_SESSION['cEroleErr'])){
	$ErrRole = $_SESSION['cEroleErr'];
    $_SESSION['cEroleErr']="";	
}
if(!empty($_SESSION['cErrcountry'])){
        $ErrCountry = $_SESSION['cErrcountry'];
        $_SESSION['cErrcountry']="";
}
	
?>

        <!-- content-wrap -->
        <div id="content-wrap">

            <!-- content -->
            <div id="content" class="clearfix">

                <!-- main -->
                <div id="main">

                    <div class="main-content">
                    <form method="post" action="createAccountProcessing.php">
                    
 <?php                   
$lname = $fname = $email = $role = $address1 = $address2 = $phone = $city = $country = $state = $zipcode = "";
if(!empty($_SESSION['cEfname']))
{
	$fname = $_SESSION['cEfname'];
	$_SESSION['cEfname']="";
}

if(!empty($_SESSION['cElname']))
{
	$lname = $_SESSION['cElname'];
	$_SESSION['cElname']="";
}

if(!empty($_SESSION['cEemail']))
{
	$email = $_SESSION['cEemail'];
	$_SESSION['cEemail']="";
}
if(!empty($_SESSION['cEaddress1']))
{
	$address1 = $_SESSION['cEaddress1'];
	$_SESSION['cEaddress1']="";
}

if(!empty($_SESSION['cEaddress2']))
{
	$address2 = $_SESSION['cEaddress2'];
	$_SESSION['cEaddress2']="";
}
	
if(!empty($_SESSION['cEcity']))
{
	$city = $_SESSION['cEcity'];
	$_SESSION['cEcity']="";
}
	
if(!empty($_SESSION['cEzipcode']))
{
	$zipcode = $_SESSION['cEzipcode'];
	$_SESSION['cEzipcode']="";
}
	
if(!empty($_SESSION['cEstate']))
{
	$state = $_SESSION['cEstate'];
	$_SESSION['cEstate']="";
}
	
if(!empty($_SESSION['cEcountry']))
{
	$country = $_SESSION['cEcountry'];
	$_SESSION['cEcountry']="";
}

if(!empty($_SESSION['cEphone']))
{
	$phone = $_SESSION['cEphone'];
	$_SESSION['cEphone']="";
}

if(!empty($_SESSION['cErole']))
{
	$role = $_SESSION['cErole'];
	$_SESSION['cErole']="";
}

?>
<span class="error"><?php echo $AccountExist; ?></span>
<label>First Name</label>
<input name="fname" type="text"  value="<?=$fname?>">
<span class="error"><?php echo $Err1; ?></span>

<label>Last Name</label>
<input name="lname" type="text" value="<?=$lname?>">
<span class="error"><?php echo $Err2; ?></span>

<label>Email</label>
<input name="email" type="text" value="<?=$email?>">
<span class="error"><?php echo $Err3; ?></span>

<label>Address 1</label>
<input name="address1" type="text" value="<?=$address1?>">
<span class="error"><?php echo $Err5; ?></span>

<label>Address 2</label>
<input name="address2" type="text" value="<?=$address2?>">
<!--<span class="error">/*<?php //echo $Err7; ?>*/</span>-->

<label>City</label>
<input name="city" type="text" maxlength = "10" value="<?=$city?>">
<span class="error"><?php echo $Err7; ?></span>

<label>State</label>
<input name="state" type="text" value="<?=$state?>">
<span class="error"><?php echo $Err9; ?></span>

<label>Zip Code</label>
<input name="zipcode" type="text" value="<?=$zipcode?>">
<span class="error"><?php echo $Err8; ?></span>

<label>Country</label>
<input name="country" type="text" value="<?=$country?>">
<span class="error"><?php echo $ErrCountry; ?></span>

<label>Role</label>
<select name="userrole"> 
  <option></option>
  <option <?php echo ($role === "Default") ? "selected" : ""; ?> value="programmer">Programmer</option>
  <option <?php echo ($role === "Default") ? "selected" : ""; ?> value="developer">Developer</option>
  <option <?php echo ($role === "Default") ? "selected" : ""; ?> value="analyst">Analyst</option>
  <option <?php echo ($role === "Default") ? "selected" : ""; ?> value="reporter">Reporter</option>
  <option <?php echo ($role === "Default") ? "selected" : ""; ?> value="designer">Designer</option>
  <option <?php echo ($role === "Default") ? "selected" : ""; ?> value="tester">Tester</option>   
</select>
<span class="error" ><?php echo $ErrRole; ?></span>


<label>Phone</label>
<input name="phone" type="text" value="<?=$phone?>">
<span class="error"><?php echo $Err6; ?></span>

<br></br>
<input name="create" type="submit" value="Create Account">
<a href="viewUsers.php"><input type="button" value="Cancel" /></a>
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