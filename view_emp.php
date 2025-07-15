<?php
include 'layouts/session.php';
include 'layouts/head-main.php';
include 'layouts/config.php';

/// Assuming you have a linkection to the database
// Check linkection status
if ($link->connect_error) {
  die("linkection failed: " . $link->connect_error);
}

// Get logged-in user's department ID from session
session_start();
$user_department_id = $_SESSION['d_id'];
if ($user_department_id == 11) {
  $sql = "SELECT username, u_id, profile_image FROM users";
  $result = $link->query($sql);
} else {
  // Fetch users belonging to the same department as the logged-in user
  $sql = "SELECT username, u_id, profile_image FROM users WHERE d_id = $user_department_id";
  $result = $link->query($sql);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>User Grid | Minia - Admin & Dashboard Template</title>
  <?php include 'layouts/head.php'; ?>
  <?php include 'layouts/head-style.php'; ?>
</head>

<body>

  <?php include 'layouts/body.php'; ?>

  <div id="layout-wrapper">
    <?php include 'layouts/menu.php'; ?>
    <div class="main-content">
      <div class="page-content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">View Employees</h4>
                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <!--<li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>-->
                    <li class="breadcrumb-item active">View Employees</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!--<div class="row mb-3">
                        <div class="col-md-4">
                            <label for="department">Select Department:</label>
                            <select class="form-control" id="department" name="department">
                                <option value="">All Departments</option>
                                <?php
                                // Fetch department data from the database
                                /*
                                $department_query = "SELECT * FROM department";
                                $department_result = mysqli_query($link, $department_query);
                                $selected_dept = isset($_GET['department']) ? $_GET['department'] : '';
                                while ($dept_row = mysqli_fetch_assoc($department_result)) {
                                    $selected = ($selected_dept == $dept_row['d_id']) ? 'selected' : '';
                                    echo "<option value='{$dept_row['d_id']}' $selected>{$dept_row['d_name']}</option>";
                                }*/
                                ?>
                            </select>
                        </div>
                    </div>-->
          <div class="row">
            <?php
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo '<div class="col-xl-3 col-sm-6">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div class="dropdown text-end">
                                                <a class="text-muted dropdown-toggle font-size-16" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"></a>
                                            </div>
                                            <div class="mx-auto mb-4">
                                                <img src="' . $row['profile_image'] . '" alt="Profile Image" class="avatar-xl rounded-circle img-thumbnail">
                                            </div>
                                            <h5 class="font-size-16 mb-1"><a href="#" class="text-body">' . $row['username'] . '</a></h5>
                                            <p class="text-muted mb-2">' . $row['u_id'] . '</p>
                                            <a href="emp_profile.php?id=' . $row['u_id'] . '">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-outline-light text-truncate"><i class="uil uil-user me-1"></i> Profile</button>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>';
              }
            } else {
              echo "No records found";
            }


            ?>
          </div>
        </div>
      </div>

      <!-- Rest of your HTML content -->

      <?php include 'layouts/footer.php'; ?>
    </div>
  </div>

  <!-- Right Sidebar -->
  <?php include 'layouts/right-sidebar.php'; ?>
  <!-- /Right-bar -->

  <!-- JAVASCRIPT -->
  <?php include 'layouts/vendor-scripts.php'; ?>
  <script src="assets/js/app.js"></script>
</body>

</html>