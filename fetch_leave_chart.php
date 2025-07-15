<?php
include "layouts/config.php";

// Check connection
if ($link->connect_error) {
  die("Connection failed: " . $link->connect_error);
}

// Get the current year
$currentYear = date("Y");

// Fetch data based on parameter
$sql = "SELECT COUNT(*) AS count, MONTH(applied_on) AS month FROM leave_tbl WHERE YEAR(applied_on) = $currentYear GROUP BY MONTH(applied_on)";
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
