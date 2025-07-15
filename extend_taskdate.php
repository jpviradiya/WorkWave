<?php
session_start();
require "layouts/check_pm.php";
include 'layouts/head-main.php';

// Store all GET variables in one container
$getVariables = array(
  'id' => $_GET['task_id'] ?? '',
  'title' => $_GET['tasktitle'] ?? '',
  'description' => $_GET['taskdescription'] ?? '',
  'department' => $_GET['taskdepartment'] ?? '',
  'previousStartDate' => $_GET['previousStartDate'] ?? '',
  'previousEndDate' => $_GET['previousEndDate'] ?? ''
);

?>

<head>
  <title>
    <?php echo $language["Dashboard"]; ?> | WorkWave - Admin & Dashboard Template
  </title>
  <?php include 'layouts/head.php'; ?>
  <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"
    type="text/css" />
  <?php include 'layouts/head-style.php'; ?>
  <style>
  .form-content {
    padding: 25px;
    border-radius: 15px;
    margin: 10px;
    box-shadow: 0 0 20px 15px rgba(0, 0, 0, 0.1);
  }
  </style>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

</head>

<?php include 'layouts/body.php'; ?>
<div id="layout-wrapper">
  <?php include 'layouts/menu.php'; ?>
  <div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
              <h4 class="mb-sm-0 font-size-18">Extend End Date</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item active">Update Task Date</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div class="form-content">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <form action="extend_taskdate_bcknd.php" method="POST" id="taskForm">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="Title">Title</label>
                      <input type="text" class="form-control" id="title" name="title"
                        value="<?php echo $getVariables['title']; ?>" required disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="Description">Description</label>
                      <input type="text" class="form-control" id="description" name="description"
                        value="<?php echo $getVariables['description']; ?>" required disabled>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 mb-3">
                      <label for="Department">Department</label>
                      <!-- <select class="form-control" id="department" name="department" required disabled>
                        <option value="<?php
                        //  echo $getVariables['department'];
                        ?>" disabled></option>
                      </select> -->
                      <input type="text" class="form-control" id="description" name="description"
                        value="<?php echo $getVariables['department']; ?>" required disabled>
                    </div>
                    <!-- start date open -->
                    <div class="col-md-4 mb-3">
                      <label for="startdate">Start Date</label>
                      <input type="text" class="form-control" id="startDate" name="startDate"
                        value="<?php echo $getVariables['previousStartDate']; ?>" required disabled>
                    </div>
                    <!-- start date close -->
                    <!-- end date open -->
                    <div class="col-md-4 mb-3">
                      <label for="enddate">End Date</label>
                      <input type="text" class="form-control" id="new_end_date" name="new_end_date"
                        value="<?php echo $getVariables['previousEndDate']; ?>" required>
                    </div>
                    <!-- end date close -->

                    <!-- passing task id  -->
                    <input type="hidden" name="task_id" value="<?php echo $getVariables['id']; ?>">

                  </div>
                  <div class="row">
                    <div class="col-md-4 mb-3">
                      <br>
                      <button type="submit" class="btn btn-primary form-control" id="submit" name="submit"
                        style="margin-top: 8px;">Extend End Date
                    </div>
                  </div>
                  <div id="error-message" style="color: red;"></div>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
<?php include 'layouts/footer.php'; ?>
<?php include 'layouts/right-sidebar.php'; ?>
<?php include 'layouts/vendor-scripts.php'; ?>
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
<script src="assets/js/app.js"></script>

<!-- datepicker -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var today = new Date();
  var EminDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 1);
  var EmaxDate = new Date(today.getFullYear(), today.getMonth() + 4, 0);

  var endDatePicker = flatpickr("#new_end_date", {
    dateFormat: "Y-m-d",
    minDate: EminDate,
    maxDate: EmaxDate
  });

  var form = document.getElementById('taskForm');
  var endDateInput = document.getElementById('new_end_date');

  form.addEventListener('submit', function(event) {
    // Get the selected end date
    var selectedEndDate = new Date(endDateInput.value);
    // Get today's date
    var today = new Date();

    // Check if the selected end date is before today's date
    if (selectedEndDate <= today) {
      // Prevent the form from submitting
      event.preventDefault();
      // Show an error message
      alert('Extend End Date');
    }
  });
});
</script>
</body>

</html>