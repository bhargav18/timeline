/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 $(function() {
    $( "#from" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });

// $(function() {
//    $( "#start_date" ).datepicker();
//    $( "#end_date" ).datepicker();
//  });  
function fun1()
{
//alert('hii');                                      
var cost_value  = document.getElementById("cost").value;  
if(cost_value =="" || cost_value == null)
{                          
  alert("Please Enter Cost Value more 0 or more than that");
  return false;
}
if(isNaN(cost_value))
{
  alert('Please Enter Proper Value');
  return false;
}
if(cost_value < 0)
{
   alert('Enter estimation value more than zero') ;
   return false;
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
   window.location = 'http://localhost/homework_462/index.php';
}