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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifique se os dados foram recebidos
    if (isset($_POST['materia']) && isset($_POST['professor']) && isset($_POST['turma']) && !empty($_POST['materia']) && !empty($_POST['professor']) && !empty($_POST['turma'])) {
        $materia = $_POST['materia'];
        $professor = $_POST['professor'];
        $turma = $_POST['turma'];

        $sql_professor = "SELECT * FROM professor WHERE login = '$professor';";
        $sql_materia = "SELECT * FROM materias WHERE materia = '$materia';";
        $sql_turma = "SELECT * FROM turmas WHERE turma = '$turma';";

        $result_turma = mysqli_query($conn, $sql_turma);
        $result_professor = mysqli_query($conn, $sql_professor);
        $result_materia = mysqli_query($conn, $sql_materia);

        $new_materia = mysqli_fetch_assoc($result_materia);
        $new_prof = mysqli_fetch_assoc($result_professor);
        $new_turma = mysqli_fetch_assoc($result_turma);

        // Execute a lógica para excluir os dados com base nos valores recebidos
        $sql = "DELETE FROM turma_materia WHERE turma = '". $new_turma["id"] ."' AND materia = '". $new_materia["id"] ."' AND proid = '". $new_prof["proid"] ."'";

        if (mysqli_query($conn, $sql)) {
            // Exclusão bem-sucedida
            $response = array('status' => 'success', 'message' => 'Associação deletada com sucesso');
            echo json_encode($response);
        } else {
            // Erro na exclusão
            $response = array('status' => 'error', 'message' => 'Erro ao deletar !');
            echo json_encode($response);
        }
        mysqli_close($conn);  
    } else {
        $response = array('status' => 'error', 'message' => 'Erro ao deletar, selecione uma matéria e professor !');
        echo json_encode($response);
    }
} else {
    $response = array('status' => 'error', 'message' => 'Erro ao deletar');
    echo json_encode($response);
}
?>