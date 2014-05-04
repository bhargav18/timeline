<?php
    
    $myData = "";
    $query = "SELECT est_end_date, end_date FROM tasks WHERE est_end_date = end_date ";
    $onTime = 0;
    $before = 0;
    $afterr = 0;
    $total = 0;
    $result= $db->query($query);
    $r = mysqli_fetch_array($result);
    while($r = mysqli_fetch_array($result)) {
            $onTime++;
        $total++;
    }
    $query = "SELECT est_end_date, end_date FROM tasks WHERE est_end_date > end_date";
    $result= $db->query($query);
    $r = mysqli_fetch_array($result);
    while($r = mysqli_fetch_array($result)) {
            $before++;
            $total++;
    }
    
    $query = "SELECT est_end_date, end_date FROM tasks WHERE est_end_date < end_date";
    $result= $db->query($query);
    $r = mysqli_fetch_array($result);
    while($r = mysqli_fetch_array($result)) {
        $afterr++;
        $total++;
    }

    $myData .= "[ 'On Time',  " . (($onTime/$total)*100). " ], ";
     $myData .= "[ 'Delayed',  " . (($afterr/$total)*100). " ], ";
     $myData .= "[ 'Early',  " . (($before/$total)*100). " ]";

    ?>
