<?php

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Include database connection file
  include 'layouts/config.php';
  session_start();
  $u_id = $_SESSION['u_id'];

  // Get form data and escape special characters
  $leave_reason = mysqli_real_escape_string($link, $_POST['leave_reason']);
  $leave_from = mysqli_real_escape_string($link, $_POST['leave_from']);
  $leave_to = mysqli_real_escape_string($link, $_POST['leave_to']);
  $description = mysqli_real_escape_string($link, $_POST['description']);
  $applied_on = date('Y-m-d');

  // Set the initial status to 2 (pending)
  $status = 2;

  // SQL query to insert data into leave_tbl with status
  $sql = "INSERT INTO leave_tbl (emp_id, leave_reason, leave_from, leave_to, description, status, applied_on) 
            VALUES ('$u_id', '$leave_reason', '$leave_from', '$leave_to', '$description', $status, '$applied_on')";

  // Execute query
  if ($link->query($sql) === TRUE) {
    // Redirect to leave_status.php after successful submission
    header("Location: leave_status.php");
    exit();
  } else {
    // Handle error
    echo "Error: " . $sql . "<br>" . $link->error;
  }

  // Close database connection
  $link->close();
} else {
  // Redirect to the form page if accessed directly without submitting the form
  header("Location: leave_history.php");
  exit();
}
