<?php
include './Template.php';
$header = new Template('./header.php',array(current_page=>2));
$header->out();
?>

<!-- content-wrap -->
<div id="content-wrap">

    <!-- content -->
    <div id="content" class="clearfix">

        <!-- main -->
        <div id="main">
            <div class="main-content">
                <script>
                    $(function() {
                        $("#from").datepicker({
                            defaultDate: "+1w",
                            changeMonth: true,
                            numberOfMonths: 1,
                            onClose: function(selectedDate) {
                                $("#to").datepicker("option", "minDate", selectedDate);
                            }
                        });
                        $("#to").datepicker({
                            defaultDate: "+1w",
                            changeMonth: true,
                            numberOfMonths: 1,
                            onClose: function(selectedDate) {
                                $("#from").datepicker("option", "maxDate", selectedDate);
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
                        var cost_value = document.getElementById("cost").value;
                        if (cost_value < 1)
                        {
                            alert('Enter estimation value more than zero');
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
                        window.location = '/';
                    }
                </script>
               <h2>Create a Project</h2>
                <form action="index.php" method="post" id="form1" onsubmit="return fun1()">
                    <div>
                        <label>Project name</label>
                        <input type="text" id="project_name" name="project_name" value="">                        
                    </div>
                    <div>
                        <label>Project Description</label>
                        <textarea class="textarea" cols="165" rows="5" name="description" id="description"></textarea>
                    </div>
                    <div>
                        <label>Project Brief Description</label>
                        <textarea class="textarea" cols="165" rows="5" name="brief_description" id="brief_description"></textarea>
                    </div>
                    <div>
                        <label>Priority</label>                        
                        <select id="priority" name="priority">
                            <option value="Low">Low</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                    <div>
                        <label>Status</label>
                        <select id="Status" name="Status">
                            <option value="open">Open</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div>                        
                        <label>Users</label>                        
                        <select id="uid" name="uid">
                            <option value="user1">User 1</option>
                            <option value="user2">User 2</option>
                            <option value="user3">User 3</option>
                            <option value="user4">User 4</option>
                        </select>
                    </div>
                    <div>
                        <label>Start date</label>
                        <input type="text" id="from" name="from">
                    </div>
                    <div>
                        <label>End date</label>
                        <input type="text" id="to" name="to">
                    </div>
                    <div>
                        <label>Cost</label>
                        <input type="text" id="cost" name="cost">
                    </div>

                    <input type="submit" id="submit" name="submit" value="Submit">
                    <input type="button" id="Cancel" name="Cancel" value="Cancel" onclick="fun2()">
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