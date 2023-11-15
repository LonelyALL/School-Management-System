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
    <script src="https://kit.fontawesome.com/23d5698429.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="detalhes.css">
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
            </ul>
        </nav>
    </header>
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
<div class="box">
        <?php 
        require '../../connect/connect.php';
        if(isset($_GET['id']) && isset($_GET['turma'])){
            $turma = $_GET['turma'];
            $idaluno = $_GET['id'];
           
            $sql_nome = "SELECT nome, login FROM alunos WHERE matricula='$idaluno';";
            $result_nome = mysqli_query($conn, $sql_nome);
            $nome = mysqli_fetch_assoc($result_nome);
            echo "<div class='boxNomealuno'>";
            echo "<div class='nomealuno'>";
            echo "Aluno: " . htmlspecialchars($nome['nome']);
            echo "</div>";
            echo "</div>";
            echo "<main>";
            echo "<table class='scrollable-table'>";
            echo "<tr class='trTitle'><th class='title'>Matérias</th><th class='title'>1° Bimestre</th><th class='title'>Rec. 1° Bim.</th><th class='title'>2° Bimestre</th><th class='title'>Rec. 2° Bim.</th><th class='title'>3° Bimestre</th><th class='title'>Rec. 3° Bim.</th><th class='title'>4° Bimestre</th><th class='title'>Rec. 4° Bim.</th><th class='title'>Média</th><th class='title'>Situação</th><th class='title'>Ações</th></tr>";

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
                echo "<td class='escuro'>";
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
                                $notaRow = $row_nota_avaliacao['nota'];
                                $newNota = arredondaNota($notaRow);
                                echo $row_avaliacao['avaliacao'] . ": ". $newNota ."<br>"; 
                                $media = $media + $newNota;
                            }    
                            else{
                                echo $row_avaliacao['avaliacao'] . ": -<br>";
                                $media = $media + 0;
                            }
                            
                        }   
                        $media = arredondaNota($media / $num_avaliacoes);
                        echo "-----------<br>";
                        echo "Média: ". $media;
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
                echo "<td class='ancora'>";
                echo '<a href="editarnota.php?id='. $idaluno .'&turma='. $turma .'&materia='. $row_materia['materia'] .'&idmateria='. $row_materia['id'] .'&nome='. $nome['login'] .'&local=detalhes">Editar</a>';
                echo "</td>";
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
        }
        else{
            header('Location: boletim.php');
        }
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
    mysqli_close($conn);
    ?>

        </table>
    <form action="fecharnotas.php" method="post" id="form-notas">
        <div class="buttons-nota">
            <button type="submit">Fechar Notas</button>
            <?php 
                $id2 = $_GET['id'];
                $turma2 = $_GET['turma'];

                echo "<input type='hidden' name='id' value='". $id2 ."'>";
                echo "<input type='hidden' name='turma' value='". $turma2 ."'>";
            ?>
        </div>
    </form>        
</main>
    </div> 
    <script>
        document.getElementById('botaoVoltar').addEventListener('click', function() {

            window.location.href = 'boletim.php';
        });
    </script>
</body>
</html>
