<?php 
    session_start();
    if (!isset($_SESSION['proflogged']) || $_SESSION['proflogged'] !== true) {
        header('Location: ../professor.php');
        exit();
    }
?>
<?php 
    require '../../connect/connect.php';
    if(isset($_POST['bimestre']) && isset($_POST['avaliacao']) && isset($_POST['matricula']) && isset($_POST['turma']) && isset($_POST['idmateria']) && isset($_POST['nota'])){
        
        $bimestre = $_POST['bimestre'];
        $avaliacao = $_POST['avaliacao'];
        $turma = $_POST['turma'];
        $matricula = $_POST['matricula'];
        $idmateria = $_POST['idmateria'];
        $nota = $_POST['nota'];

        if (strpos($bimestre, "recbimestre") !== false) {
            $sql_nota = "SELECT * FROM recuperacao WHERE materia = '$idmateria' AND id_aluno = '$matricula' AND bimestre = '$bimestre';";
            $result_nota = mysqli_query($conn, $sql_nota);
            if(mysqli_num_rows($result_nota) > 0){
                $sql_update = "UPDATE `recuperacao` SET nota='$nota' WHERE id_aluno='$matricula' AND materia='$idmateria' AND bimestre='$bimestre';";

                if(mysqli_query($conn, $sql_update)){
                    header('Location: visualizaralunos.php?id='. $matricula .'&turma='. $turma .'&sucess=Nota alterada com sucesso!');
                    exit();
                }
                else{
                    header('Location: visualizaralunos.php?id='. $matricula .'&turma='. $turma .'&error=Erro ao alterar nota!');
                    exit();
                }
            }
            else{
                $sql_insert = "INSERT INTO recuperacao (id_aluno, materia, nota, bimestre) VALUES ('$matricula', '$idmateria', '$nota', '$bimestre');";
                if(mysqli_query($conn, $sql_insert)){
                    header('Location: visualizaralunos.php?id='. $matricula .'&turma='. $turma .'&sucess=Nota alterada com sucesso!');
                    exit();
                }
                else{
                    header('Location: visualizaralunos.php?id='. $matricula .'&turma='. $turma .'&error=Erro ao alterar nota!');
                    exit();
                }
            }
        } else {
            $sql_nota = "SELECT * FROM notas_avaliacoes WHERE materia = '$idmateria' AND id_aluno = '$matricula' AND avaliacao = '$avaliacao' AND bimestre = '$bimestre';";
            $result_nota = mysqli_query($conn, $sql_nota);
            if(mysqli_num_rows($result_nota) > 0){
                $sql_update = "UPDATE `notas_avaliacoes` SET nota='$nota' WHERE id_aluno='$matricula' AND materia='$idmateria' AND avaliacao='$avaliacao' AND bimestre='$bimestre';";

                if(mysqli_query($conn, $sql_update)){
                    header('Location: visualizaralunos.php?id='. $matricula .'&turma='. $turma .'&sucess=Nota alterada com sucesso!');
                    exit();
                }
                else{
                    header('Location: visualizaralunos.php?id='. $matricula .'&turma='. $turma .'&error=Erro ao alterar nota!');
                    exit();
                }
            }
            else{
            
                $sql_insert = "INSERT INTO notas_avaliacoes (id_aluno, materia, avaliacao, nota, bimestre) VALUES ('$matricula', '$idmateria', '$avaliacao', '$nota', '$bimestre');";
                if(mysqli_query($conn, $sql_insert)){
                    header('Location: visualizaralunos.php?id='. $matricula .'&turma='. $turma .'&sucess=Nota alterada com sucesso!');
                    exit();
                }
                else{
                    header('Location: visualizaralunos.php?id='. $matricula .'&turma='. $turma .'&error=Erro ao alterar nota!');
                    exit();
                }
            }
        }
    }
    else{
        header('Location: boletim.php');
        exit();
    }
?>