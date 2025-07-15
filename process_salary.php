<?php
include 'layouts/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $monthDropdown = $_POST['monthDropdown'];
    $year = $_POST['yearDropdown'];
    $username = $_POST['username'];
    $uId = $_POST['uId'];
    $baseSalary = $_POST['baseSalary'];
    $deduction = $_POST['deduction'];
    $allowance = $_POST['allowance'];
    $finalSalary = $_POST['finalSalary'];
    $hr_status=1;

    // Insert salary details into salaries table
    $insertQuery = "INSERT INTO salaries (month, year, u_id, base_salary, deduction, allowance, final_salary, hr_status) 
                    VALUES ('$monthDropdown','$year', '$uId', '$baseSalary', '$deduction', '$allowance', '$finalSalary', '$hr_status')";

    // Execute the query
    $result = mysqli_query($link, $insertQuery);

    // Check if the query was successful
    if ($result) {
        // Retrieve total salary paid
        $totalSalaryQuery = "SELECT total_salary_paid FROM users WHERE u_id = '$uId'";
        $resultTotal = mysqli_query($link, $totalSalaryQuery);

        // Check if the query was successful
        if ($resultTotal) {
            $row = mysqli_fetch_assoc($resultTotal);
            $totalSalaryPaid = $row['total_salary_paid'];

            // Update total salary paid
            $newTotalSalary = $totalSalaryPaid + $finalSalary;
            $updateTotalSalaryQuery = "UPDATE users SET total_salary_paid = '$newTotalSalary' WHERE u_id = '$uId'";
            $resultUpdate = mysqli_query($link, $updateTotalSalaryQuery);

            if (!$resultUpdate) {
                echo "Error updating total salary paid: " . mysqli_error($link);
            }
        } else {
            echo "Error retrieving total salary paid: " . mysqli_error($link);
        }

        // Close connection
        mysqli_close($link);

        // Redirect to a success page or display a success message
        header("Location: pending_salary_list.php");
        exit();
    } else {
        echo "Error inserting salary details: " . mysqli_error($link);
    }
} else {
    echo "Invalid request method!";
}
?>
