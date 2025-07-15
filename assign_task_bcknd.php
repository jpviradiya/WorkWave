<?php
session_start();
include 'layouts/check_pm.php';
include 'layouts/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $uid = $_POST['task_emp'];
  $task_id = $_POST['t_id'];
  $d_id = $_POST['d_id'];

  foreach ($task_id as $index => $t_id) {
    // echo "uid: $uid[$index]<br>";
    // echo "tid: $t_id<br>";
    // echo "did: $d_id[$index]<br><br>";

    $user_id = $uid[$index];
    $task_id = $t_id;
    $dep_id = $d_id[$index];
    $status = 1;
    $query = "INSERT INTO assign_task ( u_id, t_id, d_id,status) VALUES ('$user_id','$task_id','$dep_id','$status')";
    $result = mysqli_query($link, $query);
  }
  $query2 = "UPDATE task SET status= '$status' WHERE t_id=$task_id";
  $result2 = mysqli_query($link, $query2);

  if ($result && $result2) {
    $_SESSION['status'] = "Task assigned successfully";
    header("Location: task.php");
  } else {
    $_SESSION['status'] = "Task not assigned";
    header("Location: task.php");
  }
}

$link->close();