<?php
include "layouts/config.php";
session_start();
require 'layouts/check_pm.php';
include 'layouts/head-main.php';
?>

<head>
  <title>
    <?php echo $language["Dashboard"]; ?> | WorkWave - Admin & Dashboard Template
  </title>

  <?php include 'layouts/head.php'; ?>

  <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />

  <?php include 'layouts/head-style.php'; ?>
  <style>
    .form-content {
      padding: 25px;
      /* Adjust padding as needed */
      border-radius: 15px;
      /* Increase border-radius for rounded corners */
      margin: 10px;
      /* Center the content horizontally */
      box-shadow: 0 0 20px 15px rgba(0, 0, 0, 0.1);
      /* Darker shadow */
    }

    table {
      border-collapse: collapse;
      margin-top: 20px;
      padding: 20px;
    }

    th {
      border-bottom: 2px solid #ddd;
      /* Add a bottom border to th and td elements */
    }

    #button1 {
      width: 100%;
      font-weight: bold;
    }

    #button2 {
      width: 100%;
      border-color: blue;
      /* Set border color to blue */
      background-color: white;
      color: blue;
      /* Set font color to blue */
      font-weight: bold;
    }

    .image-container {
      width: 150px;
      height: 150px;
      border-radius: 15px;
      overflow: hidden;
      border: 1px solid #ccc;
    }

    .image-container img {
      width: 100%;
      height: auto;
    }
  </style>
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
              <h4 class="mb-sm-0 font-size-18">Assign Task</h4>

              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <!--<li class="breadcrumb-item"><a href="javascript: void(0);">Assign Task</a></li>-->
                  <li class="breadcrumb-item active">Assign Task</li>
                </ol>
              </div>

            </div>
          </div>
        </div>
        <!-- end page title -->
        <!-- start form -->
        <div class="form-content">
          <div class="row">
            <div class="col-md-12">

              <div class="row">
                <form action="assign_task_bcknd.php" method="POST" enctype="multipart/form-data">


                  <div class="form-data" id="form-data">

                    <div class="employee-container">
                      <div class="row">
                        <div class="col-md-4 mb-3">
                          <label for="Department">Employee</label>
                          <select class="form-control" id="task_emp" name="task_emp[]">
                            <option value="select" disabled selected hidden>Select Employee
                            </option>
                            <?php
                            // include 'layouts/config.php';
                            $d_id = $_SESSION['d_id'];

                            // Assuming you have a connection to your database
                            $sql = "SELECT username,u_id FROM users where d_id = $d_id AND role=4";
                            $result = $link->query($sql);

                            if ($result->num_rows > 0) {
                              while ($row = $result->fetch_assoc()) {
                                $uName = $row['username'];
                                $u_id = $row['u_id'];
                                echo "<option value=\"$u_id\">$uName</option>";
                              }
                            } else {
                              echo "<option value=\"\">No roles found</option>";
                            }
                            ?>
                          </select>

                          <!-- find department id using task id -->
                          <?php
                          $task_id = $_GET['task_id'];
                          $query = "SELECT department FROM task where t_id='$task_id'";
                          $result = mysqli_query($link, $query);
                          if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $d_name = $row['department'];
                          }
                          $query = "SELECT d_id FROM department where d_name='$d_name'";
                          $result = mysqli_query($link, $query);

                          if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $d_id = $row['d_id'];
                          }
                          ?>
                          <?php //echo $task_id 
                          ?>
                          <?php //echo $d_name 
                          ?>
                          <input type="hidden" name="t_id[]" value="<?php echo $task_id ?>">
                          <input type="hidden" name="d_id[]" value="<?php echo $d_id ?>">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <button type="button" class="btn btn-secondary" id="addEmployeeField">+</button>
                    </div>
                    <div class="paste-new-form" id="paste-new-form"></div>
                    <div class="row">
                      <div class="col-md-4 mb-3">
                        <br>
                        <button type="submit" class="btn btn-primary form-control" id="submit" name="submit" style="margin-top: 8px;">Assign Task
                      </div>
                    </div>

                  </div>
              </div>
            </div>

          </div>
          </form>
        </div>
      </div>
      <!-- end form -->
    </div>
  </div> <!-- container-fluid -->
</div>
</div>
<!-- container-fluid -->
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
  $(document).ready(function() {
    var counter = 0;

    $(document).on('click', '.removeEmployeeField', function() {
      $(this).closest('.employee-container:first').remove();
    });

    $(document).on('click', '#addEmployeeField', function() {
      counter++;
      var employeeContainer = $('.employee-container:first').clone();

      // Update IDs to make them unique
      employeeContainer.find('select').attr('id', 'task_emp_' + counter);

      // Clear selected options in the clone
      employeeContainer.find('select').val('select');

      // Add remove button to the clone
      var removeButton =
        '<button type="button" class="btn btn-danger mb-3 removeEmployeeField">Remove</button>';
      employeeContainer.append(removeButton);

      $('#paste-new-form').append(employeeContainer);
    });

    // Remove cloned element
    $(document).on('click', '.removeEmployeeField', function() {
      $(this).closest('.employee-container').remove();
    });
  });
</script>
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

</body>

</html>