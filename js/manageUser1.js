
function myFunction(act)
{
if(act == 0){
var x;
var r=true;
var DropdownList = document.getElementById('userstatus');
var SelectedValue = DropdownList.value;

  SelectedValue == 'Active';
  $('input').removeAttr('disabled');
  $('select').removeAttr('disabled');
  //return SelectedValue;
 
//}else{
//$('input').prop('disabled',true);
//$('select').prop('disabled',true);
//SelectedValue == 'Inactive'; 
  return SelectedValue;
}
}
