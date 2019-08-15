<?php
    session_start();
    if (isset($_SESSION['error']))
    {
        if (isset($_SESSION['login_username']))
        {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            $label = "Password: ";
            $input_type = "password";
            $input_name = "password";
            $submit_value = "Confirm Password";
        }
        else
        {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            $label = "Username: ";
            $input_type = "text";
            $input_name = "username";
            $submit_value = "Confirm Username";
        }
    }
    else
    {
        if (isset($_SESSION['login_username']))
        {
            $label = "Password: ";
            $input_type = "password";
            $input_name = "password";
            $submit_value = "Confirm Password";
        }
        else
        {
            $label = "Username: ";
            $input_type = "text";
            $input_name = "username";
            $submit_value = "Confirm Username";
        }
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>TodoList Login</title>

        <!-- Custom fonts for this template-->
        <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    </head>
    <body class="bg-secondary">
        <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form class="user" action="../process/login.php" method="POST">
                    <div class="form-group row">
                        <div class="col-sm-4 ce">
                            <span class="h5 text-gray-900 text-center"><?php echo $label;?></span>
                        </div>
                        <div class="col-sm-8">
                            <input type="<?php echo $input_type ?>" name="<?php echo $input_name ?>" class="form-control form-control-user" aria-describedby="emailHelp" required>
                        </div>
                    </div>
                    <input type="submit" value="<?php echo $submit_value; ?>" class="btn btn-primary btn-user btn-block">
                </div>
              </div>
            </div>
          </div>
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