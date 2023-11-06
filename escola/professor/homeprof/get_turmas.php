<?php
session_start();
if (!isset($_SESSION['proflogged']) || $_SESSION['proflogged'] !== true) {
    header('Location: ../professor.php');
    exit();
}
if (isset($_POST['materia_id'])) {
    require '../../connect/connect.php';
    $materia_id = $_POST['materia_id'];

    $sql = "SELECT turmas.id, turmas.turma
            FROM turmas
            JOIN turma_materia ON turmas.id = turma_materia.turma
            WHERE turma_materia.materia = ? ORDER BY turma";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $materia_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $turmas = array();
    while ($row = $result->fetch_assoc()) {
        $turmas[] = $row;
    }

    $stmt->close();
    $conn->close();

    echo json_encode($turmas);
}
?>