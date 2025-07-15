<?php
include 'layouts/config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = $_POST['title'];
  $desc = $_POST['description'];
  $department = $_POST['department'];
  $startDate = $_POST['startDate'];
  $endDate = $_POST['endDate'];
  $status = 0;

  // Perform date validation
  $startDate = date('Y-m-d', strtotime($startDate)); // Format the date
  $endDate = date('Y-m-d', strtotime($endDate)); // Format the date
  $today = date('Y-m-d');

  if (empty($title) || empty($desc) || empty($department) || empty($startDate) || empty($endDate)) {
    // echo "<script>alert('Please fill in all fields');</script>";
    echo "<script>console.log('Please fill in all fields');</script>";
  } elseif ($endDate < $startDate) {
    echo "<script>alert('End date cannot be before the start date.');</script>";
  } elseif ($startDate < $today) {
    echo "<script>alert('Start date cannot be before today\'s date.');</script>";
  } elseif (date('Y', strtotime($startDate)) > 3000 || date('Y', strtotime($endDate)) > 3000) {
    echo "<script>alert('Select an appropriate year. Year should not exceed 3000.');</script>";
  } else {
    // Insert data into the database
    $sql = "INSERT INTO task (t_title, t_description, department, start_date, end_date, status) 
                VALUES ('$title','$desc','$department','$startDate','$endDate', '$status')";
    if ($link->query($sql) === TRUE) {
      // echo "<script>alert('Record inserted successfully')</script>";
      header("Location: view_task.php");
      exit();
    } else {
      echo "Error: " . $sql . "<br>" . $link->error;
    }
  }
  $link->close();
} else {
  // Redirect to the form page if accessed directly without submitting the form
  header("Location: add_task.php");
  exit();
}

?>