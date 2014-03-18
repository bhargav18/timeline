<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class DBConfig {

    public $db;

    function __construct() {
        $DB_NAME = 'timeline';
        $DB_HOST = 'localhost';
        $DB_USER = 'root';
        $DB_PASS = 'root';
        $this->db = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
            echo $test;
        }
    }

    function getDBConfig() {
        return $this->db;
    }

}
?>

