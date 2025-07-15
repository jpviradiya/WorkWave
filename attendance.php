<?php
include 'layouts/head-main.php';
include 'layouts/config.php';
?>

<head>
  <title>
    <?php echo $language["Dashboard"]; ?> | WorkWave - Admin & Dashboard Template
  </title>

  <?php include 'layouts/head.php'; ?>

  <!-- FullCalendar CSS -->
  <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />

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
              <h4 class="mb-sm-0 font-size-18">Attendance</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <!--<li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>-->
                  <li class="breadcrumb-item active">Attendance</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- end page title -->

        <!-- Employee Dropdown -->
        <?php

        switch ($_SESSION['role']) {
          case '1':
            echo '<div class="row mb-3">';
            echo '<div class="col-md-4">';
            echo '<label for="departmentDropdown" class="form-label">Select Department:</label>';
            echo '<select class="form-select" id="departmentDropdown" name="departmentDropdown">';
            echo '<option value=\'\'>Select Deprtment</option>';
            $sql = "SELECT d_name,d_id FROM department";
            $result = $link->query($sql);
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $depName = $row['d_name'];
                $d_id = $row['d_id'];
                echo "<option value=\"$d_id\">$depName</option>";
              }
            } else {
              echo "<option>No roles found</option>";
            }
            echo '</select>';
            echo '</div>';
            echo '<div class="col-md-4">';
            echo '<label for="employeeDropdown" class="form-label">Select Employee:</label>';
            echo '<select class="form-select" id="emp_id" name="Employee">';
            echo '<option value=\'\'>Select Employee</option>';
            echo '</select>';
            echo '</div>';
            echo '</div>';

            $link->close();
            break;
          case '2':
            echo '<div class="col-md-4">';
            echo '<label for="employeeDropdown" class="form-label">Select Employee:</label>';
            echo '<select class="form-select" id="emp_id" name="Employee">';
            echo '<option value=\'\'>Select Employee</option>';
            $d_id = $_SESSION['d_id'];
            $sql = "SELECT u_id,username FROM users where d_id = $d_id";
            $result = $link->query($sql);
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $username = $row['username'];
                $u_id = $row['u_id'];
                echo "<option value=\"$u_id\">$username</option>";
              }
            } else {
              echo "<option>No Employee found</option>";
            }
            echo '</select>';
            echo '</div>';
            echo '</div>';
            break;


          case '3':
          case '4':
            echo "<input type='hidden' name='emp_id' id='emp_id' value=\"{$_SESSION['u_id']}\">";
            break;
        }
        ?>

        <!-- FullCalendar container -->
        <div class="row">
          <div class="col-md-12">
            <div id="calendar"></div>
          </div>
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
<?php include 'layouts/vendor-scripts.php'; ?>
<!-- App js -->
<script src="assets/js/app.js"></script>
<!-- FullCalendar JS -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>


<script>
  $(document).ready(function() {

    //! Initialize FullCalendar
    var calendar = $('#calendar').fullCalendar({
      header: {
        left: null,
        center: 'title',
        right: 'prev,next today'
      },
      events: function(start, end, timezone, callback) {
        var selectedEmployeeId = $('#emp_id').val();
        fetchEmployeeAttendanceDetails(selectedEmployeeId, start.format(), end.format(),
          callback);
      },
      eventRender: function(event, element) {
        // Customize the rendering based on attendance status
        if (event.status === 'absent') {
          element.css('background-color', 'red');
        } else if (event.status === 'half-day') {
          element.css('background-color', '#e69138');
        } else if (event.status === 'present') {
          element.css('background-color', 'green');
        } else if (event.status === 'holiday') {
          element.css('background-color', '#94c4ca');
        }
      }
    });

    //? Bind change event to the department dropdown
    $('#departmentDropdown').change(function() {
      var selectedDepartmentId = $(this).val();
      if (selectedDepartmentId !== '') {
        fetchEmployees(selectedDepartmentId);
      } else {
        $('#emp_id').empty(); // Clear employee dropdown if no department is selected
      }
    });

    //? Function to fetch employees based on department
    function fetchEmployees(departmentId) {
      $.ajax({
        url: 'fetch_employees.php',
        type: 'POST',
        dataType: 'json',
        data: {
          departmentId: departmentId
        },
        success: function(response) {
          // Populate employee dropdown with fetched employees
          populateEmployeesDropdown(response);
        },
        error: function(xhr, status, error) {
          console.error('Error fetching employees:', error);
        }
      });
    }

    //? Function to populate employee dropdown
    function populateEmployeesDropdown(employees) {
      var empDropdown = $('#emp_id');
      empDropdown.empty();
      empDropdown.append($('<option></option>').attr('value', "").text("Select Employee"))
      $.each(employees, function(index, employee) {
        empDropdown.append($('<option></option>').attr('value', employee.id).text(employee.name));
      });
    }


    // Bind change event to the employee dropdown
    $('#emp_id').change(function() {
      // Update calendar when the selected employee changes
      var selectedEmployeeId = $(this).val();
      calendar.fullCalendar('refetchEvents');
    });

    //! Fetch and populate events dynamically from the backend
    function fetchEmployeeAttendanceDetails(employeeId, start, end, callback) {
      $.ajax({
        url: 'fetch_attendance.php',
        type: 'POST',
        dataType: 'json',
        data: {
          employeeId: employeeId,
          start: start,
          end: end
        },
        success: function(response) {
          // Parse the response data and update the FullCalendar events
          var events = parseAttendanceData(response);
          callback(events);
        },
        error: function(xhr, status, error) {
          console.error('Error fetching attendance data:', error);
        }
      });
    }

    function parseAttendanceData(data) {
      // Format the data into FullCalendar events array
      return data.map(function(attendance) {
        // Check if the day is a holiday
        if (attendance.status !== 'holiday') {
          return {
            title: attendance.title,
            start: attendance.start,
            status: attendance.status // Additional property for custom rendering
          };
        } else if (attendance.status === 'holiday') {
          return {
            title: 'Holiday',
            start: attendance.start,
            status: attendance.status // Additional property for custom rendering
          };
        }
      });
    }

  });
</script>
</body>

</html>