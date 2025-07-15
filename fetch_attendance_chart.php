<?php
include "layouts/config.php";

// Check connection
if ($link->connect_error) {
  die("Connection failed: " . $link->connect_error);
}

// Get the current year
$currentYear = date("Y");

// Fetch data based on parameter
$sql = "SELECT COUNT(*) AS count, MONTH(attendance_date) AS month 
FROM employee_attendance 
WHERE YEAR(attendance_date) = 2024 AND status='present' 
GROUP BY MONTH(attendance_date);
";
$result = $link->query($sql);

$data = array_fill(0, 11, 0); // Initialize array with 0 for all months (index 0-11)

while ($row = $result->fetch_assoc()) {
  $monthIndex = $row['month'] - 1; // Adjust month index to start from 0
  $data[$monthIndex] = $row['count'];
}

// Close connection
$link->close();

// Output data as JSON
echo json_encode($data);
?>
