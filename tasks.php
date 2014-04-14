<?php

include_once './DBConfig.php';
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
    
    function getTasks($user_uid){
        $rows = array();
        $result = $this->db->query('select * from tasks where assignee = "'.$user_uid.'"');
        while ($row = mysqli_fetch_array($result)) {
            $rows[] =$row;
        }
        return $rows;
    }
    
    function getTasks_JSON($user_uid,$project_uid){
        $rows = array();
        if($_SESSION['access_level'] ==2){
        $result = $this->db->query('select * from tasks where project_uid='.$_POST['project_uid']);
        }else{
            $result = $this->db->query('select * from tasks where uid in (select task_uid from user_tasks where user_uid='.$user_uid.')');
        }
        while ($row = mysqli_fetch_array($result)) {
            $rows[] =$row;
        }        
        

        $json_data='{
                        "events":[
{
            "title": "",          
            "start": "",
            "isDuration":false,
            "end":""
}                        
';
        foreach ($rows as $row) {            
            $json_data.=',{';
            $date = DateTime::createFromFormat("Y-m-d", $row["start_date"]);
            $json_data.='"start":"'.$date->format("Y-m-d").'",';
            $date = DateTime::createFromFormat("Y-m-d", $row["end_date"]);
            $json_data.='"end":"'.$date->format("Y-m-d").'",';
            $json_data.='"title":"'.$row['name'].'",';
            $json_data.='"description":"",';
            $json_data.='"isDuration":false';
            $json_data.='}';
        }

                   $json_data=$json_data.']}';
                   return $json_data;
    }

}

?>