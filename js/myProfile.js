/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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

