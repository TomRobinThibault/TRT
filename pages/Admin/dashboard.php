<?php
include '../../tools/server.php';
if (isset($_SESSION["logged_user"])) {
    kickNoAccessPage($mysql, $_SESSION["logged_user"], "admin.panel.access");
} else {
    header("Location: ../../../accueil.php");
}
?>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Administration - Dashboard</title>
</head>
<body>
<?php include 'header-panel.php'; ?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <h2>Tableau de bord</h2>
</main>
</body>
</html>