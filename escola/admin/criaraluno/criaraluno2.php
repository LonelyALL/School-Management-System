<?php
session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header('Location: ../loginadmin/admin.php');
    exit();
}

require '../connect/connect.php';

if (
    isset($_POST['login']) && isset($_POST['senha']) &&
    isset($_POST['turma']) && isset($_POST['serie']) &&
    isset($_POST['segmento']) && isset($_POST['nome'])
) {
    $login = trim($_POST['login']);
    $senha = trim($_POST['senha']);
    $nome = trim($_POST['nome']);
    $turma = trim($_POST['turma']);
    $serie = trim($_POST['serie']);
    $segmento = trim($_POST['segmento']);

    if (!empty($login) && !empty($senha) && !empty($nome) && !empty($turma) && !empty($serie) && !empty($segmento)) {
        $sql = "INSERT INTO alunos (nome, login, senha, turma, serie, segmento) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        $newSenha = password_hash($senha, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "ssssss", $nome, $login, $newSenha, $turma, $serie, $segmento);

        $sql2 = "SELECT * FROM alunos WHERE login=?";
        $stmt2 = mysqli_prepare($conn, $sql2);
        mysqli_stmt_bind_param($stmt2, "s", $login);
        mysqli_stmt_execute($stmt2);
        $result = mysqli_stmt_get_result($stmt2);

        if (mysqli_num_rows($result) > 0) {
            header("Location: ../criaraluno/criaraluno.php?error=Usuario já cadastrado");
            exit();
        } else {
            if (isset($login) && isset($senha) && !empty($login) && !empty($senha)) {
                if (mysqli_stmt_execute($stmt)) {
                    header("Location: ../criaraluno/criaraluno.php?sucess=Usuario criado com sucesso");
                    exit();
                } else {
                    header("Location: ../criaraluno/criaraluno.php?error=Erro ao criar usuário");
                    exit();
                }
            } else {
                header("Location: ../criaraluno/criaraluno.php?error=Preencha os campos corretamente");
                exit();
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt2);
        mysqli_close($conn);
    } else {
        header("Location: ../criaraluno/criaraluno.php?error=Preencha os campos corretamente");
        exit();
    }
} else {
    header("Location: ../criaraluno/criaraluno.php?error=Preencha os campos corretamente");
    exit();
}
?>
