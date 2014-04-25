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

    function getTasks($user_uid) {
        $rows = array();
        $result = $this->db->query('select * from tasks where assignee = "' . $user_uid . '"');
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    function getTasks_JSON($user_uid, $project_uid) {
        $rows = array();
        $others = array();
        if ($_SESSION['access_level'] == 2) {
            $result = $this->db->query('select distinct(t1.uid),t1.* from tasks t1, project t2 where t1.uid in (select task_uid from user_tasks) and t1.project_uid=' . $project_uid . ' and t1.deleted="N"');
        } else {
            $result = $this->db->query('select t1.*,t2.last_name,t2.uid as user_uid,t3.status as project_st from tasks t1, project t3, users t2 where t1.uid in (select task_uid from user_tasks where user_uid=' . $user_uid . ') and t1.project_uid=t3.uid and t1.deleted="N" and t2.uid=' . $user_uid);
        }

        while ($row = mysqli_fetch_array($result)) {
            $other_people = $this->db->query('select t1.* from users t1, user_tasks t2 where t2.task_uid=' . $row["uid"] . ' and t1.uid = t2.user_uid');
            while ($row2 = mysqli_fetch_array($other_people)) {
                $others[] = $row2;
            }
            $rows[] = $row;
        }
if(count($rows) == 0){return 0;}

        $json_data = '{
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
            $json_data.='"start":"' . $date->format("Y-m-d") . '",';
            $date = DateTime::createFromFormat("Y-m-d", $row["end_date"]);
            $json_data.='"end":"' . $date->format("Y-m-d") . '",';
            $json_data.='"title":"' . $row['name'] . '",';
            $json_data.='"description":"' . $row['last_name'] . ''
                    . '<br/>Task status: ' . $row['status']
                    . '<br/><span>reply to this task:</span><br/><textarea id=\"reply_box\" style=\"height:40px;width:300px;\"></textarea><input type=\"button\" value=\"Reply\" onclick=\"reply_this('.$row[uid].')\"/>' . '",';
            $json_data.='"isDuration":false';
            $json_data.='}';
        }

        $json_data = $json_data . ']}';
        return $json_data;
    }

}

?>