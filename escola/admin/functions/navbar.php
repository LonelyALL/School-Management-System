<?php 
    function showNavbar(){
        echo '<nav id="navbar">
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
                <a href="../historico/desativados.php">
                    <i class="fas fa-graduation-cap"></i>
                    <span class="nav-item">Histórico</span>
                </a>
            </li>
            <li>
                <a href="../ajustes/ajustes.php">
                    <i class="fas fa-wrench"></i>
                    <span class="nav-item">Ajustes</span>
                </a>
            </li>
        </ul>
    </nav>';
    }
?>