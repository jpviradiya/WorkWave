<?php
// Include your database connection configuration file
include 'layouts/config.php';

// Check if the required parameters are set
if (isset($_POST['employeeId'], $_POST['start'], $_POST['end'])) {
  // Get the parameters from the AJAX request
  $employeeId = $_POST['employeeId'];
  $start = $_POST['start'];
  $end = $_POST['end'];

  // Prepare and execute SQL query to fetch attendance data
  $sql = "SELECT * FROM employee_attendance WHERE emp_id = ? AND attendance_date BETWEEN ? AND ?";
  $stmt = $link->prepare($sql);
  if ($stmt) {
    // Bind parameters and execute the statement
    $stmt->bind_param("iss", $employeeId, $start, $end);
    $stmt->execute();

    // Get result set
    $result = $stmt->get_result();

    // Prepare an array to hold the fetched data
    $attendanceData = array();

    // Fetch data and add it to the array
    while ($row = $result->fetch_assoc()) {
      $attendanceData[] = array(
        'title' => $row['status'], // Assuming 'status' contains the title (e.g., Present, Absent)
        'start' => $row['attendance_date'],
        'status' => $row['status']
      );
    }

    // Close result set
    $result->close();
  } else {
    // Error in preparing the SQL statement
    echo json_encode(array('error' => 'Failed to prepare SQL statement.'));
  }

  // Close the prepared statement
  $stmt->close();

  // Close the database connection
  $link->close();

  // Return the fetched data as JSON
  echo json_encode($attendanceData);
} else {
  // If any of the required parameters is not set, return an error message
  echo json_encode(array('error' => 'One or more required parameters are missing.'));
}
