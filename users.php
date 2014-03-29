<?php

include './DBConfig.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of users
 *
 * @author bhargav
 */
class users {

    //put your code here
    public $username = "";
    public $first_name = "";
    public $last_name = "";
    public $access_level = 0;
    public $phone = "0000000000";
    public $email = "";
    public $uid= 0;
    public $db;
    public $isLoggedin = 0;

    function __construct() {
        // echo $user;
        $mysql = new DBConfig();
        $this->db = $mysql->getDBConfig();
    }

    function isUser($username) {
        $result = $this->db->query('select * from users where username="' . $username . '"');
        //echo 'select * from users where username="'.$user.'"';
        if ($row = mysqli_fetch_array($result)) {
            return 1;
        } else {
            //echo 'User not found';
            return 0;
        }
    }

    function getUser($username, $password) {
        $result = $this->db->query('select * from users where username="' . $username . '"');
        if ($row = mysqli_fetch_array($result)) {
            if ($password == $row['password']) {
                $this->isLoggedin = 1;
                $this->first_name = $row['first_name'];
                $this->last_name = $row['last_name'];
                $this->username = $row['username'];
                $this->access_level = $row['access_level'];
                $this->phone = $row['phone'];
                $this->email = $row['email'];
                $this->uid = $row['uid'];
            } else {
                $this->isLoggedin = 0;
            }
        }
    }

}

?>
