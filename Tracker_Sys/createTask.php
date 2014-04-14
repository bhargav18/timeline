<?php
include './Template.php';
session_start();

$nameErr = $descErr = $projErr = $sdateErr = $edateErr = $empErr = $tName = $tDesc = $tProjId = $tSDate = $tEDate = $tSts = $tPrio = "";
//Getting Error Messages
if (!empty($_SESSION['nameError'])) {
    $nameErr = $_SESSION['nameError'];
    $_SESSION['nameError'] = "";
}
if (!empty($_SESSION['tDescError'])) {
    $descErr = $_SESSION['tDescError'];
    $_SESSION['tDescError'] = "";
}
if (!empty($_SESSION['tProjError'])) {
    $projErr = $_SESSION['tProjError'];
    $_SESSION['tProjError'] = "";
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
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="ModalPopupWindow.js" type="text/javascript"></script>
  <script src="js/createTask.js" type="text/javascript"></script>';

$header = new Template("../header.php", array(head => $head, title => "Create a task"));
$header->out();
?>

<!-- content-wrap -->
<div id="content-wrap">

    <!-- content -->
    <div id="content" class="clearfix">

        <!-- main -->
        <div id="main">

            <div class="main-content">
                <form method='post' action='CreateTaskProcessing.php' id='mainForm'>
                    <table class="table" style="width: 300px">


                        <!-- Name -->
                        <tr>
                        <div class="form-group">
                            <td><label for='exampleInputEmail1'>Task Name</label></td>
                            <td><input type='text' class='form-control' name='taskname' id='exampleInputEmail1' 
                                       value='<?php echo isset($tName) ? $tName : ""; ?>' placeholder='Enter task name'  required/></td>
                            <td><span class="err"><?php echo isset($nameErr) ? $nameErr : ""; ?></span></td>
                        </div>
                        </tr>


                        <!-- Description -->
                        <tr>
                        <div class='form-group'>
                            <td><label for='exampleInputEmail1'>Task Description</label></td>
                            <td><textarea rows='10' cols='50' name='descr' ><?php echo isset($tDesc) ? $tDesc : ""; ?></textarea></td>
                            <td><span class="err"><?php echo $descErr; ?></span></td>
                        </div>
                        </tr>

                        <!-- Linking task to a project -->
                        <tr>
                        <div class='form-group'>
                            <td><label for='exampleInputEmail1'>Project</label></td>	
                            <td><select class='form-control' name='proj_id' style='width: 165px'>
                                    <option></option>
<?php
$sql = "SELECT project_id, Name FROM Projects";

$result = mysql_query($sql) or die(mysql_error());

while ($row = mysql_fetch_row($result)) {

    $id = $row[0];
    $name = $row[1];
    echo "<option ($tProjId === $id)? selected:'' value='$id' >" . $name . "</option>";
}
?>       
                                </select></td>
                            <td><span class="err"><?php echo isset($projErr) ? $projErr : ""; ?></span></td>
                        </div>
                        </tr>

                        <!-- Set dates -->
                        <tr>
                        <div>
                            <td><label for="exampleInputEmail1">Start Date</label></td>
                            <td><input  class="form-control" name="startdate" id="from" value='<?php if ($tSDate) echo $tSDate; ?>'
                                        placeholder="MM/DD/YYYY" readonly="true"></input></td>
                            <td><span class="error"><?php echo $sdateErr; ?></span></td>
                        </div>
                        </tr>

                        <tr>
                        <div>
                            <td><label for="exampleInputEmail1">End Date</label></td>
                            <td><input type="text" class="form-control" name="enddate" id="to" value='<?php echo $tEDate; ?>'
                                       placeholder="MM/DD/YYYY" readonly="true"></input></td>
                            <td><span class="err"><?php echo $edateErr; ?></span></td>
                        </div>
                        </tr>


                        <!-- Status - may be deleted -->
                        <tr>
                        <div class='form-group'>
                            <td><label for='exampleInputEmail1'>Status</label>	</td>
                            <td><select class='form-control' name='status' id='sts' style='width: 165px'>
                                    <option <?php echo ($tSts === "Default") ? "selected" : ""; ?> value='Default'>Default</option>
                                    <option <?php echo ($tSts === "Closed") ? "selected" : ""; ?> value='Closed'>Closed</option>

                                </select></td></div>
                        </tr>

                        <!-- priority -->
                        <tr><div class='form-group'>
                            <td><label for='exampleInputEmail1'>Priority</label></td>	
                            <td><select class='form-control' name='priority' style='width: 165px'>
                                    <option <?php echo ($tPrio === 'High') ? 'selected' : ''; ?> value='High'>High</option>
                                    <option value='Mid' <?php echo ($tPrio === "Mid") ? "selected" : ""; ?>>Mid</option>
                                    <option <?php echo ($tPrio === "Low") ? "selected" : ""; ?> value='Low'>Low</option>
                                </select></td>
                        </div>
                        </tr>

                        <!-- Employees names -->
                        <tr>
                        <div class='form-group'>
                            <td><label for='exampleInputEmail1'>Assignees</label></td> 

                            <td><input type="button" class="btn btn-info" onclick="ShowNewPage()" value="Assign Employees" /></td>
                            <td><div id="divShowChildWindowValues">
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
                                    </dl></div></td>
                            <td><span class="err"><?php echo $empErr; ?></span></td>
                        </div>
                        </tr>

                        <!-- Buttons -->
                        <tr>
                            <td><input type='reset'  name= 'cancel' value='Cancel' class='btn btn-info'></td>
                            <td><input type='submit' name= 'submit' value='Create Task' onclick='getTime()' class='btn btn-info'></td>
                        </tr>

                    </table>
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