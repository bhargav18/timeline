<?php
SESSION_START();
    include './DBConfig.php';
    $mysql = new DBConfig();
    $db = $mysql->getDBConfig();

$Hold1 = $Hold2 = $Hold3 = $Hold4 = $Hold5 = $Hold6 = $Hold7 = $Hold8 = $Hold9 = $Hold10 = $Hold11 = $Hold12 = $Hold13 = "";
function test_input($data)   // to test Email input!!
{
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

if (!empty($_POST))
	
	if ($_POST['update']) 
	{
	$error = 0;
	
	if (empty($_POST['email']))
     {$_SESSION['Erremail'] = "Email is required";
	  $error = 1;}     
     // check if e-mail address syntax is valid
     elseif (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",test_input($_POST['email'])))
       {
       	$_SESSION['Erremail'] = "Invalid email format";
     	$error = 1;	   
       }
     else {
	   $Hold3 = $_POST['email'];
       $_SESSION['Erremail'] = "";	   
       }  
     
    if(empty($_POST['phone'])){
    	$_SESSION['Errphone'] = "Phone is required"; 
		$error = 1;} 
		//$phone = test_input($_POST['phone']);
		// check if only numbers and no whitespaces
	elseif (!preg_match("/^[0-9]*$/",test_input($_POST['phone'])))
	 {
     	$_SESSION['Errphone'] = "Please check phone number. Only numbers are allowed"; 
		$error = 1;
	}
	else {
		$Hold4 = $_POST['phone'];
		$_SESSION['Errphone'] = "";
		}
		
    if(empty($_POST['password'])){
    	$_SESSION['Errpassword'] = "Password is required"; 
		$error = 1;}
 // check if Password have a least minimal length of 8 characters and contains numeric characters
    elseif (!preg_match("/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,30}$/",$_POST['password']))
       {
       $_SESSION['Errpassword'] = "Password should have a least minimal length of 8 characters and contains alphanumeric characters"; 
	   $error = 1;
       }
	else {
		$Hold5 = $_POST['password'];
		$_SESSION['Errpassword'] = "";
		}	
    if(empty($_POST['address1'])){
    	$_SESSION['Erraddress1'] = "Address 1 is required"; 
		$error = 1;}
    elseif (!preg_match('/^[a-z0-9 .\-]+$/i',test_input($_POST['address1'])))
       {
       $_SESSION['Erraddress1'] = "Address is wrong"; 
	   $error = 1;}
	else {
		$Hold6 = $_POST['address1'];
		$_SESSION['Erraddress1'] = "";
		}
/* Need some work
	if(empty($_Post['address2']))
	{
		$_SESSION['Eaddress2'] = $_POST['address2'];
		$_SESSION['Erraddress2'] = "";
	}		
	*/	
	if(empty($_POST['city'])){
    	$_SESSION['Errcity'] = "City name is required";
		$error = 1;}
    elseif (!preg_match ('/^[a-zA-Z\s]+$/', test_input($_POST['city'])))
       {
       $_SESSION['Errcity'] = "City name is wrong"; 
	   $error = 1;}	
	else 
	    {
		$Hold7 = $_POST['city'];
		$_SESSION['Errcity'] = "";
		}	
		
    if(empty($_POST['zipcode'])){
    	$_SESSION['Errzipcode'] = "Zip code is required"; 
		$error = 1;}
// check if the address format is valid
    elseif (!preg_match ('/^[0-9]{5}$/', test_input($_POST['zipcode'])))
       {
       $_SESSION['Errzipcode'] = "Zip code is wrong"; 
	   $error = 1;}
	else {
		$Hold8 = $_POST['zipcode'];
		$_SESSION['Errzipcode'] = "";
		}
		
	if(empty($_POST['state'])){
    	$_SESSION['Errstate'] = "State is required"; 
		$error = 1;}
     // check if the state is valid
    elseif (!preg_match ('/^[a-zA-Z\s]+$/', test_input($_POST['state'])))
       {
       $_SESSION['Errstate'] = "State is wrong"; 
	   $error = 1;}
	else {
		$Hold9 = $_POST['state'];
		$_SESSION['Errstate'] = "";
		}	
		
	if(empty($_POST['country'])){
    	$_SESSION['Errcountry'] = "Country name is required";
		$error = 1;}	
     // check if the country is valid
    elseif (!preg_match ('/^[a-zA-Z\s]+$/', test_input($_POST['country'])))
       {
       $_SESSION['Errcountry'] = "Country name is wrong"; 
	   $error = 1;}
	else 
	    {
		$Hold10 = $_POST['country'];
		$_SESSION['Errcountry'] = "";
		}
	
	if(	$error == 1)
	{
		$_SESSION['Eemail']= $Hold3;
		$_SESSION['Ephone']= $Hold4;
		$_SESSION['Epassword']= $Hold5;
		$_SESSION['Eaddress1']= $Hold6;
		$_SESSION['Eaddress2']= $_POST['address2'];
		$_SESSION['Ecity']= $Hold7;
		$_SESSION['Ezipcode']= $Hold8;
		$_SESSION['Estate']= $Hold9;
		$_SESSION['Ecountry']= $Hold10;
		header("Location:updateProfile.php");
		exit;
	}
		$uid = $_POST['userid'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $address1 = $_POST['address1'];
		$address2 = $_POST['address2'];
		$city = $_POST['city'];
		$zipcode = $_POST['zipcode'];
		$state = $_POST['state'];
		$country = $_POST['country'];
        $phone = $_POST['phone'];
		
 		$query = "SELECT *
         FROM users
         INNER JOIN address
         ON users.uid = address.user_uid AND users.uid like '$uid'";
    	$result = $db->query($query);

    	$row= mysqli_fetch_row($result);
  		
           $t=$row[0];
        $query1 = $query2 = $query3 = $query4 = $query5 = $query6 = $query7 = $query8 = $query9 = $query10 = $query11 = $query12 = $query13 = "";
		if (!($email == $row[1]))
		{
			$query1 = "UPDATE users SET email='$email' where uid like '$uid'";
			$db->query($query1);
		}
     	if (!($address1 == $row[5]))
		{
			$query5 = "UPDATE address SET address1='$address1' where user_uid like '$uid'";
			$db->query($query5);
		}
		if (!($address2 == $row[6]))
		{
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
			$query11 = "UPDATE users SET users.password='$password' where user.uid like '$uid'";
			$db->query($query11);
		}
		if (!($phone == $row[12]))
		{
			$query12 = "UPDATE user SET phone='$phone' where uid like '$uid'";
			$db->query($query12);
		}
		
		/*
		if(!($query1) || !($query2) || !($query3) || !($query4) || !($query5) || !($query6) || !($query7) || !($query8) || !($query9) || !($query10) || !($query11) || !($query12) || !($query13) )
		{
		die('Could not update data: ' . mysql_error());
        }
		else
        echo "Update data successfully\n";
		*/
	}
		
	else
	{
 		header("Location:updateProfile.php");
		exit;
	}		
?>