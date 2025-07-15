<?php
// Initialize the session
session_start();
require "layouts/session.php";
?>
<?php include 'layouts/head-main.php'; ?>

<head>

  <title>Login | Minia - Admin & Dashboard Template</title>
  <?php include 'layouts/head.php'; ?>

  <?php include 'layouts/head-style.php'; ?>

</head>

<?php include 'layouts/body.php'; ?>
<div class="auth-page">
  <div class="container-fluid p-0">
    <div class="row g-0">
      <div class="col-xxl-3 col-lg-4 col-md-5">
        <div class="auth-full-page-content d-flex p-sm-5 p-4">
          <div class="w-100">
            <div class="d-flex flex-column h-100">
              <div class="mb-4 mb-md-5 text-center">
                <a href="index.php" class="d-block auth-logo">
                  <img src="assets/images/logo-sm.svg" alt="" height="28"> <span class="logo-txt">WorkWave</span>
                </a>
              </div>
              <div class="auth-content my-auto">
                <div class="text-center">
                  <h5 class="mb-0">Welcome Back !</h5>
                  <p class="text-muted mt-2">Sign in to continue to WorkWave.</p>
                </div>
                <form id="loginForm" class="mt-4 pt-2">
                  <!-- for email -->
                  <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input type="text" class="form-control" id="email" placeholder="Enter email" name="email" autocomplete="off" required>
                  </div>
                  <!-- for password -->
                  <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <div class="d-flex align-items-start">
                      <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" autocomplete="off" required>
                      <button class="btn btn-light ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                    </div>
                  </div>
                  <div class="mb-3">
                    <button id="loginBtn" class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log In</button>
                  </div>
                </form>
              </div>
              <div class="mt-4 mt-md-5 text-center">
                <p class="mb-0">©
                  <script>
                    document.write(new Date().getFullYear())
                  </script> WorkWave . <i class="mdi mdi-heart text-danger"></i>
                </p>
              </div>
            </div>
          </div>
        </div>
        <!-- end auth full page content -->
      </div>
      <!-- end col -->
      <div class="col-xxl-9 col-lg-8 col-md-7">
        <div class="auth-bg pt-md-5 p-4 d-flex">
          <div class="bg-overlay bg-primary"></div>
          <ul class="bg-bubbles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
          </ul>
          <!-- end bubble effect -->
          <div class="row justify-content-center align-items-center">
            <div class="col-xl-7">
              <div class="p-0 p-sm-4 px-xl-0">
                <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                  <!-- <div class="carousel-indicators carousel-indicators-rounded justify-content-start ms-0 mb-0" style="margin-top:30px;">
                    <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="0" class="active"
                      aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="1"
                      aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="2"
                      aria-label="Slide 3"></button>
                  </div> -->

                  <!-- end carouselIndicators -->
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <div class="testi-contain text-white">
                        <i class="bx bxs-quote-alt-left text-success display-6"></i>
                        <h4 class="mt-4 fw-medium lh-base text-white">“Unity is strength. When there is teamwork and
                          collaboration, wonderful things can be achieved.” ― Mattie Stepanek”</h4>
                      </div>
                    </div>
                    <div class="carousel-item">
                      <div class="testi-contain text-white">
                        <i class="bx bxs-quote-alt-left text-success display-6"></i>
                        <h4 class="mt-4 fw-medium lh-base text-white">“Many ideas grow better when transplanted into
                          another mind than the one where they sprang up.” – Oliver Wendell Holmes”</h4>
                      </div>
                    </div>
                    <div class="carousel-item">
                      <div class="testi-contain text-white">
                        <i class="bx bxs-quote-alt-left text-success display-6"></i>
                        <h4 class="mt-4 fw-medium lh-base text-white">“Collaboration is a key part of the success of any
                          organization, executed through a clearly defined vision and mission and based on transparency
                          and constant communication." — Dinesh Paliwal”</h4>
                      </div>
                    </div>
                  </div>
                  <!-- end carousel-inner -->
                </div>
                <!-- end review carousel -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
  </div>
  <!-- end container fluid -->
</div>


<!-- JAVASCRIPT -->

<?php include 'layouts/vendor-scripts.php'; ?>
<!-- password addon init -->
<script src="assets/js/pages/pass-addon.init.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');

    loginForm.addEventListener('submit', function(event) {
      event.preventDefault();

      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;

      if (email.trim() === '' || password.trim() === '') {
        alert('Please enter email and password.');
        return;
      }

      // Create an XMLHttpRequest object
      const xhr = new XMLHttpRequest();

      // Configure the request
      xhr.open('POST', 'check_login_ajax.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      // Define what happens on successful data submission
      xhr.onload = function() {
        if (xhr.status === 200) {
          // Parse the response
          const response = JSON.parse(xhr.responseText);

          // Check the status of the response
          if (response.status === 'success') {
            // Redirect to the dashboard
            window.location.href = 'index.php';
          } else {
            // Display an error message
            alert(response.message);
          }
        } else {
          // Handle errors
          console.error('Error:', xhr.statusText);
        }
      };

      // Define what happens in case of an error
      xhr.onerror = function() {
        console.error('Request failed.');
      };

      // Send the request with the form data
      xhr.send(`email=${email}&password=${password}`);
    });
  });
</script>


</body>

</html>