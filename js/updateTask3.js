function getTime(){
var now = new Date();
var years = now.getFullYear();
var months = now.getMonth()+1;
var days = now.getDate();
var newElm = document.createElement("input");
newElm.setAttribute("type", "hidden");
newElm.setAttribute("name",'clientTime');
newElm.setAttribute("value", months+"/"+days+"/"+years);
document.getElementById('sts').appendChild(newElm);
}

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
  
 var modalWin = new CreateModalPopUpObject();
 modalWin.SetLoadingImagePath("images/loading.gif");
 modalWin.SetCloseButtonImagePath("images/remove.gif");

function ShowNewPage(){
 var callbackFunctionArray = new Array(Assign, Cancel);
 modalWin.Draggable=false;
 modalWin.ShowURL('assignEmp.php',320,470,'Assign Employees to Task',null,callbackFunctionArray);
 }
 
//This is for Assign button
function Assign(msg){
modalWin.HideModalPopUp();
}

//This for cancel button
function Cancel(){
modalWin.HideModalPopUp();
}

function ShowChildWindowValues(names, ids) {
    var displayString = "";
    var div = document.getElementById("divShowChildWindowValues");
	//var x = document.getElementById("main");
	var empList = document.getElementById("empList");
	var arr = new Array();
        var i = 0;
	if (arr = document.getElementsByName("emp[]")){
    var emp;
	for ( i = 0; i < arr.length; i++)
	{
        emp = document.getElementById(''+i);
		emp.parentNode.removeChild(emp); 
        
    }if(emp = document.getElementById(''+i))
        emp.parentNode.removeChild(emp); 
}
    if (arr = document.getElementsByName('empName[]')){
    var emp ;
	for (var i = 0; i < arr.length; i++)
	{
		emp = document.getElementById('n'+i);
		emp.parentNode.removeChild(emp); 
        
	}if(emp = document.getElementById('n'+i))
        emp.parentNode.removeChild(emp); 
    } 
	var x = document.createElement('span');
    x.setAttribute('id', 'main');
    div.appendChild(x);
    var c=0;
    for (var i=0; names.length>i; i++)
    {      
        var newElm = document.createElement("input");
        newElm.setAttribute("type", "hidden");
        var elmName = 'emp[]';
        newElm.setAttribute("name",elmName);
        newElm.setAttribute("id",''+i);
        newElm.setAttribute("value", ""+ids[i]);
        x.appendChild(newElm);

        //Keep Names
        var newElm = document.createElement("input");
        newElm.setAttribute("type", "hidden");
        newElm.setAttribute("name",'empName[]');
        newElm.setAttribute("id",'n'+i);
        newElm.setAttribute("value", ""+names[i]);
        x.appendChild(newElm);
        
        displayString += names[i] + "<br>";
        c=i;
    }
    //x.appendChild(lm);
    //div.innerHTML = displayString;
    empList.innerHTML = displayString;
}