<?php
    require "../functions/functions.php";
    checkLogin();

    if (isset($_SESSION['action_message']))
    {
        echo $_SESSION['action_message'];
        unset($_SESSION['action_message']);
    }

    if (isset($_SESSION['error']))
    {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    }
?>
<html>
    <head>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Home</title>

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

      <!-- Topbar Navbar -->
      <ul class="navbar-nav ml-auto">
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Hello, <?php echo $_SESSION['username']; ?></span>
            <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
          </a>
          <!-- Dropdown - User Information -->
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#">
              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
              Profile
            </a>
            <a class="dropdown-item" href="#">
              <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
              Settings
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

    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href=../views/add_todo_view.php class="btn btn-primary" role="button">Add Task</a>
      </div>

      <div class="row">
        
      </div>

      <div class="row">
      <div class="col-lg-4">
        <!-- Backlog header -->
        <div class="">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-6">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Backlog</div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-plus fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <br>
        <?php
          if ($_SESSION['user_role_id'] == 200)
          {
            $user_id = $_SESSION['user_id'];
          }
          elseif ($_SESSION['user_role_id'] == 100)
          {
            $user_id = $_SESSION['adminview_userid'];
          }
          else
          {
            header("Location: ../process/logout.php");
          }

          $resultbacklog = fetchTodoBacklog($user_id);
          $resultprogress = fetchTodoProgress($user_id);
          $resultdone = fetchTodoDone($user_id);
          while ($row = $resultbacklog->fetch_assoc())
          {
        ?>
            
              <!-- Dropdown Card Example -->
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary"><?php echo $row['todo_title']; ?></h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Todo Action:</div>
                      <a class="dropdown-item" href="../process/edit_todo.php?todoid=<?php echo $row['todo_id'];?>">Edit</a>
                      <a class="dropdown-item" href="../process/add_list.php?todoid=<?php echo $row['todo_id'];?>">Add List</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="../process/delete_todo.php?todoid=<?php echo $row['todo_id'];?>">Delete</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <?php echo $row['todo_description']; ?>
                  <br><br>
                  <i>List:</i> <br>
                  <?php  
                    $resultlist = getList($row['todo_id']);
                    while ($listrow = $resultlist->fetch_assoc())
                    {
                      if ($listrow['list_status'] == "inprogress")
                      {
                        echo "<a href='../process/list_done.php?listid=". $listrow['list_id'] ."'><i class='fas fa-check fa-2x text-gray-300'></i></a>";
                        echo $listrow['list_name']."<br>";
                      }
                    }
                  ?>
                  <hr/>
                    <div class="row">
                      <div class="col-lg-10">
                      </div>
                      <div class="col-lg-2">
                        <a href="../process/todo_progress.php?todoid=<?php echo $row['todo_id']; ?>" class="btn btn-primary" role="button"> >> </a>
                      </div>
                    </div>
                </div>
              </div>
         
            <!-- backlog end tag -->
            <?php } ?>
            </div>
            
            <!-- Earnings (Monthly) Card Example -->
            
            <div class="col-lg-4">
            <div class="">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Progress</div>
                      <div class="row no-gutters align-items-center">
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <br>
            
            <?php 
              while ($row = $resultprogress->fetch_assoc())
              {
            ?>

              <!-- Dropdown Card Example -->
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary"><?php echo $row['todo_title']; ?></h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Todo Action:</div>
                      <a class="dropdown-item" href="../process/edit_todo.php?todoid=<?php echo $row['todo_id'];?>">Edit</a>
                      <a class="dropdown-item" href="../process/add_list.php?todoid=<?php echo $row['todo_id'];?>">Add List</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="../process/delete_todo.php?todoid=<?php echo $row['todo_id'];?>">Delete</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <?php echo $row['todo_description']; ?>
                    <hr/>
                    <div class="row">
                      <div class="col-lg-10">
                        <a href="../process/todo_backlog.php?todoid=<?php echo $row['todo_id']; ?>" class="btn btn-primary" role="button"> << </a>
                      </div>
                      <div class="col-lg-2">
                        <a href="../process/todo_done.php?todoid=<?php echo $row['todo_id']; ?>" class="btn btn-primary" role="button"> >> </a>
                      </div>
                    </div>
                </div>
              </div>
              
            <!-- progress end tag -->
            <?php 
              }
            ?>
            </div>

              <div class="col-lg-4">
                <div class="">
                <div class="card border-left-info shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Done</div>
                        <div class="row no-gutters align-items-center">
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-Check fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              <br>
              <?php
                while ($row = $resultdone->fetch_assoc())
                {
              ?>
              <!-- Dropdown Card Example -->
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary"><?php echo $row['todo_title']; ?></h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Todo Action:</div>
                      <a class="dropdown-item" href="../process/edit_todo.php?todoid=<?php echo $row['todo_id'];?>">Edit</a>
                      <a class="dropdown-item" href="../process/add_list.php?todoid=<?php echo $row['todo_id'];?>">Add List</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="../process/delete_todo.php?todoid=<?php echo $row['todo_id'];?>">Delete</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <?php echo $row['todo_description']; ?>
                  <hr/>
                    <div class="row">
                      <div class="col-lg-10">
                        <a href="../process/todo_progress.php?todoid=<?php echo $row['todo_id']; ?>" class="btn btn-primary" role="button"> << </a>
                      </div>
                    </div>
                </div>
              </div>

                <?php } ?>

              </div>
            </div> 
            </div>  
        </div>
      </div>
        
        
    </div>
    <!-- /.container-fluid -->

  </div>
  <!-- End of Main Content -->

  <!-- Footer -->
  <footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>Copyright &copy; Your Website 2019</span>
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
          
<!-- Bootstrap core JavaScript-->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../js/sb-admin-2.min.js"></script>
    </body>
</html>