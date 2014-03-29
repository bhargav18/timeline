<?php
include './users.php';
session_start();
$user = new users();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if(!isset($_POST['ajax'])){
    $username = mysql_real_escape_string($_POST['user']);
    if($user->isUser($username)){
        $user->getUser($username,$_POST['password']);
        if($user->isLoggedin){
            echo 'User logged in successfully';
            $_SESSION['userLoggedin'] = $user->isLoggedin;
            $_SESSION['first_name'] = $user->first_name;
            $_SESSION['last_name'] = $user->last_name;
            $_SESSION['access_level'] = $user->access_level;
            $_SESSION['phone'] = $user->phone;
            $_SESSION['email'] = $user->email;
            $_SESSION['username'] = $user->username;
            $_SESSION['user_uid'] = $user->uid;
            header("Location: /".$_GET['return_url']);
        }else{
            echo 'User failed to login';
        }
    }else{
        echo 'User not found';
    }
}else{
    
}
?>
