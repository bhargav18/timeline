/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function fun1()
{
//alert('hii');                                       
//var cost_value  = document.getElementById("cost").value;  
var fname  = document.getElementById("first_name").value;  
var lname  = document.getElementById("last_name").value;  
var email  = document.getElementById("email").value;  
//var password = document.getElementById("password").value;
var role = document.getElementById("role").value;
var phone = document.getElementById("phone").value;
//alert(phone);
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

else if(role == "-1")
{
    alert('Select role position') ;
    return false;
}

else if(email == "" || email == null)
 {
 alert('Enter Email Address') ;
 return false;
 }
 if(email != "" && email!= null)
 {
 //alert('hii');
 var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  if( !emailReg.test(email) ) {
      alert('Invalid Email Address') ;
      return false;
  } 
}

if(phone ==""  || phone == null)
{
alert('Enter Phone Number');
return false;
}
if(phone!="")
{
    //alert('hii');
	var filter = /^[0-9-+]+$/;
if (!filter.test(phone)) {
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
