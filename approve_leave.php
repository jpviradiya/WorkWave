<?php
include "layouts/config.php";
session_start(); // Start session to get user role
require 'layouts/check_hr.php';
include 'layouts/head-main.php';
?>

<head>
  <title>
    <?php echo $language["Dashboard"]; ?> | Employee Management System
  </title>

  <?php include 'layouts/head.php'; ?>
  <?php include 'layouts/head-style.php'; ?>

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
              <h4 class="mb-sm-0 font-size-18">Approve Leave</h4>

              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Employee Leave</a></li>
                  <!-- <li class="breadcrumb-item active">Dashboard</li>-->
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- end page title -->

        <!-- Add the content and functionality of the "Approve Leave" page here -->
        <div class="content-wrapper" style="min-height: 637.2px;">
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
                      <!-- DataTable -->
                      <table id="example1" class="table table-bordered table-striped dataTable no-footer">
                        <thead>
                          <tr role="row">
                            <!-- Table Headers -->
                            <th>#</th>
                            <th>Emp_id</th>
                            <th>Reason</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Description</th>
                            <th>Applied On</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- Leave Data Goes Here -->
                          <?php
                          // include 'layouts/config.php';
                          
                          // Fetch HR's department
                          $hr_id = $_SESSION['u_id'];
                          $hr_department_query = "SELECT d_id FROM users WHERE u_id = $hr_id";
                          $hr_department_result = mysqli_query($link, $hr_department_query);
                          $hr_department_row = mysqli_fetch_assoc($hr_department_result);
                          $hr_department = $hr_department_row['d_id'];

                          // Fetch leave records with pending status for employees in the same department as HR
                          $sql = "SELECT l.* 
        FROM leave_tbl l
        INNER JOIN users u ON l.emp_id = u.u_id
        WHERE l.status = 2 AND u.d_id = $hr_department";
                          $result = $link->query($sql);

                          // Check if there are any leave records
                          if (mysqli_num_rows($result) > 0) {
                            $rowNumber = 1;

                            while ($row = mysqli_fetch_assoc($result)) {
                              echo '<tr>';
                              echo '<td>' . $rowNumber . '</td>';
                              echo '<td>' . $row['emp_id'] . '</td>';
                              // Add other fields accordingly
                              echo '<td>' . $row['leave_reason'] . '</td>';
                              echo '<td>' . $row['leave_from'] . '</td>';
                              echo '<td>' . $row['leave_to'] . '</td>';
                              echo '<td>' . $row['description'] . '</td>';
                              echo '<td>' . $row['applied_on'] . '</td>';
                              echo '<td>
                                        <form action="approve_leave_bcknd.php" method="post">
                                          <input type="hidden" name="leave_id" value="' . $row['id'] . '">
                                          <button type="submit" name="approve" class="btn btn-success">Approve</button>
                                          <button type="submit" name="reject" class="btn btn-danger">Reject</button>
                                        </form>
                                    </td>';
                              echo '</tr>';

                              $rowNumber++;
                            }
                          } else {
                            echo '<tr class="odd">
                                    <td valign="top" colspan="10">No pending leave requests found.</td>
                                  </tr>';
                          }
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
      <?php include 'layouts/footer.php'; ?>
      <!-- Right Sidebar -->
      <?php include 'layouts/right-sidebar.php'; ?>
      <!-- /Right-bar -->

      <!-- JAVASCRIPT -->
      <?php include 'layouts/vendor-scripts.php'; ?>

      <!-- apexcharts -->
      <script src="http://localhost/EMS-CI/assets/libs/apexcharts/apexcharts.min.js"></script>

      <!-- App js -->
      <script src="assets/js/app.js"></script>



      </body>

      </html>