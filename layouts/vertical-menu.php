<header id="page-topbar">
  <?php

  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  } ?>
  <div class="navbar-header">
    <div class="d-flex">
      <!-- LOGO -->
      <div class="navbar-brand-box">
        <a href="index.php" class="logo logo-dark">
          <span class="logo-sm">
            <img src="assets/images/logo.png" alt="" height="26">
          </span>
          <span class="logo-lg">
            <img src="assets/images/wwlogo.jpeg" alt="" height="26"> <span class="logo-txt">Work Wave (<?php
            switch ($_SESSION['role']) {
              case 1:
                echo "admin";
                break;
              case 2:
                echo "hr";
                break;
              case 3:
                echo "pm";
                break;
              case 4:
                echo "emp";
                break;
            }
            ?>)</span>
          </span>
        </a>

        <!-- logo for light color in dark theme -->
        <!-- <a href="index.php" class="logo logo-light">
          <span class="logo-sm">
            <img src="assets/images/logo-sm.svg" alt="" height="26">
          </span>
          <span class="logo-lg">
            <img src="assets/images/wwlogo.jpeg" alt="" height="26"> <span class="logo-txt">Work Wave</span>
          </span>
        </a> -->
      </div>

      <!-- <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
      </button> -->
      </form>
    </div>

    <div class="d-flex">

      <!-- night mode button -->
      <!-- <div class="dropdown d-none d-sm-inline-block">
        <button type="button" class="btn header-item" id="mode-setting-btn">
          <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
          <i data-feather="sun" class="icon-lg layout-mode-light"></i>
        </button>
      </div> -->

      <div class="dropdown d-inline-block">
        <?php


        $u_id = $_SESSION['u_id'];

        // Fetch user data from the database
        $sql1 = "SELECT * FROM users WHERE u_id=$u_id";
        $result1 = mysqli_query($link, $sql1);

        // Check if query execution was successful
        if ($result1 && mysqli_num_rows($result1) > 0) {
          $row = mysqli_fetch_assoc($result1);
          $profile_image = $row['profile_image']; // Assign profile image path
          $username = $row['username']; // Assign username
        } else {
          // Handle error or provide default values
          $profile_image = 'assets/images/users/default.jpg'; // Provide default profile image path
          $username = 'Unknown'; // Provide default username
        }

        ?>
        <button type="button" class="btn header-item bg-light-subtle border-start border-end"
          id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

          <?php echo "<img class='rounded-circle header-profile-user' src=" . $profile_image . " alt='Profile Image'>"; ?>

          <span class="d-none d-xl-inline-block ms-1 fw-medium">
            <?php

            echo $username;

            ?>
          </span>
          <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
          <!-- item-->
          <!-- <a class="dropdown-item" href="apps-contacts-profile.php"><i
              class="mdi mdi mdi-face-man font-size-16 align-middle me-1"></i>
               <?php // echo $language["Profile"];                                   ?>
              </a>
          <a class="dropdown-item" href="auth-lock-screen.php"><i
              class="mdi mdi-lock font-size-16 align-middle me-1"></i>
               <?php // echo $language["Lock_screen"];                                   ?>
               </a>
          <div class="dropdown-divider"></div> -->
          <a class="dropdown-item" href="profile.php">
            <i data-feather="user" class="icon-sm" style=" font-size: 16px;"></i>
            <?php echo $language["Profile"]; ?>
          </a>
          <a class="dropdown-item" href="logout.php">
            <i class="mdi mdi-logout font-size-16 align-middle me-1"></i>
            <?php echo $language["Logout"]; ?>
          </a>
        </div>
      </div>

    </div>
  </div>
</header>

<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

  <?php
  $user_role = $_SESSION['role'];
  ?>

  <div data-simplebar class="h-100">

    <!--- Sidemenu -->
    <div id="sidebar-menu">
      <!-- Left Menu Start -->
      <ul class="metismenu list-unstyled" id="side-menu">

        <li class="menu-title" data-key="t-menu">
          <?php echo $language["Menu"]; ?>
        </li>
        <li>
          <a href="index.php">
            <i data-feather="home"></i>
            <span data-key="t-dashboard">
              <?php echo "Dashboard"; ?>
            </span>
          </a>
        </li>

        <?php
        if ($user_role == 1) {
          include "layouts/vertical-menu-admin.php";
        } elseif ($user_role == 2) {
          include "layouts/vertical-menu-hr.php";
        } elseif ($user_role == 3) {
          include "layouts/vertical-menu-pm.php";
        } else {
          include "layouts/vertical-menu-emp.php";
        }
        ?>

      </ul>

    </div>
    <!-- Sidebar -->
  </div>
</div>
<!-- Left Sidebar End -->