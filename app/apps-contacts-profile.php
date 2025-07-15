<?php include 'layouts/session.php'; ?>
<?php include 'layouts/head-main.php'; ?>

<head>

  <title>Profile | WorkWave - Admin & Dashboard Template</title>
  <?php include 'layouts/head.php'; ?>
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
          <div class="col-20">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
              <h4 class="mb-sm-0 font-size-18">Profile</h4>

              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Contact</a></li>
                  <li class="breadcrumb-item active">Profile</li>
                </ol>
              </div>

            </div>
          </div>
        </div>
        <!-- end page title -->

        <div class="row">

          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm order-2 order-sm-1">
                  <div class="d-flex align-items-start mt-3 mt-sm-0">
                    <div class="flex-shrink-0">
                      <div class="avatar-xl me-3">
                        <img src="assets/images/users/avatar-2.jpg" alt="" class="img-fluid rounded-circle d-block">
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <div>
                        <h5 class="font-size-25 mb-3">Yash Rana</h5>

                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-auto order-1 order-sm-2">
                  <div class="d-flex align-items-start justify-content-end gap-2">


                  </div>
                </div>
              </div>

            </div>
          </div>

          <div class="card-body">
            <div>
              <div class="pb-2 mt-5">
                <div class="row">
                  <div class="col-xl-2">
                    <div>
                      <h5 class="font-size-15">Username :</h5>
                    </div>
                  </div>
                  <div class="col-xl">
                    <div class="text-muted">
                      <p>Yash Rana</p>

                    </div>
                  </div>
                </div>
              </div>

              <div class="py-3">
                <div class="row">
                  <div class="col-xl-2">
                    <div>
                      <h5 class="font-size-15">Email :</h5>
                    </div>
                  </div>
                  <div class="col-xl">
                    <div class="text-muted">
                      <p>yashrana123@gmail.com</p>
                    </div>
                  </div>
                </div>

                <div class="py-3">
                  <div class="row">
                    <div class="col-xl-2">
                      <div>
                        <h5 class="font-size-15">phone :</h5>
                      </div>
                    </div>
                    <div class="col-xl">
                      <div class="text-muted">
                        <p>7861399996</p>
                      </div>
                    </div>
                  </div>

                  <div class="py-3">
                    <div class="row">
                      <div class="col-xl-2">
                        <div>
                          <h5 class="font-size-15">Role :</h5>
                        </div>
                      </div>
                      <div class="col-xl">
                        <div class="text-muted">
                          <p>Employee</p>
                        </div>
                      </div>
                    </div>

                    <div class="py-3">
                      <div class="row">
                        <div class="col-xl-2">
                          <div>
                            <h5 class="font-size-15">Department :</h5>
                          </div>
                        </div>
                        <div class="col-xl">
                          <div class="text-muted">
                            <p>IT</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <!-- end card -->
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->

          </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


      </div>
      <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    <!-- Right Sidebar -->
    <?php include 'layouts/right-sidebar.php'; ?>
    <!-- /Right-bar -->

    <!-- JAVASCRIPT -->

    <?php include 'layouts/vendor-scripts.php'; ?>

    <script src="assets/js/app.js"></script>

    </body>

    </html>