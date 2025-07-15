<?php
include 'layouts/config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $firstName = $_POST['FirstName'];
  $lastName = $_POST['LastName'];
  $username = $firstName . ' ' . $lastName;
  $email = $_POST['Email'];
  $mobileNumber = $_POST['MobileNumber'];
  $dateOfBirth = date('Y-m-d', strtotime($_POST['DateOfBirth']));
  $dateOfJoining = date('Y-m-d', strtotime($_POST['DateOfJoining']));
  $gender = $_POST['Gender'];
  $address = $_POST['Address'];
  $area = $_POST['Area'];
  $city = $_POST['City'];
  $state = $_POST['State'];
  $pincode = $_POST['Pincode'];
  $country = $_POST['Country'];
  $salary = $_POST['Salary'];

  $pass = strtolower($firstName . $lastName . substr((string) $mobileNumber, -4));
  $password = $pass;

  $role = $_POST['Role'];
  $sql = "SELECT r_id FROM role WHERE r_name = '$role'";
  $result = $link->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $roleId = $row['r_id'];
  }

  $department = $_POST['Department'];
  $sql = "SELECT d_id FROM department WHERE d_name = '$department'";
  $result = $link->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $depId = $row['d_id'];
  }

  $image = $_FILES['imageInput'];
  if ($image['size'] > 0) {
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    if (in_array(strtolower($extension), $allowedExtensions)) {
      $imageName = uniqid('img_') . '.' . $extension;
      $imagePath = 'profile_images/' . $imageName;
      move_uploaded_file($image['tmp_name'], $imagePath);
    }
  } else {
    $imagePath = 'profile_images/user_default_img.jpg';
  }

  $query = "SELECT email FROM users where email='$email'";
  $result = mysqli_query($link, $query);
  if ($result) {
    $rowCount = mysqli_num_rows($result);
    if ($rowCount != 0) {
      echo "
<script>alert('user already exist')</script>";
    } else {
      $sql = "INSERT INTO users (username, password, profile_image, firstname, lastname, email, phone, dob, role, d_id, salary,total_salary_paid, address, area, city, state, pincode, country, gender,date_of_joining)
VALUES ('$username','$password','$imagePath','$firstName', '$lastName','$email', '$mobileNumber', '$dateOfBirth',$roleId, $depId,'$salary',0,'$address','$area','$city', '$state','$pincode','$country','$gender','$dateOfJoining')";
    }
  }
  if ($link->query($sql) === TRUE) {
    // echo "Record inserted successfully";
    header("Location: view_emp.php");
  } else {
    echo "Error: " . $sql . "<br>" . $link->error;
  }
  $link->close();
} else {
  // Redirect to the form page if accessed directly without submitting the form
  header("Location: add_emp.php");
  exit();
}
