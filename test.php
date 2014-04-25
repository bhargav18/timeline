<?php

SESSION_START();
include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();

$Hold1 = $Hold2 = $Hold3 = $Hold4 = $Hold5 = $Hold6 = $Hold7 = $Hold8 = $Hold9 = $Hold10 = $Hold11 = $Hold12 = $Hold13 = "";

function test_input($data) {   // to test Email input!!
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (!empty($_POST))
    if ($_POST['update']) {
        $error = 0;

        if (empty($_POST['fname'])) {
            $_SESSION['cErrfname'] = "First name is required";
            $error = 1;
        }
        //$fname = test_input($_POST['fname']);
        // check if name only contains letters and no whitespace
        elseif (!preg_match("/^[a-zA-Z]*$/", test_input($_POST['fname']))) {
            $_SESSION['cErrfname'] = "Only letters and no whitespace allowed";
            $error = 1;
        } else {
            $hold1 = $_POST['fname'];
            $_SESSION['cErrfname'] = "";
        }

        if (empty($_POST['lname'])) {
            $_SESSION['cErrlname'] = "Last name is required";
            $error = 1;
        }
        //$lname = test_input($_POST['lname']);
        // check if name only contains letters and no whitespace
        elseif (!preg_match("/^[a-zA-Z]*$/", test_input($_POST['lname']))) {
            $_SESSION['cErrlname'] = "Only letters and no whitespace allowed";
            $error = 1;
        } else {
            $hold2 = $_POST['lname'];
            $_SESSION['cErrlname'] = "";
        }

        if (empty($_POST['email'])) {
            $_SESSION['cErremail'] = "Email is required";
            $error = 1;
        }
        //$email = test_input($_POST['email']);
        // check if e-mail address syntax is valid
        elseif (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", test_input($_POST['email']))) {
            $_SESSION['cErremail'] = "Invalid email format";
            $error = 1;
        } else {
            $Hold3 = $_POST['email'];
            $_SESSION['cErremail'] = "";
        }

        if (empty($_POST['phone'])) {
            $_SESSION['cErrphone'] = "Phone is required";
            $error = 1;
        }
        //$phone = test_input($_POST['phone']);
        // check if only numbers and no whitespaces
        elseif (!preg_match("/^[0-9]*$/", test_input($_POST['phone']))) {
            $_SESSION['cErrphone'] = "Please check phone number. Only numbers are allowed";
            $error = 1;
        } else {
            $Hold4 = $_POST['phone'];
            $_SESSION['cErrphone'] = "";
        }
        /*
          if(empty($_POST['password'])){
          $_SESSION['cErrpassword'] = "Password is required";
          $error = 1;}

          $password = test_input($_POST['password']);
          // check if Password have a least minimal length of 8 characters and contains numeric characters
          if (!preg_match("/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,30}$/",$password))
          {
          $_SESSION['cErrpassword'] = "Password should have a least minimal length of 8 characters and contains alphanumeric characters";
          $error = 1;
          }
          else {
          $Hold5 = $_POST['password'];
          $_SESSION['cErrpassword'] = "";
          }
         */
        if (empty($_POST['address1'])) {
            $_SESSION['cErraddress1'] = "Address 1 is required";
            $error = 1;
        }
        //$address1 = test_input($_POST['address1']);
        // check if the address format is valid
        elseif (!preg_match('/^[a-z0-9 .\-]+$/i', test_input($_POST['address1']))) {
            $_SESSION['cErraddress1'] = "Address is wrong";
            $error = 1;
        } else {
            $Hold6 = $_POST['address1'];
            $_SESSION['cErraddress1'] = "";
        }
        /* Need some work
          if(empty($_Post['address2']))
          {
          $_SESSION['Eaddress2'] = $_POST['address2'];
          $_SESSION['cErraddress2'] = "";
          }
         */
        if (empty($_POST['city'])) {
            $_SESSION['cErrcity'] = "City name is required";
            $error = 1;
        }
        //$city = test_input($_POST['city']);
        // check if the city is valid
        elseif (!preg_match('/^[a-zA-Z\s]+$/', test_input($_POST['city']))) {
            $_SESSION['cErrcity'] = "City name is wrong";
            $error = 1;
        } else {
            $Hold7 = $_POST['city'];
            $_SESSION['cErrcity'] = "";
        }

        if (empty($_POST['zipcode'])) {
            $_SESSION['cErrzipcode'] = "Zip code is required";
            $error = 1;
        }

        //$zipcode = test_input($_POST['zipcode']);
        // check if the address format is valid
        elseif (!preg_match('/^[0-9]{5}$/', test_input($_POST['zipcode']))) {
            $_SESSION['cErrzipcode'] = "Zip code is wrong";
            $error = 1;
        } else {
            $Hold8 = $_POST['zipcode'];
            $_SESSION['cErrzipcode'] = "";
        }

        if (empty($_POST['state'])) {
            $_SESSION['cErrstate'] = "State is required";
            $error = 1;
        } elseif (!preg_match('/^[a-zA-Z\s]+$/', test_input($_POST['state']))) {
            $_SESSION['cErrstate'] = "State is wrong";
            $error = 1;
        } else {
            $Hold9 = $_POST['state'];
            $_SESSION['cErrstate'] = "";
        }

        if (empty($_POST['country'])) {
            $_SESSION['cErrcountry'] = "Country name is required";
            $error = 1;
        } elseif (!preg_match('/^[a-zA-Z\s]+$/', test_input($_POST['country']))) {
            $_SESSION['cErrcountry'] = "Country name is wrong";
            $error = 1;
        } else {
            $Hold10 = $_POST['country'];
            $_SESSION['cErrcountry'] = "";
        }

        if ($error == 1) {
            $_SESSION['cEid'] = $_POST['userid'];
            $_SESSION['cEfname'] = $Hold1;
            $_SESSION['cElname'] = $Hold2;
            $_SESSION['cEemail'] = $Hold3;
            $_SESSION['cEphone'] = $Hold4;
            $_SESSION['cEpassword'] = $Hold5;
            $_SESSION['cErole'] = $_POST['userrole'];
            $_SESSION['cEstatus'] = $_POST['userstatus'];
            $_SESSION['cEaddress1'] = $Hold6;
            $_SESSION['cEaddress2'] = $_POST['address2'];
            $_SESSION['cEcity'] = $Hold7;
            $_SESSION['cEzipcode'] = $Hold8;
            $_SESSION['cEstate'] = $Hold9;
            $_SESSION['cEcountry'] = $Hold10;
            header("Location:manageUser.php");
            exit;
        }
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $address1 = $_POST['address1'];
        $address2 = $_POST['address2'];
        $city = $_POST['city'];
        $zipcode = $_POST['zipcode'];
        $state = $_POST['state'];
        $country = $_POST['country'];
        $role = $_POST['userrole'];
        $phone = $_POST['phone'];
        $status = $_POST['userstatus'];
        $password = randomPassword();
        
        $stmt = $db->prepare('insert into users( first_name, last_name, phone, role, email)'
                . 'VALUES (?,?,?,?,?)');

        $stmt->bind_param('sssss', $_POST['fname'], $_POST['lname'], $_POST['phone'], $_POST['userrole'], $_POST['email']);
        $stmt->execute();
        
        $holdUserId = mysqli_insert_id($db);
        $userName = $lname.$holdUserId;
        
        $stmt = $db->prepare('insert into users( username, password)'
                . 'VALUES (?,?)');

        $stmt->bind_param('ss',$userName,$password );
        $stmt->execute();
        
        $stmt = $db->prepare('insert into address( user_uid, address1, address2, city, zipcode, country, state)'
                . 'VALUES (?,?,?,?,?)');
        $stmt->bind_param('dssssss', $holdUserId, $_POST['address1'], $_POST['address2'], $_POST['city'], $_POST['zipcode'], $_POST['country'], $_POST['state']);
        $stmt->execute();
        
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $messages  = "Username : " . $userName . "<br/>";
            $messages .= "First Name : " . $fname . "<br/>";
            $messages .= "Last Name : " . $lname . "<br/>";
            $messages .= "Address : " . $address1 . "<br/>".$address2."<br/>";
            $messages .= "Phone : " . $phone . "<br/>";
            $messages .= "Role : " . $role . "<br/>";
            $messages .= "Email : " . $email . "<br/>";
            $messages .= "Password : " . $password;
            $messages .= "<br/><br/> Use this username and the password for timeline.<br/> Thank you";
            mail($i, "New acoount is created", $messages, $headers);
        
        header("Location:viewUsers.php");
        exit;    
} else {
    header("Location:viewUsers.php");
    exit;
}

function randomPassword() {
    //DebugBreak();
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@#$%^&*()?/'{}][|\;:_-=+";
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, strlen($alphabet) - 1);
        $pass .= $alphabet[$n];
    }
    return $pass;
}
?>