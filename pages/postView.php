<?php
require("../tools/server.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Listes des Posts</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../css/adminlte.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
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
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Liste des posts</h1>
                        </div>
                        <table class="table">
                            <tr>
                                <td><u>Numéro</u></td>
                                <td><u>Titre</u></td>
                                <td><u>Description</u></td>
                                <td><u>Date de création</u></td>
                                <td><u>Dernière modification</u></td>
                            </tr>
                            <?php
                            $recupPost = getMysqlPosts($mysql);
                            foreach ($recupPost as $value) {
                                echo "<tr>";
                                echo "<td>" . $value['idPost'] . "</td>";
                                echo "<td>" . $value['titrePost'] . "</td>";
                                echo "<td>" . $value['descPost'] . "</td>";
                                echo "<td>" . $value['dateCreation'] . "</td>";
                                echo "<td>" . $value['dateLastModification'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
        </div>
        <!-- /.content -->
    </div>
</body>

<!-- /.content-wrapper -->
<footer class="main-footer">
    <strong>Copyright &copy; 2020-2020 Andrivet Tom, Capt Thibault, Laborde Robin </strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
</footer>

</html>