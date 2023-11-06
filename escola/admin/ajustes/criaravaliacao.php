<?php 
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
        header('Location: ../loginadmin/admin.php');
        exit();
    }
?>
<?php 
    require '../../connect/connect.php';
    if(isset($_POST['avaliacao']) && !empty(trim($_POST['avaliacao']))){
        if($_POST['avaliacao'] == 'recuperação' OR $_POST['avaliacao'] == 'Recuperação' OR $_POST['avaliacao'] == 'recuperacao' OR $_POST['avaliacao'] == 'Recuperacao'){
            header('Location: ajustes.php?error=Nome de avaliação bloqueado, sistema de recuperação já existe por padrão do sistema.');
            exit();
        }
        $avaliacao = $_POST['avaliacao'];
        
        $sql = "INSERT INTO avaliacoes (avaliacao) VALUES ('$avaliacao');";

        $sql_verify = "SELECT * FROM avaliacoes WHERE avaliacao='$avaliacao';";
        $result_verify = mysqli_query($conn, $sql_verify);

        if(mysqli_num_rows($result_verify) == 0){
            if(mysqli_query($conn, $sql)){        
                header('Location: ajustes.php?sucess=Avaliação cadastrada com sucesso!');
                exit();
            }
            else{  
                header('Location: ajustes.php?error=Erro ao cadastrar segmento.');
                exit();
            }
        }
        else{
            header('Location: ajustes.php?error=Avaliação já cadastrada!');
            exit();
        }
    }
    else{
        header('Location: ajustes.php?error=Preencha o campo corretamente.');
        exit();
    }
?>