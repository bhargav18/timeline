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

$holdFName = $holdLName = $holdCity = $holdCountry = $holdState = $holdZipcode = $holdPhone = 
$holdEmail = $holdAdd1 = $holdAdd2 = "";
function test_input($data)   // to test input!!
{
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
     elseif (!preg_match("/^[a-zA-Z ]*$/",test_input($_POST['fname'])))
       {
       $_SESSION['Errfname'] = "Only letters and no whitespace allowed"; 
       $error = 1;
       }
     else {
		$holdFName = $_POST['fname'];
		$_SESSION['Errfname'] = "";
		}
	
    if(empty($_POST['lname'])){
    	$_SESSION['Errlname'] = "Last name is required";
		$error = 1;}		
     elseif (!preg_match("/^[a-zA-Z ]*$/",test_input($_POST['lname'])))
       {
       $_SESSION['Errlname'] = "Only letters and no whitespace allowed";
       $error = 1; 
       }
	else {
		$holdLName = $_POST['lname'];
		$_SESSION['Errlname'] = "";
		}
	
if (empty($_POST['email']))
     {$_SESSION['Erremail'] = "Email is required";
	  $error = 1;}     
     elseif (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",test_input(trim($_POST['email']))))
       {
       	$_SESSION['Erremail'] = "Invalid email format";
     	$error = 1;	   
       }
     else {
	   $holdEmail = $_POST['email'];
       $_SESSION['Erremail'] = "";	   
       }  
     
    if(empty($_POST['phone'])){
    	$_SESSION['Errphone'] = "Phone is required"; 
		$error = 1;} 
	else {
		$holdPhone = test_input($_POST['phone']);
		$_SESSION['Errphone'] = "";
		}
    if(empty($_POST['address1'])){
    	$_SESSION['Erraddress1'] = "Address 1 is required"; 
		$error = 1;}
	else {
		$holdAdd1 = test_input($_POST['address1']);
		$_SESSION['Erraddress1'] = "";
		}
	if(!empty($_POST['address2']))
	{
		$holdAdd2 = test_input($_POST['address2']);
	}		
	if(empty($_POST['city'])){
    	$_SESSION['Errcity'] = "City name is required";
		$error = 1;}
    elseif (!preg_match ('/^[a-zA-Z\s]+$/', test_input($_POST['city'])))
       {
       $_SESSION['Errcity'] = "Only letters and whitespace are allowed"; 
	   $error = 1;}	
	else 
	    {
		$holdCity = $_POST['city'];
		$_SESSION['Errcity'] = "";
		}	
		
    if(empty($_POST['zipcode'])){
    	$_SESSION['Errzipcode'] = "Zip code is required"; 
		$error = 1;}
	else {
		$holdZipcode = test_input($_POST['zipcode']);
		$_SESSION['Errzipcode'] = "";
		}
		
	if(empty($_POST['state'])){
    	$_SESSION['Errstate'] = "State is required"; 
		$error = 1;}
    elseif (!preg_match ('/^[a-zA-Z\s]+$/', test_input($_POST['state'])))
       {
       $_SESSION['Errstate'] = "Only letters and whitespace are allowed"; 
	   $error = 1;}
	else {
		$holdState = $_POST['state'];
		$_SESSION['Errstate'] = "";
		}	
		
	if(empty($_POST['country'])){
    	$_SESSION['Errcountry'] = "Country name is required";
		$error = 1;}	
    elseif (!preg_match ('/^[a-zA-Z\s]+$/', test_input($_POST['country'])))
       {
       $_SESSION['Errcountry'] = "Only letters and whitespace are allowed"; 
	   $error = 1;}
	else 
	    {
		$holdCountry = $_POST['country'];
		$_SESSION['Errcountry'] = "";
		}
	
	if(	$error == 1)
	{
		$_SESSION['Eid']= $_POST['userid'];
		$_SESSION['Efname']= $holdFName;
		$_SESSION['Elname']= $holdLName;
		$_SESSION['Eemail']= $holdEmail;
		$_SESSION['Ephone']= $holdPhone;
		$_SESSION['Erole'] = $_POST['userrole'];
		$_SESSION['Estatus'] = $_POST['userstatus'];
		$_SESSION['Eaddress1']= $holdAdd1;
		$_SESSION['Eaddress2']= $holdAdd2;
		$_SESSION['Ecity']= $holdCit;
		$_SESSION['Ezipcode']= $holdZipcode;
		$_SESSION['Estate']= $holdState;
		$_SESSION['Ecountry']= $holdCountry;
		header("Location:manageUser.php");
		exit;
	}
		$uid = $_POST['userid'];
		$fname = $holdFName;
        $lname = $holdLName;
        $email = $holdEmail;
        $address1 = $holdAdd1;
		$address2 = $holdAdd2;
		$city = $holdCity;
		$zipcode = $holdZipcode;
		$state = $holdState;
		$country = $holdCountry;
        $role = $_POST['userrole'];
        $phone = $holdPhone;
        $status = $_POST['userstatus'];
		
 		$query = "SELECT *
         FROM users
         INNER JOIN address
         ON users.uid = address.user_uid AND users.uid like '$uid'";
    	$result = $db->query($query);

    	$row= mysqli_fetch_row($result);
  		
        $t=$row[0];
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