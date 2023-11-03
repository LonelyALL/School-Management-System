<?php
session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header('Location: ../loginadmin/admin.php');
    exit();
}

require '../connect/connect.php';

if (
    isset($_POST['login']) && isset($_POST['senha'])
) {
    $login = trim($_POST['login']);
    $senha = trim($_POST['senha']);

    if (!empty($login) && !empty($senha)) {
        $sql2 = "SELECT MAX(proid) as max_proid FROM professor";
        $stmt2 = mysqli_prepare($conn, $sql2);
        mysqli_stmt_execute($stmt2);
        $result = mysqli_stmt_get_result($stmt2);
        $row = mysqli_fetch_assoc($result);
        $new_id = $row['max_proid'] + 1;

        $newSenha = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO professor (proid, login, senha) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iss", $new_id, $login, $newSenha);

        $sql3 = "SELECT * FROM professor WHERE login=?";
        $stmt3 = mysqli_prepare($conn, $sql3);
        mysqli_stmt_bind_param($stmt3, "s", $login);
        mysqli_stmt_execute($stmt3);
        $result2 = mysqli_stmt_get_result($stmt3);

        if (mysqli_num_rows($result2) > 0) {
            header("Location: ../criarprofessor/criarprofessor.php?error=Usuario já cadastrado");
            exit();
        } else {
            if (isset($login) && isset($senha) && !empty($login) && !empty($senha)) {
                if (mysqli_stmt_execute($stmt)) {
                    header("Location: ../criarprofessor/criarprofessor.php?sucess=Usuario criado com sucesso");
                    exit();
                } else {
                    header("Location: ../criarprofessor/criarprofessor.php?error=Erro ao criar usuário");
                    exit();
                }
            } else {
                header("Location: ../criarprofessor/criarprofessor.php?error=Preencha os campos corretamente");
                exit();
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt2);
        mysqli_stmt_close($stmt3);
        mysqli_close($conn);
    } else {
        header("Location: ../criarprofessor/criarprofessor.php?error=Preencha os campos corretamente");
        exit();
    }
} else {
    header("Location: ../criarprofessor/criarprofessor.php?error=Preencha os campos corretamente");
    exit();
}
?>
