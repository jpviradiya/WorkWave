<?php
session_start();
include 'layouts/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $user_id = $_SESSION['u_id'];
    $newPhone = mysqli_real_escape_string($link, $_POST['newPhone']);
    $newCity = mysqli_real_escape_string($link, $_POST['newCity']);
    $newState = mysqli_real_escape_string($link, $_POST['newState']);
    $newCountry = mysqli_real_escape_string($link, $_POST['newCountry']);
    $newAddress = mysqli_real_escape_string($link, $_POST['newAddress']);

    // Prepare and bind parameters
    $stmt = $link->prepare("UPDATE users SET phone=?, city=?, state=?, country=?, address=? WHERE u_id=?");
    $stmt->bind_param("sssssi", $newPhone, $newCity, $newState, $newCountry, $newAddress, $user_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(array("success" => true));
    } else {
        // Log the error to a file for debugging
        error_log("Error updating user info: " . $stmt->error);

        // Return error response
        echo json_encode(array("success" => false, "error" => "Error updating user info"));
    }

    // Close statement
    $stmt->close();
} else {
    // If the request method is not POST, return an error
    echo json_encode(array("success" => false, "message" => "Invalid request method."));
}

// Close connection
$link->close();
?>
