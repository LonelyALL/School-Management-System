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
    <link rel="stylesheet" href="reativar.css">
</head>
<body>
    <main>
        <div class="box">
            <form action="reativaraluno.php" method="post">
                <div class="title">
                    <h2>Reativar Aluno</h2>
                </div>
                <div class="inputs">
                    <?php 
                        require '../../connect/connect.php';
                        if(isset($_GET['id']) && !empty($_GET['id'])){
                            $id = $_GET['id'];
                            $sql = "SELECT * FROM alunos_desativados WHERE matricula = ?;";
                            $stmt = mysqli_prepare($conn, $sql);
                            mysqli_stmt_bind_param($stmt, "i", $id);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            $row = mysqli_fetch_assoc($result);

                            $sql_turmas = "SELECT * FROM turmas;";
                            $result_turmas = mysqli_query($conn, $sql_turmas);

                            echo "<span>Matricula:</span>";
                            echo '<input type="text" value="'. $row['matricula'] .'" name="id" readonly="true" required="true">';
                            echo "<span>Login:</span>";
                            echo '<input type="text" value="'. $row['login'] .'" readonly="true" required="true">';
                            echo '<span>Selecionar Turma:</span>';
                            echo "<select name='turma' required='true'>";
                            while($row_turmas = mysqli_fetch_assoc($result_turmas)){
                                echo "<option value='". $row_turmas['turma'] ."'>". $row_turmas['turma'] ."</option>";
                            }
                            echo "</select>";
                            mysqli_close($conn);
                        }
                        else{
                            header('Location: desativados.php');
                        }
                    ?>
                </div>
                <div class="buttons">
                    <button type="submit">Reativar</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>