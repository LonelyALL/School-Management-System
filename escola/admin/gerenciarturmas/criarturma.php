<?php
session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header('Location: ../loginadmin/admin.php');
    exit();
}

require '../../connect/connect.php';

if (isset($_POST['turma']) && !empty(trim($_POST['turma'])) && isset($_POST['serieid'])) {
    $turma = trim($_POST['turma']);
    $serie_id = $_POST['serieid'];

    if (!empty($turma)) {
        $sql2 = "SELECT MAX(id) as max_id FROM turmas";
        $stmt2 = mysqli_prepare($conn, $sql2);
        mysqli_stmt_execute($stmt2);
        $result = mysqli_stmt_get_result($stmt2);
        $row = mysqli_fetch_assoc($result);
        $new_id = $row['max_id'] + 1;

        $sql = "INSERT INTO turmas (id, turma, serie_id) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isi", $new_id, $turma, $serie_id);

        $sql3 = "SELECT * FROM turmas WHERE turma=?";
        $stmt3 = mysqli_prepare($conn, $sql3);
        mysqli_stmt_bind_param($stmt3, "s", $turma);
        mysqli_stmt_execute($stmt3);
        $result2 = mysqli_stmt_get_result($stmt3);

        if (mysqli_num_rows($result2) > 0) {
            header("Location: ../gerenciarturmas/gerenciarturmas.php?error=Essa turma já foi criada");
            exit();
        } else {
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../gerenciarturmas/gerenciarturmas.php?sucess=Turma criada com sucesso");
                exit();
            } else {
                header("Location: ../gerenciarturmas/gerenciarturmas.php?error=Erro ao criar turma");
                exit();
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt2);
        mysqli_stmt_close($stmt3);
        mysqli_close($conn);
    } else {
        header("Location: ../gerenciarturmas/gerenciarturmas.php?error=Preencha os campos corretamente");
        exit();
    }
} else {
    header("Location: ../gerenciarturmas/gerenciarturmas.php?error=Preencha os campos corretamente");
    exit();
}
?>
