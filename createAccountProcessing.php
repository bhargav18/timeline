<?php

SESSION_START();
date_default_timezone_set('America/Los_Angeles');
	include './DBConfig.php';
	$mysql = new DBConfig();
	$db = $mysql->getDBConfig();

$fName = $lName = $phone = $email = $role = $city = $country = $zcode = $address1 = $address2 = $state = "";

function test_input($data)   // to test input
{
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
function isEmpty($data)
{
	$data = trim($data);
      if (empty($data))
      	return true;
      else;
      	return false;
}
if (!empty($_POST))
	
	if ($_POST['create']) 
	{
	$error = 0;
	
    if(isEmpty($_POST['fname'])){
    	$_SESSION['cErrfname'] = "First name is required"; 
		$error = 1;}	     
     elseif (!preg_match("/^[a-zA-Z ]*$/",test_input($_POST['fname'])))
       {
       $_SESSION['cErrfname'] = "Only letters and whitespace are allowed";
           $fName = $_POST['fname'];
       $error = 1;
       }
     else {
		$fName = $_POST['fname'];
		$_SESSION['cErrfname'] = "";
		}
	
    if(isEmpty($_POST['lname'])){
    	$_SESSION['cErrlname'] = "Last name is required";
		$error = 1;}		
     elseif (!preg_match("/^[a-zA-Z ]*$/",test_input($_POST['lname'])))
       {
       $_SESSION['cErrlname'] = "Only letters and whitespace are allowed";
           $lName = $_POST['lname'];
       $error = 1; 
       }
	else {
		$lName = $_POST['lname'];
		$_SESSION['cErrlname'] = "";
		}
	
	if (isEmpty($_POST['email']))
     {$_SESSION['cErremail'] = "Email is required";
	  $error = 1;}     
     elseif (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",test_input(trim($_POST['email']))))
       {
       	$_SESSION['cErremail'] = "Invalid email format";
     	$error = 1;	   
       }
     else {
	   $email = $_POST['email'];
       $_SESSION['cErremail'] = "";	   
       }  
     
    if(isEmpty($_POST['phone'])){
    	$_SESSION['cErrphone'] = "Phone is required"; 
		$error = 1;} 
	else {
		$phone = test_input($_POST['phone']);
		$_SESSION['cErrphone'] = "";
		}
    if(isEmpty($_POST['address1'])){
    	$_SESSION['cErraddress1'] = "Address 1 is required"; 
		$error = 1;}
	else {
		$address1 = test_input($_POST['address1']);
		$_SESSION['cErraddress1'] = "";
		}
	if(!isEmpty($_POST['address2']))
	{
		$address2 = test_input($_POST['address2']);
	}		
	if(isEmpty($_POST['city'])){
    	$_SESSION['cErrcity'] = "City name is required";
		$error = 1;}
    elseif (!preg_match ('/^[a-zA-Z\s]+$/', test_input($_POST['city'])))
       {
       $_SESSION['cErrcity'] = "Only letters and whitespace are allowed";
           $city = $_POST['city'];
	   $error = 1;}	
	else 
	    {
		$city = $_POST['city'];
		$_SESSION['cErrcity'] = "";
		}	
		
    if(isEmpty($_POST['zipcode'])){
    	$_SESSION['cErrzipcode'] = "Zip code is required"; 
		$error = 1;}
	else {
		$zcode = test_input($_POST['zipcode']);
		$_SESSION['cErrzipcode'] = "";
		}
		
	if(isEmpty($_POST['state'])){
    	$_SESSION['cErrstate'] = "State is required"; 
		$error = 1;}
    elseif (!preg_match ('/^[a-zA-Z\s]+$/', test_input($_POST['state'])))
       {
       $_SESSION['cErrstate'] = "Only letters and whitespace are allowed";
           $state = $_POST['state'];
	   $error = 1;}
	else {
		$state = $_POST['state'];
		$_SESSION['cErrstate'] = "";
		}	
	if(isEmpty($_POST['country'])){
    	$_SESSION['cErrcountry'] = "Country name is required";
		$error = 1;}	
    elseif (!preg_match ('/^[a-zA-Z\s]+$/', test_input($_POST['country'])))
       {
       $_SESSION['cErrcountry'] = "Only letters and whitespace are allowed";
           $country = $_POST['country'];
	   $error = 1;}
	else 
	    {
		$country = $_POST['country'];
		$_SESSION['cErrcountry'] = "";
		}
	 if(empty($_POST['userrole'])){
    	$_SESSION['cEroleErr'] = "Role is required"; 
		$error = 1;}
	else {
		$role = $_POST['userrole'];
		$_SESSION['cEroleErr'] = "";
		}
	
	if(	$error == 1)
	{
		$_SESSION['cEid']= $_POST['userid'];
		$_SESSION['cEfname']= $fName;
		$_SESSION['cElname']= $lName;
		$_SESSION['cEemail']= $email;
		$_SESSION['cEphone']= $phone;
		$_SESSION['cErole'] = $role;
		$_SESSION['cEaddress1']= $address1;
		$_SESSION['cEaddress2']= $address2;
		$_SESSION['cEcity']= $city;
		$_SESSION['cEzipcode']= $zcode;
		$_SESSION['cEstate']= $state;
		$_SESSION['cEcountry']= $country;
		header("Location:createAccount.php");
		exit;
	}
	
	    $userName = 'aa';
	    $password = 'aa';
 		$stmt = $db->prepare('insert into users(first_name, last_name, phone, role, email, username, password)'
	              . 'VALUES (?,?,?,?,?,?,?)');
	               
	    $stmt->bind_param('sssssss', $fName,$lName,$phone,$role,$email, $userName,$password);
		$stmt->execute();
		$holdUserId =  mysqli_insert_id($db); 

		$userName = $lName . $holdUserId;
		$password = randomPassword();
		$stmt = "UPDATE users SET username='$userName' , password='$password' WHERE uid like '$holdUserId'";
			$db->query($stmt); 
        if (!empty($address2)) 
        {                
			$stmt = $db->prepare('insert into address( user_uid, address1, address2, city, zipcode, country, state)'
	              . 'VALUES (?,?,?,?,?,?,?)');
	    	$stmt->bind_param('dssssss', $holdUserId, $address1,$address2,$city, $zcode,$country,$state);
        }
        else
        {
        	$stmt = $db->prepare('insert into address( user_uid, address1, city, zipcode, country, state)'
	              . 'VALUES (?,?,?,?,?,?)');
	    	$stmt->bind_param('dsssss', $holdUserId, $address1,$city, $zcode,$country,$state);
        }
		$stmt->execute();
		
		$headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $messages = "Username : " . $userName . "<br/>";
        $messages .= "First Name : " . $fName . "<br/>";
        $messages .= "Last Name : " . $lName . "<br/>";
        $messages .= "Address : " . $address1 . "<br/>" . $address2 . "<br/>";
        $messages .= "Phone : " . $phone . "<br/>";
        $messages .= "Role : " . $role . "<br/>";
        $messages .= "Email : " . $email . "<br/>";
        $messages .= "Password : " . $password;
        $messages .= "<br/><br/> Use this username and the password for timeline.<br/> Thank you";
        mail($email, "New acoount is created", $messages, $headers);
        $msg = 'A new account has been created';
        echo '<script type="text/javascript">alert("' . $msg . '");</script>';
        echo "<script>setTimeout(\"location.href = 'viewUsers.php';\",1500);</script>";
		exit;
	}
		
	else
	{
 		header("Location:viewUsers.php");
		exit;
	}

function randomPassword() {

    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = "";
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, strlen($alphabet) - 1);
        $pass .= $alphabet[$n];
    }
    $speChar = "!@#$%_-";
    $n = rand(0, strlen($speChar) - 1);
    $pass .= $speChar[$n];
    return $pass;
}

?>