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

        <!-- navigations -->
        <?php include("../inc/nav.inc.php"); ?>
        <?php include("../inc/sidebar.inc.php"); ?>

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
    <strong>Copyright &copy; 2020-2020 Adrivet Tom, Capt Thibault, Laborde Robin </strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.1
    </div>
</footer>

</html>