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
        print_r($_POST);
        $stmt = $db->prepare('insert into project (name,description,start_date,end_date,status,priority,assignee,est_cost) values(?,?,?,?,?,?,?,?)');
        $stmt->bind_param('sssssddd', $_POST['project_name'], $_POST['description'], $_POST['from'], $_POST['to'], $_POST['status'], $_POST['priority'], $_POST['uid'], $_POST['cost']);
        //echo '';
        $stmt->execute();
        // header("Location: projects.php");
    }
    if ($_GET['action'] == "get_tasks") {
        $tasks = new tasks();
        $task_list = $tasks->getTasks_JSON($_SESSION['user_uid'],1);
        echo $task_list;
        return $task_list;
    }
} else {
    echo 'Error';
}
?>