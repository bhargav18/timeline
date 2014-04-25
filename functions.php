<?php

session_start();
error_reporting(E_ERROR | E_PARSE);
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
        $task_list = $tasks->getTasks_JSON($_SESSION['user_uid'], $_POST['project_uid']);
        echo $task_list;
        return $task_list;
    }
    if ($_GET['action'] == "get_projects") {
        $result = $db->query('select * from project');
        $none_results = $db->query('select * from tasks where project_uid=0');
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }

        $json_data = '{
                        "events":[
{
            "title": "",          
            "start": "",
            "isDuration":false,
            "end":""
}                        
';
        if (count($rows) == 0) {
            echo 0;
        } else {
            foreach ($rows as $row) {
                $json_data.=',{';
                $date = DateTime::createFromFormat("Y-m-d", $row["start_date"]);
                $json_data.='"start":"' . $date->format("Y-m-d") . '",';
                $date = DateTime::createFromFormat("Y-m-d", $row["end_date"]);
                $json_data.='"end":"' . $date->format("Y-m-d") . '",';
                $json_data.='"title":"' . $row['name'] . '",';
                $json_data.='"description":"'
                        . '<br/>Project status:' . $row['status'] . ''
                        . '<br/><a href=\"/Timeline.php?project=' . $row['uid'] . '\">Tasks</a>  ",';
                $json_data.='"isDuration":false';
                $json_data.='}';
            }
            while ($row = mysqli_fetch_array($none_results)) {
                $json_data.=',{';
                $date = DateTime::createFromFormat("Y-m-d", $row["start_date"]);
                $json_data.='"start":"' . $date->format("Y-m-d") . '",';
                $date = DateTime::createFromFormat("Y-m-d", $row["end_date"]);
                $json_data.='"end":"' . $date->format("Y-m-d") . '",';
                $json_data.='"title":"' . $row['name'] . '",';

                $json_data.='"description":"' . $row['last_name'] . ''
                        . '<br/>Task status:' . $row['status'] . '",';
                $json_data.='"isDuration":false';
                $json_data.='}';
            }
            $json_data = $json_data . ']}';
            echo $json_data;
        }
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
            $stmt->bind_param('sssssss', $a, $b, $e, $f, $i, $j, $c);
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
    if ($_GET['action'] == "update_profile") {
        if ($_POST["submit"]) {
            $a = $_POST["firstName"];
            $b = $_POST["lastName"];
            $c = $_POST["email"];
            $d = $_POST["password"];
            $e = $_POST["phone"];
            $f = $_POST["address"];
            //echo $a." ".$b." ".$c." ".$d." ".$e." ".$f;
            $result = $db->query('UPDATE users SET first_name=' . $a . ', last_name=' . $b . ', password=' . $d . ', email=' . $c . ', phone=' . $e . '  WHERE uid=' . $_SESSION['user_uid']);
            error_log('UPDATE users SET first_name="' . $a . '", last_name="' . $b . '", email="' . $c . '", phone=' . $e . '  WHERE uid=' . $_SESSION['user_uid']);
            header("Location: /");
        }
    }
    if ($_GET['action'] == "reply_task") {
        $stmt = $db->prepare('insert into replies(`user_uid`,`task_uid`,`text`,`time`) values(?,?,?,?)');
        $stmt->bind_param('ddss',$_SESSION['user_uid'],$_POST['taskid'],$_POST['text'],date('Y-m-d H:i:s'));
        $stmt->execute();
        
    }
} else {
    echo 'Error';
}
?>