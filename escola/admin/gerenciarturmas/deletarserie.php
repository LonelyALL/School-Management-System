<?php
session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header('Location: ../loginadmin/admin.php');
    exit();
}

require '../functions/functions.php';
require '../../connect/connect.php';

$serie = $_POST['deletserie'];
$segmento = $_POST['segmentodeletar'];

if (isset($serie) && !empty($serie) && isset($segmento) && !empty($segmento)) {
    $sql2 = "SELECT id FROM series WHERE serie = ? AND segmento = ?";
    $stmt2 = mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param($stmt2, "ss", $serie, $segmento);
    mysqli_stmt_execute($stmt2);
    $result = mysqli_stmt_get_result($stmt2);

    if (mysqli_num_rows($result) === 0) {
        header("Location: ../gerenciarturmas/gerenciarturmas.php?error=Série inválida");
        exit();
    } else {
        $row = mysqli_fetch_assoc($result);
        $serie_id = $row['id'];

        $sql = "DELETE FROM series WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $serie_id);

        $sql3 = "DELETE FROM turmas WHERE serie_id = ?";
        $stmt3 = mysqli_prepare($conn, $sql3);
        mysqli_stmt_bind_param($stmt3, "i", $serie_id);

        $sql_aluno = "SELECT * FROM alunos WHERE serie IN (SELECT serie FROM series WHERE id = ?)";
        $stmt_aluno = mysqli_prepare($conn, $sql_aluno);
        mysqli_stmt_bind_param($stmt_aluno, "i", $serie_id);
        mysqli_stmt_execute($stmt_aluno);
        $result_alunos = mysqli_stmt_get_result($stmt_aluno);
        while($row_alunos = mysqli_fetch_assoc($result_alunos)){
            $moverAlunos = new desativarAluno($row_alunos['matricula']);
            $moverAlunos -> moverAluno("none", false);
        }

        if (mysqli_stmt_execute($stmt) && mysqli_stmt_execute($stmt3)) {
            header("Location: ../gerenciarturmas/gerenciarturmas.php?sucess=Série deletada com sucesso!");
            exit();
        } else {
            header("Location: ../gerenciarturmas/gerenciarturmas.php?error=Erro ao deletar!");
            exit();
        }
        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt2);
        mysqli_stmt_close($stmt3);
        mysqli_stmt_close($stmt_aluno);
        mysqli_close($conn);
    }
} else {
    header("Location: ../gerenciarturmas/gerenciarturmas.php?error=Erro desconhecido");
    exit();
}
?>
