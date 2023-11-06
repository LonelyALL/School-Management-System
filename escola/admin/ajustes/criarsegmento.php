<?php 
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
        header('Location: ../loginadmin/admin.php');
        exit();
    }
?>
<?php 
    require '../../connect/connect.php';
    if(isset($_POST['segmento']) && !empty(trim($_POST['segmento']))){
        $segmento = $_POST['segmento'];
        
        $sql_id = "SELECT MAX(id) as max_id FROM segmentos;";
        $result = mysqli_query($conn, $sql_id);
        $max = mysqli_fetch_assoc($result);
        $newid = $max['max_id'] + 1;
        $sql = "INSERT INTO segmentos (id, segmento) VALUES ('$newid', '$segmento');";

        $sql_verify = "SELECT * FROM segmentos WHERE segmento='$segmento';";
        $result_verify = mysqli_query($conn, $sql_verify);

        if(mysqli_num_rows($result_verify) == 0){
            if(mysqli_query($conn, $sql)){        
                header('Location: ajustes.php?sucess=Segmento cadastrado com sucesso!');
                exit();
            }
            else{  
                header('Location: ajustes.php?error=Erro ao cadastrar segmento.');
                exit();
            }
        }
        else{
            header('Location: ajustes.php?error=Segmento já cadastrado!');
            exit();
        }
    }
    else{
        header('Location: ajustes.php?error=Preencha o campo corretamente.');
        exit();
    }
?>