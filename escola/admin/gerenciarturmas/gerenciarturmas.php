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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autumn</title>
    <link rel="stylesheet" href="gerenciarturmas.css">
    <script src="https://kit.fontawesome.com/23d5698429.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php 
        require '../../connect/connect.php';
        require "../functions/navbar.php";
        require "../popup/popup.php";
        showNavbar();
    ?>

    <div class="popup" id="popup">
        <div class="popupbox">
        <span>Você tem certeza que deseja realizar essa ação?</span>  
            <div class="buttons">
             <button id="cancelar" type="button">Cancelar</button>  
             <button id="confirmar" type="button">Confirmar</button>   
            </div>      
        </div>  
    </div>

    <div class="errors" id="errors">
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
        <div class="box" id="box">
            <div class="table-container">
                <?php   
                    require '../../connect/connect.php';
                    $sql = "SELECT * FROM segmentos;";
                    $result = mysqli_query($conn, $sql);
                    
                    echo "<table class='scrollable-table'>";
                    while($row = mysqli_fetch_assoc($result)){
                        $newsegmento = $row['segmento'];
                        $sql_ef1 = "SELECT * FROM series WHERE segmento = '$newsegmento' ORDER BY serie";
                        $result_ef1 = mysqli_query($conn, $sql_ef1);

                        echo "<tr><td class='segmento'>Segmento: ". $row['segmento'] ."</td></tr>";
                        echo "<tr><td class='title'>Série</td><td class='title'>Turmas</td></tr>";

                        while ($row_series = mysqli_fetch_assoc($result_ef1)) {
                            $serie_id = $row_series['id'];
                            $serie = $row_series['serie'];

                            $sql_turmas = "SELECT turma FROM turmas WHERE serie_id='$serie_id' ORDER BY turma ASC";
                            $result_turmas = mysqli_query($conn, $sql_turmas);

                            echo "<tr>";
                            echo "<td>" . $serie . " Ano</td>";
                            echo "<td>";
                            echo "<select>";
                            while ($row_turmas = mysqli_fetch_assoc($result_turmas)) {
                                echo "<option value='1'>". $row_turmas['turma'] ."</option>";
                            }
                            echo "</select>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        
                    }
                    echo "</table>";
                    mysqli_close($conn);
                ?>
            </div>
                <div class="sub-inputs">
                    <div class="firstElement" style="display: flex;">
                        <div class="inputs">
                            <form action="criarserie.php" method="post">
                                <div class="serie">
                                    <span>Criar Série:</span>
                                    <input type="number" placeholder="Apenas número" name="serie" required="true" maxlength="10" id="block"> 
                                    
                                    <span>Segmento:</span>
                                    <select name="segmento">
                                        <?php 
                                            require '../../connect/connect.php';
                                            $sql = "SELECT * FROM segmentos;";
                                            $result = mysqli_query($conn, $sql);

                                            while($row = mysqli_fetch_assoc($result)){
                                                echo '<option value="'. $row['segmento'] .'">'. $row['segmento'] .'</option>';
                                            }
                                        ?>
                                    </select>
                                    <button type="submit">Criar</button>   
                                </div>
                            </form>
                        </div>
                        <div class="inputs" style="margin-left: 5px;">
                            <form action="criarturma.php" method="post">
                                <div class="turma">
                                    <span>Adicionar turma:</span>
                                    <input type="text" placeholder="Turma" id="turma" name="turma" required="true" maxlength="10">
                                    <span>Segmento:</span>
                                    <select name="segmento" class="segmento2" id="segmento2" required="true">
                                        <option value=""></option>
                                        <?php 
                                            require '../../connect/connect.php';
                                            $sql = "SELECT * FROM segmentos;";
                                            $result = mysqli_query($conn, $sql);

                                            while($row = mysqli_fetch_assoc($result)){
                                                echo '<option value="'. $row['segmento'] .'">'. $row['segmento'] .'</option>';
                                            }
                                        ?>
                                    </select>
                                    <span class="left">Destino:</span>
                                    <select name="serieid" required="true" id="destino">
                                    </select>
                                    <button type="submit">Adicionar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="secondElement" style="display: flex;">
                        <div class="inputs-bottom">
                            <form action="deletarserie.php" method="post" id="deletarSerie">
                                <div class="deletar">
                                <span>Deletar série:</span>      
                                <input type="text" name="deletserie" placeholder="Serie desejada" required="true">
                                <span>Segmento:</span>
                                <select name="segmentodeletar" required="true" id="segmentodeletar">
                                        <option value=""></option>
                                        <?php
                                            require '../../connect/connect.php'; 
                                            $sql = "SELECT * FROM segmentos;";
                                            $result = mysqli_query($conn, $sql);

                                            while($row = mysqli_fetch_assoc($result)){
                                                echo '<option value="'. $row['segmento'] .'">'. $row['segmento'] .'</option>';
                                            }
                                        ?>
                                </select>
                                <button type="button" id="botaoSerie">Deletar</button>
                                </div>
                            </form>
                        </div>
                        <div class="inputs-bottom" style="margin-left: 5px;">                
                            <form action="deletarturma.php" method="post" id="deletarTurma">
                                <div class="deletar" style="margin-top: 20px;">
                                <span>Deletar turma:</span>      
                                <input type="text" name="deletturma" placeholder="Turma desejada" required="true">
                                <button type="button" id="botaoTurma">Deletar</button>      
                                </div>
                            </form>   
                        </div>
                    </div>
                </div>
    </main>
    <script>
        document.getElementById('segmento2').addEventListener('change', function () {
        var segmento = this.value;
        var destinoSelect = document.getElementById('destino');
        destinoSelect.innerHTML = ''; // Limpar o select de turmas

        // Fazer uma solicitação AJAX para buscar as turmas da série
        $.ajax({
            url: 'buscar_destino.php', // Arquivo PHP para buscar turmas
            method: 'POST',
            data: { segmento: segmento },
            success: function (data) {
                // Preencher o select de turmas com os dados recebidos
                destinoSelect.innerHTML = data;
            }
        });
        });
    </script>
        <script>
                const box = document.getElementById("box");
                const popup = document.getElementById("popup");
                const confirmar = document.getElementById("confirmar");
                const nav = document.getElementById("navbar");
                const cancelar = document.getElementById("cancelar");

                const botaoSerie = document.getElementById("botaoSerie");
                const botaoTurma = document.getElementById("botaoTurma");

                const formSerie = document.getElementById("deletarSerie");
                const formTurma = document.getElementById("deletarTurma");

                const errors = document.getElementById("errors");

                qualForm = '';
                
                botaoSerie.onclick = () =>{
                    popup.style.display = "flex";
                    box.style.display = "none";
                    nav.style.display = "none";
                    errors.style.display = "none";
                    qualForm = formSerie;
                }

                botaoTurma.onclick = () =>{
                    popup.style.display = "flex";
                    box.style.display = "none";
                    nav.style.display = "none";
                    errors.style.display = "none";
                    qualForm = formTurma;
                }

                confirmar.onclick = () =>{
                    qualForm.submit();
                }
                 cancelar.onclick = () =>{
                    window.location.href = "gerenciarturmas.php";
                }
        </script>
</body>
</html>
