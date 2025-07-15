<?php
session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) {
  header("location: login.php");
}
include 'layouts/head-main.php';
include "layouts/config.php";
?>


<head>

  <title>
    <?php echo $language["Dashboard"]; ?> | Minia - Admin & Dashboard Template
  </title>

  <?php include 'layouts/head.php'; ?>


  <!-- <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />-->


  <?php include 'layouts/head-style.php'; ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<?php include 'layouts/body.php'; ?>


<!-- Begin page -->


<div id="layout-wrapper">

  <?php include 'layouts/menu.php'; ?>


  <div class="main-content">
    <div class="page-content">
      <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
          <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
              <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">WorkWave</a></li>
                  <li class="breadcrumb-item active">Dashboard</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <!-- Boxes -->
        <div class="row">
          <div class="col-md-3">
            <div class="card bg-c-blue order-card">
              <div class="card-body">
                <h5 class="m-b-20">No of Employees</h5>
                <h2 class="text-right"><i class="fa-solid fa-users"></i>
                  <span class="numbers">
                    <?php
                    $query = "SELECT COUNT(*) AS total_users FROM users WHERE role != 1";
                    $result = mysqli_query($link, $query);
                    if ($result) {
                      $row = mysqli_fetch_assoc($result);
                      echo $row['total_users'];
                    } else {
                      echo "Undefined";
                    }
                    ?>
                  </span>
                </h2>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card bg-c-green order-card">
              <div class="card-body">
                <h5 class="m-b-20">No of Department</h5>
                <h2 class="text-right">
                  <i class="fa-solid fa-building-user"></i>
                  <span class="numbers">
                    <?php
                    $query = "SELECT COUNT(*) AS total_departments FROM department";
                    $result = mysqli_query($link, $query);
                    if ($result) {
                      $row = mysqli_fetch_assoc($result);
                      echo $row['total_departments'];
                    } else {
                      echo "Undefined";
                    }
                    ?>
                  </span>
                </h2>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card bg-c-yellow order-card">
              <div class="card-body">
                <h5 class="m-b-20">No of Active Task</h5>
                <h2 class="text-right"><i class="fa-solid fa-list-check"></i>
                  <span class="numbers">
                    <?php
                    $query = "SELECT COUNT(*) AS total_active_task FROM task where status=2";
                    $result = mysqli_query($link, $query);
                    if ($result) {
                      $row = mysqli_fetch_assoc($result);
                      echo $row['total_active_task'];
                    } else {
                      echo "Undefined";
                    }
                    ?>
                  </span>
                </h2>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card bg-c-pink order-card">
              <div class="card-body">
                <h5 class="m-b-20">Total Salary Given</h5>
                <h2 class="text-right"><i class="fa-solid fa-indian-rupee-sign" style="font-size:25px;"></i>
                  <span class="numbers">
                    <?php
                    $query = "SELECT total_salary_paid FROM users where u_id!=1";
                    $result = mysqli_query($link, $query);
                    $total_salary_given = 0;
                    if ($result) {
                      while ($row = mysqli_fetch_assoc($result)) {
                        $total_salary_given += $row['total_salary_paid'];
                      }
                      echo $total_salary_given;
                    } else {
                      echo "Undefined";
                    }
                    ?>
                  </span>
                </h2>
              </div>
            </div>
          </div>
        </div>

        <!-- Charts -->
        <div class="row mt-4">
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <h4 class="header-title">No of Attendance Taken</h4>
                <div id="chart1"></div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <h4 class="header-title">No of Leave Taken</h4>
                <div id="chart2"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- Charts -->

      </div>
      <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    <?php
    mysqli_close($link);
    ?>
    <?php include 'layouts/footer.php'; ?>
  </div>
  <!-- end main content-->

</div>
<!-- END layout-wrapper -->
</div>
<!-- Right Sidebar -->
<?php include 'layouts/right-sidebar.php'; ?>
<!-- /Right-bar -->

<!-- JAVASCRIPT -->
<?php include 'layouts/vendor-scripts.php'; ?>

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- Plugins js-->
<script src="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>

<!-- dashboard init -->
<script src="assets/js/pages/dashboard.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
  // Function to fetch data from PHP script for attendance chart
  function fetchAttendanceData() {
    fetch('fetch_attendance_chart.php')
      .then(response => response.json())
      .then(data => {
        // Update chart options with fetched data
        var options1 = {
          chart: {
            height: 400,
            type: 'line',
          },
          series: [{
            name: 'Attendance',
            data: data
          }],
          xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
          }
        };

        var chart1 = new ApexCharts(document.querySelector("#chart1"), options1);
        chart1.render();
      })
      .catch(error => {
        console.error('Error fetching attendance data:', error);
      });
  }

  // Function to fetch data from PHP script for leave chart
  function fetchLeaveData() {
    fetch('fetch_leave_chart.php')
      .then(response => response.json())
      .then(data => {
        // Update chart options with fetched data
        var options2 = {
          chart: {
            height: 400,
            type: 'line',
          },
          series: [{
            name: 'Leave',
            data: data
          }],
          xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
          }
        };

        var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
        chart2.render();
      })
      .catch(error => {
        console.error('Error fetching leave data:', error);
      });
  }

  // Call functions to fetch data for each chart
  fetchAttendanceData();
  fetchLeaveData();
</script>

<style>
  .numbers {
    margin-left: 15px;
  }

  .bg-c-blue {
    background-color: #007bff;
    color: #fff;
  }

  .bg-c-green {
    background-color: #28a100;
    color: #fff;
  }

  .bg-c-yellow {
    background-color: #ffc107;
    color: #fff;
  }

  .bg-c-pink {
    background-color: #e83e8c;
    color: #fff;
  }

  .order-card {
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    height: 80%;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .icon-big {
    font-size: 36px;
    margin-bottom: 10px;
  }

  .order-card h2 {
    margin-top: 10px;
  }
</style>

</body>

</html>