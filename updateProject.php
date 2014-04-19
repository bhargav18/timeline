<?php
    include './Template.php';
    include './DBConfig.php';
    $mysql = new DBConfig();
    $db = $mysql->getDBConfig();
    
    $head = '<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="/js/updateProject.js"></script>
';
    $header = new Template("./header.php", array(head => $head, title => "Update Project"));
    $header->out();
if (!empty($_POST) || !empty($_SESSION['pId']))
{
$id = $descErr = $edateErr ="";

if( !empty($_SESSION['pId']))
{
	$id = $_SESSION['pId'];
	$_SESSION['pId'] ="";
}
if(!empty($_SESSION['uPDescErr']))
{
	$descErr = $_SESSION['uPDescErr'];
	$_SESSION['uPDescErr']="";
}
if (!empty($_SESSION['uPEDateError']))
{
	$edateErr = $_SESSION['uPEDateError'];
	$_SESSION['uPEDateError'] = "";
}
?>
  <div id="content-wrap">

            <!-- content -->
            <div id="content" class="clearfix">

                <!-- main -->
                <div id="main">

                    <div class="main-content">
<form action= "updateProjProc.php" method= "post">
    
<?php 

		if ($_POST['radio'])	
  			$selectedProj = $_POST['radio'];
  		else 
			$selectedProj = $id;
			
        $query="SELECT name, uid, status, priority, description, start_date, end_date
        		FROM project WHERE uid like '$selectedProj'";
		$result= $db->query($query);
  		$row= mysqli_fetch_row($result);
		$name = $row[0];
		$id = $row[1];
		if (!empty($_SESSION['uPSts']))
		{
			$sts = $_SESSION['uPSts'];
			$_SESSION['uTSts'] = "";
		}
		else
			$sts = $row[2];

		if (!empty($_SESSION['uPDesc']))
		{
			$desc = $_SESSION['uPDesc'];
			$_SESSION['uTDesc'] = "";
		}
		else
			$desc = $row[4];
		$sDate = $row[5];
		if (!empty($_SESSION['uPEDate']))
		{
			$eDate = $_SESSION['uPEDate'];
			$_SESSION['uPEDate'] = "";
		}
		else
			$eDate = $row[6];
?> 


	<label>Project ID: <?php echo $id; ?></label>	
	<input type='hidden' value='<?php echo $id; ?>' name='projId'/>


	<label>Project Name: <?php echo $name; ?></label>


<!-- Description -->
 
    <label for='exampleInputEmail1'>Description</label>
    <textarea rows='10' cols='50' name='descr' ><?php echo $desc; ?></textarea>
    <span class='err'><?php echo $descErr;$descErr =""; ?></span>


<!-- dates -->

	<div>
	  <label for="exampleInputEmail1">Start Date</label>
      <input  class="form-control" name="startdate" value='<?php echo date("m/d/Y", strtotime($sDate)); ?>' readonly="true"></input>
    </div>



	<div>
	  <label for="exampleInputEmail1">End Date</label>
      <input type="text" class="form-control" name="enddate" id="to" value='<?php echo date("m/d/Y", strtotime($eDate)); ?>' readonly="true"></input>
      <span class="err"><?php echo $edateErr;?></span>
     </div>

    
<!-- Status -->

    <label for='exampleInputEmail1'>Status</label>
	<select class='form-control' name='status' style='width: 165px'>
		<option value='Open' <?php echo ($sts === "Open")?"selected":""; ?>>Open</option>
		<option value='In Progress' <?php echo ($sts === "In Progress")?"selected":""; ?>>In Progress</option>
		<option value='Completed' <?php echo ($sts === "Completed")?"selected":""; ?>>Completed</option>
  		<option value='Closed' <?php echo ($sts === "Closed")?"selected":""; ?>>Closed</option>
  </select>


<!-- Priority -->
 
    <label for='exampleInputEmail1'>Priority</label>	
	<select class='form-control' name='priority' style='width: 165px'>
		<option value='High' <?php echo ($prio === "High")?"selected":""; ?>>High</option>
		<option value='Mid' <?php echo ($prio === "Mid")?"selected":""; ?>>Mid</option>
  		<option value='Low' <?php echo ($prio === "Low")?"selected":""; ?>>Low</option>
  </select>

<br/>

  <input type='submit' name='update' value= 'Update Project' class='btn btn-info'>
  <input type='submit' name='delete' value= 'Delete Project' class='btn btn-info'>
  

  </form>   		
<?php 		
		mysql_close($connect);
}
else
{
	header("Location:viewProjects.php");
 		exit;
}
?>
</div>

                    <!-- /main -->
                </div>

                <!-- sidebar -->
<? include './sidebar.php'; ?>
                <!-- content -->
            </div>

            <!-- /content-out -->
        </div>

        <!-- extra -->
<?php 
include './footer.php';
?>