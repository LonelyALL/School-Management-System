-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15-Nov-2023 às 03:18
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `escolaenzow`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos`
--

CREATE TABLE `alunos` (
  `nome` char(85) NOT NULL,
  `login` varchar(12) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `matricula` int(8) NOT NULL,
  `turma` char(20) NOT NULL,
  `serie` char(20) NOT NULL,
  `segmento` char(35) NOT NULL,
  `status` char(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `alunos`
--

INSERT INTO `alunos` (`nome`, `login`, `senha`, `matricula`, `turma`, `serie`, `segmento`, `status`) VALUES
('ReactJsIsGoat', 'ReactJsIsGoa', '$2y$10$NmTtekOcHpqFtpwppb553uan3FcJrIA4..9GWtWLGRtsiWxrbOGlq', 50, '1301', '1', 'Ensino Fundamental I', 'Ativado'),
('carlos', 'carlos', '$2y$10$/3Hf6fJxvIRA9X02VJbsjuGeUJd3xtAIF7MfIq6JObpzuP6zmUWgq', 48, '1301', '1', 'Ensino Fundamental I', 'Ativado'),
('teste', 'teste', '$2y$10$qpbXyTtt7SFzMY2MPOL38OmAhKq77Xqgav9rKivg.7G.bnJFJA7LS', 49, '1301', '1', 'Ensino Fundamental I', 'Ativado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos_desativados`
--

CREATE TABLE `alunos_desativados` (
  `id` int(8) NOT NULL,
  `nome` char(85) NOT NULL,
  `login` varchar(12) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `matricula` int(8) NOT NULL,
  `status` char(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `alunos_desativados`
--

INSERT INTO `alunos_desativados` (`id`, `nome`, `login`, `senha`, `matricula`, `status`) VALUES
(47, 'josue', 'josue', '$2y$10$DYhyPFt1TtHQK3Tpm/KNu.nhXyp3ZV0SbtKDIkpJy0E0NL2A2nB7a', 46, 'Desativado'),
(48, 'luiz', 'luiz', '$2y$10$ky0vG1is6a4hXd9AbVU6n.5fp8N4FCdFhkgybJFPJGwVYWiuoAVCK', 47, 'Desativado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `id` int(8) NOT NULL,
  `avaliacao` char(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `avaliacoes`
--

INSERT INTO `avaliacoes` (`id`, `avaliacao`) VALUES
(31, 'portal'),
(33, 'Simulado Presencial');

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacoes_ano`
--

CREATE TABLE `avaliacoes_ano` (
  `id` int(10) NOT NULL,
  `avaliacao` char(35) NOT NULL,
  `ano` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `avaliacoes_ano`
--

INSERT INTO `avaliacoes_ano` (`id`, `avaliacao`, `ano`) VALUES
(13, 'portal', 2023),
(14, 'Simulado Presencial', 2023);

-- --------------------------------------------------------

--
-- Estrutura da tabela `gerencia`
--

CREATE TABLE `gerencia` (
  `gerenciaid` int(5) NOT NULL,
  `usuario` varchar(12) NOT NULL,
  `senha` varchar(60) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `gerencia`
--

INSERT INTO `gerencia` (`gerenciaid`, `usuario`, `senha`) VALUES
(1, 'admin', '$2y$10$ULyAarm5TCUI93ijOMKVJeV0YbeqkG9urvk1tsdf2ScuQ09OW5ogG');

-- --------------------------------------------------------

--
-- Estrutura da tabela `historico`
--

CREATE TABLE `historico` (
  `id` int(12) NOT NULL,
  `id_aluno` int(8) NOT NULL,
  `materia` char(10) NOT NULL,
  `avaliacao` char(35) NOT NULL,
  `nota` float NOT NULL,
  `bimestre` char(12) NOT NULL,
  `ano` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `historico`
--

INSERT INTO `historico` (`id`, `id_aluno`, `materia`, `avaliacao`, `nota`, `bimestre`, `ano`) VALUES
(56, 50, 'Portugues', 'portal', 20, 'bimestre1', 2023);

-- --------------------------------------------------------

--
-- Estrutura da tabela `materias`
--

CREATE TABLE `materias` (
  `id` int(12) NOT NULL,
  `materia` char(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `materias`
--

INSERT INTO `materias` (`id`, `materia`) VALUES
(2, 'Portugues'),
(1, 'Matemática'),
(3, 'Filosofia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `media`
--

CREATE TABLE `media` (
  `id` int(1) NOT NULL,
  `media` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `media`
--

INSERT INTO `media` (`id`, `media`) VALUES
(1, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `notas_avaliacoes`
--

CREATE TABLE `notas_avaliacoes` (
  `id` int(12) NOT NULL,
  `id_aluno` int(8) NOT NULL,
  `materia` char(10) NOT NULL,
  `avaliacao` char(35) NOT NULL,
  `nota` float NOT NULL,
  `bimestre` char(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `notas_avaliacoes`
--

INSERT INTO `notas_avaliacoes` (`id`, `id_aluno`, `materia`, `avaliacao`, `nota`, `bimestre`) VALUES
(77, 50, '2', 'Simulado Presencial', 0, 'bimestre1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `professor`
--

CREATE TABLE `professor` (
  `proid` int(12) NOT NULL,
  `login` varchar(12) NOT NULL,
  `senha` varchar(60) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `professor`
--

INSERT INTO `professor` (`proid`, `login`, `senha`) VALUES
(1, 'carlos', '$2y$10$NOVk0ObkBQN1yexydLca0e9tQExf0DdkM/6/Pe6iGJgmqLq2ekfC6'),
(2, 'josue', '$2y$10$DiCFdsqjDdGHA/rrXdSMYu17h.VB5uvRzprFWNgbcqxKv56Zm16mS');

-- --------------------------------------------------------

--
-- Estrutura da tabela `recuperacao`
--

CREATE TABLE `recuperacao` (
  `id` int(12) NOT NULL,
  `id_aluno` int(8) NOT NULL,
  `materia` char(10) NOT NULL,
  `nota` float NOT NULL,
  `bimestre` char(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `segmentos`
--

CREATE TABLE `segmentos` (
  `id` int(50) NOT NULL,
  `segmento` char(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `segmentos`
--

INSERT INTO `segmentos` (`id`, `segmento`) VALUES
(1, 'Ensino Fundamental I'),
(2, 'Ensino Fundamental II'),
(3, 'Ensino Médio');

-- --------------------------------------------------------

--
-- Estrutura da tabela `series`
--

CREATE TABLE `series` (
  `id` int(12) NOT NULL,
  `serie` int(10) NOT NULL,
  `segmento` char(35) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `series`
--

INSERT INTO `series` (`id`, `serie`, `segmento`) VALUES
(1, 1, 'Ensino Fundamental I'),
(3, 5, 'Ensino Fundamental II');

-- --------------------------------------------------------

--
-- Estrutura da tabela `turmas`
--

CREATE TABLE `turmas` (
  `id` int(12) NOT NULL,
  `turma` char(20) NOT NULL,
  `serie_id` int(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `turmas`
--

INSERT INTO `turmas` (`id`, `turma`, `serie_id`) VALUES
(1, '1301', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `turma_materia`
--

CREATE TABLE `turma_materia` (
  `id` int(12) NOT NULL,
  `turma` varchar(12) NOT NULL,
  `materia` int(12) NOT NULL,
  `proid` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `turma_materia`
--

INSERT INTO `turma_materia` (`id`, `turma`, `materia`, `proid`) VALUES
(1, '1', 1, 1),
(2, '2', 1, 1),
(3, '2', 3, 1),
(4, '1', 3, 1),
(5, '1', 2, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`matricula`);

--
-- Índices para tabela `alunos_desativados`
--
ALTER TABLE `alunos_desativados`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `avaliacoes_ano`
--
ALTER TABLE `avaliacoes_ano`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `gerencia`
--
ALTER TABLE `gerencia`
  ADD PRIMARY KEY (`gerenciaid`);

--
-- Índices para tabela `historico`
--
ALTER TABLE `historico`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `notas_avaliacoes`
--
ALTER TABLE `notas_avaliacoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`proid`);

--
-- Índices para tabela `recuperacao`
--
ALTER TABLE `recuperacao`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `segmentos`
--
ALTER TABLE `segmentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `turmas`
--
ALTER TABLE `turmas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `turma_materia`
--
ALTER TABLE `turma_materia`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alunos`
--
ALTER TABLE `alunos`
  MODIFY `matricula` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de tabela `alunos_desativados`
--
ALTER TABLE `alunos_desativados`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `avaliacoes_ano`
--
ALTER TABLE `avaliacoes_ano`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `historico`
--
ALTER TABLE `historico`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de tabela `notas_avaliacoes`
--
ALTER TABLE `notas_avaliacoes`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT de tabela `recuperacao`
--
ALTER TABLE `recuperacao`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
