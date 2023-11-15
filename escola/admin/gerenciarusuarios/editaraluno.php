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
            <form action="editaluno.php" method="post">
                <div class="title">
                    <h2>Editar Aluno</h2>
                </div>
                <div class="inputs">
                    <?php 
                        require '../../connect/connect.php';
                        $id = $_GET['edit'];
                        $sql = "SELECT * FROM alunos WHERE matricula = '$id';";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);

                        $turma_atual = $row['turma'];

                        $sql_turmas = "SELECT * FROM turmas WHERE turma <> '$turma_atual' ORDER BY turma;";
                        $result_turmas = mysqli_query($conn, $sql_turmas);

                        echo "<span>Matricula:</span>";
                        echo '<input type="text" value="'. $row['matricula'] .'" name="id" readonly="true" required="true">';
                        echo "<span>Login:</span>";
                        echo '<input type="text" value="'. $row['login'] .'" name="login"  readonly="true" required="true">';
                        echo "<span>Nova Senha:</span>";
                        echo '<input type="text" name="senha" minlength="4" maxlength="12">';
                        echo '<span>Turma:</span>';
                        echo "<select name='turma' required='true'>";
                        echo "<option value='". $row['turma'] ."'>". $row['turma'] ."</option>";
                        while($row_turmas = mysqli_fetch_assoc($result_turmas)){
                            echo "<option value='". $row_turmas['turma'] ."'>". $row_turmas['turma'] ."</option>";
                        }
                        echo "</select>";
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