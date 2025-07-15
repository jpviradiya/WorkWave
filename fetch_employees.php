<?php

include 'layouts/config.php';

// Check if departmentId is set in the POST request
if (isset($_POST['departmentId'])) {
  $departmentId = $_POST['departmentId'];

  $sql = "SELECT * FROM users WHERE d_id = $departmentId";
  $result = $link->query($sql);


  // Fetch and store the result in an array
  $employees = array();
  while ($row = $result->fetch_assoc()) {
    $employees[] = array(
      'id' => $row['u_id'],
      'name' => $row['username']
    );
  }

  $link->close(); // Close connection if not needed elsewhere

  echo json_encode($employees);
}
