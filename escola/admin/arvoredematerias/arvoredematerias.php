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
        $materia = $_GET['name'];

        if(isset($materia) && !empty(trim($materia))){
            $sql_verify = "SELECT * FROM materias WHERE materia='$materia';";
            $result = mysqli_query($conn, $sql_verify);
            $row = mysqli_fetch_assoc($result);
            $materiaid = $row['id'];
            $sql = "DELETE FROM materias WHERE materia='$materia';";
            $sql2 = "DELETE FROM notas_avaliacoes WHERE materia='$materiaid';";
            $sql3 = "DELETE FROM turma_materia WHERE materia='$materiaid';";
            if(mysqli_query($conn, $sql) && mysqli_query($conn, $sql2) && mysqli_query($conn, $sql3)){
                header('Location: arvoredematerias.php?sucess=Matéria deletada com sucesso');
                exit();
            }  
            else{
                header('Location: arvoredematerias.php?error=Erro ao deletar matéria!');
                exit();
            }
        }
        else{
            header('Location: arvoredematerias.php?error=Erro ao deletar!');
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autumn</title>
    <link rel="stylesheet" href="arvoredematerias.css">
    <script src="https://kit.fontawesome.com/23d5698429.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php 
        require "../functions/navbar.php";
        showNavbar();
    ?>
    <div class="popup" id="popup">
        <div class="popupbox">
        <span>Você tem certeza que deseja deletar essa matéria?</span>  
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
    <div class="table-container">
    <table class="scrollable-table">
    <tr class="itemstr">
    <form action="criarmateria.php" method="post">
        <td class="imateria">
            <input type="text" placeholder="Materia" name="materia" required="true">
            
            <button type="submit">Criar</button>
        </td>
    </form>
    </tr>
    <tr class="title_class"><td class="title">Matéria</td></tr>
    <?php 
         if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_GET["edit"];
            if (isset($_POST['materia']) && !empty(trim($_POST['materia']))){
                $materia = $_POST["materia"];
                $sql_verifiyrow = "SELECT * FROM materias WHERE materia='$materia';";
                $result_verifyrow = mysqli_query($conn, $sql_verifiyrow);

                if(mysqli_num_rows($result_verifyrow) > 0){
                    header('Location: ../arvoredematerias/arvoredematerias.php?error=Nome de matéria já utilizado.');
                }
                else{
                    $sql = "UPDATE materias SET materia='$materia' WHERE id=$id";
                    if (mysqli_query($conn, $sql) === TRUE) {
                        header('Location: ../arvoredematerias/arvoredematerias.php?sucess=Registro atualizado com sucesso.');
                    } else {
                        echo "Erro ao atualizar o registro: " . mysqli_error($conn);
                    }
                }
            } else{
                header("Location: ../arvoredematerias/arvoredematerias.php?error=Preencha o campo antes de salvar");
            }
        }
        
         $sql_materias = "SELECT * FROM materias ORDER BY materia ASC";
         $result_materias = mysqli_query($conn, $sql_materias);

         while ($row_materias = mysqli_fetch_assoc($result_materias)) {
             
            if (isset($_GET["edit"]) && $_GET["edit"] == $row_materias["id"]) {
                echo "<form method='post' id='atualizar'>";
                echo "<td><input type='text' class='edit_input' required='true' name='materia' value='" . $row_materias["materia"] . "'></td>";
                echo '<td><a href="?name='. $row_materias["materia"] .'&popup=true" id="deletar"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
              </svg></a></td>';
              echo '<td>';
              echo '<a href="javascript:void(0)" onclick="enviarFormulario()"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
              <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
            </svg></a>';
              echo '</td>';
                echo "</form>";
            } else {
                echo "<tr>";    
                echo "<td>" . $row_materias['materia'] . "</td>";
                echo '<td><a href="?name='. $row_materias["materia"] .'&popup=true" id="deletar"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
              </svg></a></td>';
                echo '<td>';
                echo '<a href="javascript:void(0)" onclick="editar(' . $row_materias["id"] . ')"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
              </svg></a>';
                echo '</td>';
                echo "</tr>";
            }
         }
         echo "</table>";
         mysqli_close($conn);    
    ?>
    </div>
    </div>
    <script>
    function enviarFormulario() {
        document.getElementById('atualizar').submit();
    }
    function editar(id) {
        
        window.location.href = window.location.pathname + '?edit=' + id;
    }

    function atualizar(id) {
        
        var materia = document.getElementsByName('materia')[0].value;

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText); 
                window.location.reload(); 
            }
        };

        xmlhttp.open("POST", window.location.pathname, true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("id=" + id + "&materia=" + materia);
    }
</script>
    <?php 
       require '../popup/popup.php';
       $popup = new Popup("arvoredematerias.php");
       $popup->mostrarPopup();
    ?>

</body>
</html>
