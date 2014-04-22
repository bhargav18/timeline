<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
$return_url = "/";
if (!$_SESSION['userLoggedin']) {
    if (isset($this)) {                
                $return_url = $this->return;                
            }
    header("Location: login.php?return_url=".$return_url);
}
?>
<!DOCTYPE html>
<html>

    <head>

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta charset="utf-8"/>
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php
            if (isset($this)) {
                if(isset($this->title)){
                echo $this->title;
                }
            } else {
                echo "Timeline";
            }
            ?></title>

        <link rel="stylesheet" type="text/css" media="screen" href="css/coolblue.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="css/droppy.css" />        
        <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/jquery-1.6.1.min.js"><\/script>')</script>

        <script src="js/scrollToTop.js"></script>
        <script src="js/jquery.droppy.js"></script>

        <?php
        if (isset($this)) {
            echo $this->head;
        }
        ?>
    </head>

    <body id="top" <?php
    if (isset($this)) {        
        echo $this->body;        
    }
    ?>>
        <script>
            $(function() {
                $('.navi').droppy();
            });
        </script>

        <!--header -->
        <div id="header-wrap"><header>

                <nav>
                    <ul class="navi">
                        <li <?php
                        if (isset($this)) {                            
                                if ($this->current_page == 1) {
                                    echo 'id="current"';
                                }                            
                        }
                        ?>><a href="Timeline.php">Timeline</a><span></span>

                        </li>
                        <?php if($_SESSION['access_level'] == 2){ ?>
                        <li <?php
                        if (isset($this)) {                            
                                if ($this->current_page == 2) {
                                    echo 'id="current"';                            
                            }
                        }
                        ?>><a href="#">Projects</a><span></span>
                            <ul>
                                <li><a href='createProject.php'>Create Project</a></li>
                                <li><a href='viewProjects.php'>View Projects</a></li>                                
                            </ul>
                        </li>
                        <?php }?>
                        <li <?php
                        if (isset($this)) {                            
                                if ($this->current_page == 3) {
                                    echo 'id="current"';                            
                            }
                        }
                        ?>><a href="#">Tasks</a><span></span>
                            <ul>
                                <?php if($_SESSION['access_level'] == 2){ ?><li><a href='createTask.php'>Create Task</a></li><?php } ?>
                                <li><a href='viewTasks.php'>View tasks</a></li>                                
                            </ul>
                        </li>
                        <li <?php
                        if (isset($this)) {                            
                                if ($this->current_page == 4) {
                                    echo 'id="current"';                            
                            }
                        }
                        ?>><a href="">Profile</a><span></span></li>
                        <?php if($_SESSION['access_level'] == 2){ ?>
                        <li  <?php
                        if (isset($this)) {                            
                                if ($this->current_page == 5) {
                                    echo 'id="current"';
                                }                            
                        }
                        ?>><a href="#">Manage Employee</a><span></span>
                            <ul>
                                <li><a href='createAccount.php'>Create Account</a></li>
                                <li><a href=''>Manage Employee</a></li>
                            </ul>
                        </li> 
                        <?php } ?>
                    </ul>
                </nav>


                <div class="subscribe">                   
                    Welcome <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?> | <a href="logout.php">Logout</a>
                </div>               

                <!--/header-->
            </header></div>