<?php 
require "../tools/server.php";
if (isset($_SESSION["logged_user"])) {
    kickNoAccessPage($mysql, $_SESSION["logged_user"], "admin.panel.add.post");
} else {
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Projet TRT</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../css/adminlte.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- css page -->
  <link rel="stylesheet" href="../css/publicPost.css">

</head>

<body class="hold-transition sidebar-mini">
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="../" class="brand-link">
            <span class="brand-text font-weight-light">Panel TRT</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <a href="#" class="d-block"><?php if (isset($_SESSION["logged_user"])) { echo $_SESSION["logged_user"];} else { echo "Visiteur"; } ?></a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-header">ADMINISTRATION</li>
                    <li class="nav-item has-treeview">
                        <a href="Admin/dashboard.php" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                DashBoard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="login.php" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Connexion
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="register.php" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                S'enregistrer
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-header">POSTS</li>
                    <li class="nav-item has-treeview">
                        <a href="publicPost.php" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Publier
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="postView.php" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Voir
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    <!-- Navbar horizontal -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="../">Accueil</a></li>
            <li class="nav-item"><a class="nav-link" href="postView.php">Posts</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php">Connexion</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php?delogger">Deconnexion</a></li>
        </ul>
    </nav>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Post publique</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../">Accueil</a></li>
              <li class="breadcrumb-item active">Post publique</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Ajoutez un post publique
              </h3>
              <!-- /. tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body pad">
              <p id="error"></p>
              <div class="mb-3">
                <form method="POST" action="publicPost.php">
                  <input type="text" name="tbxTitre" class="title" placeholder="Titre" />
                  <textarea name="tbxDesc" class="textarea" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                  <input type="submit" value="Publier" id="btnPublier" name="btnPublier" class="btn btn-primary" />
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- /.col-->
      </div>
      <!-- ./row -->
    </section>
    <!-- /.content -->
  </div>

    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2020-2020 Andrivet Tom, Capt Thibault, Laborde Robin </strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../js/demo.js"></script>
  <!-- Summernote -->
  <script src="../plugins/summernote/summernote-bs4.min.js"></script>
  <script>
    $(function() {
      // Summernote
      $('.textarea').summernote()
    })
  </script>
  <?php
  $tbxTitre = filter_input(INPUT_POST, "tbxTitre", FILTER_SANITIZE_STRING);
  $tbxDesc = filter_input(INPUT_POST, "tbxDesc", FILTER_SANITIZE_STRING);
  $btnPublier = filter_input(INPUT_POST, "btnPublier", FILTER_VALIDATE_BOOLEAN);

  if (isset($btnPublier) && empty($tbxTitre) && empty($tbxDesc))
    echo "<script>document.getElementById('error').innerHTML = 'Veuillez renseigner les champs titre et descritpion'; </script>";
  else if (isset($btnPublier) && empty($tbxTitre) && !empty($tbxDesc))
    echo "<script>document.getElementById('error').innerHTML = 'Veuillez renseigner le champs titre'; </script>";
  else if (isset($btnPublier) && !empty($tbxTitre) && empty($tbxDesc))
    echo "<script>document.getElementById('error').innerHTML = 'Veuillez renseigner le champs descritpion'; </script>";
  else if (isset($btnPublier) && !empty($tbxTitre) && !empty($tbxDesc)){
      MysqlAddPost($mysql, $tbxTitre, $tbxDesc, $_SESSION["logged_user"]);
      echo "<script>document.getElementById('error').style.color = 'green' </script>";
      echo "<script>document.getElementById('error').innerHTML = 'Votre post à bien été publié' </script>";
  }
  ?>

</body>

</html>