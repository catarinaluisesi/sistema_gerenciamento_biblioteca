-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01/05/2024 às 01:14
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `livros`
--

CREATE TABLE `livros` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `autor` varchar(255) NOT NULL,
  `ISBN` varchar(13) NOT NULL,
  `numero_de_copias_disponiveis` int(11) NOT NULL DEFAULT 0,
  `imagem_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `livros`
--

INSERT INTO `livros` (`id`, `titulo`, `autor`, `ISBN`, `numero_de_copias_disponiveis`, `imagem_url`) VALUES
(1, 'Seis vezes em que a gente quase ficou', 'Tess Sharpe', '12345', 13, NULL),
(2, 'Harry Potter e a Pedra Filosofal', 'J.K. Rowling', '9781408855652', 5, NULL),
(3, 'O Senhor dos Anéis: A Sociedade do Anel', 'J.R.R. Tolkien', '9788567296213', 3, NULL),
(4, 'Dom Quixote', 'Miguel de Cervantes', '9789727086768', 4, NULL),
(5, 'Cem Anos de Solidão', 'Gabriel García Márquez', '9788535909554', 2, NULL),
(6, '1984', 'George Orwell', '9780451524935', 6, NULL),
(7, 'Girls Like Girls', 'Haley Kyoko', '1234568', 9, NULL),
(9, 'Memórias de um amor inesperado', 'Cyara Smith', '987451360', 6, NULL),
(10, 'Blablablbalabla', 'blilililili', '999999999', 8, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `livros`
--
ALTER TABLE `livros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ISBN` (`ISBN`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `livros`
--
ALTER TABLE `livros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
