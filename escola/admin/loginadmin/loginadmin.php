<?php
require '../connect/connect.php';

if (isset($_POST['user']) && isset($_POST['pass']) && !empty($_POST['user']) && !empty($_POST['pass'])) {
    $login = trim($_POST["user"]);
    $password = trim($_POST["pass"]);

    $sql = "SELECT * FROM gerencia WHERE usuario=?";
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
            $_SESSION['logged'] = true;
            header("Location: ../homeadmin/homeadmin.php");
            exit();
        }
    }
    header("Location: admin.php?error=Usuário ou senha inválidos");
    exit();
} else {
    header("Location: admin.php?error=Usuário ou senha inválidos");
    exit();
}
?>
