<?php 
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
        header('Location: ../loginadmin/admin.php');
        exit();
    }
?>
<?php 
    require '../../connect/connect.php';
    $materia = $_POST['materia'];
    
    if(isset($materia) && !empty(trim($materia))){

        $sql2 = "SELECT MAX(id) as max_id FROM materias";
        $result = mysqli_query($conn, $sql2);
        $row = mysqli_fetch_assoc($result);
        $new_id = $row['max_id'] + 1;

        $sql = "INSERT INTO materias (id, materia) VALUES ('$new_id', '$materia')";

        $sql_verify = "SELECT * FROM materias WHERE materia='$materia';";        
        $result_verify = mysqli_query($conn, $sql_verify);
        if(mysqli_num_rows($result_verify) > 0){
            header("Location: ../arvoredematerias/arvoredematerias.php?error=Materia já cadastrada");
        }
        else{
            if(mysqli_query($conn, $sql)){
                header("Location: ../arvoredematerias/arvoredematerias.php?sucess=Matéria criada com sucesso");
            }
            else{
                header("Location: ../arvoredematerias/arvoredematerias.php?error=Erro desconhecido");
            }
        }
    }
    else{
        header("Location: ../arvoredematerias/arvoredematerias.php?error=Preencha os campos corretamente");
    }

    mysqli_close($conn);
?>