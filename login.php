<?php
session_start();
include './Template.php';

$header = new Template('Templates/header.php',  array(title=>"Login to Timeline",css=>array("css/header.css")));

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SESSION['userLoggedin']) {
    header("Location: /Timeline.php");
//echo 'Welcome back '.$_SESSION['first_name']." ".$_SESSION['last_name'];
}
$header->out();
?>        
        <form name="login" action="/loginService.php?return_url=login.php" method="post">
            <input type="text" name="user">
            <br/>
            <input type="password" name="password">
            <br/>
            <input type="submit" name="submit" value="Login">

        </form>
    </body>
</html>
