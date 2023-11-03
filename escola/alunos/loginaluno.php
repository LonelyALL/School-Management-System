<?php
require '../alunos/connect/connect.php';

if(isset($_POST['user']) && isset($_POST['pass']) && !empty($_POST['user']) && !empty($_POST['pass'])){
    $login = trim($_POST["user"]);
    $password = trim($_POST["pass"]);

    $sql = "SELECT * FROM alunos WHERE login=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $login);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['senha'];

        if (password_verify($password, $hashedPassword)) {
            session_start();
            session_set_cookie_params(3600);
            $_SESSION['alunologged'] = true;
            $_SESSION['login'] = $login;
            header("Location: ../alunos/homealuno/home.php");
            exit();
        } else {
            header("Location: aluno.php?error=Usuário ou senha inválidos");
            exit();
        }
    } else {
        header("Location: aluno.php?error=Usuário ou senha inválidos");
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
