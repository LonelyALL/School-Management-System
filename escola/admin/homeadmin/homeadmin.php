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
<nav>
        <ul>
            <li>
                <a href="#" class="logo">
                    <img src="../../images/oregonnovalogo.png" alt="#">
                    <span class="nav-item">Autumn</span>
                </a>
            </li>
            <li>
                <a href="../homeadmin/homeadmin.php">
                    <i class="fas fa-home"></i>
                    <span class="nav-item">Home</span>
                </a>
            </li>
            <li>
                <a href="../boletim/boletim.php">
                    <i class="fas fa-book"></i>
                    <span class="nav-item">Boletim</span>
                </a>
            </li>
            <li>
                <a href="../criarusuarios/criarusuarios.php">
                    <i class="fas fa-user"></i>
                    <span class="nav-item">Criar Usuários</span>
                </a>
            </li>
            <li>
                <a href="../gerenciarusuarios/aluno.php">
                    <i class="fas fa-user-group"></i>
                    <span class="nav-item">Gerenciar Usuários</span>
                </a>
            </li>
            <li>
                <a href="../arvoredematerias/arvoredematerias.php">
                    <i class="fas fa-layer-group"></i>
                    <span class="nav-item">Árvore de Matérias</span>
                </a>
            </li>
            <li>
                <a href="../gerenciarturmas/gerenciarturmas.php">
                    <i class="fas fa-cog"></i>
                    <span class="nav-item">Gerenciar Turmas</span>
                </a>
            </li>
            <li>
                <a href="../associarmaterias/associar.php">
                    <i class="fas fa-link"></i>
                    <span class="nav-item">Associação de Itens</span>
                </a>
            </li>
            <li>
                <a href="../ajustes/ajustes.php">
                    <i class="fas fa-wrench"></i>
                    <span class="nav-item">Ajustes</span>
                </a>
            </li>
            <li>
                <a href="../migracao/migracao.php">
                    <i class="fas fa-arrow-right-arrow-left"></i>
                    <span class="nav-item">Migração</span>
                </a>
            </li>
        </ul>
    </nav>
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
                        require '../connect/connect.php';
                        $sql = "SELECT * FROM alunos";
                        $result = mysqli_query($conn, $sql);
                        $numalunos = mysqli_num_rows($result);
                        echo $numalunos;
                        mysqli_close($conn);
                    ?>
                </div>
            </div>
            <div class="align">
                <h3>Professores Criados:</h3>
                <div class="n professores">
                <?php 
                        require '../connect/connect.php';
                        $sql = "SELECT * FROM professor";
                        $result = mysqli_query($conn, $sql);
                        $numprofs = mysqli_num_rows($result);
                        echo $numprofs;
                        mysqli_close($conn);
                    ?>
                </div>
            </div>
            <div class="align">
                <h3>Turmas Criadas:</h3>
                <div class="n turmas">
                <?php 
                        require '../connect/connect.php';
                        $sql = "SELECT * FROM turmas";
                        $result = mysqli_query($conn, $sql);
                        $numturmas = mysqli_num_rows($result);
                        echo $numturmas;
                        mysqli_close($conn);
                    ?>
                </div>
            </div>
            <div class="align">
                <h3>Séries Criadas:</h3>
                <div class="n series">
                <?php 
                        require '../connect/connect.php';
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