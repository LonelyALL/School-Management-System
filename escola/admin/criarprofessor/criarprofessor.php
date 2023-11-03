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
<nav>
<ul>
            <li>
                <a href="#" class="logo">
                    <img src="../../images/oregonnovalogo.png" alt="#">
                    <span class="nav-item">Autumn</span>
                </a>
            </li>
            <li>
                <a href="../homeadmin/homeadmin.php">
                    <i class="fas fa-home"></i>
                    <span class="nav-item">Home</span>
                </a>
            </li>
            <li>
                <a href="../boletim/boletim.php">
                    <i class="fas fa-book"></i>
                    <span class="nav-item">Boletim</span>
                </a>
            </li>
            <li>
                <a href="../criarusuarios/criarusuarios.php">
                    <i class="fas fa-user"></i>
                    <span class="nav-item">Criar Usuários</span>
                </a>
            </li>
            <li>
                <a href="../gerenciarusuarios/aluno.php">
                    <i class="fas fa-user-group"></i>
                    <span class="nav-item">Gerenciar Usuários</span>
                </a>
            </li>
            <li>
                <a href="../arvoredematerias/arvoredematerias.php">
                    <i class="fas fa-layer-group"></i>
                    <span class="nav-item">Árvore de Matérias</span>
                </a>
            </li>
            <li>
                <a href="../gerenciarturmas/gerenciarturmas.php">
                    <i class="fas fa-cog"></i>
                    <span class="nav-item">Gerenciar Turmas</span>
                </a>
            </li>
            <li>
                <a href="../associarmaterias/associar.php">
                    <i class="fas fa-link"></i>
                    <span class="nav-item">Associação de Itens</span>
                </a>
            </li>
            <li>
                <a href="../ajustes/ajustes.php">
                    <i class="fas fa-wrench"></i>
                    <span class="nav-item">Ajustes</span>
                </a>
            </li>
            <li>
                <a href="../migracao/migracao.php">
                    <i class="fas fa-arrow-right-arrow-left"></i>
                    <span class="nav-item">Migração</span>
                </a>
            </li>
        </ul>
    </nav>
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
    
    