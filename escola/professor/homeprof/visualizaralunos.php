<?php 
    session_start();
    if (!isset($_SESSION['proflogged']) || $_SESSION['proflogged'] !== true) {
        header('Location: ../professor.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autumn</title>
    <link rel="stylesheet" href="visualizaralunos.css">
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
                    <a href="home.php" class="active">Voltar</a>
                </li>
                <li>
                    <a href="../logout.php" class="active">Logout</a>
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
            if(isset($_POST['materia']) && isset($_POST['turma']) && !empty($_POST['materia']) && !empty($_POST['turma'])){
                $materia = $_POST['materia'];
                $turma = $_POST['turma'];

                $_SESSION['materia'] = $materia;
                $_SESSION['turma'] = $turma;

                $sql_nome = "SELECT * FROM materias WHERE id='$materia';";
                $result_nome = mysqli_query($conn, $sql_nome);
                $nome = mysqli_fetch_assoc($result_nome);
                echo "<div class='boxNomealuno'>";
                echo "<div class='nomealuno'>";
                echo "Matéria: " . $nome['materia'];
                echo "</div>";
                echo "</div>";
                echo "<main>";
                echo "<table class='scrollable-table'>";
                echo "<tr><th class='title'>Alunos</th><th class='title'>1° Bimestre</th><th class='title'>Rec. 1° Bim.</th><th class='title'>2° Bimestre</th><th class='title'>Rec. 2° Bim.</th><th class='title'>3° Bimestre</th><th class='title'>Rec. 3° Bim.</th><th class='title'>4° Bimestre</th><th class='title'>Rec. 4° Bim.</th><th class='title'>Média</th><th class='title'>Situação</th><th class='title'>Ações</th>  </tr>";

                $mediaFinal = 0;
                $reprovacoes = 0;
                $totalAlunos = 0;
                $aprovados = 0;
                
                $sql_alunos = "SELECT * FROM alunos WHERE turma IN (SELECT turma FROM turmas WHERE id = '$turma');";
                $result_alunos = mysqli_query($conn, $sql_alunos);  
                        
                while($row_alunos = mysqli_fetch_assoc($result_alunos)){ 
                    $totalAlunos = $totalAlunos + 1;
                    $idaluno = $row_alunos['matricula'];
                    $sql_nota = "SELECT * FROM notas_avaliacoes WHERE materia = '$materia' AND id_aluno = '$idaluno';";
                    $result_nota = mysqli_query($conn, $sql_nota);
                    
                    $sql_recuperacao = "SELECT * FROM recuperacao WHERE materia = '$materia' AND id_aluno = '$idaluno';";
                    $result_recuperacao = mysqli_query($conn, $sql_recuperacao);

                    echo "<tr>";
                    echo "<td>";
                    echo $row_alunos['login'];
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
                                $sql_nota_avaliacao = "SELECT * FROM notas_avaliacoes WHERE materia = '$materia' AND id_aluno = '$idaluno' AND avaliacao = '". $row_avaliacao['avaliacao'] ."' AND bimestre = 'bimestre$i';";
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
                            $media /= $num_avaliacoes;
                            echo "-----------<br>";
                            echo "Média: ".$media;
                            echo "</td>";

                            $sql_verifyRecuperacao = "SELECT * FROM recuperacao WHERE materia = '$materia' AND id_aluno = '$idaluno' AND bimestre = 'recbimestre$i';";
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
                            }
                        }

                        echo "<td>";
                        echo $mediaFinal / 4;
                        echo "</td>";
                        
                        $newmediaFinal = $mediaFinal / 4;

                        if($newmediaFinal >= $mediaCadastrada){
                            echo "<td>";
                            echo "APR";
                            echo "</td>";
                            $aprovados = $aprovados + 1;
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
                    echo '<form action="editarnota.php" method="post" id="form3">';
                    echo '<a href="javascript: void(0)" id="botaoEditar">Editar</a>';
                    echo '<input type="hidden" value="'. $idaluno .'" name="id">';
                    echo '<input type="hidden" value="'. $turma .'" name="turma">';
                    echo '<input type="hidden" value="'. $nome['materia'] .'" name="materia">';
                    echo '<input type="hidden" value="'. $materia .'" name="idmateria">';
                    echo '<input type="hidden" value="'. $row_alunos['login'] .'" name="nome">';
                    echo '</form>';
                    echo "</td>";
                    echo "</tr>";
                }
                echo '<tr class="reprovacaoTr">';
                echo '<td class="reprovacaoTd">';
                echo "Total de Alunos: " . $totalAlunos;
                echo '</td>';
                echo '<td class="reprovacaoTd">';
                echo "Alunos Reprovados: " . $reprovacoes;
                echo '</td>';
                echo '<td class="reprovacaoTd">';
                echo "Alunos Aprovados: " . $aprovados;
                echo '</td>';
                echo '</tr>';
            }
            else if (isset($_SESSION['turma']) && isset($_SESSION['materia'])){
                $materia = $_SESSION['materia'];
                $turma = $_SESSION['turma'];

                $sql_nome = "SELECT * FROM materias WHERE id='$materia';";
                $result_nome = mysqli_query($conn, $sql_nome);
                $nome = mysqli_fetch_assoc($result_nome);
                echo "<div class='boxNomealuno'>";
                echo "<div class='nomealuno'>";
                echo "Matéria: " . $nome['materia'];
                echo "</div>";
                echo "</div>";
                echo "<main>";
                echo "<table class='scrollable-table'>";
                echo "<tr><th class='title'>Alunos</th><th class='title'>1° Bimestre</th><th class='title'>Rec. 1° Bim.</th><th class='title'>2° Bimestre</th><th class='title'>Rec. 2° Bim.</th><th class='title'>3° Bimestre</th><th class='title'>Rec. 3° Bim.</th><th class='title'>4° Bimestre</th><th class='title'>Rec. 4° Bim.</th><th class='title'>Média</th><th class='title'>Situação</th><th class='title'>Ações</th></tr>";

                $mediaFinal = 0;
                $reprovacoes = 0;
                $totalAlunos = 0;
                $aprovados = 0;
                
                $sql_alunos = "SELECT * FROM alunos WHERE turma IN (SELECT turma FROM turmas WHERE id = '$turma');";
                $result_alunos = mysqli_query($conn, $sql_alunos);  
                        
                while($row_alunos = mysqli_fetch_assoc($result_alunos)){ 
                    $totalAlunos = $totalAlunos + 1;
                    $idaluno = $row_alunos['matricula'];
                    $sql_nota = "SELECT * FROM notas_avaliacoes WHERE materia = '$materia' AND id_aluno = '$idaluno';";
                    $result_nota = mysqli_query($conn, $sql_nota);
                    
                    $sql_recuperacao = "SELECT * FROM recuperacao WHERE materia = '$materia' AND id_aluno = '$idaluno';";
                    $result_recuperacao = mysqli_query($conn, $sql_recuperacao);

                    echo "<tr>";
                    echo "<td>";
                    echo $row_alunos['login'];
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
                                $sql_nota_avaliacao = "SELECT * FROM notas_avaliacoes WHERE materia = '$materia' AND id_aluno = '$idaluno' AND avaliacao = '". $row_avaliacao['avaliacao'] ."' AND bimestre = 'bimestre$i';";
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
                            echo "Média: ". $media;
                            echo "</td>";

                            $sql_verifyRecuperacao = "SELECT * FROM recuperacao WHERE materia = '$materia' AND id_aluno = '$idaluno' AND bimestre = 'recbimestre$i';";
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
                            $aprovados = $aprovados + 1;
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
                    echo '<form action="editarnota.php" method="post" id="form3">';
                    echo '<a href="javascript: void(0)" id="botaoEditar">Editar</a>';
                    echo '<input type="hidden" value="'. $idaluno .'" name="id">';
                    echo '<input type="hidden" value="'. $turma .'" name="turma">';
                    echo '<input type="hidden" value="'. $nome['materia'] .'" name="materia">';
                    echo '<input type="hidden" value="'. $materia .'" name="idmateria">';
                    echo '<input type="hidden" value="'. $row_alunos['login'] .'" name="nome">';
                    echo '</form>';
                    echo "</td>";
                    echo "</tr>";
                }
                echo '<tr class="reprovacaoTr">';
                echo '<td class="reprovacaoTd">';
                echo "Total de Alunos: " . $totalAlunos;
                echo '</td>';
                echo '<td class="reprovacaoTd">';
                echo "Alunos Reprovados: " . $reprovacoes;
                echo '</td>';
                echo '<td class="reprovacaoTd">';
                echo "Alunos Aprovados: " . $aprovados;
                echo '</td>';
                echo '</tr>';
            }
            else{
                header('Location: home.php');
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
    </div>
    <script>
        const form = document.getElementById("form3");
        const button = document.getElementById("botaoEditar");
        button.onclick = () =>{
            form.submit();
        }
    </script>
</body>
</html>