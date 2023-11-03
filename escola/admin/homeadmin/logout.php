<?php 
    session_start();
    session_destroy();
    header('Location: ../loginadmin/admin.php');
    exit();
?>