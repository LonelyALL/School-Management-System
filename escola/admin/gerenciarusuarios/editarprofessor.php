<?php 
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
        header('Location: ../loginadmin/admin.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autumn</title>
    <link rel="stylesheet" href="editarusuarios.css">
</head>
<body>
    <main>
        <div class="box">
            <form action="editprofessor.php" method="post">
                <div class="title">
                    <h2>Editar Professor</h2>
                </div>
                <div class="inputs">
                    <?php 
                        require '../../connect/connect.php';
                        $id = $_GET['edit'];
                        $sql = "SELECT * FROM professor WHERE proid = '$id';";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        echo "<span>Id:</span>";
                        echo '<input type="text" value="'. $row['proid'] .'" name="id" readonly="true" required="true">';
                        echo "<span>Login:</span>";
                        echo '<input type="text" value="'. $row['login'] .'" name="login" minlength="4" maxlength="12" required="true">';
                        echo "<span>Nova Senha:</span>";
                        echo '<input type="text" name="senha" minlength="4" maxlength="12">';
                        echo '<input type="hidden" value="'. $row['login'] .'" name="loginfixo" required="true">';
                        mysqli_close($conn);
                    ?>
                </div>
                <div class="buttons">
                    <button type="submit">Salvar</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>