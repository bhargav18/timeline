<?php

include './DBConfig.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tasks {

    public $db;

    function __construct() {
        // echo $user;
        $mysql = new DBConfig();
        $this->db = $mysql->getDBConfig();
    }
    
    function getTasks_JSON($user_uid){
        $rows = array();
        $result = $this->db->query('select * from tasks where assignee = "'.$user_uid.'"');
        while ($row = mysqli_fetch_array($result)) {
            $rows[] =$row;
        }
        return $rows;
    }

}

?>