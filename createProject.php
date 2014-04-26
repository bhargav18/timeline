<?php
include './Template.php';
include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();

session_start();

$nameErr = $descErr = $sdateErr = $edateErr = $empErr = $pName = $pDesc = $pSDate = $pEDate = $pSts = $pPrio = "";
//Getting Error Messages
if (!empty($_SESSION['nameErr'])) {
    $nameErr = $_SESSION['nameErr'];
    $_SESSION['nameErr'] = "";
}
if (!empty($_SESSION['pDescErr'])) {
    $descErr = $_SESSION['pDescErr'];
    $_SESSION['pDescErr'] = "";
}
if (!empty($_SESSION['pSDateErr'])) {
    $sdateErr = $_SESSION['pSDateErr'];
    $_SESSION['pSDateErr'] = "";
}
if (!empty($_SESSION['pEDateErr'])) {
    $edateErr = $_SESSION['pEDateErr'];
    $_SESSION['pEDateErr'] = "";
}
if (!empty($_SESSION['costErr'])) {
    $costErr = $_SESSION['costErr'];
    $_SESSION['costErr'] = "";
}

//Getting Old Values
if (!empty($_SESSION['pName'])) {
    $pName = $_SESSION['pName'];
    $_SESSION['pName'] = "";
}
if (!empty($_SESSION['pDesc'])) {
    $pDesc = $_SESSION['pDesc'];
    $_SESSION['pDesc'] = "";
}

if (!empty($_SESSION['pSDate'])) {
    $pSDate = $_SESSION['pSDate'];
    $_SESSION['pSDate'] = "";
}
if (!empty($_SESSION['pEDate'])) {
    $pEDate = $_SESSION['pEDate'];
    $_SESSION['pEDate'] = "";
}
if (!empty($_SESSION['pSts'])) {
    $pSts = $_SESSION['pSts'];
    $_SESSION['pSts'] = "";
}
if (!empty($_SESSION['pPrio'])) {
    $pPrio = $_SESSION['pPrio'];
    $_SESSION['pPrio'] = "";
}
if (!empty($_SESSION['pCost'])) {
    $pCost = $_SESSION['pCost'];
    $_SESSION['pCost'] = "";
}
//Save Emp old value NEED
$head = '<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="js/updateTask3.js" type="text/javascript"></script>
  
  ';

$header = new Template("./header.php", array('head' => $head, 'title' => "Create a project"));
$header->out();
?>

<!-- content-wrap -->
<div id="content-wrap">

    <!-- content -->
    <div id="content" class="clearfix">

        <!-- main -->
        <div id="main">

            <div class="main-content">
                <form method='post' action='createProjectProcessing.php' id='mainForm'>

                    <!-- Name -->
                        <label >Project Name</label>
                        <input type='text' class='form-control' name='projname'  
                               value='<?php echo $pName; ?>' placeholder='Enter project name'  required/>
                        <span class="error"><?php echo isset($nameErr) ? $nameErr : ""; ?></span>
 
                    <!-- Description -->
                        <label >Project Description</label>
                        <textarea rows='10' cols='50' name='descr' ><?php echo $pDesc; ?></textarea>
                        <span class="err"><?php echo $descErr; ?></span>

                    <!-- Set dates -->
                        <label for="exampleInputEmail1">Start Date</label>
                        <input  class="form-control" name="startdate" id="from" value='<?php if ($pSDate) echo $pSDate; ?>'
                                placeholder="MM/DD/YYYY" readonly="true">
                        <span class="error"><?php echo $sdateErr; ?></span>

                        <label for="exampleInputEmail1">End Date</label>
                        <input class="form-control" name="enddate" id="to" value='<?php echo $pEDate; ?>'
                               placeholder="MM/DD/YYYY" readonly="true">
                        <span class="error"><?php echo $edateErr; ?></span>                    

                    <!-- Status -->
                        <label >Status</label>	
                        <select class='form-control' name='status' id='sts' style='width: 165px'>
                            <option <?php echo ($pSts === "Default") ? "selected" : ""; ?> value='Default'>Default</option>
                            <option <?php echo ($pSts === "Closed") ? "selected" : ""; ?> value='Closed'>Closed</option>
                        </select>                    

                    <!-- priority -->
                        <label >Priority</label>	
                        <select class='form-control' name='priority' style='width: 165px'>
                            <option <?php echo ($pPrio === 'High') ? 'selected' : ''; ?> value='High'>High</option>
                            <option value='Mid' <?php echo ($pPrio === "Mid") ? "selected" : ""; ?>>Mid</option>
                            <option <?php echo ($pPrio === "Low") ? "selected" : ""; ?> value='Low'>Low</option>
                        </select>

                    <!-- Cost -->
                        <label >Project Budget</label>
                        <input type='text' class='form-control' name='cost' 
                               value='<?php echo $pCost; ?>' placeholder='Enter project budget'  required/>
                        <span class="error"><?php echo isset($costErr) ? $costErr : ""; ?></span>                    

                    <!-- Buttons -->
                    <div style ="text-align: right;">
                    <input type='reset'  name= 'cancel' value='Cancel' class='btn btn-info'>
                    <input type='submit' name= 'submit' value='Create Project' onclick='getTime()' class='btn btn-info'>
                    </div>

                    
                    </div>
                </form>
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