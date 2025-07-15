<?php
session_start(); 
require_once 'layouts/check_hr.php';// Start session to get user role
include 'layouts/head-main.php';
include 'layouts/config.php'; // Include database configuration file



// Check if the u_id parameter is provided in the URL
if (isset($_GET['id']) && isset($_GET['u_id']) && isset($_GET['month']) && isset($_GET['year'])) {
    $id = $_GET['id'];
    $u_id = $_GET['u_id'];
    $month = $_GET['month'];
    $year = $_GET['year'];

    $query2 = "SELECT username FROM users WHERE u_id = $u_id";
    $result2 = mysqli_query($link, $query2);
    $row2 = mysqli_fetch_assoc($result2);

    // Fetch record details based on the provided u_id
    $query = "SELECT * FROM salaries WHERE id=$id AND u_id = $u_id AND month = '$month' AND year = $year";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_assoc($result);

    // Check if the record exists
    if ($row) {

?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <title>Edit Record | Employee Management System</title>
            <?php include 'layouts/head.php'; ?>
            <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
            <?php include 'layouts/head-style.php'; ?>
            <!-- Additional styles/scripts if needed -->
            <style>
                .form-content {
                    padding: 25px;
                    border-radius: 15px;
                    margin: 10px;
                    box-shadow: 0 0 20px 15px rgba(0, 0, 0, 0.1);
                }
            </style>
        </head>

        <body>
            <div id="layout-wrapper">
                <?php include 'layouts/menu.php'; ?>
                <div class="main-content">
                    <div class="page-content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box">
                                        <h4 class="page-title">Edit Record</h4>
                                    </div>
                                </div>
                            </div>

                            <section class="form-content">


                                <div class="row">
                                    <form method="POST" action="post_update_data.php">

                                        <!-- Your form fields here -->
                                        <input type="hidden" name="month" value="<?php echo $month; ?>">
                                        <input type="hidden" name="year" value="<?php echo $year; ?>">
                                        <input type="hidden" name="u_id" value="<?php echo $u_id; ?>">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">


                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="yearDropdown" class="form-label">Select Year:</label>
                                                <select class="form-select" id="yearDropdown" name="yearDropdown">
                                                    <?php
                                                    // Get the current year
                                                    $currentYear = date("Y");

                                                    // Set the range of years you want to display
                                                    $startYear = $currentYear - 2;
                                                    $endYear = $currentYear;

                                                    // Generate options for the year dropdown
                                                    for ($year = $startYear; $year <= $endYear; $year++) {
                                                        echo "<option value='$year'>$year</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- Add code to populate the month dropdown with the selected month -->
                                            <div class="col-md-4">
                                                <label for="monthDropdown" class="form-label">Select Month:</label>
                                                <select class="form-select" id="monthDropdown" name="monthDropdown">
                                                    <option value="January">January</option>
                                                    <option value="February">February</option>
                                                    <option value="March">March</option>
                                                    <option value="April">April</option>
                                                    <option value="May">May</option>
                                                    <option value="June">June</option>
                                                    <option value="July">July</option>
                                                    <option value="August">August</option>
                                                    <option value="September">September</option>
                                                    <option value="October">October</option>
                                                    <option value="November">November</option>
                                                    <option value="December">December</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="allowance">Username:</label>
                                                <input type="text" class="form-control" name="username" value='<?php echo $row2['username']; ?>' readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="uId">Employee ID:</label>
                                                <input type="text" class="form-control" id="uId" name="uId" value='<?php echo $row['u_id']; ?>' readonly>
                                            </div>
                                        </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="baseSalary">Base Salary:</label>
                                        <input type="text" class="form-control" id="baseSalary" name="baseSalary" value='<?php echo $row['base_salary']; ?>' readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="deduction">Deduction:</label>
                                        <input type="text" class="form-control" id="deduction" name="deduction" value='<?php echo $row['deduction']; ?>'>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="allowance">Allowance:</label>
                                        <input type="text" class="form-control" id="allowance" name="allowance" value='<?php echo $row['allowance']; ?>'>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3><label for="finalSalary">Final Salary:</label></h3>
                                        <input type="text" class="form-control" id="finalSalary" name="finalSalary" value='<?php echo $row['final_salary']; ?>' readonly>
                                    </div>
                                </div>
                                <br>
                                <button id="confirmButton" class="btn btn-primary">Confirm</button>
                                </form>
                        </div>

                        </section>


                    </div>
                </div>
                <?php include 'layouts/footer.php'; ?>
            </div>
            </div>
            <?php include 'layouts/right-sidebar.php'; ?>
            <?php include 'layouts/vendor-scripts.php'; ?>
            <!-- Additional scripts if needed -->
        </body>

        </html>
        <script>
            $(document).ready(function() {
                $('#employeeDropdown').change(function() {
                    var selectedEmployee = $(this).val(); // Get the selected employee username
                    if (selectedEmployee) {
                        $.ajax({
                            type: 'POST',
                            url: 'get_employees.php', // PHP script to fetch employee information
                            data: {
                                username: selectedEmployee
                            },
                            success: function(response) {
                                var data = JSON.parse(response);
                                // Update the base salary and u_id fields with the fetched data
                                $('#baseSalary').val(data.baseSalary);
                                $('#uId').val(data.u_id);
                            }
                        });
                    } else {
                        $('#baseSalary').val(''); // Clear the base salary field if no employee is selected
                        $('#uId').val(''); // Clear the u_id field if no employee is selected
                    }
                });

                // Handle change event for the month dropdown
                $('#monthDropdown').change(function() {
                    // You can perform additional actions here based on the selected month
                });

                // Handle input change events for deduction and allowance fields
                $('#deduction, #allowance').on('input', function() {
                    // Calculate the final salary based on deduction, allowance, and base salary
                    var baseSalary = parseFloat($('#baseSalary').val());
                    var deduction = parseFloat($('#deduction').val()) || 0;
                    var allowance = parseFloat($('#allowance').val()) || 0;
                    var finalSalary = baseSalary - deduction + allowance;
                    $('#finalSalary').val(finalSalary.toFixed(2));
                });

                // Handle click event for the confirm button
                $('#confirmButton').click(function() {
                    // You can perform actions here when the confirm button is clicked
                });
            });

            $(document).ready(function() {
                $('#departmentDropdown').on('change', function() {
                    var departmentId = $(this).val(); // Get the selected department ID
                    if (departmentId) {
                        $.ajax({
                            type: 'POST',
                            url: 'get_employees.php', // PHP script to fetch employees based on department
                            data: {
                                d_id: departmentId
                            },
                            success: function(html) {
                                $('#employeeDropdown').html(html); // Update employee dropdown with new options
                            }
                        });
                    } else {
                        $('#employeeDropdown').html('<option value="">Select Department First</option>'); // If no department is selected, reset employee dropdown
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                // Handle input change events for deduction and allowance fields
                $('#deduction, #allowance').on('input', function() {
                    calculateFinalSalary(); // Calculate final salary when deduction or allowance changes
                });

                // Function to calculate final salary
                function calculateFinalSalary() {
                    var baseSalary = parseFloat($('#baseSalary').val()) || 0; // Get base salary
                    var deduction = parseFloat($('#deduction').val()) || 0; // Get deduction
                    var allowance = parseFloat($('#allowance').val()) || 0; // Get allowance

                    // Calculate final salary
                    var finalSalary = baseSalary + allowance - deduction;

                    // Display final salary in the final salary field
                    $('#finalSalary').val(finalSalary.toFixed(2));
                }

                // Trigger calculation initially
                calculateFinalSalary();

                // Handle click event for the confirm button
                $('#confirmButton').click(function() {
                    // Perform additional actions here when the confirm button is clicked
                });
            });
            $('#yearDropdown').change(function() {
                // You can perform additional actions here based on the selected year
            });
        </script>

<?php
    } else {
        // Handle case where record with provided u_id does not exist
        echo "Record not found.";
    }
} else {
    // Handle case where u_id parameter is not provided in the URL
    echo "Invalid request.";
}
?>