<?php 
    session_start();
    if (!isset($_SESSION['proflogged']) || $_SESSION['proflogged'] !== true) {
        header('Location: ../professor.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autumn</title>
    <link rel="stylesheet" href="home.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <div class="nav-bar-elements">
            <img src="../../images/oregonnovalogo (5).png" alt="#">
            <div class="logo">Autumn</div>
        </div>
        <nav class="nav-bar">
            <ul>
                <li>
                    <a href="../logout.php" class="active">Logout</a>
                </li>
            </ul>
        </nav>  
    </header>
    <div class="container-box">
        <div class="container">
                <h3>Boas vindas, <?php echo $_SESSION['loginprof'];?></h3>
                
                <h3>Matérias Associadas: 
                    <?php 
                        require '../../connect/connect.php';
                        $idprof = $_SESSION['profid'];
                        $sql_materia = "SELECT DISTINCT materia FROM turma_materia WHERE proid='$idprof';";
                        $result = mysqli_query($conn, $sql_materia);
                        $numlinhas = mysqli_num_rows($result);
                        echo $numlinhas;
                    ?>
                </h3>
                <h3>Turmas Associadas: 
                    <?php 
                        require '../../connect/connect.php';
                        $idprof = $_SESSION['profid'];
                        $sql_turma = "SELECT DISTINCT turma FROM turma_materia WHERE proid='$idprof';";
                        $result = mysqli_query($conn, $sql_turma);
                        $numlinhas = mysqli_num_rows($result);
                        echo $numlinhas;
                    ?>
                </h3>
        </div>
    </div>
    <form id="form" method='POST' action='visualizaralunos.php'>
        <div class="box-inputs">
            <div class="inputs">
                <span>Matéria:</span>
                <select name="materia" id="materia" required="true">
                    <option value=""></option>
                    <?php 
                        require '../../connect/connect.php';
                        if(isset($_SESSION['profid']) && !empty($_SESSION['profid'])){
                            $id = $_SESSION['profid'];
                            $sql = "SELECT DISTINCT materia FROM turma_materia WHERE proid = '$id' ORDER BY materia;";
                            $result = mysqli_query($conn, $sql);    
                            while($row = mysqli_fetch_assoc($result)){
                                $idmateria = $row['materia'];
                                $sql2 = "SELECT * FROM materias WHERE id='$idmateria';";
                                $result2 = mysqli_query($conn, $sql2);
                                $row2 = mysqli_fetch_assoc($result2);

                                echo '<option value="'. $row2['id'] .'">'. $row2['materia'] .'</option>';
                            }

                        }
                    ?>  
                </select>
                <span>Turma:</span>
                <select name="turma" id="turma" required="true">
                </select>
                <button>Acessar</button>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            // Quando ocorre uma alteração no select de matéria
            $('select#materia').change(function() {
                var materia_id = $(this).val(); // Obtém o ID da matéria selecionada
                var turma_select = $('select#turma'); // Encontra o select de turma

                // Faça uma solicitação AJAX para obter as turmas associadas à matéria
                $.ajax({
                    type: 'POST',
                    url: 'get_turmas.php',
                    data: {
                        materia_id: materia_id
                    },
                    dataType: 'json',
                    success: function(turmas) {
                        // Limpe o select de turmas
                        turma_select.empty();

                        // Preencha o select de turmas com os resultados da solicitação AJAX
                        $.each(turmas, function(index, turma) {
                            turma_select.append($('<option>', {
                                value: turma.id,
                                text: turma.turma
                            }));
                        });
                    },
                    error: function() {
                        alert('Erro ao carregar turmas.');
                    }
                });
            });
        })
    </script>
</body>
</html>