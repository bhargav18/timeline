<?php

include './users.php';
session_start();
$user = new users();
$mysql = new DBConfig();
$db = $mysql->getDBConfig();
/*
 * To change this template, choose Tools | Templates
 * and open the templa mari pasete in the editor.
 */
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'forget') {
        $result = $db->query('select * from users where email="' . $_POST['email'] . '"');
        if (($row = mysqli_fetch_array($result)) != null) {
            $new_pass = md5(time());
            print_r($row);
            $to = $row['email'];
            $subject = 'Password Reset';
            $message = 'Your password is reset to '.$new_pass.'
                    

Please use this password to reset your password in profiles.

Thank you,

--Timeline team';
            $headers = 'From: test@example.com' . "\r\n" .
                    'Reply-To: webmaster@example.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);            
            $db->query('update users set password="'.$new_pass.'" where email="'.$row['email'].'"');
        } else {
            echo 'No user';
        }
    }
} else if (!isset($_POST['ajax'])) {
    $username = mysql_real_escape_string($_POST['user']);
    if ($user->isUser($username)) {
        $user->getUser($username, $_POST['password']);
        if ($user->isLoggedin) {
            echo 'User logged in successfully';
            $_SESSION['userLoggedin'] = $user->isLoggedin;
            $_SESSION['first_name'] = $user->first_name;
            $_SESSION['last_name'] = $user->last_name;
            $_SESSION['access_level'] = $user->access_level;
            $_SESSION['phone'] = $user->phone;
            $_SESSION['email'] = $user->email;
            $_SESSION['username'] = $user->username;
            $_SESSION['user_uid'] = $user->uid;
            header("Location: " . $_GET['return_url']);
        } else {
            echo 'User failed to login';
        }
    } else {
        echo 'User not found';
    }
} else {
    
}
?>
