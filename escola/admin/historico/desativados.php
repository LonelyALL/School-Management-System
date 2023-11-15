<?php 
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
        header('Location: ../loginadmin/admin.php');
        exit();
    }
?>
<?php 
    require '../../connect/connect.php';
    require '../popup/popup.php';
    require '../functions/functions.php';
    if(isset($_GET['confirm'])){
        if(isset($_GET['delete']) && !empty($_GET['delete'])){
            $id = $_GET['delete'];

            $verifyAtivados = "SELECT * FROM alunos WHERE matricula = ?;";
            $stmtAtivados = mysqli_prepare($conn, $verifyAtivados);
            mysqli_stmt_bind_param($stmtAtivados, "i", $id);
            mysqli_stmt_execute($stmtAtivados);
            $resultAtivados = mysqli_stmt_get_result($stmtAtivados);

            $verifyDesativados = "SELECT * FROM alunos_desativados WHERE matricula = ?;";
            $stmtDesativados = mysqli_prepare($conn, $verifyDesativados);
            mysqli_stmt_bind_param($stmtDesativados, "i", $id);
            mysqli_stmt_execute($stmtDesativados);
            $resultDesativados = mysqli_stmt_get_result($stmtDesativados);

            deleteHistory($id, "none", "none", false);

            if(mysqli_num_rows($resultAtivados) > 0){
                $deleteAtivados = "DELETE FROM alunos WHERE matricula = '$id';";
                if(mysqli_query($conn, $deleteAtivados)){
                    header('Location: desativados.php?sucess=Usuário deletado permanentemente com sucesso.');
                    exit();
                }
                else{
                    header('Location: desativados.php?error=Erro desconhecido.');
                    exit();
                }
            }
            else if(mysqli_num_rows($resultDesativados) > 0){
                $deleteDesativados = "DELETE FROM alunos_desativados WHERE matricula = '$id';";
                if(mysqli_query($conn, $deleteDesativados)){
                    header('Location: desativados.php?sucess=Usuário deletado permanentemente com sucesso.');
                    exit();
                }
                else{
                    header('Location: desativados.php?error=Erro desconhecido.');
                    exit();
                }
            }

        }
        if(isset($_GET['deletehistorico']) && !empty($_GET['deletehistorico'])){
            $id2 = $_GET['deletehistorico'];

            deleteHistory($id2, "desativados.php?sucess=Histórico deletado com sucesso.", "desativados.php?error=Nenhum histórico para ser deletado.", true);
                
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autumn</title>
    <link rel="stylesheet" href="desativados.css">
    <script src="https://kit.fontawesome.com/23d5698429.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="popup" id="popup">
        <div class="popupbox">
        <span>Você tem certeza que deseja realizar essa ação?</span>  
            <div class="buttons">
             <button id="cancelar" type="button">Cancelar</button>  
             <button id="confirmar" type="button">Confirmar</button>   
            </div>      
        </div>  
    </div>
    <?php 
        require '../../connect/connect.php';
        require "../functions/navbar.php";
        showNavbar();
    ?>
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
    <main> 
        <div class="box" id="box">
        <div class="searchbox">
            <input type="search" placeholder="Pesquisar" id="inputs" required="true">
            <button type="button" id="buscar">Buscar</button>
        </div>
            <?php 
               if(isset($_GET['busca']) && !empty($_GET['busca'])){
                 $busca = $_GET['busca'];
                
                showTableHistorico("SELECT nome, matricula, login, status FROM alunos WHERE nome LIKE '%$busca%' OR matricula LIKE '%$busca%' OR login LIKE '%$busca%' OR status LIKE '%$busca%'
                UNION ALL
                SELECT nome, matricula, login, status FROM alunos_desativados WHERE nome LIKE '%$busca%' OR matricula LIKE '%$busca%' OR login LIKE '%$busca%' OR status LIKE '%$busca%'
                ;");
               }
               else{
                 showTableHistorico("SELECT nome, matricula, login, status FROM alunos UNION ALL SELECT nome, matricula, login, status FROM alunos_desativados ORDER BY nome;");
               }
            ?>
        </div>
    </main>
    <?php
       $popup = new Popup("desativados.php");
       $popup->mostrarPopup();
    ?>
    <script>
        const button = document.getElementById('buscar');
        const input = document.querySelector('#inputs');
        button.onclick = () =>{
            if(input.value.length < 1){
                window.location.href = "desativados.php?error=Preencha os campos corretamente !";
            }
            else{
                
                window.location.href = "desativados.php?busca="+input.value;
            }
            
        }
    </script>
</body>
</html>