<?php 
session_start();
if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header('Location: ../loginadmin/admin.php');
    exit();
}

require '../connect/connect.php';

if (isset($_POST['id_aluno']) && isset($_POST['id_materia']) && isset($_POST['avaliacao']) && isset($_POST['bimestre'])) {
    $id_aluno = $_POST['id_aluno'];
    $id_materia = $_POST['id_materia'];
    $avaliacao = $_POST['avaliacao'];
    $bimestre = $_POST['bimestre'];

    $sql = "SELECT nota FROM notas_avaliacoes WHERE id_aluno = $id_aluno AND materia = $id_materia AND avaliacao = '$avaliacao' AND bimestre = '$bimestre'";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $nota = $row['nota'];
        
        echo json_encode(array('nota' => $nota));
    }
    mysqli_close($conn);
}
?>