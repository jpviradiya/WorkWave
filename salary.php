<?php
// Include necessary files and session handling logic

// Static data for demonstration (replace with actual data fetching logic)
$employeeDetails = array(
  'name' => 'John Doe',
  'employee_id' => '1000',
  'email' => 'john.doe@example.com',
  // Add more details as needed
);

?>

<!DOCTYPE html>
<html lang="en">

<?php include 'layouts/head-main.php'; ?>

<head>
  <title><?php echo $language["Salary Module"]; ?> | Your App Name</title>
  <?php include 'layouts/head.php'; ?>
  <?php include 'layouts/head-style.php'; ?>

  <?php include 'layouts/head.php'; ?>

  <!-- Additional CSS styles for improved UI -->
  <style>
    body {
      background-color: #f8f9fa;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .salary-section {
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      background-color: #fff;
      margin: 20px;
      border-radius: 10px;
      overflow: hidden;
      border: 1px solid #ddd;
      /* Added border styling */
    }

    .salary-section h5 {
      font-size: 24px;
      margin-bottom: 15px;
      color: #333;
    }

    .salary-form {
      margin: 20px 0;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-size: 18px;
      margin-bottom: 5px;
      color: #555;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    .submit-btn {
      background-color: #007bff;
      color: #fff;
      padding: 10px 20px;
      font-size: 18px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>

<?php include 'layouts/body.php'; ?>

<div id="layout-wrapper">
  <?php include 'layouts/menu.php'; ?>

  <div class="main-content">
    <div class="page-content">
      <div class="container-fluid">

        <!-- Employee Salary Entry Section -->
        <div class="salary-section">
          <h5 class="mb-3">Employee Salary Entry</h5>
          <form class="salary-form" method="post" action="process_salary.php">
            <!-- Employee Details -->
            <div class="form-group">
              <label for="employee_name">Employee Name</label>
              <input type="text" id="employee_name" name="employee_name" value="<?php echo $employeeDetails['name']; ?>" readonly>
            </div>

            <div class="form-group">
              <label for="employee_id">Employee ID</label>
              <input type="text" id="employee_id" name="employee_id" value="<?php echo $employeeDetails['employee_id']; ?>" readonly>
            </div>

            <!-- Salary Details -->
            <div class="form-group">
              <label for="basic_salary">Basic Salary</label>
              <input type="text" id="basic_salary" name="basic_salary" required>
            </div>

            <div class="form-group">
              <label for="bonus">Bonus</label>
              <input type="text" id="bonus" name="bonus" required>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
              <button type="submit" class="submit-btn">Submit Salary</button>
            </div>
          </form>
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