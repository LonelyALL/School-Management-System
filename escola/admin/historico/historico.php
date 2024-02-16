<?php 
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
        header('Location: ../loginadmin/admin.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autumn</title>
    <link rel="stylesheet" href="historico.css">
    <script src="https://kit.fontawesome.com/23d5698429.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="pdf.js" defer></script>
</head>
<body>
    <?php 
        require '../../connect/connect.php';
        require '../functions/functions.php';    
    ?>
    
    <header>
        <div class="nav-bar-elements">
            <img src="../../images/oregonnovalogo (5).png" alt="#">
            <div class="logo">Autumn</div>
        </div>
        <nav class="nav-bar">
            <ul>
                <li>
                    <a href='desativados.php' id="botaoVoltar">Voltar</a>
                </li>
            </ul>
        </nav>
    </header>
    <div class="box">
        <div class="content" id="content">
        <div class="title"><h3>Histórico Escolar:</h3></div>
            <?php 
               if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['nome']) && !empty($_GET['nome'])){
                $id = $_GET['id'];

                $sql = "SELECT * FROM historico WHERE id_aluno = ?;";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) > 0){
                    showHistory($result, $id);
                }
                else{
                    header('Location: desativados.php?error=Nenhuma nota cadastrada nesse aluno.');
                    exit();
                }

               }   
               else{
                header('Location: desativados.php');
                exit();
               }  
            ?>
        </div>
        <div class="buttons">
            <button type="button" id="pdfGenerate">Gerar PDF</button>
        </div>
    </div>
</body>
</html>