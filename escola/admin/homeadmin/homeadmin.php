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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colegio Santos - Area Admin</title>
    <link rel="stylesheet" href="homeadmin.css">
    <script src="https://kit.fontawesome.com/23d5698429.js" crossorigin="anonymous"></script>
    <script src="homeadmin.js" defer></script>
</head>
<body>
    <?php 
        require '../../connect/connect.php';
        require "../functions/navbar.php";
        showNavbar();
    ?>
    <main>
        <div class="container">
            <h3>Boas vindas, Admin</h3>
            <button id="logout" type="button">Sair</button>
        </div>
        <div class="box">
            <div class="align">
                <h3>Alunos Criados:</h3>
                <div class="n alunos">
                    <?php 
                        $sql = "SELECT * FROM alunos";
                        $result = mysqli_query($conn, $sql);
                        $numalunos = mysqli_num_rows($result);
                        echo $numalunos;
                    ?>
                </div>
            </div>
            <div class="align">
                <h3>Professores Criados:</h3>
                <div class="n professores">
                <?php 
                        $sql = "SELECT * FROM professor;";
                        $result = mysqli_query($conn, $sql);
                        $numprofs = mysqli_num_rows($result);
                        echo $numprofs;
                    ?>
                </div>
            </div>
            <div class="align">
                <h3>Turmas Criadas:</h3>
                <div class="n turmas">
                <?php 
                        $sql = "SELECT * FROM turmas";
                        $result = mysqli_query($conn, $sql);
                        $numturmas = mysqli_num_rows($result);
                        echo $numturmas;
                    ?>
                </div>
            </div>
            <div class="align">
                <h3>Séries Criadas:</h3>
                <div class="n series">
                <?php 
                        $sql = "SELECT * FROM series";
                        $result = mysqli_query($conn, $sql);
                        $numseries = mysqli_num_rows($result);
                        echo $numseries;
                        mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>