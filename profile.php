<?php
session_start();
include 'layouts/head-main.php';
include 'layouts/config.php';
include 'layouts/head.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user_id = $_SESSION['u_id'];
  $newPhone = $_POST['newPhone'];
  $newCity = $_POST['newCity'];
  $newState = $_POST['newState'];
  $newCountry = $_POST['newCountry'];
  $newAddress = $_POST['newAddress'];

  // Perform database update
  $sql = "UPDATE users SET phone = '$newPhone', city = '$newCity', state = '$newState', country = '$newCountry', address = '$newAddress' WHERE u_id = $user_id";
  if (mysqli_query($link, $sql)) {
    echo json_encode(array("success" => true));
  } else {
    echo json_encode(array("success" => false, "error" => mysqli_error($link)));
  }
} else {
  // If the request method is not POST, return an error
  echo json_encode(array("success" => false, "message" => "Invalid request method."));
}

$user_id = $_SESSION['u_id'];
$query = "SELECT * FROM users WHERE u_id = $user_id";
$result = mysqli_query($link, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);

  // Assign fetched values to variables
  $u_id = $row['u_id'];
  $username = $row['username'];
  $email = $row['email'];
  $phone = $row['phone'];
  $dob = $row['dob'];
  $address = $row['address'];
  $city = $row['city'];
  $state = $row['state'];
  $pincode = $row['pincode'];
  $country = $row['country'];
  $role = $row['role'];
  $d_id = $row['d_id'];
  $date_of_joining = $row['date_of_joining'];
  $profile_image = $row['profile_image'];

  $query3 = "SELECT d_name FROM department WHERE d_id = $d_id";
  $result3 = mysqli_query($link, $query3);

  if ($result3 && mysqli_num_rows($result3) > 0) {
    $row2 = mysqli_fetch_assoc($result3);
    $d_name = $row2['d_name'];
  } else {
    echo "d_name not found or error in fetching data.";
  }

  $query3 = "SELECT r_name FROM role WHERE r_id = $role";
  $result3 = mysqli_query($link, $query3);

  if ($result3 && mysqli_num_rows($result3) > 0) {
    $row3 = mysqli_fetch_assoc($result3);
    $r_name = $row3['r_name'];
  } else {
    echo "d_name not found or error in fetching data.";
  }
} else {
  echo "User not found or error in fetching data.";
  exit;
}

?>

<head>
  <title>Profile</title>
  <?php include 'layouts/head-style.php'; ?>
  <style>
    .form-content {
      padding: 25px;
      border-radius: 15px;
      margin: 10px;
      box-shadow: 0 0 20px 15px rgba(0, 0, 0, 0.1);
    }

    .basic {
      padding: 25px;
      border-radius: 15px;
      margin: 10px;
      box-shadow: 0 0 20px 5px rgba(0, 0, 0, 0.1);
    }

    .personal {
      padding: 25px;
      border-radius: 15px;
      margin: 10px;
      box-shadow: 0 0 20px 5px rgba(0, 0, 0, 0.1);
    }

    table {
      border-collapse: collapse;
      margin-top: 20px;
      padding: 20px;
    }

    th {
      border-bottom: 2px solid #ddd;
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
      height: 100%;
    }

    .edit-icon {
      cursor: pointer;
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

        <div class="row">
          <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
              <h4 class="mb-sm-0 font-size-18">Profile</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Profile</a></li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <div class="form-content">
          <div class="row">
            <div class="col-md-12">
              <div class="row">

                <div class="row">
                  <div class="col-md-3 mb-3">
                    <div class="image-container" id="displayContainer">
                      <img id="displayImage" alt="profile Image" src="<?php echo $profile_image; ?>">
                    </div>
                  </div>
                </div>
                <br><br>
                <div class="basic">
                  <div class="row">
                    <strong>
                      <h3>Basic Information</h3>
                    </strong>
                    <br><br><br>
                    <div class="col-md-6 mb-3">
                      <div class="row">
                        <div class="col-md-3 mb-3">
                          <h5>ID: </h5>
                          <h5>Name: </h5>
                          <h5>Department: </h5>
                          <h5>Role: </h5>
                          <h5>Email: </h5>
                          <h5>D.O.B.: </h5>
                        </div>
                        <div class="col-md-3 mb-3">
                          <h5><strong><?php echo $u_id; ?></strong></h5>
                          <h5><strong><?php echo $username; ?></strong></h5>
                          <h5> <strong><?php echo $d_name; ?></strong></h5>
                          <h5><strong><?php echo $r_name; ?></strong></h5>
                          <h5><strong><?php echo $email; ?></strong></h5>
                          <h5><strong><?php echo $dob; ?></strong></h5>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
                <!-- Inside the form -->
                <div class="personal">
                  <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="row">
                      <strong>
                        <h3>Personal Information</h3>
                      </strong>
                      <br><br><br>
                      <div class="col-md-6 mb-3">
                        <div class="row">
                          <div class="col-md-3 mb-3">
                            <h5>Phone No.: </h5>
                            <h5>City: </h5>
                            <h5>State: </h5>
                            <h5>Country: </h5>
                            <h5>Address: </h5>
                          </div>
                          <div class="col-md-3 mb-3 basic-info-field">
                            <h5 id="username" class="basic-info-field"><strong><?php echo $phone; ?></strong></h5>
                            <h5 id="department" class="basic-info-field"><strong><?php echo $city; ?></strong></h5>
                            <h5 id="role" class="basic-info-field"><strong><?php echo $state; ?></strong></h5>
                            <h5 id="email" class="basic-info-field"><strong><?php echo $country; ?></strong></h5>
                            <h5 id="email" class="basic-info-field"><strong><?php echo $address; ?></strong></h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
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

<!-- Right Sidebar -->
<?php include 'layouts/right-sidebar.php'; ?>
<!-- /Right-bar -->

<!-- JAVASCRIPT -->
<?php include 'layouts/vendor-scripts.php'; ?>

<script src="assets/js/app.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('editBasicInfo').addEventListener('click', function (e) {
      e.preventDefault();
      var basicInfoFields = document.querySelectorAll('.basic-info-field');
      basicInfoFields.forEach(function (field) {
        var value = field.innerText.trim();
        field.innerHTML = '<input type="text" value="' + value + '">';
      });
      document.getElementById('submitBasicInfo').style.display = 'inline'; // Show the Submit button
    });

    document.getElementById('submitBasicInfo').addEventListener('click', function (e) {
      e.preventDefault();
      var basicInfoFields = document.querySelectorAll('.basic-info-field');
      var updatedFields = {};
      basicInfoFields.forEach(function (field) {
        var newValue = field.querySelector('input').value;
        updatedFields[field.id] = newValue;
        field.innerHTML = '<strong>' + newValue + '</strong>';
      });
      document.getElementById('submitBasicInfo').style.display = 'none'; // Hide the Submit button

      // Send AJAX request to update details
      updatePersonalInfo(updatedFields);
    });

    function updatePersonalInfo(updatedFields) {
      // Assuming you have included jQuery
      $.ajax({
        type: 'POST',
        url: 'profile.php',
        data: updatedFields,
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            console.log('Details updated successfully!');
            // You can provide feedback to the user if needed
          } else {
            console.error('Error updating details:', response.error);
            // Handle error, show an error message, etc.
          }
        },
        error: function (xhr, status, error) {
          console.error('AJAX Error:', error);
          // Handle error, show an error message, etc.
        }
      });
    }
  });
</script>


</body>

</html>