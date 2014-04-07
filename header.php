<?php 
session_start();
if (!$_SESSION['userLoggedin']) {
    header("Location: login.php?return_url=Timeline.php");
}
?>
<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie"> <![endif]-->
<!--[if IE session_start();
if (!$_SESSION['userLoggedin']) {
    header("Location: login.php?return_url=Timeline.php");
}9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html> <!--<![endif]-->

    <head>

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta charset="utf-8"/>
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Timeline</title>

        <link rel="stylesheet" type="text/css" media="screen" href="css/coolblue.css" />

        <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/jquery-1.6.1.min.js"><\/script>')</script>

        <script src="js/scrollToTop.js"></script>
<? if(isset($this)){
    echo $this->head;
} ?>
    </head>

    <body id="top">

        <!--header -->
        <div id="header-wrap"><header>

                <nav>
                    <ul>
                        <li <? if(isset($this)){if($this->current_page == 1){echo 'id="current"';};} ?>><a href="Timeline.php">Timeline</a><span></span></li>
                        <li <? if(isset($this)){if($this->current_page == 2){echo 'id="current"';};} ?>><a href="projects.php">Projects</a><span></span></li>
                        <li <? if(isset($this)){if($this->current_page == 3){echo 'id="current"';};} ?>><a href="blog.html">Tasks</a><span></span></li>
                        <li <? if(isset($this)){if($this->current_page == 4){echo 'id="current"';};} ?>><a href="archive.html">Profile</a><span></span></li>
                        <li <? if(isset($this)){if($this->current_page == 5){echo 'id="current"';};} ?>><a href="index.html">Support</a><span></span></li>                        
                    </ul>
                </nav>

                
                <div class="subscribe">                   
                    Welcome <?=$_SESSION['first_name']." ".$_SESSION['last_name']; ?> | <a href="logout.php">Logout</a>
                </div>               

                <!--/header-->
            </header></div>