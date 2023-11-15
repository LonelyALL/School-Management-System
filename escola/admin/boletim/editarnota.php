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
    <link rel="stylesheet" href="editarnota.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <main>
        <div class="box">
            <form action="editnota.php" method="post" id="form">
                <div class="title">
                    <h2>Editar Notas</h2>
                </div>
                <div class="inputs">
                    <?php 
                        require '../../connect/connect.php';
                        if(isset($_GET['id']) && isset($_GET['turma']) && isset($_GET['materia']) && isset($_GET['idmateria'])  && isset($_GET['nome'])){
                            $id = $_GET['id'];
                            $turma = $_GET['turma'];
                            $materia = $_GET['materia'];
                            $idmateria = $_GET['idmateria'];
                            $nome = $_GET['nome'];
                            if($_GET['local']){
                                $local = $_GET['local'];
                                echo '<input type="hidden" value="'. $local .'" name="local">';
                            }
                            
                            echo '<input type="hidden" value="'. $idmateria .'" name="idmateria">';

                            echo "<div class='elements'>";
                            echo '<span>Aluno: '. $nome .'</span>';
                            echo '<span>Matéria: '. $materia .'</span>';
                            echo "</div>";

                            $sqlAvaliacao = "SELECT * FROM avaliacoes;";
                            $resultAvaliacao = mysqli_query($conn, $sqlAvaliacao);

                            echo "<span>Selecione a Avaliação:</span>";                            
                            echo "<select name='avaliacao' id='avaliacao' required='true'>";
                            echo "<option value=''></option>";
                            while($rowAvaliacao = mysqli_fetch_assoc($resultAvaliacao)){
                                $nomeAvaliacao = $rowAvaliacao['avaliacao'];
                                echo '<option value="'. $nomeAvaliacao .'">'. $nomeAvaliacao .'</option>';
                            }
                            echo "<option value='Recuperação'>Recuperação</option>";
                            echo "</select>";

                            echo "<span>Selecione o Bimestre:</span>";                            
                            echo "<select name='bimestre' id='bimestre' required='true'>";
                            echo "<option value='bimestre1'>1º Bimestre</option>";
                            
                            echo "<option value='bimestre2'>2º Bimestre</option>";
                           
                            echo "<option value='bimestre3'>3º Bimestre</option>";
                           
                            echo "<option value='bimestre4'>4º Bimestre</option>";
                            
                            echo "</select>";
                            echo "<span>Digite a nota:</span>";
                            echo "<input type='text' name='nota' id='nota'>";

                            echo '<input type="hidden" value="'. $id .'" name="matricula">';
                            echo '<input type="hidden" value="'. $turma .'" name="turma">';
                            
                        
                            echo "<script>
                            // Quando o select de avaliação muda
                            $('#avaliacao').on('change', function() {
                                atualizarNota();
                                limparInputNota();
                            });
                    
                            // Quando o select de bimestre muda
                            $('#bimestre').on('change', function() {
                                atualizarNota();
                                limparInputNota();
                            });
                    
                            function atualizarNota() {
                                var avaliacaoSelecionada = $('#avaliacao').val();
                                var bimestreSelecionado = $('#bimestre').val();
                    
                                // Fazer uma solicitação AJAX para verificar a nota
                                $.ajax({
                                    url: 'consultar_nota.php',
                                    method: 'POST',
                                    data: {
                                        id_aluno: $id,
                                        id_materia: $idmateria,
                                        avaliacao: avaliacaoSelecionada,
                                        bimestre: bimestreSelecionado
                                    },
                                    success: function(data) {
                                        var nota = data.nota;
                                        // Atualizar o valor do input 'nota' com a nota verificada
                                        $('#nota').val(nota);
                                    },
                                    dataType: 'json'
                                });
                            }
                            function limparInputNota() {
                                // Limpar o valor do input 'nota'
                                $('#nota').val('');
                            }
                        </script>";
                        }
                        else{
                            header('Location: boletim.php');
                            exit();
                        }
                        mysqli_close($conn);
                    ?>
                </div>
                <div class="buttons">
                    <button type="submit" id="salvar">Salvar</button>
                </div>
            </form>
        </div>
    </main>
    <script>
        const button = document.getElementById('salvar');
        const regex = /^[0-9.]+$/;
        const form = document.getElementById('form');

        form.addEventListener("submit", (e) => {
            const input1 = document.querySelector('#nota').value;
            let hasError = false;

            if (!regex.test(input1)) {
                hasError = true;
            }

            if (hasError) {
            e.preventDefault();
            alert("Utilize apenas números, podendo ser reais.");
            }
        })

        document.getElementById('botaoVoltar').addEventListener('click', function() {
            // Obtém a URL anterior do histórico do navegador
            var urlAnterior = document.referrer;

            // Redireciona para a URL anterior
            window.location.href = urlAnterior;
        });
        var activated = false;

        $('#avaliacao').on('change', function() {
            if ($('#avaliacao').val() == "Recuperação" && !activated) {
                $('#bimestre').html('');

                var options = [
                    "<option value='recbimestre1'>Rec. 1º Bim.</option>",
                    "<option value='recbimestre2'>Rec. 2º Bim.</option>",
                    "<option value='recbimestre3'>Rec. 3º Bim.</option>",
                    "<option value='recbimestre4'>Rec. 4º Bim.</option>"
                ];

                $('#bimestre').html(options.join(''));
                activated = true;
            } else if ($('#avaliacao').val() != "Recuperação" && activated) {
                $('#bimestre').html('');

                var options = [
                    "<option value='bimestre1'>1º Bimestre</option>",
                    "<option value='bimestre2'>2º Bimestre</option>",
                    "<option value='bimestre3'>3º Bimestre</option>",
                    "<option value='bimestre4'>4º Bimestre</option>"
                ];

                $('#bimestre').html(options.join(''));
                activated = false;
            }
        });

    </script>
</body>
</html>