<?php
	        date_default_timezone_set('America/Los_Angeles');

    include './Template.php';
    include './DBConfig.php';
    $mysql = new DBConfig();
    $db = $mysql->getDBConfig();
if ((!empty($_POST) && !empty($_POST['radio'])) || !empty($_SESSION['pId']))
{    
    $head = '<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="js/updateProject.js"></script>
';
    $header = new Template("./header.php", array("current_page"=>2,"head" => $head, "title" => "Update Project"));
    $header->out();

$id = $descErr = $edateErr ="";

//Get error messages if any
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
if (!empty($_SESSION['uPCostErr'])) {
    $costErr = $_SESSION['uPCostErr'];
    $_SESSION['uPCostErr'] = "";
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
			
        $query="SELECT name, uid, status, priority, description, start_date, end_date, cost
        		FROM project WHERE uid like '$selectedProj'";
		$result= $db->query($query);
  		$row= mysqli_fetch_row($result);
		$name = $row[0];
		$id = $row[1];
		if (!empty($_SESSION['uPSts']))
		{
			$sts = $_SESSION['uPSts'];
			$_SESSION['uPSts'] = "";
		}
		else
			$sts = $row[2];
		if (!empty($_SESSION['uPPrio']))
		{
			$prio = $_SESSION['uPPrio'];
			$_SESSION['uPPrio'] = "";
		}
		else
			$prio = $row[3];

		if (!empty($_SESSION['uPDesc']))
		{
			$desc = $_SESSION['uPDesc'];
			$_SESSION['uPDesc'] = "";
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
		if (!empty($_SESSION['uPCost']))
		{
			$pCost = $_SESSION['uPCost'];
			$_SESSION['uPCost'] = "";
		}
		else
			$pCost = $row[7];
?> 


	<label>Project ID: <?php echo $id; ?></label>	
	<input type='hidden' value='<?php echo $id; ?>' name='projId'/>


	<label>Project Name: <?php echo $name; ?></label>


<!-- Description -->
 
    <label>Description</label>
    <textarea rows='10' cols='50' name='descr' maxlength = "20000" required><?php echo $desc; ?></textarea>
    <span class='err'><?php echo $descErr;$descErr =""; ?></span>


<!-- dates -->

	<div>
	  <label for="exampleInputEmail1">Start Date</label>
      <input  class="form-control" name="startdate" value='<?php echo date("m/d/Y", strtotime($sDate)); ?>' readonly="true"></input>
    </div>



	<div>
	  <label for="exampleInputEmail1">End Date</label>
      <input class="form-control" name="enddate" id="to" value='<?php echo date("m/d/Y", strtotime($eDate)); ?>' readonly="true"></input>
      <span class="error"><?php echo $edateErr;?></span>
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
  
                    <!-- Cost -->
                        <label >Project Budget</label>
                        <input type='text' class='form-control' name='cost' maxlength = "15"
                               value='<?php echo $pCost; ?>' placeholder='Enter project budget'  required/>
                        <span class="error"><?php echo !empty($costErr) ? $costErr : ""; ?></span>                    


<br/>

  <input type='submit' name='update' value= 'Update Project' class='btn btn-info1'>
  <input type='submit' name='delete' value= 'Delete Project' class='btn btn-info2' onclick='return confirm("You are about to delete the project. Do you want to continue?");'>
  <br/>
  <a href="viewProjects.php"><input type="button" value="Cancel" class='btn btn-info'/></a>
  
  

  </form>   		
<?php 		
		
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