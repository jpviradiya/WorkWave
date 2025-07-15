<?php
session_start(); // Start session to get user role
include 'layouts/head-main.php';
include 'layouts/config.php'; // Include database configuration file
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $language["Dashboard"]; ?> | Employee Management System</title>
    <?php include 'layouts/head.php'; ?>
    <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
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
                                <h4 class="mb-sm-0 font-size-18">My Payslip List</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);"> My Payslip List</a></li>
                                        <li class="breadcrumb-item active">My Payslip List</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="month">Select month:</label>
                            <select class="form-control" id="month" name="month">
                                <option value="">All months</option>
                                <option value="January" <?php if(isset($_GET['month']) && $_GET['month'] == 'January') echo 'selected'; ?>>January</option>
                                <option value="February" <?php if(isset($_GET['month']) && $_GET['month'] == 'February') echo 'selected'; ?>>February</option>
                                <option value="March" <?php if(isset($_GET['month']) && $_GET['month'] == 'March') echo 'selected'; ?>>March</option>
                                <option value="April" <?php if(isset($_GET['month']) && $_GET['month'] == 'April') echo 'selected'; ?>>April</option>
                                <option value="May" <?php if(isset($_GET['month']) && $_GET['month'] == 'May') echo 'selected'; ?>>May</option>
                                <option value="June" <?php if(isset($_GET['month']) && $_GET['month'] == 'June') echo 'selected'; ?>>June</option>
                                <option value="July" <?php if(isset($_GET['month']) && $_GET['month'] == 'July') echo 'selected'; ?>>July</option>
                                <option value="August" <?php if(isset($_GET['month']) && $_GET['month'] == 'August') echo 'selected'; ?>>August</option>
                                <option value="September" <?php if(isset($_GET['month']) && $_GET['month'] == 'September') echo 'selected'; ?>>September</option>
                                <option value="October" <?php if(isset($_GET['month']) && $_GET['month'] == 'October') echo 'selected'; ?>>October</option>
                                <option value="November" <?php if(isset($_GET['month']) && $_GET['month'] == 'November') echo 'selected'; ?>>November</option>
                                <option value="December" <?php if(isset($_GET['month']) && $_GET['month'] == 'December') echo 'selected'; ?>>December</option>
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
                                                                    <th>Payment Date</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                // Modify your query to include the month filter
                                                                $query = "SELECT s.id, s.*, u.username, u.profile_image, r.r_name FROM salaries s 
          INNER JOIN users u ON s.u_id = u.u_id
          INNER JOIN role r ON u.role = r.r_id 
          WHERE s.admin_status = 1";

                                                                // Check if a month is selected and apply the filter
                                                                if (isset($_GET['month']) && !empty($_GET['month'])) {
                                                                    $selected_month = $_GET['month'];
                                                                    $query .= " AND s.month = '$selected_month'";
                                                                }
                                                                $query .= " AND s.u_id = {$_SESSION['u_id']}"; // Filter by session user id
                                                                
                                                                $result = mysqli_query($link, $query);
                                                                if (!$result) {
                                                                    die('Error: ' . mysqli_error($link)); // Display error message and terminate script execution
                                                                }
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
                                                                    echo "<td>{$row['payment_date']}</td>";

                                                                    echo '<td>';

                                                                    echo "<a href='generate_pdf.php?id={$row['id']}&u_id={$row['u_id']}&month={$row['month']}&year={$row['year']}' class='btn btn-warning'>PDF</a>";


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
        $(document).ready(function() {
            $('#datatable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
            // JavaScript function to filter records based on month selection
            $('#month').change(function() {
                var selectedMonth = $(this).val();
                var url = 'emp_payslip.php';
                if (selectedMonth !== '') {
                    url += '?month=' + selectedMonth;
                }
                window.location.href = url;
            });
        });
    </script>
</body>

</html>
