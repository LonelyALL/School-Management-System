<?php 
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
        header('Location: ../loginadmin/admin.php');
        exit();
    }
?>
<?php
require '../../connect/connect.php';

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Receber o ID da série enviado via POST
$serieId = $_POST['serie_id'];

// Consulta para obter as turmas da série
$sql = "SELECT id, turma FROM turmas WHERE serie_id = '$serieId' ORDER BY turma;";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<option value='{$row['turma']}'>{$row['turma']}</option>";
}

// Fechar a conexão com o banco de dados
$stmt->close();
$conn->close();
?>
