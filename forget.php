<?php
session_start();

//$header = new Template('Templates/header.php', array(title => "Login to Timeline", css => array("css/header.css")));

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SESSION['userLoggedin']) {
    header("Location: Timeline.php");
//echo 'Welcome back '.$_SESSION['first_name']." ".$_SESSION['last_name'];
}
//$header->out();
?><!DOCTYPE HTML>
<html>
    <head>
        <title>Login to Timeline</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="css/reset.css">
        <link rel="stylesheet" type="text/css" href="css/structure.css">
    </head>

    <body>
        <form style="height: 180px;" class="box login" action="loginService.php?action=forget&return_url=login.php" method="post">
            <fieldset class="boxBody">
                <label>Email address</label>
                <input type="text" tabindex="1" name="email" placeholder="emailaddress" required>                
            </fieldset>
            <footer>              
                <input style="float: none; margin-left: 100px;" type="submit" class="btnLogin" value="Login" tabindex="4">
            </footer>
        </form>
    </body>
</html>