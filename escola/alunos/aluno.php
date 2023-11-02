<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autumn</title>
    <link rel="stylesheet" href="aluno.css">
    <script src="../navbar/navbar.js" defer></script>
</head>
<body>
    <header>
        <div class="nav-bar-elements">
            <img src="../images/oregonnovalogo (5).png" alt="#">
            <div class="logo">Autumn</div>
        </div>
        <div class="hamburger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <nav class="nav-bar">
            <ul>
                <li>
                    <a href="../alunos/aluno.php" class="active">Alunos</a>
                </li>
                <li>
                     <a href="../professor/professor.php" class="active">Professores</a>
                </li>
                <li>
                    <a href="../admin/loginadmin/admin.php" class="active">Admin</a>
                </li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <form id="form" method="post" action="loginaluno.php">
            <div class="box">

                <h3>Acesse seu Boletim</h3>
                <?php if(isset($_GET['error'])){ ?>
                    <div class='errors' id="error"><?php echo "<p>". $_GET['error'] ."</p>"; ?></div>
                <?php } ?>
                <div class="inputs">
                    <span>Digite seu usuário:</span>
                    <input type="text" id="usuario" placeholder="Usuário" required='true' minlength='4' maxlength='12' name="user">

                    <span>Digite sua senha:</span>
                    <input type="password" id="senha" placeholder="Senha" required='true' minlength='4' maxlength='12' name="pass">
                </div>
                
                <div class="buttons">
                    <button type="submit">Entrar</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>