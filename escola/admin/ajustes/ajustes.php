<?php 
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
        header('Location: ../loginadmin/admin.php');
        exit();
    }
?>
<?php 
    require '../../connect/connect.php';
    if(isset($_GET['confirm'])){
        if(isset($_GET['delete']) && !empty($_GET['delete'])){
            $id = $_GET['delete'];
    
            $sql_segmento = "SELECT * FROM segmentos WHERE id = '$id'";
            $result_segmento = mysqli_query($conn, $sql_segmento);
            $row_segmento = mysqli_fetch_assoc($result_segmento);
            $segmento = $row_segmento['segmento'];
    
            $sql_series = "SELECT * FROM series WHERE segmento = '$segmento'";
            $result_series = mysqli_query($conn, $sql_series);
    
            if(mysqli_num_rows($result_series) > 0){
                while ($row_series = mysqli_fetch_assoc($result_series)) {
                    $serieid = $row_series['id'];
        
                    $sql_turma = "SELECT * FROM turmas WHERE serie_id = '$serieid';";
                    $result_turma = mysqli_query($conn, $sql_turma);
                    $row_turma = mysqli_fetch_assoc($result_turma);
                    $turmaid = $row_turma['id'];
        
                    $sql_deleteturma = "DELETE FROM turmas WHERE serie_id='$serieid'";
                    mysqli_query($conn, $sql_deleteturma);
        
                    $sql_deleteturma2 = "DELETE FROM turma_materia WHERE turma = '$turmaid';";
                    
                    mysqli_query($conn, $sql_deleteturma2); 
                }
            }
    
            $sql_deletealuno = "DELETE FROM alunos WHERE segmento ='$segmento';";
            mysqli_query($conn, $sql_deletealuno);
            
            $sql_deleteserie = "DELETE FROM series WHERE segmento='$segmento'";
            if (mysqli_query($conn, $sql_deleteserie)) {
                $sql_delete = "DELETE FROM segmentos WHERE id ='$id'";
                if (mysqli_query($conn, $sql_delete)) {
                    header('Location: ajustes.php?sucess=Segmento deletado com sucesso!');
                    exit();
                } else {
                    header('Location: ajustes.php?error=Erro ao deletar segmento!');
                    exit();
                }
            } else {
                header('Location: ajustes.php?error=Erro ao deletar séries e turmas relacionadas!');
                exit();
            }
        }
    }
?>
<?php 
    if(isset($_GET['confirm'])){
        if(isset($_GET['deleteavaliacao']) && !empty($_GET['deleteavaliacao'])){
            $idavaliacao = $_GET['deleteavaliacao'];
            
            $delete_avaliacao = "DELETE FROM avaliacoes WHERE id = '$idavaliacao';";
    
            if(mysqli_query($conn, $delete_avaliacao)){
                header('Location: ajustes.php?sucess=Avaliação deletada com sucesso!');
                exit();
            }
            else{
                header('Location: ajustes.php?error=Erro ao deletar avaliação.');
                exit();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autumn</title>
    <link rel="stylesheet" href="ajustes.css">
    <script src="https://kit.fontawesome.com/23d5698429.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php 
        require "../functions/navbar.php";
        showNavbar();
    ?>
    <div class="popup" id="popup">
        <div class="popupbox">
        <span>Você tem certeza que deseja deletar?</span>  
            <div class="buttons">
             <button id="cancelar" type="button">Cancelar</button>  
             <button id="confirmar" type="button">Confirmar</button>   
            </div>      
        </div>  
    </div>
    <div class="box" id="box">
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
                        
        <form method="POST" action="editmedia.php" id='formmedia'>
             <div class="boxmedia">
                <?php
                    $sql_verify = "SELECT * FROM media;";
                    $result = mysqli_query($conn, $sql_verify);
                    if(mysqli_num_rows($result) > 0){
                        $media = mysqli_fetch_assoc($result);
                        echo "Média para aprovação: ";
                        echo "<input type='text' value='". $media['media'] ."' name='media' required='true'>";
                    }
                    else{
                        $insert = "INSERT INTO media (id, media) VALUES ('1', '6');";
                        mysqli_query($conn, $insert);
                        echo "Média para aprovação: ";
                        echo "<input type='text' value='6' name='media' required='true'>";
                    }
                    if(isset($_GET['id']) && isset($_GET['turma']) && !empty($_GET['id']) && !empty($_GET['turma'])){
                        $id = $_GET['id'];
                        $turma = $_GET['turma'];
                        echo "<input type='hidden' value='". $id ."' name='id'>";
                        echo "<input type='hidden' value='". $turma ."' name='turma'>";
                    }
                ?> 
                <button type='submit'>Alterar</button>  
             </div>
        </form>
        <form action="criarsegmento.php" method='POST' id='formsegmento'>
            <div class="boxsegmentos">
                <span>Cadastrar segmento:</span>
                <input type="text" name='segmento' placeholder="Segmento" required='true' maxlength='35'>
                <button>Cadastrar</button>
            </div>
        </form>
        <form action="criaravaliacao.php" method='POST' id='formsegmento'>
            <div class="boxsegmentos">
                <span>Cadastrar avaliações:</span>
                <input type="text" name='avaliacao' id='avaliacao' placeholder="Avaliação" required='true' maxlength='25'>
                <button id='avaliacaoButton'>Cadastrar</button>
            </div>
        </form>
        <div class="boxtable">
            <?php 
                $sql_verify = "SELECT * FROM segmentos;";
                $result_verify = mysqli_query($conn, $sql_verify);
                if(mysqli_num_rows($result_verify) > 0){
                    echo "<table class='scrollable-table'>";
                    echo "<tr class='titletr'><th class='title'>Segmento</th></tr>";
                    while($row = mysqli_fetch_assoc($result_verify)){
                        echo "<tr>";
                        echo "<td class='segmentotd'>";
                        echo $row['segmento'];
                        echo "</td>";
                        echo "<td class='delete'>";
                        echo '<a href="ajustes.php?delete='. $row['id'] .'&popup=true"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                    </svg></a>';
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            ?>
            
            <?php 
                $sql_verifyavaliacao = "SELECT * FROM avaliacoes;";
                $result_avaliacao = mysqli_query($conn, $sql_verifyavaliacao);
                if(mysqli_num_rows($result_avaliacao) > 0){
                    echo "<table class='scrollable-table' id='table2'>";
                    echo "<tr class='titletr'><th class='title'>Avaliação</th></tr>";
                    while($row_avaliacao = mysqli_fetch_assoc($result_avaliacao)){
                        echo "<tr>";
                        echo "<td class='segmentotd'>";
                        echo $row_avaliacao['avaliacao'];
                        echo "</td>";
                        echo "<td class='delete'>";
                        echo '<a href="ajustes.php?deleteavaliacao='. $row_avaliacao['id'] .'&popup=true"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                    </svg></a>';
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            ?>
        </div>
    <form action="fecharnotasgerais.php" method="post" id="form-notas">
    <div class="buttons-nota">
        <button type="submit">Fechar Notas</button>
    </div>
    </form>     
    </div>   
    <?php 
       require '../popup/popup.php';
       $popup = new Popup("ajustes.php");
       $popup->mostrarPopup();
    ?>
</body>
</html>