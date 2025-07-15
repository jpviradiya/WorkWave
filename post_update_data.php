<?php
session_start();
include 'layouts/head-main.php';
include 'layouts/config.php'; // Include database configuration file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $deduction = $_POST['deduction'];
    $allowance = $_POST['allowance'];
    $finalSalary = $_POST['finalSalary'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $u_id = $_POST['u_id'];
    $id = $_POST['id'];
    $new_year = $_POST['yearDropdown'];
    $new_month = $_POST['monthDropdown'];

    // Prepare and execute the SQL query to update or insert data
    $sql = "SELECT * FROM salaries WHERE u_id = $u_id AND month = '$month' AND year = $year";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Data exists, update it
        $update_query = "UPDATE salaries SET month = '$new_month', year = '$new_year', deduction = $deduction, allowance = $allowance, final_salary = $finalSalary WHERE id=$id AND u_id = $u_id AND month = '$month' AND year = $year";
        $result_update = mysqli_query($link, $update_query);

        if ($result_update) {
            // Redirect back to the payslip list page
            header("Location: pending_salary_list.php");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($link);
        }
    } else {
        // Data does not exist, insert it
        $insert_query = "INSERT INTO salaries (u_id, month, year, deduction, allowance, final_salary) VALUES ($u_id, '$new_month', '$new_year', $deduction, $allowance, $finalSalary)";
        $result_insert = mysqli_query($link, $insert_query);

        if ($result_insert) {
            // Redirect back to the payslip list page
            header("Location: pending_salary_list.php");
            exit();
        } else {
            echo "Error inserting record: " . mysqli_error($link);
        }
    }
}

// If the form is not submitted or there is an error, handle it accordingly
?>
