<?php
SESSION_START();

if ((!empty($_POST) &&!empty($_POST['radio'])) || !empty($_SESSION['Eid']))
{
include './Template.php';
include './DBConfig.php';
$Err1 = $Err2 = $Err3 = $Err4 = $Err5 = $Err6 = $Err7 = $Err8 = $Err9 = $Err10 = $Err11 = "";
$mysql = new DBConfig();
$db = $mysql->getDBConfig();
$head='<script src="js/manageUser1.js"> type="text/javascript"> </script>
';
$header = new Template("./header.php", array(head => $head, title => "Title"));
$header->out();

$id =""; 
if (!empty($_SESSION['Eid'])){
$id= $_SESSION['Eid'];
$_SESSION['Eid']="";}
if(!empty($_SESSION['Errfname'])){
	$Err1 = $_SESSION['Errfname'];
	$_SESSION['Errfname'] = "";}
if(!empty($_SESSION['Errlname'])){
	$Err2 = $_SESSION['Errlname'];
	$_SESSION['Errlname']="";}
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
    if(!empty($_SESSION['Errcountry'])){
        $Err10 = $_SESSION['Errcountry'];
        $_SESSION['Errcountry']="";}
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
                    <form method="post" action="manageUserProcessing.php">
                    
 <?php                   
         if(!empty($_POST['radio']))
		   $user_id = $_POST['radio'];
		  else
		   $user_id = $id;
		
$query = "SELECT *
         FROM users
         INNER JOIN address
         ON users.uid = address.user_uid AND users.uid like '$user_id'";

		$result= $db->query($query);

$row = mysqli_fetch_array($result);

if(!empty($_SESSION['Efname']))
{
	$fname = $_SESSION['Efname'];
	$_SESSION['Efname']="";
}
else
	$fname = $row['first_name'];
        
if(!empty($_SESSION['Elname']))
{
	$lname = $_SESSION['Elname'];
	$_SESSION['Elname']="";
}
else
	$lname = $row['last_name'];
	
if(!empty($_SESSION['Eemail']))
{
	$email = $_SESSION['Eemail'];
	$_SESSION['Eemail']="";
}
else
	$email = $row['email'];	
/*
if(!empty($_SESSION['Epassword']))
{
	$password = $_SESSION['Epassword'];
	$_SESSION['Epassword']="";
}
else
	$password = $row['password'];	
*/
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

if(!empty($_SESSION['Erole']))
{
	$role = $_SESSION['Erole'];
	$_SESSION['Erole']="";
}
else	
    $role = $row['role'];

	if(!empty($_SESSION['Estatus']))
{
	$status = $_SESSION['Estatus'];
	$_SESSION['Estatus']="";
}
else	
    $status = $row['employee_status'];

?>

<!--ID-->
<input name="userid" type="hidden" value="<?=$user_id?>">

<label>First Name</label>
<input name="fname" type="text" <?php echo ($status == "Inactive")? 'disabled="disabled"':"";?> value="<?=$fname?>" maxlength = "30" required>
<span class="error"><?php echo $Err1; ?></span>

<label>Last Name</label>
<input name="lname" type="text" <?php echo ($status == "Inactive")? 'disabled="disabled"':"";?> value="<?=$lname?>" maxlength = "30" required>
<span class="error"><?php echo $Err2; ?></span>

<label>Email</label>
<input name="email" type="text" <?php echo ($status == "Inactive")? 'disabled="disabled"':"";?> value="<?=$email?>" maxlength = "30" required>
<span class="error"><?php echo $Err3; ?></span>

<label>Address 1</label>
<input name="address1" type="text" <?php echo ($status == "Inactive")? 'disabled="disabled"':"";?> value="<?=$address1?>" maxlength = "50" required>
<span class="error"><?php echo $Err5; ?></span>

<label>Address 2</label>
<input name="address2" type="text" <?php echo ($status == "Inactive")? 'disabled="disabled"':"";?> value="<?=$address2?>" maxlength = "10" >
<!--<span class="error">/*<?php //echo $Err7; ?>*/</span>-->

<label>City</label>
<input name="city" type="text" <?php echo ($status == "Inactive")? 'disabled="disabled"':"";?> value="<?=$city?>" maxlength = "50" required>
<span class="error"><?php echo $Err7; ?></span>

<label>Zip Code</label>
<input name="zipcode" type="text" <?php echo ($status == "Inactive")? 'disabled="disabled"':"";?> value="<?=$zipcode?>" maxlength = "10" required>
<span class="error"><?php echo $Err8; ?></span>



<label>State</label>
<input name="state" type="text" <?php echo ($status == "Inactive")? 'disabled="disabled"':"";?> value="<?=$state?>" maxlength = "30" required>
<span class="error"><?php echo $Err9; ?></span>




<label>Country</label>
<input name="country" type="text" <?php echo ($status == "Inactive")? 'disabled="disabled"':"";?> value="<?=$country?>" maxlength = "30" required>
<span class="error"><?php echo $Err10; ?></span>



<label>Role</label>
<select name="userrole" <?php echo ($status == "Inactive")? 'disabled="disabled"':"";?>> 
  <option value="programmer" <?php echo ($role === "programmer")? 'selected="selected"':"";?>>Programmer</option>
  <option value="developer" <?php echo ($role === "developer")?'selected="selected"':"";?>>Developer</option>
  <option value="analyst" <?php echo ($role === "analyst")?'selected="selected"':"";?>>Analyst</option>
  <option value="reporter" <?php echo ($role === "reporter")?'selected="selected"':"";?>>Reporter</option>
  <option value="designer" <?php echo ($role === "designer")?'selected="selected"':"";?>>Designer</option>
  <option value="tester" <?php echo ($role === "tester")?'selected="selected"':"";?>>Tester</option>   
</select>




<label>Phone</label>
<input name="phone" type="text" <?php echo ($status == "Inactive")? 'disabled="disabled"':"";?> value="<?=$phone?>" maxlength = "15" required>
<span class="error"><?php echo $Err6; ?></span>


<label>Status</label>
<input type='hidden' name='orgSts' value='<?php echo $status;?>'/>
<select name="userstatus" id="userstatus"  
		onchange="if(this.selectedIndex==0) 
			{if(confirm('Do you want to activate the account?')){myFunction(this.selectedIndex);
			document.getElementById('up').removeAttribute('disabled');}
			else { this.selectedIndex=1; }}
			">
  <option value="Active" <?php echo ($status === "Active")?"selected":"";?>>Active</option>
  <option value="Inactive" <?php echo ($status === "Inactive")?"selected":"";?>>Inactive</option>
</select>
<br></br>
<input name="update" type="submit" <?php echo ($status == "Inactive")? 'disabled="disabled"':"";?> id ="up" value="Update User" class='btn btn-info1'>
<a href="viewUsers.php"><input type="button" value="Cancel" class='btn btn-info2'/></a>
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
}else 
{
	header("Location:viewUsers.php");
	exit;
}
?>