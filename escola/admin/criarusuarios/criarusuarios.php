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
    <title>Autumn</title>
    <link rel="stylesheet" href="criarusuarios.css">
    <script src="https://kit.fontawesome.com/23d5698429.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php 
        require "../functions/navbar.php";
        showNavbar();
    ?>
    <div class="box">
        <div class="inputs">
            <div class="container">
                <div class="title"><h3>Escolha a função:</h3></div>
            <div>
                <button onclick="window.location.href = '../criaraluno/criaraluno.php'">Cadastrar Alunos</button>
                <button onclick="window.location.href = '../criarprofessor/criarprofessor.php'">Cadastrar Professores</button>
            </div>
            </div>
        </div>
    </div>
</body>
</html>