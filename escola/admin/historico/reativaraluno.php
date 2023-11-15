<?php 
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
        header('Location: ../loginadmin/admin.php');
        exit();
    }
?>
<?php 
    require '../../connect/connect.php';
    if(isset($_POST['id']) && isset($_POST['turma']) && !empty($_POST['id']) && !empty($_POST['turma'])){
        $turma = $_POST['turma'];
        $matricula = $_POST['id'];
        $status = "Ativado";

        $get_aluno = "SELECT * FROM alunos_desativados WHERE matricula = ?;";
        $stmt_aluno = mysqli_prepare($conn, $get_aluno);
        mysqli_stmt_bind_param($stmt_aluno, "s", $matricula);
        mysqli_stmt_execute($stmt_aluno);
        $result_aluno = mysqli_stmt_get_result($stmt_aluno);
        $row_aluno = mysqli_fetch_assoc($result_aluno);

        $nome = $row_aluno['nome'];
        $login = $row_aluno['login'];
        $senha = $row_aluno['senha'];
        $newMatricula = $row_aluno['matricula'];

        $get_serie = "SELECT * FROM turmas WHERE turma = ?;";
        $stmt_serie = mysqli_prepare($conn, $get_serie);
        mysqli_stmt_bind_param($stmt_serie, "s", $turma);
        mysqli_stmt_execute($stmt_serie);
        $result = mysqli_stmt_get_result($stmt_serie);
        $row = mysqli_fetch_assoc($result);
        $serieId = $row['serie_id'];

        $get_segmento = "SELECT * FROM series WHERE id = $serieId;";
        $result_segmento = mysqli_query($conn, $get_segmento);
        $row_segmento = mysqli_fetch_assoc($result_segmento);
        $segmento = $row_segmento['segmento'];

        $insert = "INSERT INTO alunos (nome, login, senha, matricula, turma, serie, segmento, status) VALUES ('$nome', '$login', '$senha', '$newMatricula', '$turma', '$serieId', '$segmento', '$status');";
        $delete = "DELETE FROM alunos_desativados WHERE matricula = '$newMatricula';";
        
        if(mysqli_query($conn, $insert) && mysqli_query($conn, $delete)){
            header('Location: desativados.php?sucess=Aluno reativado com sucesso.');
            exit();
        }
        else{
            header('Location: desativados.php?error=Erro desconhecido.');
            exit();
        }

    }
    else{
        header('Location: desativados.php');
        exit();
    }
?>