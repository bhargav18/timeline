<?php
SESSION_START();
date_default_timezone_set('America/Los_Angeles');
    include './DBConfig.php';
    $mysql = new DBConfig();
    $db = $mysql->getDBConfig();

$uid = $email = $password = $address1 = $address2 = $city = $zipcode = $state = $country = $phone = "";

        
function test_input($data)   // to test input!!
{
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

function isEmpty($data)   // to test input!!
{
    $data = trim($data);
    if (empty($data))
        return true;
    else
        return false;
}
    

if (!empty($_POST)){
	
	if ($_POST['update']) 
	{
	$error = 0;
	
	if (empty($_POST['email']))
     {$_SESSION['Erremail'] = "Email is required";
	  $error = 1;}     
     elseif (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",test_input($_POST['email'])))
       {
       	$_SESSION['Erremail'] = "Invalid email format";
     	$error = 1;	   
       }
     else {
	   $email = $_POST['email'];
       $_SESSION['Erremail'] = "";	   
       }  
     
    if(isEmpty($_POST['phone'])){
    	$_SESSION['Errphone'] = "Phone is required"; 
		$error = 1;} 
	else {
		$phone = test_input($_POST['phone']);
		$_SESSION['Errphone'] = "";
		}
		
    if(isEmpty($_POST['password'])){
    	$_SESSION['Errpassword'] = "Password is required"; 
		$error = 1;}
 // check if Password have a minimal length of 8 characters and contains numeric characters
    elseif (!preg_match("/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%_-]{8,30}$/",$_POST['password']))
       {
       $_SESSION['Errpassword'] = "Password should have a minimal length of 8 characters and contains alphanumeric characters"; 
	   $error = 1;
       }
	else {
		$password = $_POST['password'];
		$_SESSION['Errpassword'] = "";
		}	
    if(isEmpty($_POST['address1'])){
    	$_SESSION['Erraddress1'] = "Address 1 is required"; 
		$error = 1;}
	else {
		$address1 = test_input($_POST['address1']);
		$_SESSION['Erraddress1'] = "";
		}
	if(!isEmpty($_POST['address2']))
	{
		$address2 = $_POST['address2'];
		$_SESSION['Erraddress2'] = "";
	}		
	if(isEmpty($_POST['city'])){
    	$_SESSION['Errcity'] = "City name is required";
		$error = 1;}
    elseif (!preg_match ('/^[a-zA-Z\s]+$/', test_input($_POST['city'])))
       {
       $_SESSION['Errcity'] = "Only letters and white space are allowed";
		$city = $_POST['city'];
	   $error = 1;}	
	else 
	    {
		$city = $_POST['city'];
		$_SESSION['Errcity'] = "";
		}	
		
    if(isEmpty($_POST['zipcode'])){
    	$_SESSION['Errzipcode'] = "Zip code is required"; 
		$error = 1;}
	else {
		$zipcode = test_input($_POST['zipcode']);
		$_SESSION['Errzipcode'] = "";
		}
		
	if(isEmpty($_POST['state'])){
    	$_SESSION['Errstate'] = "State is required"; 
		$error = 1;}
    elseif (!preg_match ('/^[a-zA-Z\s]+$/', test_input($_POST['state'])))
       {
       $_SESSION['Errstate'] = "Only letters and white space are allowed"; 
	   $error = 1;}
	else {
		$state = $_POST['state'];
		$_SESSION['Errstate'] = "";
		}	
		
	if(isEmpty($_POST['country'])){
    	$_SESSION['Errcountry'] = "Country name is required";
		$error = 1;}	
     // check if the country is valid
    elseif (!preg_match ('/^[a-zA-Z\s]+$/', test_input($_POST['country'])))
       {
       $_SESSION['Errcountry'] = "Only letters and white space are allowed";
		$country = $_POST['country'];
	   $error = 1;}
	else 
	    {
		$country = $_POST['country'];
		$_SESSION['Errcountry'] = "";
		}
	
	if(	$error == 1)
	{
		$_SESSION['Eemail']= $email;
		$_SESSION['Ephone']= $phone;
		$_SESSION['Epassword']= $password;
		$_SESSION['Eaddress1']= $address1;
		$_SESSION['Eaddress2']= $address2;
		$_SESSION['Ecity']= $city;
		$_SESSION['Ezipcode']= $zipcode;
		$_SESSION['Estate']= $state;
		$_SESSION['Ecountry']= $country;
		header("Location:updateProfile.php");
		exit;
	}
		$uid = $_POST['userid'];
	/*
        $email = $_POST['email'];
        $password = $_POST['password'];
        $address1 = $_POST['address1'];
		$address2 = $_POST['address2'];
		$city = $_POST['city'];
		$zipcode = $_POST['zipcode'];
		$state = $_POST['state'];
		$country = $_POST['country'];
        $phone = $_POST['phone'];
		*/
        $updated = 0;
 		$query = "SELECT *
         FROM users
         INNER JOIN address
         ON users.uid = address.user_uid AND users.uid like '$uid'";
    	$result = $db->query($query);

    	$row= mysqli_fetch_row($result);
  		
           $t=$row[0];
           
		if ($email != $row[1] || $password != $row[11] || $phone == $row[12])
		{
			$stmt = $db->prepare("UPDATE users SET email = ?, password = ?, phone = ? WHERE uid like '$uid'"); 
			$stmt->bind_param('sss', $email, $password, $phone);
			$stmt->execute();
			$updated = 1;
		}
     	if ($address1 != $row[5] || $address2 != $row[6] || $city != $row[7] || $zipcode != $row[8] || $state != $row[9] 
     			|| $country != $row[10] )
		{
			$stmt = $db->prepare("UPDATE address SET country=?, address1 = ?, address2 = ?, city = ?, zipcode = ?, state = ? WHERE user_uid like '$uid'"); 
			$stmt->bind_param('ssssss', $country,$address1, $address2, $city, $zipcode, $state);
			$stmt->execute();
			$updated = 1;
			
		}
		/*
		if (!($address2 == $row[6]))
		{
		$stmt = $db->prepare("UPDATE user SET status = ?, priority = ?, description = ?, cost = ?, end_date = ? WHERE user_uid like '".$_POST['projId']."'"); 
		$stmt->bind_param('sssss', $_POST['status'], $_POST['priority'], $holdDesc, $holdCost, $holdED);
		$stmt->execute();
			$query6 = "UPDATE address SET address2='$address2' where user_uid like '$uid'";
			$db->query($query6);
		}
		if (!($city == $row[7]))
		{
			$query7 = "UPDATE address SET city='$city' where user_uid like '$uid'";
			$db->query($query7);
		}
		if (!($zipcode == $row[8]))
		{
		$stmt = $db->prepare("UPDATE user SET status = ?, priority = ?, description = ?, cost = ?, end_date = ? WHERE uid like '".$_POST['projId']."'"); 
		$stmt->bind_param('sssss', $_POST['status'], $_POST['priority'], $holdDesc, $holdCost, $holdED);
		$stmt->execute();
			$query8 = "UPDATE address SET zipcode='$zipcode' where address.user_uid like '$uid'";
			$db->query($query8);
		}
		if (!($state == $row[9]))
		{
			$query9 = "UPDATE address SET state='$state' where user_uid like '$uid'";
			$db->query($query9);
		}
		if (!($country == $row[10]))
		{
			$query10 = "UPDATE address SET country='$country' where user_uid like '$uid'";
			$db->query($query10);
		}
		if (!($password == $row[11]))
		{
		$stmt = $db->prepare("UPDATE user SET status = ?, priority = ?, description = ?, cost = ?, end_date = ? WHERE uid like '".$_POST['projId']."'"); 
		$stmt->bind_param('sssss', $_POST['status'], $_POST['priority'], $holdDesc, $holdCost, $holdED);
		$stmt->execute();
			$query11 = "UPDATE users SET users.password='$password' where user.uid like '$uid'";
			$db->query($query11);
		}
		if (!($phone == $row[12]))
		{
		$stmt = $db->prepare("UPDATE user SET status = ?, priority = ?, description = ?, cost = ?, end_date = ? WHERE uid like '".$_POST['projId']."'"); 
		$stmt->bind_param('sssss', $_POST['status'], $_POST['priority'], $holdDesc, $holdCost, $holdED);
		$stmt->execute();
			$query12 = "UPDATE user SET c='$phone' where uid like '$uid'";
			$db->query($query12);
		}
		*/
        
    if ($updated == 1) {
		$msg = 'Your profile has been updated';
        echo '<script type="text/javascript">alert("' . $msg . '");</script>';
    }
	}
        echo "<script>setTimeout(\"location.href = 'updateProfile.php';\",500);</script>";
		exit;
	}
		
	else
	{
 		header("Location:updateProfile.php");
		exit;
	}		
?>