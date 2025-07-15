<?php
session_start();
require "layouts/session.php";
require_once "layouts/config.php";

// Check if email and password are set and not empty
if (isset($_POST["email"]) && isset($_POST["password"]) && !empty(trim($_POST["email"])) && !empty(trim($_POST["password"]))) {
  $email = $_POST["email"];
  $password = $_POST["password"];

  // Retrieve user from database
  $query = "SELECT * FROM users WHERE email = '$email'";
  $result = mysqli_query($link, $query);

  if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $dbpassword = $row['password'];

    // Verify password
    if ($password === $dbpassword) {
      $_SESSION['loggedin'] = true;
      $_SESSION['u_id'] = $row['u_id'];
      $_SESSION['role'] = $row['role'];
      $_SESSION['d_id'] = $row['d_id'];
      $_SESSION['email'] = $email;
      // Password is correct
      echo json_encode(["status" => "success", "message" => "Login successful."]);
      exit;
    } else {
      // Password is incorrect
      echo json_encode(["status" => "error", "message" => "Invalid password."]);
      exit;
    }
  } else {
    // Email doesn't exist
    echo json_encode(["status" => "error", "message" => "Invalid email"]);
    exit;
  }
} else {
  // Invalid request
  echo json_encode(["status" => "error", "message" => "Invalid request."]);
  exit;
}
?>