<?php 
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
        header('Location: ../loginadmin/admin.php');
        exit();
    }
?>

<?php 
    require '../functions/functions.php';
    gerarHistoricoGeral();
?>