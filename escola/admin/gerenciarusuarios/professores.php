<?php 
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
        header('Location: ../loginadmin/admin.php');
        exit();
    }
?>
<?php 
    require '../connect/connect.php';
    if(isset($_GET['delete']) && !empty($_GET['delete'])){
        $id = $_GET['delete'];
        $sql = "DELETE FROM professor WHERE proid='$id';";
        $sql2 = "DELETE FROM turma_materia WHERE proid='$id';";
        if(mysqli_query($conn, $sql) && mysqli_query($conn, $sql2)){
            header('Location: professores.php?sucess=Usuário deletado com sucesso');
        }  
    }
    mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autumn</title>
    <link rel="stylesheet" href="gerenciarusuarios.css">
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
    <div class="errors">
                <?php if(isset($_GET['error'])){ ?>
                    <div id="error"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" color="red" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
</svg><?php echo $_GET['error']; ?></div>
                <?php } ?>
                <?php if(isset($_GET['sucess'])){ ?>
                    <div id="sucess"><svg viewBox="0 0 16 16" fill="none" width="20" height="20" preserveAspectRatio="xMidYMid meet" style="vertical-align: middle; color: rgb(0, 136, 71);"><g clip-path="url(#CheckCircle_svg__clip0_1372_9763)" fill="currentColor"><path d="M11.966 5.778a.6.6 0 10-.932-.756l-4.101 5.047-1.981-2.264a.6.6 0 00-.904.79l2.294 2.622a.8.8 0 001.223-.023l4.4-5.416z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M8 .4a7.6 7.6 0 100 15.2A7.6 7.6 0 008 .4zM1.6 8a6.4 6.4 0 1112.8 0A6.4 6.4 0 011.6 8z"></path></g><defs><clipPath id="CheckCircle_svg__clip0_1372_9763"><path fill="#fff" d="M0 0h16v16H0z"></path></clipPath></defs></svg><?php echo $_GET['sucess']; ?></div>
                <?php } ?>
    </div>
    <form action="aluno.php" method="post" id="form">
        <h4>Selecione o tipo de usuário:</h4>
        <select name="changepage" id="changepage">
            <option value="professor">Professores</option> 
            <option value="aluno">Alunos</option>        
        </select>
    </form>
    <div class="box">
    <div class="searchbox">
        <input type="search" placeholder="Pesquisar" id="inputs" required="true">
        <button type="button" id="buscar">Buscar</button>
    </div>
    <table class="scrollable-table">
    <tr><th class="title">Login</th><th class="title" colspan="2">Ações</th></tr>
    <?php 
        require '../connect/connect.php';
        if(isset($_GET['busca'])){
            $busca = $_GET['busca'];
            $sql_busca = "SELECT * FROM professor WHERE login LIKE '%$busca%';";
            $result_busca = mysqli_query($conn, $sql_busca);
            if(mysqli_num_rows($result_busca) > 0){
                while($row_busca = mysqli_fetch_assoc($result_busca)){
                    echo "<tr>";
                    echo "<td>";
                    echo $row_busca['login'];
                    echo "</td>";
                    echo '<td><a href="professores.php?delete='. $row_busca["proid"] .'"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                    </svg></a></td>';
                    echo '<td><a href="editarprofessor.php?edit=' . $row_busca['proid'] . '"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/></a></td>';
                    echo "</tr>";
                }  
            }
            else{
                header('Location: professores.php?error=Nenhum usuário encontrado.');
                exit();
            }
        }
        else{
            $sql = "SELECT * FROM professor ORDER BY login ASC;";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                echo "<td>";
                echo $row['login'];
                echo "</td>";
                echo '<td><a href="professores.php?delete='. $row["proid"] .'"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                </svg></a></td>';
                echo '<td><a href="editarprofessor.php?edit=' . $row['proid'] . '"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/></a></td>';
                echo "</tr>";
            }
        }
        echo "</table>";
        mysqli_close($conn);
    ?>
    </div>
    
    <script>
        const form = document.getElementById("form");
        const select = document.getElementById("changepage");
        changepage.onchange = () =>{
            if(select.value == "aluno"){
                form.submit();
            }
        }
        const button = document.getElementById('buscar');
        const input = document.querySelector('#inputs');
        button.onclick = () =>{
            if(input.value.length < 1){
                window.location.href = "professores.php?error=Preencha os campos corretamente !";
            }
            else{
                
                window.location.href = "professores.php?busca="+input.value;
            }
            
        }
    </script>
</body>
</html>