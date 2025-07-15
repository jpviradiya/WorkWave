<?php
session_start();
require "layouts/check_pm.php";
include 'layouts/config.php'; // Include your database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_end_date'])) {
  // Retrieve task ID and new end date from GET parameters
  $task_id = $_POST['task_id'] ?? '';
  $new_end_date = $_POST['new_end_date'] ?? '';

  // Validate task ID and new end date
  if ($task_id && $new_end_date) {
    // Update task table with new end date
    $sql_update_task = "UPDATE task SET end_date = '$new_end_date' WHERE t_id = '$task_id'";
    if (mysqli_query($link, $sql_update_task)) {
      // Redirect to a success page or display a success message
      header("Location: view_task.php");
      exit();
    } else {
      // Handle error updating task table
      echo "Error updating task table: " . mysqli_error($link);
    }
  } else {
    // Handle invalid parameters
    echo "Invalid task ID or new end date";
  }
} else {
  // Handle invalid request method
  echo "Invalid request method";
}

// Close database connection
mysqli_close($link);

?>