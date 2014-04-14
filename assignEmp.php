<?php
SESSION_START();
/*		
 	$_SESSION['current_page'] = "addTask.php";
	$user= $_SESSION[usr];
	$pass= $_SESSION[pwd];	
	*/

include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Untitled Page</title>
    <style>
        body
        {
            font-family: Verdana;
            font-size: 12px;
        }
        td{
            padding: 0em 0em !important;
        }
    </style>
</head>
<body>


    <table cellpadding="2" cellspacing="10">
        <tr>
            <td>
    <form method=post name='emp-form' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
    <div id="emp-div" ></div>
	<select class='form-control' name='assignees' style='width: 165px' onchange='form.submit()'>
		<option >--Select a Role--</option>
      	<option  value='all'>All</option>
		<option value='programmer'>Programmer</option>
		<option value='developer'>Developer</option>
  		<option value='tester'>Tester</option>
    </select>
	</form>
            </td>
        </tr>
        
        
<?php
if ('POST' === $_SERVER['REQUEST_METHOD']){
//Populiting the list from DB
if ($_POST['assignees'] === "all")
	$sql= "SELECT first_name, last_name, uid FROM users";   
else
	$sql= "SELECT first_name, last_name, uid FROM users WHERE role = '" . $_POST['assignees'] ."' ORDER BY last_name";
    error_log($sql);

$result= $db->query($sql);

echo '<tr><td> Assignees: </td></tr>';

$i=0;
while($row= mysqli_fetch_row($result))
{

	 $f = $row[0];
	 $l = $row[1];
	echo'<tr><td>';
	 echo "<input type='checkbox' name='cb' value= '". $row[0]." ". $row[1]."'>" ;
	 echo $f . " " . $l;
	 echo "<input type='hidden' name='uid' value='". $row[2]. "'>";
	 
	 $uiid[$i] = $row[2];
	 $i++;
	 echo '</td></tr>';
}   

echo'<tr><td>';

echo '</td></tr>';
}
?>     
        <tr>
            <td align="center">
                <input type="button" onclick="AssignClick()" value="Assign Employees" style="height: 30px;
                    width: 100px;"/>
                <input type="button" onclick="CancelClick()" value="Cancel" style="height: 30px;
                    width: 100px;"/>
            </td>
        </tr>
    </table>
    <script>
        function AssignClick() {
            if (!valthisform()){
                document.getElementById("emp-div").innerHTML="Please select at least one employee";}
            else {
            PassValueToParentWindow();
            window.parent.modalWin.CallCallingWindowFunction(0, 'User Enrolled Scucessfully');}
        }
        function CancelClick() {
            window.parent.modalWin.CallCallingWindowFunction(0, 'Information Saved Scucessfully');
        }

        function PassValueToParentWindow() {
            var temp1 = document.getElementsByName("cb");
            var temp2 = document.getElementsByName("uid");
            var names = new Array();
            var ids = new Array();
            var c = 0;
			for (i=0;i<temp1.length;i++)
            	{ if (temp1[i].checked){
            		names[c] = temp1[i].value;
            		ids[c] = temp2[i].value;
            		c++;
            		}
            	}
            
            window.parent.ShowChildWindowValues(names, ids);
        }
        function valthisform()
        {
            var checkboxs=document.getElementsByName("cb");
            for(var i=0,l=checkboxs.length;i<l;i++)
            {
                if(checkboxs[i].checked)
                {
                    return true;
                }
            }
            return false;
        }
    </script>
</body>
</html>
