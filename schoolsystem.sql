-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16-Fev-2024 às 23:11
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
-- Banco de dados: `schoolsystem`
--
CREATE DATABASE IF NOT EXISTS `schoolsystem` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `schoolsystem`;

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
('Pedro Da Silva', 'pedro', '$2y$10$ua7P.U5rvLEMfrhQFnZdwOSEzQXKLl27ylyTUZbK3xtpDgUWx7l5O', 54, '101', '1', 'Ensino Fundamental I', 'Ativado'),
('Teste Da Silva', 'teste', '$2y$10$22ee.Ji0iUkJy8Pd9yDXK.vWQJHBeIlcyeNRXxj4wRfJ5LqaQvtLa', 53, '101', '1', 'Ensino Fundamental I', 'Ativado'),
('Carlos Da Silva', 'carlos', '$2y$10$uIrCurHADjLqeAOjWCal4.j.FMtZjU17.NpVfTk6j.zXQElWCp7qy', 52, '101', '1', 'Ensino Fundamental I', 'Ativado'),
('Renato Da Silva', 'renato', '$2y$10$2Nqlc8AeD6Stso.P9rjJgecvK4lZ4kXBn7th7boiqOrIyyx1bT3K.', 55, '101', '1', 'Ensino Fundamental I', 'Ativado'),
('Kaio Da Silva', 'Kaio', '$2y$10$7lYUnsI/E2G24ds6u87SuuqlPDWlSL8AxtgIMrM4BkMm0NZ1isZta', 56, '101', '1', 'Ensino Fundamental I', 'Ativado'),
('Login Da Silva', 'login', '$2y$10$FI5TEufnnc5mMDNKGbvm9.O3EIIGSIrIPg7ckrjyn3wKBhc8uzGgG', 57, '3301', '12', 'Ensino Médio', 'Ativado');

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
(35, 'Teste'),
(36, 'Simulado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacoes_ano`
--

CREATE TABLE `avaliacoes_ano` (
  `id` int(10) NOT NULL,
  `avaliacao` char(35) NOT NULL,
  `ano` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
(1, 'admin', '$2y$10$Ifc4pq7Gkak7tPaTw3WMl.HuyhPaXkJ425TqA6RN3o9mbY1jad3o.');

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
(3, 'Geografia'),
(2, 'Matemática'),
(1, 'Português'),
(4, 'Filosofia'),
(5, 'Ciências'),
(6, 'Hardware'),
(7, 'Engenharia');

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
(2, 'Negao', '$2y$10$FERulI61P/eh7Ibkv3XyDe7BHvYjjZ02a.IyFIB/G6HIZQfkOquDy'),
(1, 'Xandao', '$2y$10$yGiMwENa43cL8knY5svETuN6Hdl4CSd.0/eilIToRdJttQ22UI6US'),
(3, 'Renato', '$2y$10$mggQSnUI70r/VGrUBhHfueQ1nqO3.PGQzt0UyT8YDx3PEmdMiWT7q'),
(4, 'Pedro', '$2y$10$rytPTlnabZNLBaZ2CzkTwurccDyNIu8xfAn50AAzbEvG07Q4LINqO'),
(5, 'Carlos', '$2y$10$n7eVtY0MsfmatWOi8qrcsecpZixf.RjGyT/oevgQ3Jt86bZd/qTF6');

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
(2, 2, 'Ensino Fundamental I'),
(1, 1, 'Ensino Fundamental I'),
(3, 3, 'Ensino Fundamental I'),
(4, 4, 'Ensino Fundamental I'),
(5, 5, 'Ensino Fundamental I'),
(6, 6, 'Ensino Fundamental II'),
(7, 7, 'Ensino Fundamental II'),
(8, 8, 'Ensino Fundamental II'),
(9, 9, 'Ensino Fundamental II'),
(10, 1, 'Ensino Médio'),
(11, 2, 'Ensino Médio'),
(12, 3, 'Ensino Médio');

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
(1, '101', 1),
(2, '201', 2),
(3, '301', 3),
(4, '401', 4),
(5, '501', 5),
(6, '601', 6),
(7, '701', 7),
(8, '801', 8),
(9, '901', 9),
(10, '1101', 10),
(11, '2201', 11),
(12, '3301', 12);

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
(1, '1', 5, 5),
(2, '10', 5, 5),
(3, '2', 5, 5),
(4, '11', 5, 5),
(5, '3', 5, 5),
(6, '12', 5, 5),
(7, '4', 5, 5),
(8, '5', 5, 5),
(9, '6', 5, 5),
(10, '7', 5, 5),
(11, '12', 7, 5),
(12, '12', 4, 5),
(13, '12', 3, 5),
(14, '12', 6, 5),
(15, '12', 2, 5),
(16, '12', 1, 5);

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
  MODIFY `matricula` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de tabela `alunos_desativados`
--
ALTER TABLE `alunos_desativados`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `avaliacoes_ano`
--
ALTER TABLE `avaliacoes_ano`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `historico`
--
ALTER TABLE `historico`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de tabela `notas_avaliacoes`
--
ALTER TABLE `notas_avaliacoes`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de tabela `recuperacao`
--
ALTER TABLE `recuperacao`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
