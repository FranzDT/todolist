<?php
    session_start();
?>
<html>
    <head>
        <title>Verification Code</title>
    </head>
    <body>
       
    </body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - 404</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          
        <i class="fas fa-clipboard fa-lg"></i>
        <a href="../index.php">
            <h1>TodoList App</h1>
          </a>

        
        <ul class="navbar-nav ml-auto">
            <a href="../views/login_view.php">Login</a> 
        </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

    
          <!-- 404 Error Text -->
          <div class="text-center">
          <?php
            if (isset($_SESSION['vkey_message']))
            {
                if ($_SESSION['vkey_message'] == 'SUCCESS')
                {   
                    session_destroy();
                    echo "<div class='error mx-auto' data-text='SUCCESS'>SUCCESS</div>";
                    echo "<p class='lead text-gray-800 mb-5'>Verfication Code validated, you may now user your account.</p>";
                }
                else
                {
                    session_destroy();
                    echo "<div class='success mx-auto' data-text='404'>404</div>";
                    echo "<p class='lead text-gray-800 mb-5'>Verfication Code not valid</p>";
                }
            }
            else
            {
                session_destroy();
                header("Location: ../views/index.php");
            }
          ?>
            <a href="../index.php">&larr; Back to TodoList.com</a>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
            <br><br> <br> <br><br><br><br><br><br><br><br><br><br><br>
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; TodoList 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  
  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

</body>