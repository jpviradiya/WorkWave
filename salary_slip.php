<?php
// Include necessary files and session handling logic

// Static data for demonstration (replace with actual data fetching logic)
$employeeDetails = array(
  'name' => 'John Doe',
  'employee_id' => 'EMP123',
  'email' => 'john.doe@example.com',
  // Add more details as needed
);

// Static data for demonstration (replace with actual data fetching logic)
$salaryDetails = array(
  'basic_salary' => 5000,
  'bonus' => 1000,
  'total_salary' => 6000,
  'payment_date' => '2022-02-01',
);

?>

<!DOCTYPE html>
<html lang="en">

<?php include 'layouts/head-main.php'; ?>

<head>
  <title>Salary slip | Your App Name</title>
  <?php include 'layouts/head.php'; ?>
  <?php include 'layouts/head-style.php'; ?>


  <!-- Additional CSS styles for improved UI -->
  <style>
    body {
      background-color: #f8f9fa;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .salary-slip-section {
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      background-color: #fff;
      margin: 20px;
      border-radius: 10px;
      overflow: hidden;
      border: 1px solid #ddd;
      /* Added border styling */
    }

    .salary-slip-section h5 {
      font-size: 24px;
      margin-bottom: 15px;
      color: #333;
    }

    .salary-details {
      margin-top: 20px;
    }

    .details-box {
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      background-color: #fff;
      margin-bottom: 20px;
      border-radius: 10px;
      overflow: hidden;
      border: 1px solid #ddd;
      /* Added border styling */
    }

    .details-box p {
      margin: 0 0 15px;
      font-size: 18px;
      color: #555;
    }

    .details-box strong {
      color: #333;
    }
  </style>
</head>

<?php include 'layouts/body.php'; ?>

<div id="layout-wrapper">
  <?php include 'layouts/menu.php'; ?>

  <div class="main-content">
    <div class="page-content">
      <div class="container-fluid">

        <!-- Salary Slip Section -->
        <div class="salary-slip-section">
          <h5 class="mb-3">Salary Slip</h5>

          <!-- Employee Details -->
          <div class="details-box">
            <p><strong>Employee Name:</strong> <?php echo $employeeDetails['name']; ?></p>
            <p><strong>Employee ID:</strong> <?php echo $employeeDetails['employee_id']; ?></p>
            <p><strong>Email:</strong> <?php echo $employeeDetails['email']; ?></p>
          </div>

          <!-- Salary Details -->
          <div class="details-box salary-details">
            <p><strong>Basic Salary:</strong> $<?php echo $salaryDetails['basic_salary']; ?></p>
            <p><strong>Bonus:</strong> $<?php echo $salaryDetails['bonus']; ?></p>
            <p><strong>Total Salary:</strong> $<?php echo $salaryDetails['total_salary']; ?></p>
            <p><strong>Payment Date:</strong> <?php echo $salaryDetails['payment_date']; ?></p>
          </div>
        </div>

      </div>
      <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <?php include 'layouts/footer.php'; ?>
  </div>
  <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<?php include 'layouts/right-sidebar.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>

</body>

</html>