<?php
require_once('tcpdf/tcpdf.php');
include 'layouts/config.php'; // Include database configuration file

// Fetch necessary data from the database based on the parameters passed
if (isset($_GET['u_id']) && isset($_GET['id'])) {
    $u_id = $_GET['u_id'];
    $id = $_GET['id'];

    // Fetch data from salaries, users, role, and department tables based on the provided IDs
    $query = "SELECT u.username, u.email, u.phone, u.date_of_joining,
    s.base_salary, s.deduction, s.allowance, s.final_salary,
    s.month, s.year, s.payment_date,
    r.r_name, d.d_name
FROM users u
INNER JOIN salaries s ON u.u_id = s.u_id
INNER JOIN role r ON u.role = r.r_id
INNER JOIN department d ON u.d_id = d.d_id
WHERE s.u_id = $u_id AND s.id = $id";
    $result = mysqli_query($link, $query);
    if (!$result) {
        die('Error: ' . mysqli_error($link));
    }

    $row = mysqli_fetch_assoc($result);

    // Create new PDF document
    $pdf = new TCPDF();
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 11);

    // Add site heading
    $pdf->writeHTMLCell(0, 0, '', '', '<h2 style="text-align:center;">Work Wave</h2>', 0, 1, 0, true, 'C', true);

    // Add salary slip heading
    $pdf->writeHTMLCell(0, 0, '', '', "<h3 style='text-align:center;'>Salary Slip for {$row['month']} {$row['year']}</h3>", 0, 1, 0, true, 'C', true);

    // Add user details in two columns
    $userDetails = "
        <table>
            <tr>
                <td><strong>User Information:</strong></td>
                <td></td>
            </tr>
            <tr>
                <td>Username:</td>
                <td>{$row['username']}</td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>{$row['email']}</td>
            </tr>
            <tr>
                <td>Phone:</td>
                <td>{$row['phone']}</td>
            </tr>
            <tr>
                <td>Date of Joining:</td>
                <td>{$row['date_of_joining']}</td>
            </tr>
            <tr>
                <td>Role:</td>
                <td>{$row['r_name']}</td>
            </tr>
            <tr>
                <td>Department:</td>
                <td>{$row['d_name']}</td>
            </tr>
        </table><br><br>";

    $pdf->writeHTML($userDetails);

    // Add salary details in table format with black border and different font size
    $salaryDetails = "
        <table border='1' cellpadding='5' style='border-collapse: collapse;'>
            <tr>
                <td style='font-weight: bold; font-size: 12px;'>Base Salary</td>
                <td style='font-weight: bold; font-size: 12px;'>Allowance</td>
                <td style='font-weight: bold; font-size: 12px;'>Deduction</td>
                <td style='font-weight: bold; font-size: 12px;'>Payment Date</td>
            </tr>
            <tr>
                <td style='font-size: 12px;'>{$row['base_salary']}</td>
                <td style='font-size: 12px;'>{$row['allowance']}</td>
                <td style='font-size: 12px;'>{$row['deduction']}</td>
                <td style='font-size: 12px;'>{$row['payment_date']}</td>
            </tr>
            <tr>
                <td colspan='2' style='text-align:center; font-weight: bold; font-size: 14px;'><strong>Final Salary: {$row['final_salary']}</strong></td>
            </tr>
        </table>";

    $pdf->writeHTML($salaryDetails);

    // Output PDF as a file
    $pdf->Output('salary_slip.pdf', 'D');
} else {
    // Handle case where parameters are not provided
    echo "Invalid request.";
}
