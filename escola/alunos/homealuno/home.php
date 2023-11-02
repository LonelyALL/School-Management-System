<?php 
    session_start();
    if (!isset($_SESSION['alunologged']) || $_SESSION['alunologged'] !== true) {
        header('Location: ../aluno.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autumn</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <header>
        <div class="nav-bar-elements">
            <img src="../../images/oregonnovalogo (5).png" alt="#">
            <div class="logo">Autumn</div>
        </div>
        <nav class="nav-bar">
            <ul>
                <li>
                    <a href="../logout.php" class="active">Logout</a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="infos">
            <div class="items">
                <?php 
                    require '../connect/connect.php';
                    $login = $_SESSION['login'];
                    $sql = "SELECT * FROM alunos WHERE login = '$login';";  
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);

                    $serieid = $row['serie'];

                    $sql_serie = "SELECT * FROM series WHERE id = '$serieid';";
                    $result_serie = mysqli_query($conn, $sql_serie);

                    echo "<div class='title'>";
                    echo "<h3>Boas Vindas, ". $row['nome'] ."</h3>";
                    echo "</div>";
                    echo "<div class='turmaSerie'>";
                    if(mysqli_num_rows($result_serie) > 0){
                        $row_serie = mysqli_fetch_assoc($result_serie);
                        $newserie = $row_serie['serie'];
                        echo "<span>Série: ". $newserie ." Ano</span>";
                    }
                    else{
                        echo "<span>Série: Sem série</span>";
                    }
                    echo "<span>Turma: ". $row['turma'] ."</span>";
                    echo "</div>";
                    echo "<div class='matricula'>";
                    echo "<span>Matrícula: ". $row['matricula'] ."</span>";
                    echo "</div>";
                ?>
            </div>
            <div class="button">
                <a href="../boletim/boletim.php">Visualizar Boletim</a>
            </div>
        </div>
    </main>
</body>
</html>