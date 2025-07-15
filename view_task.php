<?php
include 'layouts/config.php';
session_start(); // Start session to get user role
// require 'layouts/check_admin.php';
// require 'layouts/check_emp.php';
// Redirect to login page if user is not logged in or is an employee
if (!(isset($_SESSION['loggedin'])) || $_SESSION['role'] == 2) {
  header("Location: login.php");
  exit(); // Make sure to exit after redirection
}
include 'layouts/head-main.php';
include 'layouts/head.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['task_id'])) {

  $task_id = $_GET['task_id'];

  // Include database connection or configuration file

  if ($_GET['action'] == 'Start') {
    // Fetch task data from the database
    $query = "SELECT * FROM task WHERE t_id = $task_id";
    $result = mysqli_query($link, $query);

    if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $status = $row['status'];

      // Start Task
      if ($status == 1) {
        $updateQuery1 = "UPDATE task SET status = 2 WHERE t_id = $task_id";
        $updateQuery2 = "UPDATE assign_task SET status = 2 WHERE t_id = $task_id";
        if (mysqli_query($link, $updateQuery1) && mysqli_query($link, $updateQuery2)) {
          // Task started successfully
          header("Location: view_task.php"); // Redirect back to view_tasks.php
          exit();
        } else {
          // Error updating task status
          echo "Error updating task status: " . mysqli_error($link);
          exit();
        }
      }
    } else {
      // Task not found
      echo "Task not found.";
      exit();
    }
  }
  if ($_GET['action'] == 'End') {
    // Fetch task data from the database
    $query = "SELECT * FROM task WHERE t_id = $task_id";
    $result = mysqli_query($link, $query);

    if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $status = $row['status'];
      // End Task
      if ($status == 2) {
        $updateQuery3 = "UPDATE task SET status = 3 WHERE t_id = $task_id";
        $updateQuery4 = "UPDATE assign_task SET status = 3 WHERE t_id = $task_id";
        if (mysqli_query($link, $updateQuery3) && mysqli_query($link, $updateQuery4)) {
          // Task ended successfully
          header("Location: view_task.php"); // Redirect back to view_tasks.php
          exit();
        } else {
          // Error updating task status
          echo "Error updating task status: " . mysqli_error($link);
          exit();
        }
      }
    } else {
      // Task not found
      echo "Task not found.";
      exit();
    }
  }

  if ($_GET['action'] == 'remove') {
    // Fetch task data from the database
    $query = "SELECT * FROM task WHERE t_id = $task_id";
    $result = mysqli_query($link, $query);

    if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $status = $row['status'];
      if ($status == 0 || $status == 1 || $status == 2) {
        // Remove Task
        // Check if end date has been exceeded
        $end_date = $_GET['remove_end_date'];
        $endDate = strtotime($end_date);
        $today = strtotime(date('Y-m-d'));

        if ($endDate < $today) {
          $deleteQuery1 = "DELETE FROM assign_task WHERE t_id = $task_id";
          $deleteQuery2 = "DELETE FROM task WHERE t_id = $task_id";
          if (mysqli_query($link, $deleteQuery1) && mysqli_query($link, $deleteQuery2)) {
            // Task removed successfully
            header("Location: view_task.php"); // Redirect back to view_tasks.php
            exit();
          } else {
            // Error removing task
            echo "Error removing task: " . mysqli_error($link);
            exit();
          }
        }
      } elseif ($status == 3) {
        $deleteQuery3 = "DELETE FROM assign_task WHERE t_id = $task_id";
        $deleteQuery4 = "DELETE FROM task WHERE t_id = $task_id";
        if (mysqli_query($link, $deleteQuery3) && mysqli_query($link, $deleteQuery4)) {
          // Task removed successfully
          header("Location: view_task.php"); // Redirect back to view_tasks.php
          exit();
        } else {
          // Error removing task
          echo "Error removing task: " . mysqli_error($link);
          exit();
        }
      }
    } else {
      // Task not found
      echo "Task not found.";
      exit();
    }
  }
} else {
  echo "db connection error.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>
    <?php echo $language["Dashboard"]; ?> | Employee Management System
  </title>
  <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"
    type="text/css" />
  <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet"
    type="text/css" />
  <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <?php include 'layouts/head-style.php'; ?>
</head>

<?php include 'layouts/body.php'; ?>

<!-- Begin page -->

<body>
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
                <h4 class="mb-sm-0 font-size-18">View Tasks</h4>
                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <!--<li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>-->
                    <li class="breadcrumb-item active">View Tasks</li>
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
                          $u_id = $_SESSION['u_id'];
                          $role = $_SESSION['role'];

                          // Fetch task data from the database based on user role
                          if ($role == 1) {
                            // Query for admin
                            $query = "SELECT * FROM task";
                          } elseif ($role == 3) {
                            // Fetch the PM's department
                            $DEPquery = "SELECT d_id FROM users WHERE u_id=$u_id";
                            $DEPresult = mysqli_query($link, $DEPquery);

                            if ($DEPresult && mysqli_num_rows($DEPresult) > 0) {
                              $DEProw = mysqli_fetch_assoc($DEPresult);
                              $PMdepartment = $DEProw['d_id'];
                            }

                            // Query to select tasks based on the PM's department
                            $query = "SELECT * FROM task WHERE department='$PMdepartment'";
                          } elseif ($role == 4) {
                            // Query for employee
                            $query = "SELECT t.* FROM task t JOIN assign_task a ON t.t_id = a.t_id WHERE a.u_id = '$u_id'";
                          }

                          $result = mysqli_query($link, $query);

                          if (!$result) {
                            die('Error executing query: ' . mysqli_error($link));
                          }

                          // Check if there are rows in the result
                          if (mysqli_num_rows($result) > 0) {
                            $rowNumber = 1; // Variable to track the row number in the table
                            while ($row = mysqli_fetch_assoc($result)) {
                              // Output each row in the table 
                              echo '<tr>';
                              echo '<td>' . $rowNumber . '</td>'; // Assuming 'emp_id' is the employee ID column
                              // Add other fields accordingly
                              echo '<td>' . $row['t_title'] . '</td>';
                              echo '<td>' . $row['t_description'] . '</td>';
                              $departmentID = $row['department'];

                              $sqldep = "SELECT d_name FROM department WHERE d_id='$departmentID'";
                              $resultdep = $link->query($sqldep);
                              if (mysqli_num_rows($resultdep) > 0) {
                                while ($rowdep = mysqli_fetch_assoc($resultdep)) {
                                  $depName = $rowdep['d_name'];
                                }
                              }
                              echo '<td>' . $row['start_date'] . '</td>';
                              echo '<td>' . $row['end_date'] . '</td>';

                              $endDate = strtotime($row['end_date']);
                              $today = strtotime(date('Y-m-d'));

                              // Set status and status color based on end date
                              if ($endDate < $today) {
                                if ($row['status'] == 3) {
                                  echo '<td style="color: blue;">Completed</td>';
                                } else {
                                  // End date has been exceeded
                                  echo '<td style="color: red;">Date Exceeded</td>';
                                }
                              } else {

                                // Set status color based on the task's status value
                                switch ($row['status']) {
                                  case 0:
                                    echo '<td style="color: blue;">Not Assigned</td>';
                                    break;
                                  case 1:
                                    echo '<td style="color: red;">Not Started</td>';
                                    break;
                                  case 2:
                                    echo '<td style="color:green;">Working</td>';
                                    break;
                                  case 3:
                                    echo '<td style="color: green;">Completed</td>';
                                    break;
                                  default:
                                    $statusColor = 'black';
                                    break;
                                }
                              }

                              // Output status column
                              // echo '<td style="color: ' . $statusColor . ';">' . $status . '</td>';
                              $status = $row['status'];
                              //Action column
                              if ($role == 3) {
                                // Check if end date has been exceeded
                                if ($endDate < $today) {
                                  // Action buttons for pm if task end date is exceeded 
                                  // Action buttons for extending end date and removing task
                                  echo '<td>';
                                  echo '<a href="extend_taskdate.php?task_id=' . $row['t_id'] . '&action=extend&tasktitle=' . $row['t_title'] . '&taskdescription=' . $row['t_description'] . '&taskdepartment=' . $depName . '&previousStartDate=' . $row['start_date'] . '&previousEndDate=' . $row['end_date'] . '" class="btn btn-success">Extend Date</a> ';
                                  echo '<a href="?task_id=' . $row['t_id'] . '&action=remove&remove_end_date=' . $row['end_date'] . '" class="btn btn-danger">Remove</a>';
                                  echo '</td>';
                                } else {
                                  if ($status == 3 || $status == 0) {
                                    //Message for admin or pm if task is on working phase(employee started working on task)
                                    echo '<td>';
                                    echo '<a href="?task_id=' . $row['t_id'] . '&action=remove" class="btn btn-danger">Remove</a>';
                                    echo '</td>';
                                  } elseif ($status == 1) {
                                    echo '<td style="color: blue;">waiting..</td>';
                                  } else {
                                    echo '<td style="color: blue;">waiting..</td>';
                                  }
                                }
                              } elseif ($role == 1) {
                                // Check if end date has been exceeded
                                if ($endDate < $today) {
                                  // Action buttons for admin if task end date is exceeded 
                                  // Action buttons for removing task
                                  echo '<td>';
                                  echo '<a href="?task_id=' . $row['t_id'] . '&action=remove&remove_end_date=' . $row['end_date'] . '" class="btn btn-danger">Remove</a>';
                                  echo '</td>';
                                } else {
                                  if ($status == 3 || $status == 0) {
                                    //Message for admin or pm if task is on working phase(employee started working on task)
                                    echo '<td>';
                                    echo '<a href="?task_id=' . $row['t_id'] . '&action=remove" class="btn btn-danger">Remove</a>';
                                    echo '</td>';

                                  } elseif ($status == 1) {
                                    echo '<td style="color: blue;">waiting..</td>';
                                  } else {
                                    echo '<td style="color: blue;">waiting..</td>';
                                  }
                                }
                              }
                              if ($role == 4) {
                                if ($endDate < $today) {
                                  echo '<td style="color: red;">Incomplete</td>';
                                } else {

                                  if ($status == 1) {
                                    // Action buttons for employee only if the task is not started
                                    // Action Button for employee to start the task
                                    echo '<td>';
                                    echo '<a href="?task_id=' . $row['t_id'] . '&action=Start" class="btn btn-success">Start</a>';
                                    echo '</td>';
                                  } elseif ($status == 2) {
                                    // Action buttons for employee only if the task is in working phase(started)
                                    // Action Button for employee to end the task
                                    echo '<td>';
                                    echo '<a href="?task_id=' . $row['t_id'] . '&action=End" class="btn btn-warning">End</a>';
                                    echo '</td>';
                                  } elseif ($status == 3) {
                                    // Action buttons for employee only if the task completed
                                    echo '<td style="color: blue;">Completed</td>';
                                  }
                                }
                              }
                              echo '</tr>';
                              $rowNumber++;
                            }
                          } else {
                            //don't uncomment this, throws warning if no data is fetched from db
                            // If no data is available
                            // echo '<tr><td colspan="9">No data available in the table</td></tr>';
                          }

                          // Close the database connection
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
        <!-- Footer -->

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

  <!-- App js -->
  <script src="assets/js/app.js"></script>
  <!-- DataTables js -->
  <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
  <script>
    $.fn.dataTable.ext.errMode = 'none';

    $(document).ready(function () {
      $('#example1').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
  <!-- Datatable -->
</body>

</html>