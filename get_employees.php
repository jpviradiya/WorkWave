<?php
// Include database connection or configuration file
include 'layouts/config.php';

// Handle the request to fetch employees based on department ID
if (isset($_POST['d_id'])) {
    $departmentId = $_POST['d_id'];
    
    // Prepare the SQL statement
    $sql = "SELECT username, u_id FROM users WHERE d_id = ?";
    
    // Prepare and bind parameters
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $departmentId);
    
    // Execute the query
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();

    // Check if there are rows returned
    if ($result->num_rows > 0) {
        $options = "";
        while ($row = $result->fetch_assoc()) {
            $username = $row['username'];
            $u_id = $row['u_id'];
            $options .= "<option value=\"$u_id\">$username</option>";
        }
        echo $options;
    } else {
        echo "<option value=\"\">No employees found</option>";
    }
    // Close statement
    $stmt->close();
}

// Handle the request to fetch employee information based on username
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    $username = $_POST['username'];

    // Prepare the SQL statement
    $query = "SELECT u_id, salary FROM users WHERE username = ?";
    
    // Prepare and bind parameters
    $stmt = $link->prepare($query);
    $stmt->bind_param("s", $username);
    
    // Execute the query
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();

    // Check if there are rows returned
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $employeeInfo = array(
            'u_id' => $row['u_id'],
            'salary' => $row['salary']
        );
        echo json_encode($employeeInfo);
    } else {
        // Handle if employee information is not found
        echo json_encode(array('error' => 'Employee information not found'));
    }
    // Close statement
    $stmt->close();
}
?>
