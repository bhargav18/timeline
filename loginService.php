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
        $result = $db->query('select * from users where email="' . $_POST['email'] . '" and username="' . $_POST['username'] . '"');
        if (($row = mysqli_fetch_array($result)) != null) {
            $new_pass = randomPassword();
            $to = $row['email'];
            $subject = 'Password Reset';
            $message = 'Your password is reset to ' . $new_pass . '
                    

Thank you,

--Timeline team';
            $headers = 'From: test@example.com' . "\r\n" .
                    'Reply-To: webmaster@example.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);
            $db->query('update users set password="' . $new_pass . '" where email="' . $row['email'] . '"');
            echo '<script>
                    alert("Your password is reset and sent to your email address.\n Please use that password to change your password");
                    window.location = "/logout.php";
                  </script>';
        } else {
            echo ' 
<script>
alert("invalid username or email address.");
window.location = "/logout.php";
</script>
                    ';
        }
    }
} else if (!isset($_POST['ajax'])) {
    $username = $db->real_escape_string($_POST['user']);
    if ($user->isUser($username)) {
        $user->getUser($username, $_POST['password']);
        if ($user->isLoggedin) {
            //echo 'User logged in successfully';
            $_SESSION['userLoggedin'] = $user->isLoggedin;
            $_SESSION['first_name'] = $user->first_name;
            $_SESSION['last_name'] = $user->last_name;
            $_SESSION['access_level'] = $user->access_level;
            $_SESSION['phone'] = $user->phone;
            $_SESSION['email'] = $user->email;
            $_SESSION['username'] = $user->username;
            $_SESSION['user_uid'] = $user->uid;
            $_SESSION['access_level'] = $user->access_level;
            $_SESSION['address'] = $user->address;
            if (!$_GET['return_url'] == "") {                
                header("Location: " . $_GET['return_url']);               
            } else {                
                header("Location: /");
            }
        } else {
            echo ' <script>alert("Invalid username and password."); window.location = "/logout.php";</script>';
        }
    } else {
        echo ' <script>alert("invalid username and password."); window.location = "/logout.php";</script>';
    }
} else {
    
}

function randomPassword() {
    //DebugBreak();
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@#$%^&*()-_=+{}[]:;?/.,";
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, strlen($alphabet) - 1);
        $pass .= $alphabet[$n];
    }
    return $pass;
}

?>
