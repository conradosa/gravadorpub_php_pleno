CREATE DATABASE bd;
USE bd;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `celke`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinhos`
--

DROP TABLE IF EXISTS `carrinhos`;
CREATE TABLE IF NOT EXISTS `carrinhos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `carrinhos`
--

INSERT INTO `carrinhos` (`id`, `usuario_id`, `created`, `modified`) VALUES
(1, 1, '2019-04-30 00:00:00', NULL),
(2, 1, '2019-05-01 00:00:00', NULL),
(3, 2, '2019-05-01 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinhos_produtos`
--

DROP TABLE IF EXISTS `carrinhos_produtos`;
CREATE TABLE IF NOT EXISTS `carrinhos_produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valor_cotacao` double NOT NULL,
  `valor_venda` double NOT NULL,
  `qnt_produto` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `carrinho_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `carrinhos_produtos`
--

INSERT INTO `carrinhos_produtos` (`id`, `valor_cotacao`, `valor_venda`, `qnt_produto`, `produto_id`, `carrinho_id`, `created`, `modified`) VALUES
(1, 150, 137, 2, 1, 1, '2019-04-30 00:00:00', NULL),
(2, 45, 42, 1, 2, 1, '2019-04-30 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamentos`
--

DROP TABLE IF EXISTS `pagamentos`;
CREATE TABLE IF NOT EXISTS `pagamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_pg` int(11) DEFAULT NULL,
  `cod_trans` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `link_boleto` text COLLATE utf8_unicode_ci,
  `link_db_online` text COLLATE utf8_unicode_ci,
  `carrinho_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `pagamentos`
--

INSERT INTO `pagamentos` (`id`, `tipo_pg`, `cod_trans`, `status`, `link_boleto`, `link_db_online`, `carrinho_id`, `created`, `modified`) VALUES
(1, 2, '105DB212-38E2-4F6B-ABDD-22C81605066E', 1, 'https://sandbox.pagseguro.uol.com.br/checkout/payment/booklet/print.jhtml?c=952680626531bd8611c12de22a73a51d877d60be9d2a789c1690f03ab2bacac30d4c84fb7ae4fb12', NULL, 1, '2019-10-06 19:11:54', NULL),
(2, 1, '515211B4-3B0A-4B1A-937F-230389EB3945', 1, '', NULL, 1, '2019-10-06 19:17:15', NULL),
(3, 3, '729D728D-BDD2-4F73-8310-2070914C6710', 1, NULL, 'https://sandbox.pagseguro.uol.com.br/checkout/payment/eft/print.jhtml?c=1e745404eb8374518f09fd0a9bf4433d72bb7507ce3574cfd126ec929c69ab1d21a9b5a0656641a7', 1, '2019-10-06 19:25:17', NULL),
(4, 2, '842C7AFF-8AB5-4AD7-8C06-48FE9C63A8B1', 1, 'https://sandbox.pagseguro.uol.com.br/checkout/payment/booklet/print.jhtml?c=b86d3b5e86a8e8401b05c5a3279ecb2926752257f7333b0a1c8c3ddb8428f3f6da66f1bcb2f7d8d8', NULL, 1, '2019-10-06 19:33:56', NULL),
(5, 3, '39CCDB51-7FB4-4874-8C56-9C8E92DF7433', 1, NULL, 'https://sandbox.pagseguro.uol.com.br/checkout/payment/eft/print.jhtml?c=2370816c230887ed0a7c560b52fa5f42e314521e60a514f9ead460236fa4ec84df362412a7e878c2', 1, '2019-10-06 19:34:41', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_produto` varchar(220) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `valor_compra` double DEFAULT NULL,
  `valor_venda` double NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome_produto`, `valor_compra`, `valor_venda`, `created`, `modified`) VALUES
(1, 'Teclado + Mouse', 85.12, 150, '2019-04-30 00:00:00', NULL),
(2, 'Mouse', 15.77, 45, '2019-04-30 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `created`, `modified`) VALUES
(1, 'Cesar', 'celkeadm@gmail.com', '2019-01-05 00:00:00', '2019-01-05 00:00:00'),
(2, 'Kelly', 'kelly@celke.com.br', '2019-01-05 00:00:00', '2019-01-05 00:00:00'),
(3, 'Jessica', 'jessica@celke.com.br', '2019-01-05 00:00:00', '2019-01-05 00:00:00'),
(4, 'Danielle', 'danielle@celke.com.br', '2019-01-05 00:00:00', '2019-01-05 00:00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
