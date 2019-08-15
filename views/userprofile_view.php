<?php
    session_start();

    if (isset($_SESSION['action_message']))
    {
        echo $_SESSION['action_message'];
        unset($_SESSION['action_message']);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>User Profile</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.css" rel="stylesheet">

</head>

<body class="bg-gradient-secondary">

  <div class="container">

    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

      <!-- Sidebar Toggle (Topbar) -->
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>

      <li class="nav-item active">
        <a class="nav-link" href="../views/user_view.php">
          <i class="fas fa-fw fa-clipboard"></i>
          <span class="h4 text-uppercase">Todo</span></a>
      </li>

      <!-- Topbar Navbar -->
      <ul class="navbar-nav ml-auto">
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Hello, <?php echo $_SESSION['username']; ?></span>
            <img class="img-profile rounded-circle" src="../res/default.jpg">
          </a>
          <!-- Dropdown - User Information -->
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="../views/user_view.php">
              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
              Todo app
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Logout
            </a>
          </div>
        </li>

      </ul>

    </nav>
    <!-- End of Topbar -->

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
                <div class="row mb-4">
                    <div class="col-sm-2">
                        <label for="username" class="h4 text-gray-500 text-uppercase text-left">Username: </label>
                    </div>
                    <div class="col-sm-10 mb-sm-4">
                        <h1 class="h4 text-gray-900 text-uppercase text-center"><?php echo $_SESSION['username']; ?></h1>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-sm-2 mb-sm-4">
                        <label for="username" class="h4 text-gray-500 text-uppercase text-left">Email: </label>
                    </div>
                    <div class="col-sm-10">
                        <h1 class="h4 text-gray-900 text-uppercase text-center"><?php echo $_SESSION['email']; ?></h1>
                    </div>
                </div>

              <hr class="mb-4">
                <div class="row mb-4">
                    <div class="col-sm-8 mb-4">
                        <a href="#"><i class="fas fa-camera-retro fa-lg"> Upload image</i></a>
                    </div>
                    <div class="col-sm-4 mb-4">
                        <a href="#" data-toggle="modal" data-target="#editModal"><i class="fas fa-cog fa-lg"> Edit Profile</i></a>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-sm-8 mb-sm-4">
                        <a href="#" data-toggle="modal" data-target="#changePasswordModal"><i class="fas fa-lock fa-lg"> Change Password</i></a>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../process/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Profile Modal-->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">
                    <form action="../process/edit_user.php" method="POST" class="form-inline user">
                        <div class="container">
                            <div class="form-group row text-center">
                                <div class="col-sm-3">
                                    <label for="username" class="h5 text-gray center">Username: </label>
                                </div>
                                <div class="col-sm-9 mb-4">
                                    <input type="text" class="form-control form-control-user" name="username" placeholder="<?php echo $_SESSION['username']; ?>" value="<?php echo $_SESSION['username']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row text-center">
                                <div class="col-sm-3 ">
                                    <label for="email" class="h5 text-gray center">Email: </label>
                                </div>
                                <div class="col-sm-9 mb-6">
                                    <input type="text" class="form-control form-control-user" name ="email" placeholder="<?php echo $_SESSION['email']; ?>" value="<?php echo $_SESSION['email']; ?>" required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                <input type="submit" class="btn btn-primary" href="" value="Edit Profile"></a> 
                </form>
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Change Password Modal-->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">
                    <form action="../process/change_password.php" method="POST" class="form-inline user">
                        <div class="container">
                            <div class="form-group row text-center">
                                <div class="col-sm-6">
                                    <label for="old password" class="h5 text-gray center"> Old Password: </label>
                                </div>
                                <div class="col-sm-6 mb-4">
                                    <input type="password" class="form-control form-control-user" name="oldpassword" required>
                                </div>
                            </div>
                            <div class="form-group row text-center">
                                <div class="col-sm-6 ">
                                    <label for="new Password" class="h5 text-gray center"> New Password: </label>
                                </div>
                                <div class="col-sm-6 mb-4">
                                    <input type="password" class="form-control form-control-user" name ="newpassword" required>
                                </div>
                            </div>
                            <div class="form-group row text-center">
                                <div class="col-sm-6 mb-">
                                    <label for="confirm Password" class="h5 text-gray center"> Confirm Password: </label>
                                </div>
                                <div class="col-sm-6 mb-6">
                                    <input type="password" class="form-control form-control-user" name ="newpassword2" required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                <input type="submit" class="btn btn-primary" href="" value="Change Password"></a> 
                </form>
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>