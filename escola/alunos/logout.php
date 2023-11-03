<?php 
    session_start();
    session_destroy();
    header('Location: aluno.php');
    exit();
?>