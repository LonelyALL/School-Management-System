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
    <link rel="stylesheet" href="criarprofessor.css">
    <script src="https://kit.fontawesome.com/23d5698429.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php 
        require "../functions/navbar.php";
        showNavbar();
    ?>
    <div class="container">
        <form method="post" action="../criarprofessor/criarprofessor2.php" id="form">
            <div class="box">
                <div class="inputs">
                    <h3>Cadastrar Professor</h3>
                    
                    <?php if(isset($_GET['error'])){ ?>
                            <p id="error"><?php echo $_GET['error']; ?></p>
                    <?php } ?>
                    <?php if(isset($_GET['sucess'])){ ?>
                            <p id="sucess"><?php echo $_GET['sucess']; ?></p>
                    <?php } ?>

                    <span>Digite o login:</span>
                    <input type="text" placeholder="Usuário" name="login" id="user" minlength="4" maxlength="12" required="true">

                    <span>Digite a senha:</span>
                    <input type="text" placeholder="Senha" name="senha" id="password" minlength="4" maxlength="12" required="true">

                    <div class="buttons">
                        <button>Criar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
    
    