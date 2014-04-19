<?php

session_start();
include_once './DBConfig.php';
include_once './tasks.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SESSION['userLoggedin']) {
    if ($_GET['action'] == "add_project") {
        $project_id = $_POST['project_id'];
        $project_name = $_POST['project_name'];
        $description = $_POST['description'];
        $priority = $_POST['priority'];
        $status = $_POST['Status'];        
        $date = $_POST['from'];
        $cost = $_POST['cost'];
        $end_date = $_POST['to'];
        if ($_POST) {        
           
                $query = "insert into project (name,description,start_date,end_date,status,priority,est_cost) values ('$project_name','$description',STR_TO_DATE('$date','%m/%d/%Y'),STR_TO_DATE('$end_date','%m/%d/%Y'),'$status','$priority','$cost')";
                error_log($query);
                $db->query($query);
            
        }
        header("Location: viewProjects.php");
    }
    if ($_GET['action'] == "get_tasks") {
        $tasks = new tasks();
        $task_list = $tasks->getTasks_JSON($_SESSION['user_uid'], 1);
        echo $task_list;
        return $task_list;
    }
    if ($_GET['action'] == "create_account") {

        if ($_POST["submit"]) {
            $a = $_POST["first_name"];
            $b = $_POST["last_name"];
            $c = $_POST["address"];
            $e = $_POST["phone"];
            $f = $_POST["role"];
            $i = $_POST["email"];
            $j = $_POST["employeestatus"];

            function randomPassword() {
                //DebugBreak();
                $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
                for ($i = 0; $i < 8; $i++) {
                    $n = rand(0, strlen($alphabet) - 1);
                    $pass .= $alphabet[$n];
                }
                return $pass;
            }

//print_r($password);              
            $password = randomPassword();
//$password = rand(0,25);					
            //mysql_select_db("homework_462",$link);
            $stmt = $db->prepare('insert into users(first_name,last_name,phone,role,email,employee_status,address) values(?,?,?,?,?,?,?)');
            $stmt->bind_param('ssssss', $a, $b, $e, $f, $i, $j, $c);
            $stmt->execute();

           

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $messages = "First Name : " . $a . "<br/>";
            $messages .= "Last Name : " . $b . "<br/>";
            $messages .= "Address : " . $c . "<br/>";
            $messages .= "Phone : " . $e . "<br/>";
            $messages .= "Role : " . $f . "<br/>";
            $messages .= "Email : " . $i . "<br/>";
            $messages .= "Password : " . $password;
            mail($i, "New Acoount Created", $messages, $headers);
            
            header("Location: allemployee.php");
        }
    }
} else {
    echo 'Error';
}
?>