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
    <link rel="stylesheet" href="boletim.css">
    <script src="https://kit.fontawesome.com/23d5698429.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php 
        require "../functions/navbar.php";
        require '../../connect/connect.php';
        showNavbar();
    ?>
    <div class="box">
        <div class="errors">
                        <?php if(isset($_GET['error'])){ ?>
                            <div id="error"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" color="red" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
        </svg><?php echo $_GET['error']; ?></div>
                    <?php } ?>
                    <?php if(isset($_GET['sucess'])){ ?>
                        <div id="sucess"><svg viewBox="0 0 16 16" fill="none" width="20" height="20" preserveAspectRatio="xMidYMid meet" style="vertical-align: middle; color: rgb(0, 136, 71);"><g clip-path="url(#CheckCircle_svg__clip0_1372_9763)" fill="currentColor"><path d="M11.966 5.778a.6.6 0 10-.932-.756l-4.101 5.047-1.981-2.264a.6.6 0 00-.904.79l2.294 2.622a.8.8 0 001.223-.023l4.4-5.416z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M8 .4a7.6 7.6 0 100 15.2A7.6 7.6 0 008 .4zM1.6 8a6.4 6.4 0 1112.8 0A6.4 6.4 0 011.6 8z"></path></g><defs><clipPath id="CheckCircle_svg__clip0_1372_9763"><path fill="#fff" d="M0 0h16v16H0z"></path></clipPath></defs></svg><?php echo $_GET['sucess']; ?></div>
                    <?php } ?>
        </div>
        <main>
        <form action="boletim.php" method="get" id="form">
            <div class="inputs">
                <h4>Selecione a turma:</h4>
                <select name="turma" id="turma">
                    <?php 
                        require '../../connect/connect.php';
                        $sql = "SELECT * FROM turmas ORDER BY turma ASC;";
                        $result = mysqli_query($conn, $sql);

                        while($row = mysqli_fetch_assoc($result)){
                            echo '<option value="'. $row['id'] .'">'. $row['turma'] .'</option>';
                        }
                        mysqli_close($conn);
                    ?>       
                </select>
                <button>Acessar</button>
            </div>
        </form>
        <?php
            require '../../connect/connect.php';
            if(isset($_GET['turma'])){
                $turma = $_GET['turma'];
                $sql = "SELECT * FROM alunos WHERE turma IN (SELECT turma FROM turmas WHERE id = '$turma');"; 
                $result = mysqli_query($conn, $sql);

                
                if(mysqli_num_rows($result) > 0){
                    echo "<table class='scrollable-table'>";
                    echo "<tr class='titleTr'><th class='title'>Aluno</th><th class='title'>Matricula</th><th class='title'>Série</th><th class='title'>Ação</th></tr>";
                    while($row_aluno = mysqli_fetch_assoc($result)){
                        $idaluno = $row_aluno['matricula'];
                        $sql_serie = "SELECT * FROM series WHERE id = '{$row_aluno['serie']}';";
                        $result_serie = mysqli_query($conn, $sql_serie);
                        $newrow = mysqli_fetch_assoc($result_serie);

                        echo "<tr>";
                        echo "<td>";
                        echo $row_aluno['login'];
                        echo "</td>";
                        echo "<td>";
                        echo $row_aluno['matricula'];
                        echo "</td>";
                        echo "<td>";
                        echo $newrow['serie'] . " Ano";
                        echo "</td>";
                        echo "<td class='ancora'>";
                        echo '<a id="visualizar" href="detalhes.php?id='. $idaluno .'&turma='. $turma .'">Visualizar</a>';
                        echo "</td>";
                        echo "</tr>";
                    }
                }else{
                    header('Location: boletim.php?error=Nenhum usuário cadastrado nessa turma!');
                    exit();
                }         
            } 
            mysqli_close($conn);  
        ?>  
        </main>
    </div>
</body>
</html>