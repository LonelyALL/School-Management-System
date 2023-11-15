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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Autumn</title>
    <link rel="stylesheet" href="criaraluno.css">
    <script src="https://kit.fontawesome.com/23d5698429.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php 
        require "../functions/navbar.php";
        require '../../connect/connect.php';
        showNavbar();
    ?>
    <div class="container">
        <form method="post" action="../criaraluno/criaraluno2.php" id="form">
            <div class="box">
                <div class="inputs">
                    <h3>Cadastrar Aluno</h3>

                    <?php if(isset($_GET['error'])){ ?>
                            <p id="error"><?php echo $_GET['error']; ?></p>
                    <?php } ?>
                    <?php if(isset($_GET['sucess'])){ ?>
                            <p id="sucess"><?php echo $_GET['sucess']; ?></p>
                    <?php } ?>
                    
                    <span>Nome Completo:</span>
                    <input type="text" placeholder="Nome Completo" name="nome" id="nome" minlength="3" maxlength="85" required="true">

                    <span>Digite o usuário:</span>
                    <input type="text" placeholder="Usuário" name="login" id="user" minlength="4" maxlength="12" required="true">

                    <span>Digite a senha:</span>
                    <input type="text" placeholder="Senha" name="senha" id="password" minlength="4" maxlength="12" required="true">

                    <span>Selecione o segmento:</span>
                    <select name="segmento" id="segmento" required="true">
                        <option value=""></option>
                        <?php 
                            $sql = "SELECT * FROM segmentos;";
                            $result = mysqli_query($conn, $sql);

                            while($row = mysqli_fetch_assoc($result)){
                                echo '<option value="'. $row['segmento'] .'">'. $row['segmento'] .'</option>';
                            }
                        ?>
                    </select>

                    <span>Selecione a série:</span>
                    <select name="serie" id="serie" required="true">
                        <option value="empty"></option>
                    </select>

                    <span>Selecione a turma:</span>
                    <select name="turma" id="turma" required="true">
                        
                    </select>

                    <div class="buttons">
                        <button>Criar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
    document.getElementById('segmento').addEventListener('change', function (){
        var segmento = this.value;
        var serieSelect = document.getElementById('serie');
        serieSelect.innerHTML = '';

        $.ajax({
            url: 'buscar_series.php', // Arquivo PHP para buscar turmas
            method: 'POST',
            data: { segmento: segmento },
            success: function (data) {
                // Preencher o select de turmas com os dados recebidos
                serieSelect.innerHTML = data;
            },
            error: function () {
                // Lidar com erros, se houver algum
                alert('Erro ao buscar séries.');
            }
        });
    })
    document.getElementById('serie').addEventListener('change', function () {
        var serieId = this.value;
        var turmaSelect = document.getElementById('turma');
        turmaSelect.innerHTML = ''; // Limpar o select de turmas

        // Fazer uma solicitação AJAX para buscar as turmas da série
        $.ajax({
            url: 'buscar_turmas.php', // Arquivo PHP para buscar turmas
            method: 'POST',
            data: { serie_id: serieId },
            success: function (data) {
                // Preencher o select de turmas com os dados recebidos
                turmaSelect.innerHTML = data;
            },
            error: function () {
                // Lidar com erros, se houver algum
                alert('Erro ao buscar turmas.');
            }
        });
    });
</script>


</body>
</html>
    
    