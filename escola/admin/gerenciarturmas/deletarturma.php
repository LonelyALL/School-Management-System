<?php
session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header('Location: ../loginadmin/admin.php');
    exit();
}
require '../functions/functions.php';
require '../../connect/connect.php';

$turma = $_POST['deletturma'];

if (isset($turma) && !empty($turma)) {
    $sql2 = "SELECT * FROM turmas WHERE turma = ?";
    $stmt2 = mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param($stmt2, "s", $turma);
    mysqli_stmt_execute($stmt2);
    $result = mysqli_stmt_get_result($stmt2);

    if (mysqli_num_rows($result) === 0) {
        header("Location: ../gerenciarturmas/gerenciarturmas.php?error=Turma inválida");
        exit();
    } else {
        $sql = "DELETE FROM turmas WHERE turma = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $turma);

        $sql3 = "SELECT * FROM alunos WHERE turma = ?";
        $stmt3 = mysqli_prepare($conn, $sql3);
        mysqli_stmt_bind_param($stmt3, "s", $turma);
        mysqli_stmt_execute($stmt3);
        $result_alunos = mysqli_stmt_get_result($stmt3);
        while($row_alunos = mysqli_fetch_assoc($result_alunos)){
            $moverAlunos = new desativarAluno($row_alunos['matricula']);
            $moverAlunos -> moverAluno("none", false);
        }


        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../gerenciarturmas/gerenciarturmas.php?sucess=Turma deletada com sucesso");
            exit();
        } else {
            header("Location: ../gerenciarturmas/gerenciarturmas.php?error=Erro desconhecido");
            exit();
        }
        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt2);
        mysqli_stmt_close($stmt3);
        mysqli_close($conn);
    }
} else {
    header("Location: ../gerenciarturmas/gerenciarturmas.php?error=Erro desconhecido");
    exit();
}
?>
