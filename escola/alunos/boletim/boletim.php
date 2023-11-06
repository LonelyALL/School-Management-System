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
    <link rel="stylesheet" href="boletim.css">
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
                    <button type='button' id='botaoVoltar'>Voltar</button>
                </li>
                <li>
                    <a href="../logout.php" class="active">Logout</a>
                </li>
            </ul>
        </nav>
    </header>
    <div class="box">
    <?php
        require '../../connect/connect.php';
        $login = $_SESSION['login'];
        
        $sql_nome = "SELECT nome, turma, matricula FROM alunos WHERE login='$login';";
        $result_nome = mysqli_query($conn, $sql_nome);  
        $nome = mysqli_fetch_assoc($result_nome);
        $idaluno = $nome['matricula'];

        $sql_getTurma = "SELECT * FROM turmas WHERE turma = ". $nome['turma'] .";";
        $result_getTurma = mysqli_query($conn, $sql_getTurma);
        $row_turma = mysqli_fetch_assoc($result_getTurma);
        $turma = $row_turma['id'];


        echo "<div class='boxNomealuno'>";
        echo "<div class='nomealuno'>";
        echo "Aluno: " . $nome['nome'];
        echo "</div>";
        echo "</div>";
        echo "<main>";
        echo "<table class='scrollable-table'>";
        echo "<tr><th class='title'>Matérias</th><th class='title'>1° Bimestre</th><th class='title'>Rec. 1° Bim.</th><th class='title'>2° Bimestre</th><th class='title'>Rec. 2° Bim.</th><th class='title'>3° Bimestre</th><th class='title'>Rec. 3° Bim.</th><th class='title'>4° Bimestre</th><th class='title'>Rec. 4° Bim.</th><th class='title'>Média</th><th class='title'>Situação</th></tr>";

        $mediaFinal = 0;
        $reprovacoes = 0;
        $totalMaterias = 0;
        
        $sql_materia = "SELECT * FROM materias WHERE id IN (SELECT materia FROM turma_materia WHERE turma = '$turma');";
        $result_materia = mysqli_query($conn, $sql_materia);
                
        while($row_materia = mysqli_fetch_assoc($result_materia)){ //Where Pegar todas materias do bd
            $totalMaterias = $totalMaterias + 1;
            $sql_nota = "SELECT * FROM notas_avaliacoes WHERE materia = '". $row_materia['id'] ."' AND id_aluno = '$idaluno';";
            $result_nota = mysqli_query($conn, $sql_nota);
            
            $sql_recuperacao = "SELECT * FROM recuperacao WHERE materia = '". $row_materia['id'] ."' AND id_aluno = '$idaluno';";
            $result_recuperacao = mysqli_query($conn, $sql_recuperacao);

            echo "<tr>";
            echo "<td>";
            echo $row_materia['materia'];
            echo "</td>";

            $sql_media = "SELECT media FROM media WHERE id='1';";
            $result_media = mysqli_query($conn, $sql_media);
            $row_media = mysqli_fetch_assoc($result_media);
            $mediaCadastrada = $row_media['media'];
            $mediaFinal = 0;

            if((mysqli_num_rows($result_nota) > 0) OR (mysqli_num_rows($result_recuperacao) > 0)){
                for ($i = 1; $i <= 4; $i++) {
                    $media = 0;
                    echo "<td>";
                    $sql_avaliacao = "SELECT * FROM avaliacoes;";
                    $result_avaliacao = mysqli_query($conn, $sql_avaliacao);
                    $num_avaliacoes = mysqli_num_rows($result_avaliacao);

                    while($row_avaliacao = mysqli_fetch_assoc($result_avaliacao)){
                        $sql_nota_avaliacao = "SELECT * FROM notas_avaliacoes WHERE materia = '". $row_materia['id'] ."' AND id_aluno = '$idaluno' AND avaliacao = '". $row_avaliacao['avaliacao'] ."' AND bimestre = 'bimestre$i';";
                        $result_nota_avaliacao = mysqli_query($conn, $sql_nota_avaliacao);
                        
                        $row_nota_avaliacao = mysqli_fetch_assoc($result_nota_avaliacao);
                    
                        if(mysqli_num_rows($result_nota_avaliacao) > 0){
                            echo $row_avaliacao['avaliacao'] . ": ". $row_nota_avaliacao['nota'] ."<br>"; 
                            $media = $media + $row_nota_avaliacao['nota'];
                        }    
                        else{
                            echo $row_avaliacao['avaliacao'] . ": -<br>";
                            $media = $media + 0;
                        }
                        
                    }   
                    $media = arredondaNota($media / $num_avaliacoes);
                    echo "-----------<br>";
                    echo "Média: ".$media;
                    echo "</td>";

                    $sql_verifyRecuperacao = "SELECT * FROM recuperacao WHERE materia = '". $row_materia['id'] ."' AND id_aluno = '$idaluno' AND bimestre = 'recbimestre$i';";
                    $result_verifyRecuperacao = mysqli_query($conn, $sql_verifyRecuperacao);

                    if(mysqli_num_rows($result_verifyRecuperacao) > 0){
                        $row_recuperacao = mysqli_fetch_assoc($result_verifyRecuperacao);
                        echo "<td>";
                        echo $row_recuperacao['nota'];
                        echo "</td>";
                        if($media > $row_recuperacao['nota']){
                            $mediaFinal = $mediaFinal + $media;
                        }
                        else{
                            $mediaFinal = $mediaFinal + $row_recuperacao['nota'];
                        }
                    }
                    else{
                        echo "<td>";
                        echo "-";
                        echo "</td>";
                        $mediaFinal = $mediaFinal + $media;
                    }
                }

                $newmediaFinal = arredondaNota($mediaFinal / 4);

                echo "<td>";
                echo $newmediaFinal;
                echo "</td>";

                if($newmediaFinal >= $mediaCadastrada){
                    echo "<td>";
                    echo "APR";
                    echo "</td>";
                }
                else{
                    echo "<td>";
                    echo "REP";
                    echo "</td>";
                    $reprovacoes = $reprovacoes + 1;
                }
            }
            else{
                echo "<td>";
                echo "-";
                echo "</td>";
                echo "<td>";
                echo "-";
                echo "</td>";
                echo "<td>";
                echo "-";
                echo "</td>";
                echo "<td>";
                echo "-";
                echo "</td>";
                echo "<td>";
                echo "-";
                echo "</td>";
                echo "<td>";    
                echo "-";       
                echo "</td>"; 
                echo "<td>";
                echo "-";
                echo "</td>";
                echo "<td>";
                echo "-";
                echo "</td>";
                echo "<td>";
                echo "-";
                echo "</td>";
                echo "<td>";
                echo "REP";
                echo "</td>";
                $reprovacoes = $reprovacoes + 1;
            }
            echo "</tr>";
        }
        echo '<tr class="reprovacaoTr">';
        echo '<td class="reprovacaoTd">';
        echo "Total de Matérias: " . $totalMaterias;
        echo '</td>';
        echo '<td class="reprovacaoTd">';
        echo "Matérias Reprovadas: " . $reprovacoes;
        echo '</td>';
        echo '<td class="reprovacaoTd">';
        if($reprovacoes > 0){
            echo "Situação Final: Reprovado.";
        }
        else{
            echo "Situação Final: Aprovado.";
        }
        
        echo '</td>';
        echo '</tr>';
        function arredondaNota($nota) {
            $parteDecimal = $nota - floor($nota);
        
            if($parteDecimal == 0){
                return ($nota);
            } else 
                if($parteDecimal >= 0.25 && $parteDecimal <= 0.6){
                    return (floor($nota) + 0.5);
            
                } else{
                    if($parteDecimal > 0.6){
                        return ceil($nota);
                    }
                    else{
                        return floor($nota);
                    }
                } 
        }    
    ?>
    </div>
    <script>
        document.getElementById('botaoVoltar').addEventListener('click', function() {

            window.location.href = '../homealuno/home.php';
        });
    </script>
</body>
</html>