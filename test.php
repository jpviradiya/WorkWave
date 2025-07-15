<?php
include 'layouts/config.php';

//!code for inserting holidays of 2024
//!START OF HOLIDAYS AUTO INSERTION
//! Define an array of holidays
// $holidays_2024 = array(
//     '2024-01-01', // New Year's Day
//     '2024-01-15', // Makar Sankranti
//     '2024-01-26', // Republic Day
//     '2024-02-21', // Mahashivratri
//     '2024-03-08', // Holi
//     '2024-04-14', // Dr. Ambedkar Jayanti
//     '2024-04-19', // Good Friday
//     '2024-05-01', // May Day
//     '2024-08-15', // Independence Day
//     '2024-09-02', // Janmashtami
//     '2024-10-02', // Gandhi Jayanti
//     '2024-10-28', // Dussehra
//     '2024-11-02', // Diwali
//     '2024-12-25', // Christmas Day
// );

// // Include all Sundays of 2024 as holidays
// $start_date = new DateTime('2024-01-01');
// $end_date = new DateTime('2024-12-31');
// $interval = new DateInterval('P1D'); // 1 day interval
// $date_range = new DatePeriod($start_date, $interval, $end_date);

// foreach ($date_range as $d) {
//     if ($d->format('N') == 7) { // Sunday
//         $holidays_2024[] = $d->format('Y-m-d');
//     }
// }
// // Sort the holidays array
// sort($holidays_2024);

// // Insert records for holidays automatically when the page is loaded
// foreach ($holidays_2024 as $holiday) {
//     $status = 'holiday';
//     $sql1 = "SELECT u_id FROM users";
//     $result = mysqli_query($link, $sql1);
//     if (mysqli_num_rows($result) > 0) {
//         while ($row = mysqli_fetch_assoc($result)) {
//             $in_time = 'null';
//             $out_time = 'null';
//             $emp_id = $row['u_id'];
//             // Check if a record already exists for the user and holiday date
//             $check_sql = "SELECT * FROM employee_attendance WHERE emp_id = '$emp_id' AND attendance_date = '$holiday'";
//             $check_result = mysqli_query($link, $check_sql);
//             if (mysqli_num_rows($check_result) == 0) {
//                 // If no record exists, insert the attendance record
//                 $insert_sql = "INSERT INTO employee_attendance (emp_id, in_time, out_time, attendance_date, status) VALUES ('$emp_id', $in_time, $out_time, '$holiday', '$status')";
//                 if ($link->query($insert_sql) === TRUE) {
//                     echo "Attendance recorded successfully for $holiday";
//                 } else {
//                     echo "Error: " . $insert_sql . "<br>" . $link->error;
//                 }
//             } else {
//                 echo "Attendance record already exists for user $emp_id on $holiday<br>";
//             }
//         }
//     }
// }
//!END OF HOLIDAYS AUTO INSERTION



//! Fetch employee list from the database
//! START
//displaying all the users available in database
$sql = "SELECT u_id,username FROM users";
echo $sql;
echo "<br>";

$result = mysqli_query($link, $sql);
if (!$result) {
    die("Error in SQL query: " . mysqli_error($link));
}

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo $row['u_id'];
        echo ': ';
        echo $row['username'];
        echo '<br>';
    }
}
//! END

//! code insert random attendance data for all users 
//! START 
// Define start and end dates
$start_date = new DateTime('2024-01-01');
$end_date = new DateTime('2024-12-31');
// Iterate over each date
$current_date = $start_date;
while ($current_date <= $end_date) {
    $date = $current_date->format('Y-m-d');
    // Check if the date is a holiday
    if (!isHoliday($date)) {
        // Fetch all users
        $employees_sql = "SELECT u_id FROM users";
        $employees_result = mysqli_query($link, $employees_sql);
        if ($employees_result) {
            while ($employee = mysqli_fetch_assoc($employees_result)) {
                $employee_id = $employee['u_id'];

                // Check if a record already exists for the selected employee and date
                $check_sql = "SELECT * FROM employee_attendance WHERE emp_id = '$employee_id' AND attendance_date = '$date'";
                $check_result = mysqli_query($link, $check_sql);
                if (mysqli_num_rows($check_result) == 0) {
                    // Generate random in and out times
                    list($in_time, $out_time) = generateRandomTime();

                    // Determine status based on in and out times
                    $status = determineStatus($in_time, $out_time);

                    // Insert the attendance record
                    $insert_sql = "INSERT INTO employee_attendance (emp_id, in_time, out_time, attendance_date, status) VALUES ('$employee_id', '$in_time', '$out_time', '$date', '$status')";
                    if ($link->query($insert_sql) === TRUE) {
                        echo "Attendance recorded successfully for employee $employee_id on $date with status $status<br>";
                    } else {
                        echo "Error: " . $insert_sql . "<br>" . $link->error;
                    }
                } else {
                    echo "Attendance record already exists for employee $employee_id on $date<br>";
                }
            }
        } else {
            echo "Error fetching employees: " . mysqli_error($link);
        }
    } else {
        echo "Skipping holiday: $date<br>";
    }

    // Move to the next date
    $current_date->modify('+1 day');
}

function isHoliday($date)
{
    // Define an array of holidays
    $holidays_2024 = array(
        '2024-01-01', // New Year's Day
        '2024-01-15', // Makar Sankranti
        '2024-01-26', // Republic Day
        '2024-02-21', // Mahashivratri
        '2024-03-08', // Holi
        '2024-04-14', // Dr. Ambedkar Jayanti
        '2024-04-19', // Good Friday
        '2024-05-01', // May Day
        '2024-08-15', // Independence Day
        '2024-09-02', // Janmashtami
        '2024-10-02', // Gandhi Jayanti
        '2024-10-28', // Dussehra
        '2024-11-02', // Diwali
        '2024-12-25', // Christmas Day
    );

    // Include all Sundays of 2024 as holidays
    $start_date = new DateTime('2024-01-01');
    $end_date = new DateTime('2024-12-31');
    $interval = new DateInterval('P1D'); // 1 day interval
    $date_range = new DatePeriod($start_date, $interval, $end_date);

    foreach ($date_range as $d) {
        if ($d->format('N') == 7) { // Sunday
            $holidays_2024[] = $d->format('Y-m-d');
        }
    }

    // Sort the holidays array
    sort($holidays_2024);
    return in_array($date, $holidays_2024);
}

// Function to determine status based on in and out times
function determineStatus($in_time, $out_time)
{
    // Define time ranges for different statuses
    $time_ranges = [
        'present' => ['09:00', '17:00'],
        'half-day' => ['09:00', '12:00'],
        'absent' => ['null', 'null'],
    ];

    // Randomly choose a status with probabilities
    $status_probabilities = [
        'present' => 0.7,
        'half-day' => 0.15,
        'absent' => 0.15
    ];
    $rand = mt_rand() / mt_getrandmax();
    $cumulative_probability = 0.0;
    foreach ($status_probabilities as $status => $probability) {
        $cumulative_probability += $probability;
        if ($rand < $cumulative_probability) {
            return $status;
        }
    }

    // Default to 'present' if no status is chosen
    return 'present';
}

// Function to generate random in and out times
function generateRandomTime()
{
    // Randomly generate in and out times within the range
    $in_time = date('H:i', mt_rand(strtotime('08:00'), strtotime('11:00')));
    $out_time = date('H:i', mt_rand(strtotime('16:00'), strtotime('19:00')));

    return [$in_time, $out_time];
}
//!END



//! to delete all the data except holiday
//! START
// $delete_sql = "DELETE FROM employee_attendance
// WHERE status IN ('present', 'half-day','halfday', 'absent')";
// $delete_result = mysqli_query($link, $delete_sql);

// if ($delete_result) {
//     echo "<br>Deleted all non-holiday attendance records successfully.";
// } else {
//     echo "<br>Error deleting non-holiday attendance records: " . mysqli_error($link);
// }
//! END

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Attendance Form</title>
</head>

<body>
</body>

</html>