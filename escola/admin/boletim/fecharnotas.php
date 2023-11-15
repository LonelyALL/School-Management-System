<?php 
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
        header('Location: ../loginadmin/admin.php');
        exit();
    }
?>
<?php 
    require '../functions/functions.php';
    if(isset($_POST['id']) && isset($_POST['turma'])){
        $id = $_POST['id'];
        $turma = $_POST['turma'];

        gerarHistoricoIndividual($id, "detalhes.php?id=". $id ."&turma=". $turma ."&sucess=Notas fechadas com sucesso!", "detalhes.php?id=". $id ."&turma=". $turma ."&error=Nenhuma nota para ser fechada!", "detalhes.php?id=". $id ."&turma=". $turma ."&error=As notas desse bimestre já foram fechadas, exclua as mesmas para poder fechar novamente.");
    }
?>