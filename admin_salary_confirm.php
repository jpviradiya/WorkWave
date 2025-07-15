<?php
session_start(); // Start session to get user role
include 'layouts/check_admin.php';
include 'layouts/head-main.php';
include 'layouts/config.php';
include 'layouts/head.php';
if (isset($_GET['id'])) {
  $record_id = $_GET['id'];
  $today_date = date('Y-m-d');
  // Construct the SQL UPDATE query
  $update_query = "UPDATE salaries SET admin_status = 1, payment_date = '$today_date' WHERE id = $record_id";

  // Execute the update query
  if (mysqli_query($link, $update_query)) {
    // Update successful
    echo "Admin status updated successfully.";
  } else {
    // Update failed
    echo "Error updating admin status: " . mysqli_error($link);
  }
} else {
  // Handle case where ID is not provided
  echo "Record ID not provided.";
}// Include database configuration file
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

<body>
  <div id="layout-wrapper">
    <?php include 'layouts/menu.php'; ?>
    <div class="main-content">
      <div class="page-content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Confirm Salary</h4>
                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <!--<li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>-->
                    <li class="breadcrumb-item active">Confirm Salary</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-4">
              <label for="department">Select Department:</label>
              <select class="form-control" id="department" name="department">
                <option value="">All Departments</option>
                <?php
                // Fetch department data from the database
                $department_query = "SELECT * FROM department";
                $department_result = mysqli_query($link, $department_query);
                $selected_dept = isset($_GET['department']) ? $_GET['department'] : '';
                while ($dept_row = mysqli_fetch_assoc($department_result)) {
                  $selected = ($selected_dept == $dept_row['d_id']) ? 'selected' : '';
                  echo "<option value='{$dept_row['d_id']}' $selected>{$dept_row['d_name']}</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-info">
                <div class="box-header"></div>
                <div class="box-body">
                  <div class="table-responsive">
                    <div class="row"></div>
                    <div class="row">
                      <div class="col-12">
                        <div class="card">
                          <div class="card-header">
                            <h4 class="card-title">Records</h4>
                          </div>
                          <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                              <thead>
                                <tr>
                                  <th>Sr no.</th>
                                  <th>Profile Img</th>
                                  <th>Emp ID</th>
                                  <th>Username</th>
                                  <th>Role</th>
                                  <th>Month</th>
                                  <th>Year</th>
                                  <th>Base Salary</th>
                                  <th>Deduction</th>
                                  <th>Allowance</th>
                                  <th>Final Salary</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                // Modify your query to include the department filter
                                $query = "SELECT s.id, s.*, u.username, u.profile_image, r.r_name FROM salaries s 
          INNER JOIN users u ON s.u_id = u.u_id
          INNER JOIN role r ON u.role = r.r_id
          WHERE s.hr_status = 1 AND s.admin_status = 0";  // Add this condition to filter based on hr_status
                                
                                if (isset($_GET['department']) && !empty($_GET['department'])) {
                                  $dept_id = $_GET['department'];
                                  $query .= " AND u.d_id = $dept_id"; // Add department filter if needed
                                }
                                $result = mysqli_query($link, $query);
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                  echo "<tr>";
                                  echo "<td>$i</td>";
                                  echo "<td><img src='{$row['profile_image']}' alt='Profile Image' style='width: 50px; height: 50px;'></td>";
                                  echo "<td>{$row['u_id']}</td>";
                                  echo "<td>{$row['username']}</td>";
                                  echo "<td>{$row['r_name']}</td>";
                                  echo "<td>{$row['month']}</td>";
                                  echo "<td>{$row['year']}</td>";
                                  echo "<td>{$row['base_salary']}</td>";
                                  echo "<td>{$row['deduction']}</td>";
                                  echo "<td>{$row['allowance']}</td>";
                                  echo "<td>{$row['final_salary']}</td>";

                                  echo '<td>';

                                  echo "<a href='admin_salary_confirm.php?id={$row['id']}' class='btn btn-warning'>Confirm</a>";

                                  echo '</td>';
                                  echo "</tr>";
                                  $i++;
                                }
                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
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
    </div>
  </div>
  <?php include 'layouts/right-sidebar.php'; ?>
  <?php include 'layouts/vendor-scripts.php'; ?>
  <!-- Responsive examples -->
  <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
  <script src="assets/js/pages/datatables.init.js"></script>
  <script src="assets/js/app.js"></script>
  <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
  <script>
    $.fn.dataTable.ext.errMode = 'none';
    $(document).ready(function () {
      $('#datatable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
      // JavaScript function to filter records based on department selection
      $('#department').change(function () {
        var dept_id = $(this).val();
        window.location.href = 'admin_salary_confirm.php?department=' + dept_id;
      });
    });
  </script>
</body>

</html>