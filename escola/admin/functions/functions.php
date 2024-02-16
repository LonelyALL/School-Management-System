<?php
    require '../../connect/connect.php';
    function verifyString($string){
        if (strpos($string, ' ') == false) {
            return false;
        }else{
            return true;
        }
    }

    class desativarAluno{
        var $id;
        var $matricula;
        var $nome;
        var $login;
        var $senha;



        public function __construct($deleteId){
            global $conn;
            $this->id = $deleteId;

            $sql = "SELECT * FROM alunos WHERE matricula = ?;";
            $prepare = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($prepare, "i", $this->id);
            mysqli_stmt_execute($prepare);
            $result = mysqli_stmt_get_result($prepare);
            $row = mysqli_fetch_assoc($result);

            $this->matricula = $row['matricula'];
            $this->nome = $row['nome'];
            $this->login = $row['login'];
            $this->senha = $row['senha'];
        }

        function moverAluno($redirect, $redirecionar){
            global $conn;
            $status = "Desativado";
            $insert = "INSERT INTO alunos_desativados (nome, login, senha, matricula, status) VALUES (?, ?, ?, ?, ?);";
            $stmt_insert = mysqli_stmt_init($conn);
            $prepare = mysqli_stmt_prepare($stmt_insert, $insert);
            mysqli_stmt_bind_param($stmt_insert, "sssis", $this->nome, $this->login, $this->senha, $this->matricula, $status);

            $remove = "DELETE FROM alunos WHERE matricula = '$this->matricula';";
            mysqli_query($conn, $remove);

            if($redirecionar == true){
                if(mysqli_stmt_execute($stmt_insert)){
                    header('Location: '. $redirect);
                }  
            }
            else{
                mysqli_stmt_execute($stmt_insert);
            }
        }
    }

    function showTableHistorico($sql) {
        global $conn;
        echo "<table class='scrollable-table'>";
            echo "<tr><td class='title'>Nome</td><td class='title'>Matrícula</td><td class='title'>Login</td><td class='title'>Status</td><td class='title' colspan='3'>Ações</td></tr>";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";  
                echo "<td>". $row['nome']. "</td>"; 
                echo "<td>". $row['matricula']. "</td>"; 
                echo "<td>". $row['login']. "</td>"; 
                echo "<td>". $row['status']. "</td>"; 
                if($row['status'] == "Ativado"){
                    echo "<td colspan='1'>";
                    echo "<a href='historico.php?id=". $row['matricula'] ."&nome=". $row['nome'] ."' style='width: 100%;'>Histórico</a>";
                    echo "</td>";
                    echo "<td>";
                    echo "<a href='desativados.php?deletehistorico=". $row['matricula'] ."&popup=true' style='font-size: 13.4px;'>Excluir Histórico</a>";
                    echo "</td>";
                    echo "<td>";
                    echo "<a href='desativados.php?delete=". $row['matricula'] ."&popup=true'>Excluir</a>";
                    echo "</td>";
                }
                else{
                    echo "<td>";
                    echo "<a href='historico.php?id=". $row['matricula'] ."&nome=". $row['nome'] ."'>Histórico</a>";
                    echo "</td>";
                    echo "<td>";
                    echo "<a href='reativar.php?id=". $row['matricula'] ."'>Reativar</a>";
                    echo "</td>";
                    echo "<td>";
                    echo "<a href='desativados.php?delete=". $row['matricula'] ."&popup=true'>Excluir</a>";
                    echo "</td>";
                }
                echo "</tr>";
            }
        echo "</table>";
    }

    function gerarHistoricoIndividual($id, $redirect, $error, $redirect2){
        global $conn;
        $matricula = $id;
        $anoAtual = date("Y");

        $sql = "SELECT * FROM notas_avaliacoes WHERE id_aluno = ?;";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $matricula);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $sqlRecuperacao = "SELECT * FROM recuperacao WHERE id_aluno = ?;";
        $stmtRecuperacao = mysqli_prepare($conn, $sqlRecuperacao);
        mysqli_stmt_bind_param($stmtRecuperacao, "i", $matricula);
        mysqli_stmt_execute($stmtRecuperacao);
        $resultRecuperacao = mysqli_stmt_get_result($stmtRecuperacao);

        if(mysqli_num_rows($result) > 0 OR mysqli_num_rows($resultRecuperacao) > 0){
            $verify = "SELECT * FROM historico WHERE id_aluno = '$matricula' AND ano = '$anoAtual';";
            $result_verify = mysqli_query($conn, $verify);

            if(mysqli_num_rows($result_verify) > 0){
                header('Location: '. $redirect2);
                exit();
            }
            while($row = mysqli_fetch_assoc($result)){
                $materia = $row['materia'];

                $sqlNewMateria = "SELECT * FROM materias WHERE id = '$materia';";
                $resultNewMateria = mysqli_query($conn, $sqlNewMateria);
                $rowNewMateria = mysqli_fetch_assoc($resultNewMateria);
                $newMateria = $rowNewMateria['materia'];

                
                $avaliacao = $row['avaliacao'];
                $nota = $row['nota'];
                $bimestre = $row['bimestre'];
                $linhaId = $row['id'];

                $insert = "INSERT INTO historico (id_aluno, materia, avaliacao, nota, bimestre, ano) VALUES ('$matricula', '$newMateria', '$avaliacao', '$nota', '$bimestre', '$anoAtual');";
                
                $delete = "DELETE FROM notas_avaliacoes WHERE id = '$linhaId';";
    
                mysqli_query($conn, $insert);
                mysqli_query($conn, $delete);
            }

            while($rowRecuperacao = mysqli_fetch_assoc($resultRecuperacao)){
                $materia = $rowRecuperacao['materia'];
                $avaliacao = "recuperacao";
                $nota = $rowRecuperacao['nota'];
                $bimestre = $rowRecuperacao['bimestre'];
                $matricula = $rowRecuperacao['id_aluno'];
                $linhaId = $rowRecuperacao['id'];

                
                $sqlNewMateria = "SELECT * FROM materias WHERE id = '$materia';";
                $resultNewMateria = mysqli_query($conn, $sqlNewMateria);
                $rowNewMateria = mysqli_fetch_assoc($resultNewMateria);
                $newMateria = $rowNewMateria['materia'];
                
                $insertRecuperacao = "INSERT INTO historico (id_aluno, materia, avaliacao, nota, bimestre, ano) VALUES ('$matricula', '$newMateria', '$avaliacao', '$nota', '$bimestre', '$anoAtual');";
                $deleteRecuperacao = "DELETE FROM recuperacao WHERE id = '$linhaId';";
        
                mysqli_query($conn, $insertRecuperacao);
                mysqli_query($conn, $deleteRecuperacao);
            }

            $sqlAvaliacoes = "SELECT * FROM avaliacoes;";
            $resultAvaliacoes = mysqli_query($conn, $sqlAvaliacoes);
            while($rowAvaliacoes = mysqli_fetch_assoc($resultAvaliacoes)){
                $avaliacao = $rowAvaliacoes['avaliacao'];
                $verifyAvaliacoes = "SELECT * FROM avaliacoes_ano WHERE avaliacao = '$avaliacao' AND ano = '$anoAtual';";
                $resultVerifyAvaliacoes = mysqli_query($conn, $verifyAvaliacoes);

                if(mysqli_num_rows($resultVerifyAvaliacoes) == 0){
                    $sqlAnoAvaliacoes = "INSERT INTO avaliacoes_ano (avaliacao, ano)  VALUES ('$avaliacao', '$anoAtual');";
                    mysqli_query($conn, $sqlAnoAvaliacoes);
                }
            }

            header('Location: ' . $redirect);
            exit();
        }
        else{
            header('Location: ' . $error);
            exit();
        }
    }

    function deleteHistory($id, $redirectTrue, $redirectFalse, $redirect){
        global $conn;
        $deleteHistorico = "SELECT * FROM historico WHERE id_aluno = ?;";
        $stmtHistorico = mysqli_prepare($conn, $deleteHistorico);
        mysqli_stmt_bind_param($stmtHistorico, "i", $id);
        mysqli_stmt_execute($stmtHistorico);
        $resultHistorico = mysqli_stmt_get_result($stmtHistorico);

        if($redirect == true){
            if(mysqli_num_rows($resultHistorico) > 0){
                $deletar = "DELETE FROM historico WHERE id_aluno = '$id';";
                if(mysqli_query($conn, $deletar)){
                    header('Location: ' . $redirectTrue);
                    exit();
                }
            }
            else{
                header('Location: ' . $redirectFalse);
                exit();
            }
        }
        else{
            $deletar = "DELETE FROM historico WHERE id_aluno = '$id';";
            mysqli_query($conn, $deletar);
        }

        
    }

    function gerarHistoricoGeral(){
        global $conn;
        $anoAtual = date("Y");
        
        $sql = "SELECT * FROM notas_avaliacoes;";
        $result = mysqli_query($conn, $sql);

        $sqlRecuperacao = "SELECT * FROM recuperacao"; 
        $resultRecuperacao = mysqli_query($conn, $sqlRecuperacao);

        if(mysqli_num_rows($result) > 0 OR mysqli_num_rows($resultRecuperacao) > 0){
            while($row = mysqli_fetch_assoc($result)){ 
                $materia = $row['materia'];
                $avaliacao = $row['avaliacao'];
                $nota = $row['nota'];
                $bimestre = $row['bimestre'];
                $matricula = $row['id_aluno'];
                $linhaId = $row['id'];
                
                $sqlNewMateria = "SELECT * FROM materias WHERE id = '$materia';";
                $resultNewMateria = mysqli_query($conn, $sqlNewMateria);
                $rowNewMateria = mysqli_fetch_assoc($resultNewMateria);
                $newMateria = $rowNewMateria['materia'];
                
                $verifyNota = "SELECT * FROM historico WHERE id_aluno = '$matricula' AND materia = '$newMateria' AND avaliacao = '$avaliacao' AND bimestre = '$bimestre' AND ano = '$anoAtual';";
                $resultNota = mysqli_query($conn, $verifyNota);
                if(mysqli_num_rows($resultNota) > 0){
                    $deleteNota = "DELETE FROM historico WHERE id_aluno = '$matricula' AND materia = '$newMateria' AND avaliacao = '$avaliacao' AND bimestre = '$bimestre' AND ano = '$anoAtual';";
                    mysqli_query($conn, $deleteNota);
                }

                $insert = "INSERT INTO historico (id_aluno, materia, avaliacao, nota, bimestre, ano) VALUES ('$matricula', '$newMateria', '$avaliacao', '$nota', '$bimestre', '$anoAtual');";
                $delete = "DELETE FROM notas_avaliacoes WHERE id = '$linhaId';";
        
                mysqli_query($conn, $insert);
                mysqli_query($conn, $delete);
            }
            while($rowRecuperacao = mysqli_fetch_assoc($resultRecuperacao)){
                $materia = $rowRecuperacao['materia'];
                $avaliacao = "recuperacao";
                $nota = $rowRecuperacao['nota'];
                $bimestre = $rowRecuperacao['bimestre'];
                $matricula = $rowRecuperacao['id_aluno'];
                $linhaId = $rowRecuperacao['id'];

                
                $sqlNewMateria = "SELECT * FROM materias WHERE id = '$materia';";
                $resultNewMateria = mysqli_query($conn, $sqlNewMateria);
                $rowNewMateria = mysqli_fetch_assoc($resultNewMateria);
                $newMateria = $rowNewMateria['materia'];

                $verifyNotaRecuperacao = "SELECT * FROM historico WHERE id_aluno = '$matricula' AND materia = '$newMateria' AND avaliacao = '$avaliacao' AND bimestre = '$bimestre' AND ano = '$anoAtual';";
                $resultNotaRecuperacao = mysqli_query($conn, $verifyNotaRecuperacao);
                if(mysqli_num_rows($resultNotaRecuperacao) > 0){
                    $deleteNotaRecuperacao = "DELETE FROM historico WHERE id_aluno = '$matricula' AND materia = '$newMateria' AND avaliacao = '$avaliacao' AND bimestre = '$bimestre' AND ano = '$anoAtual';";
                    mysqli_query($conn, $deleteNotaRecuperacao);
                }
                
                $insertRecuperacao = "INSERT INTO historico (id_aluno, materia, avaliacao, nota, bimestre, ano) VALUES ('$matricula', '$newMateria', '$avaliacao', '$nota', '$bimestre', '$anoAtual');";
                $deleteRecuperacao = "DELETE FROM recuperacao WHERE id = '$linhaId';";
        
                mysqli_query($conn, $insertRecuperacao);
                mysqli_query($conn, $deleteRecuperacao);
            }

            $sqlAvaliacoes = "SELECT * FROM avaliacoes;";
            $resultAvaliacoes = mysqli_query($conn, $sqlAvaliacoes);
            while($rowAvaliacoes = mysqli_fetch_assoc($resultAvaliacoes)){
                $avaliacao = $rowAvaliacoes['avaliacao'];
                $verifyAvaliacoes = "SELECT * FROM avaliacoes_ano WHERE avaliacao = '$avaliacao' AND ano = '$anoAtual';";
                $resultVerifyAvaliacoes = mysqli_query($conn, $verifyAvaliacoes);

                if(mysqli_num_rows($resultVerifyAvaliacoes) == 0){
                    $sqlAnoAvaliacoes = "INSERT INTO avaliacoes_ano (avaliacao, ano)  VALUES ('$avaliacao', '$anoAtual');";
                    mysqli_query($conn, $sqlAnoAvaliacoes);
                }
            }

            header('Location: ajustes.php?sucess=Notas fechadas com sucesso.');
            exit();
        }
        else{
            header('Location: ajustes.php?error=Nenhuma nota cadastrada.');
            exit();
        }
    }

    function showHistory($result, $id){
        global $conn;
        $nome = $_GET['nome'];

        $sqlYear = "SELECT DISTINCT ano FROM historico WHERE id_aluno = ?;";
        $stmtYear = mysqli_prepare($conn, $sqlYear);
        mysqli_stmt_bind_param($stmtYear, "i", $id);
        mysqli_stmt_execute($stmtYear);
        $resultYear = mysqli_stmt_get_result($stmtYear);
        
        echo "<div class='boxNomealuno'>";
            echo "<div class='nomealuno'>";
            echo "Aluno: " . htmlspecialchars($nome);
            echo "</div>";
        echo "</div>";

        while($rowYear = mysqli_fetch_assoc($resultYear)){
            echo "<div class='breakDiv'>";
            echo "<table>";
            $ano = $rowYear['ano'];
            echo "<tr class='titleYearTr'><th class='titleYear'>Ano: ". $rowYear["ano"] ."</th></tr>";
            echo "<tr class='trTitle'><th class='title'>Matérias</th><th class='title'>1° Bimestre</th><th class='title'>Rec. 1° Bim.</th><th class='title'>2° Bimestre</th><th class='title'>Rec. 2° Bim.</th><th class='title'>3° Bimestre</th><th class='title'>Rec. 3° Bim.</th><th class='title'>4° Bimestre</th><th class='title'>Rec. 4° Bim.</th><th class='title'>Média</th><th class='title'>Situação</th></tr>";

            $mediaFinal = 0;
            $reprovacoes = 0;
            $totalMaterias = 0;
            
            $sql_materia = "SELECT DISTINCT materia FROM historico WHERE id_aluno = '$id';";
            $result_materia = mysqli_query($conn, $sql_materia);
                    
            while($row_materia = mysqli_fetch_assoc($result_materia)){ //Where Pegar todas materias do bd
                $totalMaterias = $totalMaterias + 1;
                $sql_nota = "SELECT * FROM historico WHERE materia = '". $row_materia['materia'] ."' AND id_aluno = '$id';";
                $result_nota = mysqli_query($conn, $sql_nota);

                echo "<tr>";
                echo "<td class='escuro'>";
                echo $row_materia['materia'];
                echo "</td>";

                $sql_media = "SELECT media FROM media WHERE id='1';";
                $result_media = mysqli_query($conn, $sql_media);
                $row_media = mysqli_fetch_assoc($result_media);
                $mediaCadastrada = $row_media['media'];
                $mediaFinal = 0;

                if((mysqli_num_rows($result_nota) > 0)){
                    for ($i = 1; $i <= 4; $i++) {
                        $media = 0;
                        echo "<td>";

                        $sql_avaliacao = "SELECT * FROM avaliacoes_ano WHERE ano = '$ano';";
                        $result_avaliacao = mysqli_query($conn, $sql_avaliacao);
                        $num_avaliacoes = mysqli_num_rows($result_avaliacao);

                        while($row_avaliacao = mysqli_fetch_assoc($result_avaliacao)){
                            $sql_nota_avaliacao = "SELECT * FROM historico WHERE materia = '". $row_materia['materia'] ."' AND id_aluno = '$id' AND avaliacao = '". $row_avaliacao['avaliacao'] ."' AND bimestre = 'bimestre$i';";
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

                        $sql_verifyRecuperacao = "SELECT * FROM historico WHERE materia = '". $row_materia['materia'] ."' AND id_aluno = '$id' AND bimestre = 'recbimestre$i';";
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
            echo '<td class="reprovacaoTd" colspan="4">';
            echo "Total de Matérias: " . $totalMaterias;
            echo '</td>';
            echo '<td class="reprovacaoTd" colspan="4">';
            echo "Matérias Reprovadas: " . $reprovacoes;
            echo '</td>';
            echo '<td class="reprovacaoTd" colspan="4">';
            if($reprovacoes > 0){
                echo "Situação Final: Reprovado.";
            }
            else{
                echo "Situação Final: Aprovado.";
            }
            
            echo '</td>';
            echo '</tr>';
            echo "</table>";
            echo "</div>";
        }
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
?>