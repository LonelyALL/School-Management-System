<?php
session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header('Location: ../loginadmin/admin.php');
    exit();
}

require '../connect/connect.php';

if (
    isset($_POST['login']) && isset($_POST['senha']) &&
    isset($_POST['id']) && isset($_POST['turma']) &&
    isset($_POST['loginfixo'])
) {
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $id = $_POST['id'];
    $turma = $_POST['turma'];
    $loginfixo = $_POST['loginfixo'];

    $newSenha = password_hash($senha, PASSWORD_DEFAULT);

    $sql_turmas = "SELECT serie_id FROM turmas WHERE turma = ?";
    $stmt_turmas = mysqli_prepare($conn, $sql_turmas);
    mysqli_stmt_bind_param($stmt_turmas, "s", $turma);
    mysqli_stmt_execute($stmt_turmas);
    $result_turmas = mysqli_stmt_get_result($stmt_turmas);
    $row_turmas = mysqli_fetch_assoc($result_turmas);
    $newserie = $row_turmas['serie_id'];

    $sql_newsegmento = "SELECT segmento FROM series WHERE id = ?";
    $stmt_newsegmento = mysqli_prepare($conn, $sql_newsegmento);
    mysqli_stmt_bind_param($stmt_newsegmento, "i", $newserie);
    mysqli_stmt_execute($stmt_newsegmento);
    $result_newsegmento = mysqli_stmt_get_result($stmt_newsegmento);
    $row_segmento = mysqli_fetch_assoc($result_newsegmento);
    $newsegmento = $row_segmento['segmento'];

    $sql = "UPDATE alunos SET login=?, senha=?, turma=?, serie=?, segmento=? WHERE matricula=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssisi", $login, $newSenha, $turma, $newserie, $newsegmento, $id);

    if ($login == $loginfixo) {
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header('Location: aluno.php?sucess=Aluno editado com sucesso!');
            exit();
        } else {
            header('Location: aluno.php?error=Erro desconhecido!');
            exit();
        }
    } else {
        $sql_verify = "SELECT * FROM alunos WHERE login = ?";
        $stmt_verify = mysqli_prepare($conn, $sql_verify);
        mysqli_stmt_bind_param($stmt_verify, "s", $login);
        mysqli_stmt_execute($stmt_verify);
        $result_verify = mysqli_stmt_get_result($stmt_verify);

        if (mysqli_num_rows($result_verify) > 0) {
            mysqli_stmt_close($stmt_verify);
            mysqli_close($conn);
            header('Location: aluno.php?error=Esse login já está em uso!');
            exit();
        } else {
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt_verify);
                mysqli_close($conn);
                header('Location: aluno.php?sucess=Aluno editado com sucesso!');
                exit();
            } else {
                header('Location: aluno.php?error=Erro desconhecido!');
                exit();
            }
        }
    }
} else {
    header('Location: aluno.php');
    exit();
}
?>
