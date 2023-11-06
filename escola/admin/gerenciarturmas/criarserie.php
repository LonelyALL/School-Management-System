<?php 
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
        header('Location: ../loginadmin/admin.php');
        exit();
    }
?>
<?php 
    require '../../connect/connect.php';
    $serie = $_POST['serie'];
    $segmento = $_POST['segmento'];
    $sql2 = "SELECT MAX(id) as max_id FROM series";
    $result = mysqli_query($conn, $sql2);
    $row = mysqli_fetch_assoc($result);
    $new_id = $row['max_id'] + 1;
    $sql = "INSERT INTO series (id, serie, segmento) VALUES ('$new_id', '$serie', '$segmento')";
    $sql3 = "SELECT * FROM series WHERE serie='$serie' AND segmento='$segmento';";
    $result2 = mysqli_query($conn, $sql3);

    if(mysqli_num_rows($result2) > 0){
        header('Location: ../gerenciarturmas/gerenciarturmas.php?error=Essa serie já foi criada');
        exit();
    }
    else{
        if(isset($serie) && !empty($serie)){
            if(mysqli_query($conn, $sql)){
                header("Location: ../gerenciarturmas/gerenciarturmas.php?sucess=Serie criada com sucesso");
                exit();
            }
            else{
                header("Location: ../gerenciarturmas/gerenciarturmas.php?error=Série só pode conter até 10 caracteres!");
                exit();
            }
        }
        else{
            header("Location: ../gerenciarturmas/gerenciarturmas.php?error=Preencha os campos corretamente");
            exit();
        }
    }
    mysqli_close($conn);
?>
