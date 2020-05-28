<?php 
require "./tools/server.php";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Editors</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./css/adminlte.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="./plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- css page -->
  <link rel="stylesheet" href="./css/publicPost.css">

</head>

<body class="hold-transition sidebar-mini">

  <?php include "./inc/nav.inc.php"; ?>
  <?php include "./inc/sidebar.inc.php"; ?>

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
              <li class="breadcrumb-item"><a href="#">Home</a></li>
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
              <p class="text-sm mb-0">
                Editor <a href="https://github.com/bootstrap-wysiwyg/bootstrap3-wysiwyg">Documentation and license
                  information.</a>
              </p>
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
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.4
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="./plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="./js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="./js/demo.js"></script>
  <!-- Summernote -->
  <script src="./plugins/summernote/summernote-bs4.min.js"></script>
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
      MysqlAddPost($mysql, $_POST["tbxTitre"], $_POST["tbxDesc"], $identifiantUser);
      echo "<script>document.getElementById('error').style.color = 'green' </script>";
      echo "<script>document.getElementById('error').innerHTML = 'Votre post à bien été publié' </script>";
  }
  ?>

</body>

</html>