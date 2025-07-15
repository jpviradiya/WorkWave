<?php
session_start(); // Start session to get user role
require 'layouts/check_hr.php';

// Handle approval and rejection actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['approve']) && isset($_POST['leave_id'])) {
    // Include database configuration
    include 'layouts/config.php';

    // Get leave_id from POST data
    $leaveId = $_POST['leave_id'];

    // Update status to 1 (approved) in the database
    $updateSql = "UPDATE leave_tbl SET status = 1 WHERE id = $leaveId";
    $result = mysqli_query($link, $updateSql);
    if ($result === TRUE) {
      header("Location: approve_leave.php");
      exit();
    } else {
      echo "Error updating record: " . mysqli_error($link);
    }

    // Close database connection
    mysqli_close($link);
  } elseif (isset($_POST['reject']) && isset($_POST['leave_id'])) {
    // Include database configuration
    include 'layouts/config.php';

    // Get leave_id from POST data
    $leaveId = $_POST['leave_id'];

    // Update status to 0 (rejected) in the database
    $updateSql = "UPDATE leave_tbl SET status = 0 WHERE id = $leaveId";
    $result = mysqli_query($link, $updateSql);
    if ($result === TRUE) {
      header("Location: approve_leave.php");
      exit();
    } else {
      echo "Error updating record: " . mysqli_error($link);
    }

    // Close database connection
    mysqli_close($link);
  } else {
    // Redirect back to the page if leave_id or action is not provided
    header("Location: approve_leave.php");
    exit();
  }
} else {
  // Redirect back to the page if accessed without POST request
  header("Location: approve_leave.php");
  exit();
}
?>