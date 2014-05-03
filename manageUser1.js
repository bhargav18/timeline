
function myFunction(act)
{
if(act == 0){
var x;
var r=confirm("Do you want to activate the account?");
var DropdownList = document.getElementById('userstatus');
var SelectedValue = DropdownList.value;
if (r==true)
  {
  SelectedValue == 'Active';
  $('input').removeAttr('disabled');
  $('select').removeAttr('disabled');
  //return SelectedValue;
 
  }
else if (r==false)
  {
  SelectedValue == 'Inactive'; 
  return SelectedValue;
  }
//}else{
//$('input').prop('disabled',true);
//$('select').prop('disabled',true);
//SelectedValue == 'Inactive'; 
  return SelectedValue;
}
}
