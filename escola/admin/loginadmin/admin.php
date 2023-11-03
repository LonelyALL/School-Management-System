<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autumn</title>
    <link rel="stylesheet" href="../loginadmin/admin.css">
    <script src="../../navbar/navbar.js" defer></script>
    <link rel="stylesheet" href="../error/error.css">
</head>
<body>
    <header>
        <div class="nav-bar-elements">
            <img src="../../images/oregonnovalogo (5).png" alt="#">
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
                    <a href="../../alunos/aluno.php" class="active">Alunos</a>
                </li>
                <li>
                    <a href="../../professor/professor.php" class="active">Professores</a>
                </li>
                <li>
                    <a href="#" class="active">Admin</a>
                </li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <form id="form" method="post" action="../loginadmin/loginadmin.php">
            <div class="box">

                <h3>Área Admin</h3>

                <?php if(isset($_GET['error'])){ ?>
                    <div class='errors' id="error"><?php echo "<p>". $_GET['error'] ."</p>"; ?></div>
                <?php } ?>
                
                <div class="inputs">
                    <span>Digite seu usuário:</span>
                    <input type="text" id="usuario" placeholder="Usuário" minlength='4' maxlength='12' name="user" required="true">

                    <span>Digite sua senha:</span>
                    <input type="password" id="senha" placeholder="Senha" minlength='4' maxlength='12' name="pass" required="true">
                </div>

                <div class="buttons">
                    <button type="submit">Entrar</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>