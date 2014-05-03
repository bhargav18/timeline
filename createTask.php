<?php
include './Template.php';
include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();

session_start();

$nameErr = $descErr = $sdateErr = $edateErr = $empErr = $tName = $tDesc = $tProjId = $tSDate = $tEDate = $tSts = $tPrio = "";
//Getting Error Messages
if (!empty($_SESSION['nameError'])) {
    $nameErr = $_SESSION['nameError'];
    $_SESSION['nameError'] = "";
}
if (!empty($_SESSION['tDescError'])) {
    $descErr = $_SESSION['tDescError'];
    $_SESSION['tDescError'] = "";
}
if (!empty($_SESSION['tSDateError'])) {
    $sdateErr = $_SESSION['tSDateError'];
    $_SESSION['tSDateError'] = "";
}
if (!empty($_SESSION['tEDateError'])) {
    $edateErr = $_SESSION['tEDateError'];
    $_SESSION['tEDateError'] = "";
}
if (!empty($_SESSION['empError'])) {
    $empErr = $_SESSION['empError'];
    $_SESSION['empError'] = "";
}

//Getting Old Values
if (!empty($_SESSION['tName'])) {
    $tName = $_SESSION['tName'];
    $_SESSION['tName'] = "";
}
if (!empty($_SESSION['tDesc'])) {
    $tDesc = $_SESSION['tDesc'];
    $_SESSION['tDesc'] = "";
}
if (!empty($_SESSION['tProjId'])) {
    $tProjId = $_SESSION['tProjId'];
    $_SESSION['tProjId'] = "";
}
if (!empty($_SESSION['tSDate'])) {
    $tSDate = $_SESSION['tSDate'];
    $_SESSION['tSDate'] = "";
}
if (!empty($_SESSION['tEDate'])) {
    $tEDate = $_SESSION['tEDate'];
    $_SESSION['tEDate'] = "";
}
if (!empty($_SESSION['tSts'])) {
    $tSts = $_SESSION['tSts'];
    $_SESSION['tSts'] = "";
}
if (!empty($_SESSION['tPrio'])) {
    $tPrio = $_SESSION['tPrio'];
    $_SESSION['tPrio'] = "";
}
//Save Emp old value NEED
$head = '<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="ModalPopupWindow.js" type="text/javascript"></script>
    <script src="js/updateTask3.js" type="text/javascript"></script>
  
  ';

$header = new Template("./header.php", array('head' => $head, 'title' => "Create a task",'return'=>"createTask.php",'current_page'=>"3"));
$header->out();
?>

<!-- content-wrap -->
<div id="content-wrap">

    <!-- content -->
    <div id="content" class="clearfix">

        <!-- main -->
        <div id="main">

            <div class="main-content">
                <form method='post' action='createTaskProcessing.php' id='mainForm'>

                        <label for='exampleInputEmail1'>Task Name</label>
                        <input type='text' class='form-control' name='taskname' id='exampleInputEmail1' 
                               value='<?php echo isset($tName) ? $tName : ""; ?>' placeholder='Enter task name'  required/>
                        <span class="err"><?php echo isset($nameErr) ? $nameErr : ""; ?></span>
                    


                    <!-- Description -->

                        <label>Task Description</label>
                        <textarea rows='10' cols='50' name='descr' ><?php echo isset($tDesc) ? $tDesc : ""; ?></textarea>
                        <span class="err"><?php echo $descErr; ?></span>                    

                    <!-- Linking task to a project -->

                        <label>Project</label>	
                        <select name='proj_id' style='width: 165px'>
                            <option></option>
                            <?php
                            $sql = "SELECT uid, name FROM project WHERE deleted='N'";

                            $result = $db->query($sql);
                            if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_row($result)) {
                                $id = $row[0];
                                $name = $row[1]; 
                                             
                                echo ($tProjId == $id)? "<option selected value=".$id." >" . $name . "</option>":"<option value=".$id." >" . $name . "</option>";
    							
                            }}
                            ?>      
                        </select>   
                        <?php $sql = "SELECT uid, start_date, end_date, deleted FROM project WHERE deleted='N'";

                            $result = $db->query($sql);
                            if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_row($result)) {
                                $id = $row[0];
                                $date = DateTime::createFromFormat('Y-m-d', $row[1]);
    							$sd = $date->format('m/d/Y');
    							$date = DateTime::createFromFormat('Y-m-d', $row[2]);
    							$ed = $date->format('m/d/Y');                               
    							
                                echo "<input type='hidden' name='s$id' value='$sd'/>";
                                echo "<input type='hidden' name='e$id' value='$ed'/>";                                
                            }}
                            ?>                 

                    <!-- Set dates -->

                    
                        <label>Start Date</label>
                        <input  name="startdate" id="from" value='<?php if ($tSDate) echo $tSDate; ?>'
                                placeholder="MM/DD/YYYY" readonly="true">
                        <span class="error"><?php echo $sdateErr; ?></span>                    

                        <label>End Date</label>
                        <input name="enddate" id="to" value='<?php echo $tEDate; ?>'
                               placeholder="MM/DD/YYYY" readonly="true">
                        <span class="err"><?php echo $edateErr; ?></span>
                    


                    <!-- Status -->

                        <label for='exampleInputEmail1'>Status</label>	
                        <select class='form-control' name='status' id='sts' style='width: 165px'>
                            <option <?php echo ($tSts === "Default") ? "selected" : ""; ?> value='Default'>Default</option>
                            <option <?php echo ($tSts === "Closed") ? "selected" : ""; ?> value='Closed'>Closed</option>

                        </select>
                    

                    <!-- priority -->
                        <label for='exampleInputEmail1'>Priority</label>	
                        <select class='form-control' name='priority' style='width: 165px'>
                            <option <?php echo ($tPrio === 'High') ? 'selected' : ''; ?> value='High'>High</option>
                            <option value='Mid' <?php echo ($tPrio === "Mid") ? "selected" : ""; ?>>Mid</option>
                            <option <?php echo ($tPrio === "Low") ? "selected" : ""; ?> value='Low'>Low</option>
                        </select>
                    

                    <!-- Employees names -->

                        <label for='exampleInputEmail1'>Assignees</label> 

                        <input type="button" class="btn btn-info" onclick="ShowNewPage()" value="Assign Employees" />
                        <span id="divShowChildWindowValues">
                            <dl id='empList'>

                                <?php
                                if (!empty($_SESSION['uEmpId'])) {
                                    $i = 0;
                                    foreach ($_SESSION['uEmpId'] as $emp) {
                                        echo "<input type='hidden' name='emp[]' id='" . $i . "' value = '" . $emp . "'/>";
                                        $i++;
                                    }
                                    $_SESSION['uEmpId'] = "";
                                    if (!empty($_SESSION['uEmpName'])) {
                                        $i = 0;
                                        foreach ($_SESSION['uEmpName'] as $emp) {
                                            echo "<input type='hidden' name='empName[]' id='n" . $i . "' value = '" . $emp . "'/>";
                                            echo "<p>" . $emp . "</p>";
                                            $i++;
                                        }
                                        $_SESSION['uEmpName'] = "";
                                    }
                                    //echo $displayString;
                                    echo "<input type='hidden' name='empName[]' value = '" . $displayString . "'/>";
                                }
                                ?>
                            </dl></span>
                        <span class="err"><?php echo $empErr; ?></span>
                    

                    <!-- Buttons -->

                    <input type='reset'  name= 'cancel' value='Cancel' class='btn btn-info'>
                    <input type='submit' name= 'submit' value='Create Task' onclick='getTime()' class='btn btn-info'>
                    

                    
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