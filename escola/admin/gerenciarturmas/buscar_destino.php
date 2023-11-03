<?php 
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
        header('Location: ../loginadmin/admin.php');
        exit();
    }
?>
<?php
require '../connect/connect.php';

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Receber o ID da série enviado via POST
$segmento = $_POST['segmento'];

// Consulta para obter as turmas da série
$sql = "SELECT * FROM series WHERE segmento = '$segmento' ORDER BY serie;";
$result = mysqli_query($conn, $sql);

echo "<option value=''></option>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<option value='{$row['id']}'>{$row['serie']} Ano</option>";
}

mysqli_close($conn);
?>
