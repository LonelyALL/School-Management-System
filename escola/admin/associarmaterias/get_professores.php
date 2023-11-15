<?php 
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
        header('Location: ../loginadmin/admin.php');
        exit();
    }
?>
<?php
// Conecte-se ao banco de dados
require '../../connect/connect.php';

if (isset($_POST['materia_id']) && isset($_POST['turma_id'])) {
    $materia_id = $_POST['materia_id'];
    $turma_id = $_POST['turma_id'];

    $sql_materia = "SELECT * FROM materias WHERE materia = '$materia_id';";
    $sql_turma = "SELECT * FROM turmas WHERE turma = '$turma_id';";

    $result_materia = mysqli_query($conn, $sql_materia);
    $result_turma = mysqli_query($conn, $sql_turma);

    if ($result_materia && $result_turma) {
        $new_materia = mysqli_fetch_assoc($result_materia);
        $new_turma = mysqli_fetch_assoc($result_turma);

        // Consulta SQL para obter os professores associados à matéria e turma
        $sql_professores = "SELECT login FROM professor WHERE proid IN (SELECT proid FROM turma_materia WHERE materia = " . $new_materia['id'] . " AND turma = " . $new_turma['id'] . ")";
        $result_professores = mysqli_query($conn, $sql_professores);

        $professores = array();
        while ($row_professores = mysqli_fetch_assoc($result_professores)) {
            $professores[] = $row_professores['login'];
        }

        // Retorna os professores como JSON
        echo json_encode($professores);
    } else {
        echo "Erro na consulta ao banco de dados.";
    }
} else {
    echo "ID da matéria ou da turma não fornecido.";
}

mysqli_close($conn);
?>
