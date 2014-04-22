<?php
include './Template.php';
include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();
$head = '<script src="/js/createAccount.js"></script>';
$header = new Template("./header.php", array("current_page"=>5,"head" => $head, "title" => "Create Account"));
$header->out();
?>

<!-- content-wrap -->
<div id="content-wrap">

    <!-- content -->
    <div id="content" class="clearfix">

        <!-- main -->
        <div id="main">

            <div class="main-content">
                <form onsubmit="return fun1()" id="form1" method="post" action="functions.php?action=create_account">




                    <label>First name</label>



                    <input type="text" value="" name="first_name" id="first_name"> 




                    <label>Last Name</label>




                    <input type="text" value="" name="last_name" id="last_name"> 


                    <!--
                    
                    Password
                    
                    
                    
                    
                    <input type="text" id="password" name="password" value=""></input> 
                    
                    -->


                    <label>Address</label>




                    <textarea id="adress" name="address" style="width: 460px;"></textarea>




                    <label>Email</label>




                    <input type="text" value="" name="email" id="email"> 




                    <label>Phone Number</label>




                    <input type="text" value="" name="phone" id="phone">  




                    <label>Select Role</label>




                    <select name="role" id="role">
                        <option value="-1"></option>
                        <option value="Programmer">Programmer</option>
                        <option value="Developer">Developer</option>
                        <option value="Tester">Tester</option>
                        <option value="Designer">Designer</option>
                    </select>




                    <label>Employee Status</label>




                    <select name="employeestatus" id="employeestatus">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>


                    <br/>

                    <input type="submit" value="Submit" name="submit" id="submit">
                    <input type="button" onclick="fun2()" value="Cancel" name="Cancel" id="Cancel">


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