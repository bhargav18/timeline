<?php
SESSION_START();
date_default_timezone_set('America/Los_Angeles');
    include './DBConfig.php';
    $mysql = new DBConfig();
    $db = $mysql->getDBConfig();

$holdFName = $holdLName = $holdCity = $holdCountry = $holdState = $holdZipcode = $holdPhone = 
$holdEmail = $holdAdd1 = $holdAdd2 = "";
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
    
if (!empty($_POST))
{
	if ($_POST['update']) 
	{
	/*if ($_POST['orgSts'] == 'Inactive' && $_POST['userstatus'] == 'Inactive' )
	{
		echo "<script>setTimeout(\"location.href = 'viewUsers.php';\",50);</script>";
		exit;
	}*/
	$error = 0;
	
    if(isEmpty($_POST['fname'])){
    	$_SESSION['Errfname'] = "First name is required"; 
		$error = 1;}
	elseif (!preg_match("/^[a-zA-Z ]*$/",test_input($_POST['fname'])))
       {
	       $_SESSION['Errfname'] = "Only letters and whitespace are allowed";
	       $holdFName = $_POST['lname'];
	       $error = 1;
       }
     else {
         $holdFName = test_input($_POST['fname']);
		$_SESSION['Errfname'] = "";
		}
	
    if(isEmpty($_POST['lname'])){
    	$_SESSION['Errlname'] = "Last name is required";
		$error = 1;}
	elseif (!preg_match("/^[a-zA-Z ]*$/",test_input($_POST['lname'])))
       {
       $_SESSION['Errlname'] = "Only letters and whitespace are allowed";
           $holdLName = $_POST['lname'];
       $error = 1; 
       }
	else {
		$holdLName = test_input($_POST['lname']);
		$_SESSION['Errlname'] = "";
		}
	
if (isEmpty($_POST['email']))
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
     
    if(isEmpty($_POST['phone'])){
    	$_SESSION['Errphone'] = "Phone is required"; 
		$error = 1;} 
	else {
		$holdPhone = test_input($_POST['phone']);
		$_SESSION['Errphone'] = "";
		}
        
    if(isEmpty($_POST['address1'])){
    	$_SESSION['Erraddress1'] = "Address 1 is required"; 
		$error = 1;}
	else {
		$holdAdd1 = test_input($_POST['address1']);
		$_SESSION['Erraddress1'] = "";
		}
        
	if(!isEmpty($_POST['address2']))
	{
		$holdAdd2 = test_input($_POST['address2']);
	}
        
	if(isEmpty($_POST['city'])){
    	$_SESSION['Errcity'] = "City name is required";
		$error = 1;
	}
	elseif (!preg_match ('/^[a-zA-Z\s]+$/', test_input($_POST['city'])))
       {
	       $_SESSION['Errcity'] = "Only letters and whitespace are allowed";
	       $holdCity = $_POST['city'];
		   $error = 1;
       }	
	else 
	    {
		$holdCity = test_input($_POST['city']);
		$_SESSION['Errcity'] = "";
		}	
		
    if(isEmpty($_POST['zipcode'])){
    	$_SESSION['Errzipcode'] = "Zip code is required"; 
		$error = 1;}
	else {
		$holdZipcode = test_input($_POST['zipcode']);
		$_SESSION['Errzipcode'] = "";
		}
		
	if(isEmpty($_POST['state'])){
    	$_SESSION['Errstate'] = "State is required"; 
		$error = 1;
	}
	elseif (!preg_match ('/^[a-zA-Z\s]+$/', test_input($_POST['state'])))
       {
       $_SESSION['Errstate'] = "Only letters and whitespace are allowed";
           $holdState = $_POST['state'];
	   $error = 1;}
	else {
		$holdState = test_input($_POST['state']);
		$_SESSION['Errstate'] = "";
		}	
		
	if(isEmpty($_POST['country'])){
    	$_SESSION['Errcountry'] = "Country name is required";
		$error = 1;}	
    elseif (!preg_match ('/^[a-zA-Z\s]+$/', test_input($_POST['country'])))
       {
       $_SESSION['Errcountry'] = "Only letters and whitespace are allowed";
           $holdCountry = $_POST['country'];
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
		$_SESSION['Ecity']= $holdCity;
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
		$updated = 0;
 		$query = "SELECT *
         FROM users
         INNER JOIN address
         ON users.uid = address.user_uid AND users.uid like '$uid'";
    	$result = $db->query($query);

    	$row= mysqli_fetch_row($result);
  		
        $t=$row[0];
        
	if ($email != $row[7] || $fname != $row[3] || $lname != $row[4] || $role != $row[8] 
			|| $status != $row[9] || $phone != $row[6])
		{
			$stmt = $db->prepare("UPDATE users SET email = ?, first_name = ?, last_name = ?, role = ?,employee_status = ?,phone = ? WHERE uid like '$uid'"); 
			$stmt->bind_param('ssssss', $email, $fname, $lname, $role, $status, $phone);
			$stmt->execute();
			$updated = 1;
		}
     	if ($address1 != $row[11] || $address2 != $row[12] || $city != $row[13] || $zipcode != $row[14] || $state != $row[15] 
     			|| $country != $row[16] )
		{
			$stmt = $db->prepare("UPDATE address SET address1 = ?, address2 = ?, city = ?, zipcode = ?, state = ? WHERE user_uid like '$uid'"); 
			$stmt->bind_param('sssss', $address1, $address2, $city, $zipcode, $state);
			$stmt->execute();
			$updated = 1;
			
		}
		if ( $updated == 1){
        	$msg = ' Account has been updated';
        	echo '<script type="text/javascript">alert("' . $msg . '");</script>';
		}
	}
        echo "<script>setTimeout(\"location.href = 'viewUsers.php';\",100);</script>";
		exit;
	}
		
	else
	{
 		header("Location:viewUsers.php");
		exit;
	}		
?>