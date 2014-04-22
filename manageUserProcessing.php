<?php
SESSION_START();
    include './DBConfig.php';
    $mysql = new DBConfig();
    $db = $mysql->getDBConfig();
   
    /*if (!$connect) {
	    die('Could not connect to the mySQL database');
		}
		if(!mysql_select_db($database)) {
		   die('Could not connect to the database');
		   }
		   mysql_select_db($database);
*/

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
	
    if(empty($_POST['fname'])){
    	$_SESSION['Errfname'] = "First name is required"; 
		$error = 1;}	     
     //$fname = test_input($_POST['fname']);
     // check if name only contains letters and no whitespace
     elseif (!preg_match("/^[a-zA-Z]*$/",test_input($_POST['fname'])))
       {
       $_SESSION['Errfname'] = "Only letters and no whitespace allowed"; 
       $error = 1;
       }
     else {
		$hold1 = $_POST['fname'];
		$_SESSION['Errfname'] = "";
		}
	
    if(empty($_POST['lname'])){
    	$_SESSION['Errlname'] = "Last name is required";
		$error = 1;}		
     //$lname = test_input($_POST['lname']);
     // check if name only contains letters and no whitespace
     elseif (!preg_match("/^[a-zA-Z]*$/",test_input($_POST['lname'])))
       {
       $_SESSION['Errlname'] = "Only letters and no whitespace allowed";
       $error = 1; 
       }
	else {
		$hold2 = $_POST['lname'];
		$_SESSION['Errlname'] = "";
		}
	
if (empty($_POST['email']))
     {$_SESSION['Erremail'] = "Email is required";
	  $error = 1;}     
     //$email = test_input($_POST['email']);
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
	/*
    if(empty($_POST['password'])){
    	$_SESSION['Errpassword'] = "Password is required"; 
		$error = 1;}
		
	    $password = test_input($_POST['password']);
     // check if Password have a least minimal length of 8 characters and contains numeric characters
    if (!preg_match("/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,30}$/",$password))
       {
       $_SESSION['Errpassword'] = "Password should have a least minimal length of 8 characters and contains alphanumeric characters"; 
	   $error = 1;
       }
	else {
		$Hold5 = $_POST['password'];
		$_SESSION['Errpassword'] = "";
		}	
	*/
    if(empty($_POST['address1'])){
    	$_SESSION['Erraddress1'] = "Address 1 is required"; 
		$error = 1;}
		//$address1 = test_input($_POST['address1']);
     // check if the address format is valid
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
		//$city = test_input($_POST['city']);
     // check if the city is valid
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
		
		//$zipcode = test_input($_POST['zipcode']);
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
		
		//$state = test_input($_POST['state']);
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
		
		//$country = test_input($_POST['country']);
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
		$_SESSION['Eid']= $_POST['userid'];
		$_SESSION['Efname']= $Hold1;
		$_SESSION['Elname']= $Hold2;
		$_SESSION['Eemail']= $Hold3;
		$_SESSION['Ephone']= $Hold4;
		$_SESSION['Epassword']= $Hold5;
		$_SESSION['Erole'] = $_POST['userrole'];
		$_SESSION['Estatus'] = $_POST['userstatus'];
		$_SESSION['Eaddress1']= $Hold6;
		$_SESSION['Eaddress2']= $_POST['address2'];
		$_SESSION['Ecity']= $Hold7;
		$_SESSION['Ezipcode']= $Hold8;
		$_SESSION['Estate']= $Hold9;
		$_SESSION['Ecountry']= $Hold10;
		header("Location:manageUser.php");
		exit;
	}
		$uid = $_POST['userid'];
		$fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        //$password = $_POST['password'];
        $address1 = $_POST['address1'];
		$address2 = $_POST['address2'];
		$city = $_POST['city'];
		$zipcode = $_POST['zipcode'];
		$state = $_POST['state'];
		$country = $_POST['country'];
        $role = $_POST['userrole'];
        $phone = $_POST['phone'];
        $status = $_POST['userstatus'];
		
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
		if (!($fname == $row[2]))
		{
			$query2 = "UPDATE user SET first_name='$fname' where uid like '$uid'";
			$db->query($query2);
		}
		if (!($lname == $row[3]))
		{
			$query3 = "UPDATE user SET last_name='$lname' where uid like '$uid'";
			$db->query($query3);
		}
		if (!($role == $row[4]))
		{
			$query4 = "UPDATE user SET role='$role' where uid like '$uid'";
			$db->query($query4);
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
		if (!($phone == $row[12]))
		{
			$query12 = "UPDATE user SET phone='$phone' where uid like '$uid'";
			$db->query($query12);
		}
		if (!($status == $row[13]))
		{
			$query13 = "UPDATE user SET status='$status' where uid like '$uid'";
			$db->query($query13);
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
 		header("Location:viewUsers.php");
		exit;
	}		
?>