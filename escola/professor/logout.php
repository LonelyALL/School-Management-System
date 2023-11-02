<?php 
    session_start();
    session_destroy();
    header('Location: professor.php');
    exit();
?>