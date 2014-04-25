<?php
include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();

$result = $db->query('select * from tasks whare uid=100');
if($result){
    echo 'yes it is';
}else{
    echo 'Nop it is not';
}
?>

<script>console.log("sdfs");</script>


