<html>
<head>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<!--<script src="jquery.js"></script> -->
<script>
function fun1()
{
//alert('hii');                                       
//var cost_value  = document.getElementById("cost").value;  
var fname  = document.getElementById("first_name").value;  
var lname  = document.getElementById("last_name").value;  
var email  = document.getElementById("email").value;  
var ph_number = document.getElementById("phone_number").value;
//alert(ph_number);
if(fname == "" || fname == null)
{
    alert('Enter First Name') ;
    return false;
}
else if(lname == "" || lname == null)
{
    alert('Enter Last Name') ;
    return false;
}
else if(email == "" || email == null)
 {
 alert('Enter Email Address') ;
 if(email)
 {
 var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  if( !emailReg.test(email) ) {
      alert('Invalid Email Address') ;
      return false;
  } 
}
}
else if(ph_number)
{
    var filter = /^[0-9-+]+$/;

    if (!filter.test(ph_number)) {
	alert('Invalid Phone number') ;
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
    //window.location = 'http://localhost/homework_462/index2.php';
}
</script>
</head>
<body>
<?php

					if($_POST["submit"])
					{
					$a=$_POST["first_name"];
					$b=$_POST["last_name"];
					$c=$_POST["address"];
					$d=$_POST["password"];
					$e=$_POST["phone_number"];
					$f=$_POST["role"];
					$g=$_POST["uid"];
					$h=$_POST["username"];
					$i=$_POST["email"];
					
					
					$link = mysql_connect('127.0.0.1', 'root', 'root');
     if (!$link)
   {
   die('Could not connect: ' . mysql_error());
    }
   

    mysql_select_db("test",$link);
					$result = mysql_query("INSERT INTO users VALUES('$g','$h','$d','$a','$b','$f','$e','$i')",$link);
			echo "Sucessfully Inserted";
					}
					


?>
<table border="1" width="100%">
<form action="CreateAccount.php" method="post" id="form1" onSubmit="return fun1()">
<tr>
<td>
Create An Account
</td>
</tr>
<tr>
<td>
Username
</td>
</tr>
<tr>
<td>
<input type="text" id="username" name="username" value=""></input> 
</td>
</tr>
<tr><td>First name</td></tr>
<tr>

<td>
<input type="text" id="first_name" name="first_name" value=""></input> 
<?php
    if($message)
    {
        //DebugBreak();
        echo $message ;
        $message = "";
    }
?>
</td>
</tr>
<tr>
<td>
Last Name
</td>
</tr>
<tr>
<td>
<input type="text" id="last_name" name="last_name" value=""></input> 
</td>
</tr>
<tr>
<td>
Password
</td>
</tr>
<tr>
<td>
<input type="text" id="password" name="password" value=""></input> 
</td>
</tr>
<tr>
<td>
Address
</td>
</tr>
<tr>
<td>
<textarea cols="165" rows="5" name="address" id="adress"></textarea>
</td>
</tr>
<tr>
<td>
Email
</td>
</tr>
<tr>
<td>
<input type="text" id="email" name="email" value=""></input> 
</td>
</tr>
<tr>
<td>
Phone Number
</td>
</tr>
<tr>
<td>
<input type="text" id="phone_number" name="phone_number" value=""></input>  
</td>
</tr>
<tr>
<td>
Select Role
</td>
</tr>
<tr>
<td>
<select id="role" name="role">
  <option value="manager">Manager</option>
  <option value="user">User</option>
 </select>
</td>
</tr>
<tr>
<td>
Employee
</td>
</tr>
<tr>
<td>
<select id="uid" name="uid">
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
 </select>
</td>
</tr>
<tr>
<td>
<input type="submit" id="submit" name="submit" value="Submit"></input>
<input type="button" id="Cancel" name="Cancel" value="Cancel" onClick="fun2()"></input>
</td>
</tr>
</form>
</table>

</body>
</html>