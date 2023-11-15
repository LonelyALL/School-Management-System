<?php
session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header('Location: ../loginadmin/admin.php');
    exit();
}

require '../../connect/connect.php';
require '../functions/functions.php';

if (
    isset($_POST['login']) && isset($_POST['senha']) &&
    isset($_POST['id']) && isset($_POST['loginfixo']
    )
) {
    if(verifyString($_POST['login']) == true OR verifyString($_POST['senha']) == true){
        header('Location: professores.php?error=Usuário e Senha não podem conter espaço.');
        exit(); 
    }
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $id = $_POST['id'];
    $loginfixo = $_POST['loginfixo'];

    $newSenha = password_hash($senha, PASSWORD_DEFAULT);

    if(empty($senha)){
        $sql = "UPDATE professor SET login=? WHERE proid=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $login, $id);
    }
    else{
        $sql = "UPDATE professor SET login=?, senha=? WHERE proid=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $login, $newSenha, $id);
    }

    if ($login == $loginfixo) {
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header('Location: professores.php?sucess=Professor editado com sucesso!');
            exit();
        } else {
            header('Location: professores.php?error=Erro desconhecido!');
            exit();
        }
    } else {
        $sql_verify = "SELECT * FROM professor WHERE login = ?";
        $stmt_verify = mysqli_prepare($conn, $sql_verify);
        mysqli_stmt_bind_param($stmt_verify, "s", $login);
        mysqli_stmt_execute($stmt_verify);
        $result_verify = mysqli_stmt_get_result($stmt_verify);

        if (mysqli_num_rows($result_verify) > 0) {
            mysqli_stmt_close($stmt_verify);
            mysqli_close($conn);
            header('Location: professores.php?error=Esse login já está em uso!');
            exit();
        } else {
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt_verify);
                mysqli_close($conn);
                header('Location: professores.php?sucess=Professor editado com sucesso!');
                exit();
            }
        }
    }
} else {
    header('Location: professores.php');
    exit();
}
?>
