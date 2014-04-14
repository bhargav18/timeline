<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script>
function fun1()
{
//alert('hii');                                       
//var cost_value  = document.getElementById("cost").value;  
//var fname  = document.getElementById("first_name").value;  
var address  = document.getElementById("address").value;  
var email  = document.getElementById("email").value;  
var ph_number = document.getElementById("phone").value;
//alert(ph_number);
 if(email == "" || email == null)
 {
 alert('Enter Email Address') ;
 return false;
 }
 if(email)
 {
 //alert('hii');
 var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  if( !emailReg.test(email) ) {
      alert('Invalid Email Address') ;
      return false;
  } 
}

if(ph_number)
{
    //alert('hii');
	var filter = /^[0-9-+]+$/;

    if (!filter.test(ph_number)) {
	alert('Invalid Phone number') ;
        return false;
}
}
if(address)
{
if(/^[a-zA-Z0-9- ]*$/.test(address) == false) {
    alert('Your Address string contains illegal characters.');
	return false;
}
    
}
else
{
    //alert('hii');
    document.getElementById("form1").submit();
    return true;
}  
}

function fun2()
{
    window.location = 'http://localhost/homework_462/index2.php';
}
</script>

<?php session_start();
 ?>
<?php
                //$username=$_SESSION['username'];
				$username="rupal";
				

					$link = mysql_connect('127.0.0.1', 'root', 'root');
     if (!$link)
   {
   die('Could not connect: ' . mysql_error());
    }
   

    mysql_select_db("test",$link);
	$result = mysql_query("Select * from users where username='$username'",$link);
                         
                       
                              for($i=0; $i<mysql_numrows($result); $i++)
{ 
							   $username=mysql_result($result,$i,"username");
							    $password=mysql_result($result,$i,"password"); 
								$firstName=mysql_result($result,$i,"first_name");
								 $lastName=mysql_result($result,$i,"last_name");
								  $e=mysql_result($result,$i,"access_level");
								  if($e==1)
								  {
								  $role="Manager";
								  }
								  else if($e==2)
								  {
								 $role="Employee"; 
								  }
								  	$phone=mysql_result($result,$i,"phone");
								    $email=mysql_result($result,$i,"email");
									$address=mysql_result($result,$i,"address"); //please add address field in database 
									
									
									}
									
							    
                         
					
					if($_POST["submit"])
					{
					$a=$_POST["firstName"];
					$b=$_POST["lastName"];
					$c=$_POST["email"];
					$d=$_POST["password"];
					$e=$_POST["phone"];
					$f=$_POST["$address"];
					//echo $a." ".$b." ".$c." ".$d." ".$e." ".$f;
					
				
		
			 $result = mysql_query("UPDATE users SET first_name='$a', last_name='$b', password='$d', email='$c', phone='$e'  WHERE username='$username'",$link);
			echo "Sucessfully Updated";
					
					}

?>
<html>
<head>
<title>My Profile</title>
</head>
<body>
<br/>
<br/>

<form action="MyProfile.php" method="post" onSubmit="return fun1()">
<table width="40%" style="border: 1px solid black;">
<tr>
<td colspan="2" align="center">
<font color="blue" size="5">My Profile</font>
</td>
</tr>
<tr>
<td width="15%" align="right">First Name:</td>
<td width="25%" align="left">
<input type="text" size="40" name="firstName" maxlength="20" value="<?php echo htmlentities($firstName);?>" />
</td>
</tr>
<tr>
<td width="15%" align="right">Last Name:</td>
<td width="25%" align="left">
<input type="text" name="lastName" maxlength="20" value="<?php echo htmlentities($lastName);?>" />
</td>
</tr>
<tr>
<td align="right">Email:</td>
<td align="left">
<input type="text" name="email" id="email" maxlength="40" value="<?php echo htmlentities($email);?>" />
</td>
</tr>
<tr>
<td align="right">Password:</td>
<td align="left">
<input type="text" name="password" maxlength="20" value="<?php echo htmlentities($password);?>"/>
</td>
</tr>
<tr>
<td align="right">Role:</td>
<td align="left">
<input type="text" name="role" maxlength="20" readonly="readonly" value="<?php echo htmlentities($role);?>"/>
</td>
</tr>
<tr>
<td align="right">Phone:</td>
<td align="left">
<input type="text" id="phone" name="phone" maxlength="20" value="<?php echo htmlentities($phone);?>" />
</td>
</tr>
<tr>
<td align="right">Address:</td>
<td align="left">
<input type="text" id="address" name="address" maxlength="20" value="<?php echo htmlentities($address);?>" />
</td>
</tr>
    <tr>
       <td>&nbsp; 
            
        </td>
        <td align="left">
        <input type="submit" value="Update" name='submit' />
        <input type="button" value="Cancel" name='cancel' onClick="window.location.href='index.php'" />
                    </td>
    </tr>
    </table>
</form>

</body>
</html>