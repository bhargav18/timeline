<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of header
 *
 * @author bhargav
 */

?>

<html>
    <head>
        <title><?=$this->title;?></title>
        <? foreach ($this->css as $css){
            echo '<link rel="stylesheet" type="text/css" href="'.$css.'">';
        }?>
    </head>
    <body>
        <nav id="navigation">

            <a href="#" class="nav-btn">HOME<span class="arr"></span></a>
            <ul id="options" style="">
                <li class="active first"><a href="#">HOME</a></li>
                <li><a href="#">SERVICES</a></li>
                <li><a href="#">projects</a></li>
                <li><a href="#">solutions</a></li>
                <li><a href="#">jobs</a></li>
                <li><a href="#">blog</a></li>
                <li><a href="#">contacts</a></li>
            </ul>
        </nav>
        
<!-- End of Header -->
