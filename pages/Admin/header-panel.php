<?php
if (basename($_SERVER["PHP_SELF"]) == "header-panel.php"){
    include "../../tools/tools.php";
    include "../../tools/server.php";
} else {
    include "../../tools/tools.php";
}
if (isset($_SESSION["logged_user"])) {
    kickNoAccessPage($mysql, $_SESSION["logged_user"], "admin.panel.access");
}
$c = basename($_SERVER["PHP_SELF"]);
?>
<link href="../../css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="../../css/admin/dashboard.css" rel="stylesheet" type="text/css"/>
<header class="header-panel">
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="dashboard.php">TRT</a>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="../login.php?delogger">Se delogger</a>
            </li>
        </ul>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?php echo isCurrentPage($c, "dashboard.php"); ?>" href="dashboard.php">
                                <span data-feather="home"></span>
                                Dashboard <span class="sr-only">(current)</span>
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Gestion des Utilisateurs</span>
                        <a class="d-flex align-items-center text-muted" href="#">
                            <span data-feather="plus-circle"></span>
                        </a>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <?php
                        if (asPermission($mysql, $_SESSION["logged_user"], "admin.panel.manage.users")) {
                            echo '<li class="nav-item">
                                    <a class="nav-link ' . isCurrentPage($c, "users.php") . '" href="users.php">
                                      <span data-feather="file-text"></span>
                                      Utilisateur
                                    </a>
                                </li>';
                        }
                        ?>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>