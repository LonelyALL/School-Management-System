<?php 
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
        header('Location: ../loginadmin/admin.php');
        exit();
    }
?>
<?php 
    require '../../connect/connect.php';
    
    if(isset($_POST['media']) && !empty($_POST['media'])){
        $newmedia = $_POST['media'];

        $sql = "UPDATE media SET media = '$newmedia' WHERE id = '1';";
        $result = mysqli_query($conn, $sql);
        if($result){
            header('Location: ajustes.php?sucess=Média alterada com sucesso!');
            exit();
        }
        else{
            header('Location: ajustes.php?error=Erro desconhecido!');
            exit();
        }
        }
    else{
        header('Location: ajustes.php');
        exit();
    }
?>