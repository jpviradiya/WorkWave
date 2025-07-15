<?php
include "layouts/config.php";
session_start();
include 'layouts/check_hr.php';
include 'layouts/head-main.php';
?>

<head>

  <title>DataTables | WorkWave Admin & Dashboard Template</title>
  <?php include 'layouts/head.php'; ?>

  <!-- DataTables -->
  <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

  <!-- Responsive datatable examples -->
  <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet"
    type="text/css" />

  <?php include 'layouts/head-style.php'; ?>

  <style>
  td {
    text-align: center;
  }
  </style>

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
              <h4 class="mb-sm-0 font-size-18">Confirm Salary</h4>

              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item active">Confirm Salary</li>
                </ol>
              </div>

            </div>
          </div>
        </div>
        <!-- end page title -->

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Records</h4>

              </div>
              <div class="card-body">
                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                  <thead>
                    <tr>
                      <th>Sr no.</th>
                      <th>Profile Img</th>
                      <th>Emp ID</th>
                      <th>Username</th>
                      <th>Role</th>
                      <th>Department</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    // Assuming you have a database connection established
                    // include 'layouts/config.php';
                    
                    // Fetch HR's department
                    $hr_id = $_SESSION['u_id'];
                    $hr_department_query = "SELECT d_id FROM users WHERE u_id = $hr_id";
                    $hr_department_result = mysqli_query($link, $hr_department_query);
                    $hr_department_row = mysqli_fetch_assoc($hr_department_result);
                    $hr_department = $hr_department_row['d_id'];

                    // Query to select employees from the same department as HR
                    $query = "SELECT u.u_id, u.username, u.role, u.profile_image, u.d_id 
                              FROM users u
                              WHERE u.d_id = $hr_department";

                    $result = mysqli_query($link, $query);


                    if (!$result) {
                      die('Error executing query: ' . mysqli_error($link));
                    }

                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result))
                    // if(!($row['u_id']==$hr_id)){{  //! To prevent HR itself from displaying
                    {
                      $sql = "SELECT d_name FROM department WHERE d_id={$row['d_id']}";
                      $resultRole = $link->query($sql);
                      if ($resultRole->num_rows > 0) {
                        while ($rowRole = $resultRole->fetch_assoc()) {
                          $depName = $rowRole['d_name'];
                        }
                      }
                      $sql = "SELECT r_name FROM role WHERE r_id={$row['role']}";
                      $resultRole = $link->query($sql);

                      if ($resultRole->num_rows > 0) {
                        while ($rowRole = $resultRole->fetch_assoc()) {
                          $roleName = $rowRole['r_name'];
                        }
                      }
                      echo "<tr>";
                      echo "<td>$i</td>";
                      echo "<td>";
                      echo "<div style='width: 75px; height: 75px; overflow: hidden; border-radius: 20%; border: 2px solid #ddd; margin: 0 auto; display: flex; justify-content: center; align-items: center;'>";
                      echo "<img style='width: 100%; height: 100%; object-fit: cover;' src='{$row['profile_image']}' alt='Profile Image'>";
                      echo "</div>";
                      echo "</td>";
                      echo "<td>{$row['u_id']}</td>";
                      echo "<td>{$row['username']}</td>";
                      echo "<td>{$roleName}</td>";
                      echo "<td>{$depName}</td>";
                      // Displaying action buttons based on the status
                      echo '<td>';
                      echo '<a href="hr_salary_confirm.php?u_id=' . $row['u_id'] . '" class="btn btn-primary"><i data-feather="check"></i></a>';

                      echo '</td>';
                      echo "</tr>";
                      $i++;
                    }

                    $link->close();
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div> <!-- end col -->
        </div> <!-- end row -->


      </div> <!-- container-fluid -->
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

<!-- Required datatable js -->
<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="assets/libs/jszip/jszip.min.js"></script>
<script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

<!-- Responsive examples -->
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

<!-- Datatable init js -->
<script src="assets/js/pages/datatables.init.js"></script>

<script src="assets/js/app.js"></script>

</body>

</html>