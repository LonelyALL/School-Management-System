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
    <link rel="stylesheet" href="associar.css">
    <script src="https://kit.fontawesome.com/23d5698429.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <?php 
        require '../../connect/connect.php';
        require "../functions/navbar.php";
        showNavbar();
    ?>
    <main>
        <div class="box">
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
            <form action="assoc.php" method="post" id="form">
                <div class="box-inputs">
                    <div class="inputs">
                        <span>Turma:</span>
                        <select name="turma" required="true">
                            <?php 
                                $sql = "SELECT * FROM turmas ORDER BY turma ASC;";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_assoc($result)){
                                    echo "<option value='{$row["id"]}'>" . $row['turma'] . "</option>";
                                }
                            ?>
                        </select>
                        <span>Matéria:</span>
                        <select name="materia" id="materia" required="true">
                            <?php 
                                $sql = "SELECT * FROM materias ORDER BY materia ASC;";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_assoc($result)){
                                    echo "<option value='{$row["id"]}'>" . $row['materia'] . "</option>";
                                }
                            ?>
                        </select>
                        <span>Professor:</span>
                        <select name="professor" id="professor" required="true">
                            <?php 
                                $sql = "SELECT * FROM professor ORDER BY login ASC;";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_assoc($result)){
                                    echo "<option value='{$row["proid"]}'>" . $row['login'] . "</option>";
                                }
                            ?>
                        </select>
                        
                        <button type="submit">Associar</button>
                    </div>
                </div>
            </form>
            <div class="table-container">
        <?php   
                echo "<table class='scrollable-table'>";
                echo "<tr><td class='title'>Turma</td><td class='title'>Matérias</td><td class='title'>Professores</td><td class='title'>Ações</td></tr>";

                $sql_turmas = "SELECT * FROM turmas WHERE id IN (SELECT DISTINCT turma FROM turma_materia);";
                $result_turmas = mysqli_query($conn, $sql_turmas);

                while ($row_turma = mysqli_fetch_assoc($result_turmas)) {
                    echo "<tr>";
                    echo "<td><input value='{$row_turma['turma']}' class='turma' name='turma' readonly='true' id='turma'></td>";
                    echo "<td>";
                    
                    $sql_materias = "SELECT materia FROM materias WHERE id IN (SELECT materia FROM turma_materia WHERE turma = '{$row_turma['id']}') ORDER BY materia ASC;";
                    $result_materias = mysqli_query($conn, $sql_materias);

                    echo "<select id='select-materia'>";
                    echo "<option value='nothing'></option>";
                    while ($row_materia = mysqli_fetch_assoc($result_materias)) {
                        echo "<option value='{$row_materia['materia']}'>{$row_materia['materia']}</option>";
                    }
                    echo "</select>";
                    echo "</td>";

                    echo "<td>";
                    $sql_professores = "SELECT login FROM professor WHERE proid IN (SELECT proid FROM turma_materia WHERE turma = '{$row_turma['id']}');";
                    $result_professores = mysqli_query($conn, $sql_professores);

                    echo "<select id='select-professor' required='true'>";  
                    echo "</select>";
                    echo "</td>";
                    echo "<td class='td-deletar'>";
                    echo "<button id='deletar'>Deletar</button>";
                    echo "</td>";
                    echo "</tr>";
                }

                echo "</table>";
                mysqli_close($conn);
            ?>
        </div>
        </div>
    </main>
    <script>
        $(document).ready(function() {
    // Quando ocorre uma alteração em qualquer select de matéria
    $('select#select-materia').change(function() {
        var materia_id = $(this).val(); // Obtém o ID da matéria selecionada
        var turma_id = $(this).closest('tr').find('input#turma').val(); // Obtém o ID da turma na mesma linha
        var professor_select = $(this).closest('tr').find('select#select-professor'); // Encontra o select de professor na mesma linha

        // Faça uma solicitação AJAX para obter os professores associados à matéria e turma
        $.ajax({
            type: 'POST',
            url: 'get_professores.php',
            data: {
                materia_id: materia_id,
                turma_id: turma_id // Envie o ID da turma
            },
            dataType: 'json',
            success: function(professores) {
                // Limpe o select de professores
                professor_select.empty();

                // Preencha o select de professores com os resultados da solicitação AJAX
                $.each(professores, function(index, professor) {
                    professor_select.append($('<option>', {
                        value: professor,
                        text: professor
                    }));
                });
            }
        });
    });

    // Lidar com o clique do botão "deletar"
    $('button#deletar').click(function() {
    var materia = $(this).closest('tr').find('#select-materia').val();
    var professor = $(this).closest('tr').find('#select-professor').val();
    var turma = $(this).closest('tr').find('input#turma').val();

    $.ajax({
    type: 'POST',
    url: 'delete.php',
    data: {
        materia: materia,
        professor: professor,
        turma: turma
    },
    success: function(data) {
        try {
            var response = JSON.parse(data);
            if (response.status === 'success') {
                // Exclusão bem-sucedida
                window.location.href = "associar.php?sucess=" + response.message;
            } else {
                // Erro na exclusão
                window.location.href = "associar.php?error=" + response.message;
            }
        } catch (e) {
            // Trate erros de análise aqui
            console.error("Erro ao analisar a resposta JSON do servidor: " + e);
        }
    },
    error: function() {
        // Trate erros de requisição
        alert("Erro na requisição");
    }
});
});
});
</script>
</body>
</html>