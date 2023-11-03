<?php 
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
        header('Location: ../loginadmin/admin.php');
        exit();
    }
?>
<?php 
    require '../connect/connect.php';
    $turma = $_POST['turma'];
    $materia = $_POST['materia'];
    $professor = $_POST['professor'];

    $sql2 = "SELECT MAX(id) as max_id FROM turma_materia";
    $result_id = mysqli_query($conn, $sql2);
    $row_id = mysqli_fetch_assoc($result_id);
    $new_id = $row_id['max_id'] + 1;

    $sql_verify = "SELECT * FROM turma_materia WHERE turma = '$turma' AND materia = '$materia' AND proid = '$professor';";
    $result_verify = mysqli_query($conn, $sql_verify);

    $sql = "INSERT INTO turma_materia (id, turma, materia, proid) VALUES ($new_id, $turma, $materia, $professor);";

    if(isset($turma) && isset($materia) && isset($professor)){
        if(!empty($turma) && !empty($materia) && !empty($professor)){
            if(mysqli_num_rows($result_verify) > 0){
                header('Location: associar.php?error=Associação já existente !');
                exit();
            }
            else{
                if(mysqli_query($conn, $sql)){
                    header('Location: associar.php?sucess=Associação feita com sucesso !');
                    exit();
                }
                else{
                    header('Location: associar.php?error=Erro desconhecido !');
                    exit();
                }
            }
        }
        else{
            header('Location: associar.php?error=Preencha os campos corretamente !');
            exit();
        }
    }
    else{
        header('Location: associar.php?error=Preencha os campos corretamente !');
        exit();
    }
?>