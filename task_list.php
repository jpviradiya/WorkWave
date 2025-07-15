<?php
session_start();
require 'layouts/check_admin.php';
include 'layouts/head-main.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>
    <?php echo $language["Dashboard"]; ?> | Employee Management System
  </title>
  <?php include 'layouts/head.php'; ?>
  <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"
    type="text/css" />
  <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet"
    type="text/css" />
  <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <?php include 'layouts/head-style.php'; ?>
</head>

<?php include 'layouts/body.php'; ?>

<body>
  <div id="layout-wrapper">
    <?php include 'layouts/menu.php'; ?>
    <div class="main-content">
      <div class="page-content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">View Tasks</h4>
                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">View Tasks</a></li>
                    <li class="breadcrumb-item active">View Tasks</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <section class="content">
            <div class="row">
              <div class="col-xs-12">
                <div class="box box-info">
                  <div class="box-header"></div>
                  <div class="box-body">
                    <div class="table-responsive">
                      <table id="example1" class="table table-bordered table-striped dataTable no-footer">
                        <thead>
                          <tr role="row">
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          include 'layouts/config.php';
                          $u_id = $_SESSION['u_id'];
                          $query = "SELECT * FROM task";
                          $result = mysqli_query($link, $query);

                          if (!$result) {
                            die('Error executing query: ' . mysqli_error($link));
                          }

                          if (mysqli_num_rows($result) > 0) {
                            $rowNumber = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                              echo '<tr>';
                              echo '<td>' . $rowNumber . '</td>';
                              echo '<td>' . $row['t_title'] . '</td>';
                              echo '<td>' . $row['t_description'] . '</td>';
                              echo '<td>' . $row['start_date'] . '</td>';
                              echo '<td>' . $row['end_date'] . '</td>';
                              $status = $row['status'];
                              $statusColor = ($status == 0) ? 'red' : (($status == 1) ? 'green' : 'blue');
                              echo '<td style="color: ' . $statusColor . ';">';
                              echo ($status == 0) ? 'Pending' : (($status == 1) ? 'Working' : 'Completed');
                              echo '</td>';
                              echo '</tr>';
                              $rowNumber++;
                            }
                          } else {
                            echo '<tr><td colspan="7">No data available in the table</td></tr>';
                          }
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
      <?php include 'layouts/footer.php'; ?>
    </div>
  </div>
  <?php include 'layouts/right-sidebar.php'; ?>
  <?php include 'layouts/vendor-scripts.php'; ?>
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
</body>

</html>