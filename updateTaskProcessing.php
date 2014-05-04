<?php

SESSION_START();
date_default_timezone_set('America/Los_Angeles');
include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();

//Check for correctness
if (!empty($_POST)) {
    $update = (!empty($_POST['update'])) ? $_POST['update'] : 0;
    if ($update) {
        $error = 0;
        $holdDesc = $holdSD = $holdED = $holdEmpNames = "";

        function test_input($data) {   // to test input
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        function isEmpty($data) {
            $data = trim($data);
            if (empty($data))
                return true;
            else
                return false;
        }

        if (isEmpty($_POST['descr'])) {
            $_SESSION['uTDescErr'] = "Task description is required";
            $error = 1;
        } else {
            $holdDesc = test_input($_POST['descr']);
            $_SESSION['uTDescErr'] = "";
        }
        /* Start date
          if (empty($_POST['startdate'])){
          $_SESSION['uTSDateError'] = "Start Date is required"; $error = 1;}
          else
          {
          $_SESSION['uTSDate']= $_POST['startdate'];
          $_SESSION['uTSDateError'] = "";
          }
         */
        if (empty($_POST['enddate'])) {
            $_SESSION['uTEDateError'] = "End Date is required";
            $error = 1;
        } else if ($_POST['enddate'] < $_POST['startdate']) {
            $_SESSION['uTEDateError'] = "End Date can not be before the start date";
            $error = 1;
        } elseif (!empty($_POST['projED']) && $_POST['projED'] < $_POST['enddate']) {
            $_SESSION['uTEDateError'] = "Task cannot end after the project";
            $error = 1;
        } else {
            $holdED = $_POST['enddate'];
            $_SESSION['uTEDateError'] = "";
        }
        if (empty($_POST['empName'])) {
            $_SESSION['uEmpError'] = "Please assign task to emplyees";
            $error = 1;
        } else {
            $holdEmpNames = $_POST['empName'];
            $_SESSION['uEmpError'] = "";
        }

        if ($error == 1) {
            $_SESSION['tId'] = $_POST['taskId'];
            $_SESSION['uTSts'] = $_POST['status'];
            $_SESSION['uTPrio'] = $_POST['priority'];
            $_SESSION['uTDesc'] = $holdDesc;
            $_SESSION['uTEDate'] = $holdED;
            $_SESSION['uEmpName'] = $holdEmpNames;
            $_SESSION['uEmpId'] = (empty($_POST['emp']) ? "" : $_POST['emp']);
            header("Location:updateTask.php");
            exit;
        }


        $sql = "SELECT status, priority, description FROM tasks WHERE uid like '" . $_POST['taskId'] . "'";
        $result = $db->query($sql);
        $row = mysqli_fetch_row($result);
        $t = $row[0];
        /*
          if (!($_POST['status'] == $row[0]))
          {
          $query1 = "UPDATE tasks SET status='".$_POST['status']."' WHERE uid like '".$_POST['taskId']."'";
          $db->query($query1);
          }
          if (!($_POST['priority'] == $row[1]))
          {
          $query2 = "UPDATE tasks SET priority='.".$_POST['priority']."' WHERE uid like '".$_POST['taskId']."'";
          $db->query($query2);
          }
          if (!($_POST['descr'] == $row[2]))
          {
          $query3 = "UPDATE tasks SET description='".$holdDesc."' WHERE uid like '".$_POST['taskId']."'";
          $db->query($query3);
          }
          /* Start date
          if ($_POST['startdate'])
          {
          $query4 = "UPDATE tasks SET start_date=STR_TO_DATE('".$_POST['startdate']."','%m/%d/%Y')
          WHERE uid like '".$_POST['taskId']."'";
          $db->query($query4);
          }

          if ($_POST['enddate'])
          {
          $query5 = "UPDATE tasks SET end_date = STR_TO_DATE('".$_POST['enddate']."','%m/%d/%Y') WHERE uid like '".$_POST['taskId']."'";
          $db->query($query5);
          }
         */
        $date = DateTime::createFromFormat('m/d/Y', $holdED);
        $holdED = $date->format('Y-m-d');
        if ($_POST['status'] != $row[0] || $_POST['priority'] != $row[1] || $holdDesc != $row[2] || $holdED != $row[3]) {
            $stmt = $db->prepare("UPDATE tasks SET status = ?, priority = ?, description = ?, end_date = ? WHERE uid like '" . $_POST['taskId'] . "'");
            $stmt->bind_param('ssss', $_POST['status'], $_POST['priority'], $holdDesc, $holdED);
            $stmt->execute();

            //Employee adding and notifications
            $sql4 = "SELECT user_uid FROM user_tasks WHERE task_uid like '" . $_POST['taskId'] . "'";
            $result = $db->query($sql4);
            $oldEmp = array();
            $currentEmpArr = array();
            $i = 0;
            while ($row = mysqli_fetch_row($result)) {
                $currentEmpArr[$i] = $row[0];
                $i++;
            }

            if (!empty($_POST['emp'])) {
                $updatedEmpArr = array();
                $updatedEmpArr = $_POST['emp'];
                $newEmpArr = array();
                $removedArr = array();
                $oldEmp = array_intersect($currentEmpArr, $updatedEmpArr);
                $newEmpArr = array_diff($updatedEmpArr, $oldEmp);
                $removedArr = array_diff($currentEmpArr, $oldEmp);

                //Notify removed employees
                foreach ($removedArr as $emp) {
                    $sql3 = "SELECT email FROM users WHERE uid like '$emp'";
                    $result = $db->query($sql3);
                    $row = mysqli_fetch_row($result);
                    $to = $row[0];
                    $subject = 'Task Update';
                    $message = 'You have been removed from task ' . $_POST['taskId'];

                    $headers = 'From: test@example.com' . "\r\n" .
                            'Reply-To: webmaster@example.com' . "\r\n" .
                            'X-Mailer: PHP/' . phpversion();

                    mail($to, $subject, $message, $headers);
                }
                //Delete all employees then insert the new list
                $query6 = "DELETE FROM user_tasks WHERE task_uid like '" . $_POST['taskId'] . "'";
                $db->query($query6);
                foreach ($_POST['emp'] as $emp) {
                    $stmt = $db->prepare('insert into user_tasks (task_uid, user_uid)'
                            . 'VALUES (?,?)');
                    $stmt->bind_param('dd', $_POST['taskId'], $emp);
                    $stmt->execute();
                }

                //Notify new employee
                foreach ($newEmpArr as $emp) {
                    $sql3 = "SELECT email FROM users WHERE uid like '$emp'";
                    $result = $db->query($sql3);
                    $row = mysqli_fetch_row($result);
                    $to = $row[0];
                    $subject = 'New Task';
                    $message = 'You have been added to task ' . $_POST['taskId'];

                    $headers = 'From: test@example.com' . "\r\n" .
                            'Reply-To: webmaster@example.com' . "\r\n" .
                            'X-Mailer: PHP/' . phpversion();

                    mail($to, $subject, $message, $headers);
                }
            } else
                $oldEmp = $currentEmpArr;
            //Notify current employee
            foreach ($oldEmp as $emp) {
                $sql3 = "SELECT email FROM users WHERE uid like '$emp'";
                $result = $db->query($sql3);
                $row = mysqli_fetch_row($result);
                $to = $row[0];
                $subject = 'Task Update';
                $message = 'Task ' . $_POST['taskId'] . ' has been updated';

                $headers = 'From: test@example.com' . "\r\n" .
                        'Reply-To: webmaster@example.com' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
                mail($to, $subject, $message, $headers);
            }

            $msg = 'The task has been updated';
            echo '<script type="text/javascript">alert("' . $msg . '");</script>';
        }
        echo "<script>setTimeout(\"location.href = 'viewTasks.php';\",500);</script>";
        exit;
    } elseif ($_POST['delete']) {
        $query1 = "DELETE FROM tasks WHERE uid like '" . $_POST['taskId'] . "'";
        $db->query($query1);
        $query6 = "SELECT users.email FROM users
					LEFT JOIN user_tasks ON users.uid = user_tasks.user_uid
					WHERE user_tasks.task_uid = '" . $_POST['taskId'] . "'";
        $result = $db->query($query6);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $to = $row[0];
                $subject = 'Task Update';
                $message = 'Task "' . $_POST['taskId'] . '" has been deleted';

                $headers = 'From: test@example.com' . "\r\n" .
                        'Reply-To: webmaster@example.com' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                mail($to, $subject, $message, $headers);
            }
        }
        $query2 = "DELETE FROM user_tasks WHERE task_uid like '" . $_POST['taskId'] . "'";
        $db->query($query2);
        $msg = 'The task has been deleted';
        echo '<script type="text/javascript">alert("' . $msg . '");</script>';
        echo "<script>setTimeout(\"location.href = 'viewTasks.php';\",1500);</script>";
        exit;
    }
} else {
    header("Location:viewTasks.php");
    exit;
}
?>