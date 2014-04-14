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
        <script src="js/login.js"></script>
    </head>

    <body>
        <form name="login" class="box login" action="loginService.php?return_url=login.php" method="post">
            <fieldset class="boxBody">
                <label>Username</label>
                <input type="text" tabindex="1" name="user" placeholder="Username" required>
                <label><a href="forget.php" class="rLink" tabindex="5">Forget your password?</a>Password</label>
                <input type="password" placeholder="Password" name="password" tabindex="2" required>
            </fieldset>
            <footer>
                <label><input type="checkbox" name="keeploggedin" tabindex="3">Keep me logged in</label>
                <input type="submit" class="btnLogin" value="Login" tabindex="4">
            </footer>
        </form>
    </body>
</html>