<?php
include "layouts/config.php";
session_start(); // Start session to get user role
if ($_SESSION['role'] == 3) {
  // Redirect user to another page or show access denied message
  include 'layouts/head-main.php';
  ?>

  <head>
    <title>
      <?php echo $language["Dashboard"]; ?> | Employee Management System
    </title>
    <?php include 'layouts/head.php'; ?>
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet"
      type="text/css" />
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <?php include 'layouts/head-style.php'; ?>
  </head>

  <?php include 'layouts/body.php'; ?>

  <!-- Begin page -->
  <div id="layout-wrapper">
    <?php include 'layouts/menu.php'; ?>
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
      <div class="page-content">
        <div class="container-fluid">
          <!-- start page title -->
          <div class="row">
            <div class="col-12">
              <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Tasks</h4>
                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Tasks</a></li> -->
                    <li class="breadcrumb-item active">Tasks</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- end page title -->
          <!-- Content Header -->

          <!-- Main Content -->
          <section class="content">
            <div class="row">
              <div class="col-xs-12">
                <div class="box box-info">
                  <div class="box-header">
                  </div>
                  <div class="box-body">
                    <div class="table-responsive">
                      <div class="row">
                      </div>
                      <!-- DataTable -->
                      <table id="example1" class="table table-bordered table-striped dataTable no-footer">
                        <thead>
                          <tr role="row">
                            <!-- Table Headers -->
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          // Include database connection or configuration file
                          // include 'layouts/config.php';
                          $d_id = $_SESSION['d_id'];

                          // Fetch task data from the database where status is not 0 (not assigned)
                          $query = "SELECT * FROM task WHERE department = $d_id AND status = 0";
                          $result = mysqli_query($link, $query);

                          // Check if there are rows in the result
                          if (mysqli_num_rows($result) > 0) {
                            $rowNumber = 1; // Variable to track the row number in the table
                            while ($row = mysqli_fetch_assoc($result)) {
                              $task_id = $row['t_id'];

                              // Output each row in the table
                              echo '<tr>';
                              echo '<td>' . $rowNumber . '</td>';
                              echo '<td>' . $row['t_title'] . '</td>';
                              echo '<td>' . $row['t_description'] . '</td>';
                              echo '<td>' . $row['start_date'] . '</td>';
                              echo '<td>' . $row['end_date'] . '</td>';

                              $status = $row['status'];
                              $statusColor = ($status == 0) ? 'blue' : (($status == 1) ? 'red' : 'green');
                              echo '<td style="color: ' . $statusColor . ';">';
                              // Displaying status based on the value
                              echo ($status == 0) ? 'Not Assigned' : (($status == 1) ? 'Not Started' : (($status == 2) ? 'Working' : 'Completed'));
                              echo '</td>';

                              //action  button
                              echo '<td>';
                              //check assign_task table if task is already available in that db or not 
                              $queryCheckAssign = "SELECT * FROM assign_task where t_id = $task_id";
                              $resultCheckAssign = mysqli_query($link, $queryCheckAssign);

                              // Displaying action buttons based on the status
                              if ($status == 0) {
                                // Status is 0 
                                echo '<a href="assign_task.php?task_id=' . $row['t_id'] . '" class="btn btn-primary">Assign</a>';
                              }

                              echo '</td>';
                              echo '</tr>';
                              $rowNumber++;
                            }
                          } else {
                            //don't uncomment this, throws warning if no data is fetched from db
                            // If no data is available
                            // echo '<tr><td colspan="9">No data available in the table</td></tr>';
                          }

                          // Close the database connection
                          mysqli_close($link);
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
    <!-- end page title -->
    <!-- Content Header -->
  </div>

  <!-- Footer -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 3.4.13
    </div>
    <strong>© 2024</strong> Employee Management System in CodeIgniter Framework
  </footer>
  </div>
  </div>
  <!-- End Page-content -->

  <?php include 'layouts/footer.php'; ?>
  </div>
  <!-- end main content-->
  </div>
  <!-- END layout-wrapper -->

  <!-- Right Sidebar -->
  <?php include 'layouts/right-sidebar.php'; ?>
  <!-- /Right-bar -->

  <!-- JAVASCRIPT -->
  <?php include 'layouts/vendor-scripts.php'; ?>

  <!-- apexcharts -->
  <script src="http://localhost/EMS-CI/assets/libs/apexcharts/apexcharts.min.js"></script>

  <!-- Plugins js-->
  <script src="http://localhost/EMS-CI/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js">
  </script>
  <script
    src="http://localhost/EMS-CI/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js">
    </script>

  <!-- DataTables js -->
  <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
  <!-- DataTables js -->
  <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
  <!-- App js -->
  <script src="assets/js/app.js"></script>
  <!-- Datatable -->
  <script>
    $(document).ready(function () {
      $('#example1').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true
      });
    });
  </script>
  <?php
} else {
  header("Location: login.php");
  exit(); // Stop further execution
}
?>
</body>

</html>