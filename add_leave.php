<?php
include "layouts/config.php";
session_start();
if ($_SESSION['role'] == 3 || $_SESSION['role'] == 4) {
  include 'layouts/head-main.php';
  ?>

<head>
  <title>
    <?php echo $language["Dashboard"]; ?> | Add Leave
  </title>
  <?php include 'layouts/head.php'; ?>
  <?php include 'layouts/head-style.php'; ?>
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
              <h4 class="mb-sm-0 font-size-18">Add Leave</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">WorkWave</a></li> -->
                  <li class="breadcrumb-item active">Add Leave</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div class="content-wrapper" style="min-height: 637.2px;">
          <section class="content">
            <div class="row">
              <div class="col-xs-12">
                <div class="box box-info">
                  <div class="box-header">
                    <h3 class="box-title">Leave Details</h3>
                  </div>
                  <div class="box-body">
                    <form action="process_leave.php" method="post" id="leaveForm">
                      <div class="form-group">
                        <label for="leave_reason">Leave Reason</label>
                        <input type="text" class="form-control" id="leave_reason" name="leave_reason" required>
                      </div>
                      <!-- Replace leave_from and leave_to inputs with Flatpickr -->
                      <div class="form-group">
                        <label for="leave_from">Leave From</label>
                        <div>
                          <input type="text" class="form-control" id="leave_from" name="leave_from" required>
                        </div>
                        <span id="leaveFromError" style="color: red;"></span>
                      </div>
                      <div class="form-group">
                        <label for="leave_to">Leave To</label>
                        <div>
                          <input type="text" class="form-control" id="leave_to" name="leave_to" required>
                        </div>
                        <span id="leaveToError" style="color: red;"></span>
                      </div>
                      <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                      </div>
                      <button type="submit" class="btn btn-primary" style="margin-top:10px;">Submit</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
        <footer class="main-footer">
          <div class="pull-right hidden-xs">
            <b>Version</b> 3.4.13
          </div>
          <strong>© 2024</strong> Employee Management System in CodeIgniter Framework
        </footer>
      </div>
    </div>
  </div>
  <?php include 'layouts/footer.php'; ?>
</div>
<?php include 'layouts/right-sidebar.php'; ?>
<?php include 'layouts/vendor-scripts.php'; ?>

<script src="http://localhost/EMS-CI/assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="http://localhost/EMS-CI/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js">
</script>
<script
  src="http://localhost/EMS-CI/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js">
</script>
<script src="http://localhost/EMS-CI/assets/js/app.js"></script>
<script src="http://localhost/EMS-CI/assets/js/pages/dashboard.init.js"></script>
<script src="http://localhost/EMS-CI/assets/js/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var today = new Date();
  var SminDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
  var SmaxDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 10);

  var startDatePicker = flatpickr("#leave_from", {
    dateFormat: "Y-m-d",
    minDate: SminDate,
    maxDate: SmaxDate,
    onChange: function(selectedDates, selectedDate) {
      // Update the minimum date of the end date picker to be the selected start date
      endDatePicker.set("minDate", selectedDate);
    }
  });

  var endDatePicker = flatpickr("#leave_to", {
    dateFormat: "Y-m-d",
    minDate: "today"
  });

  function validateDates() {
    var leaveFrom = new Date(document.getElementById('leave_from').value);
    var leaveTo = new Date(document.getElementById('leave_to').value);
    var today = new Date();
    var leaveFromError = document.getElementById('leaveFromError');
    var leaveToError = document.getElementById('leaveToError');
    leaveFromError.textContent = '';
    leaveToError.textContent = '';
    if (Date(leaveFrom) < Date(today)) {
      leaveFromError.textContent = "Date must be today or after today's date.";
    }
    if (leaveTo < leaveFrom) {
      leaveToError.textContent = "Date must be after leave from date.";
    }
  }

  document.getElementById('leave_from').addEventListener('change', validateDates);
  document.getElementById('leave_to').addEventListener('change', validateDates);

  document.getElementById('leaveForm').addEventListener('submit', function(event) {
    validateDates();
    var leaveFromError = document.getElementById('leaveFromError').textContent;
    var leaveToError = document.getElementById('leaveToError').textContent;
    if (leaveFromError || leaveToError) {
      event.preventDefault();
      alert("Please correct the errors before submitting the form.");
    }
  });
});
</script>
<!-- Include Feather Icons library -->
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
// Initialize Feather Icons
feather.replace();
</script>

<?php } else {
  header("Location: login.php");
  exit();
} // Stop further execution
?>
</body>

</html>