<html>
<head>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<!--<script src="jquery.js"></script> -->
<script>
</script>
</head>
<body>
<?php

					if($_POST["submit"])
					{
					$a=$_POST["first_name"];
					$b=$_POST["last_name"];
					$c=$_POST["address"];
					$e=$_POST["phone"];
					$f=$_POST["role"];
					$i=$_POST["email"];
					$j=$_POST["employeestatus"];
function randomPassword() {
    //DebugBreak();
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, strlen($alphabet)-1);
        $pass .= $alphabet[$n];
    }
    return $pass;
}      
//print_r($password);              
$password = randomPassword();                    
//$password = rand(0,25);					
					
					$link = mysql_connect('127.0.0.1', 'root', '');
     if (!$link)
   {
   die('Could not connect: ' . mysql_error());
    }
   

    mysql_select_db("test",$link);
    //mysql_select_db("homework_462",$link);
					$result = mysql_query("INSERT INTO users VALUES('','','$a','$b','$f','$e','$i','$j','$c','$password')",$link);
			echo "Sucessfully Created Account";
					
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $messages = "First Name : ".$a."<br/>";
                    $messages .= "Last Name : ".$b."<br/>";
                    $messages .= "Address : ".$c."<br/>";
                    $messages .= "Phone : ".$e."<br/>";
                    $messages .= "Role : ".$f."<br/>";
                    $messages .= "Email : ".$i."<br/>";
                    $messages .= "Password : ".$password;
                   mail($i,"New Acoount Created",$messages,$headers);
                    }
?>
 <a href="allemployee.php">All Employee</a>
<table align="right"><tr><td align="right" width="50%"><a href="allemployee.php" target="_blank">LIST OF ALL EMPLOYEE </a></td></tr></table>
<br/><br/>
<table border="1" width="100%">
<form action="CreateAccount.php" method="post" id="form1" onSubmit="return fun1()">
<tr>
<td align="left" width="50%">
Create An Account
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
<!--<tr>
<td>
Password
</td>
</tr>
<tr>
<td>
<input type="text" id="password" name="password" value=""></input> 
</td>
</tr>-->
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
<input type="text" id="phone" name="phone" value=""></input>  
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
  <option value="-1"></option>
  <option value="Programmer">Programmer</option>
  <option value="Developer">Developer</option>
  <option value="Tester">Tester</option>
  <option value="Designer">Designer</option>
 </select>
</td>
</tr>
<tr>
<td>
Employee Status
</td>
</tr>
<tr>
<td>
<select id="employeestatus" name="employeestatus">
  <option value="Active">Active</option>
  <option value="Inactive">Inactive</option>
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