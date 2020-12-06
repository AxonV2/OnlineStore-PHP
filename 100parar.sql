-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24-Jun-2020 às 16:38
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `100parar`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `catName` varchar(255) DEFAULT NULL,
  `catDesc` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `category`
--

INSERT INTO `category` (`id`, `catName`, `catDesc`) VALUES
(1, 'Processadores', 'Processadores'),
(2, 'GPU\'s', 'Placas Gráficas'),
(3, 'Periféricos', 'Teclados/Ratos/etc..'),
(4, 'Pre-Builts', 'Sistemas'),
(5, 'Outros', 'Outros');

-- --------------------------------------------------------

--
-- Estrutura da tabela `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `idprod` varchar(255) DEFAULT NULL,
  `quant` int(11) DEFAULT NULL,
  `odata` timestamp NOT NULL DEFAULT current_timestamp(),
  `pagamento` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `orders`
--

INSERT INTO `orders` (`id`, `userId`, `idprod`, `quant`, `odata`, `pagamento`) VALUES
(35, 22, '1', 1, '2020-06-18 02:27:47', 'Pagamento por Telemóvel'),
(36, 23, '3', 6, '2020-06-20 16:13:06', 'Transferência'),
(37, 22, '6', 1, '2020-06-20 18:53:28', 'Pagamento por Telemóvel');

-- --------------------------------------------------------

--
-- Estrutura da tabela `productreviews`
--

CREATE TABLE `productreviews` (
  `id` int(11) NOT NULL,
  `idprod` int(11) DEFAULT NULL,
  `quality` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `review` longtext DEFAULT NULL,
  `reviewData` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `productreviews`
--

INSERT INTO `productreviews` (`id`, `idprod`, `quality`, `price`, `value`, `nome`, `summary`, `review`, `reviewData`) VALUES
(8, 6, 3, 3, 3, 't', 't', 't', '2020-06-18 02:40:12'),
(10, 1, 5, 4, 5, '123', '123', '123', '2020-06-18 19:23:46'),
(11, 3, 3, 3, 3, 'teste', 'teste', 'teste', '2020-06-20 15:07:36'),

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `subcategory` int(11) DEFAULT NULL,
  `nomeprod` varchar(255) DEFAULT NULL,
  `marcaprod` varchar(255) DEFAULT NULL,
  `precoprod` int(11) DEFAULT NULL,
  `descprod` longtext DEFAULT NULL,
  `imagem1` varchar(255) DEFAULT NULL,
  `imagem2` varchar(255) DEFAULT NULL,
  `imagem3` varchar(255) DEFAULT NULL,
  `taxashipping` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `products`
--

INSERT INTO `products` (`id`, `category`, `subcategory`, `nomeprod`, `marcaprod`, `precoprod`, `descprod`, `imagem1`, `imagem2`, `imagem3`, `taxashipping`) VALUES
(1, 1, 2, 'Intel I7', 'INTEL', 250, '    <br><div><ol><li>teste<br></li>\r\n<li>proce<br></li>\r\n<li>intel<br></li>\r\n</ol></div>\r\n\r\n\r\n   ', 'product-p006080-26839_2.jpg', 'product-p006080-26839_2.jpg', '41SfDaZ3u2L._AC_.jpg', 150),
(2, 1, 1, 'Ryzen 5 3600X', 'AMD', 350, '<div><ul><li> CPU <br></li>\r\n<li>RYZEN<br></li>\r\n<li>AMD <br></li>\r\n<li>Barato<br></li></ul></div>\r\n\r\n\r\n', '1_p019290.jpg', '19-113-568-V03.jpg', '19-113-568-V11.jpg', 0),
(3, 4, 6, 'CLX Set Gaming Desktop AMD Ryzen 5', 'CLX/AMD', 1199, ' AMD Ryzen 5 3600X 3.8GHz 6-Core, B450 MATX, 16GB DDR4, GeForce GTX 1660 Ti 6GB, 960GB SSD, WiFi, Black Mini-Tower RGB Fans, Windows 10 Home', '71VS8qjR2aL._AC_SL1500_.jpg', '61rJo2+FbGL._AC_SL1500_.jpg', '61k2U3U6veL._AC_SL1500_.jpg', 50),
(4, 4, 6, 'TOSHIBA Tecra A50-E ', 'TOSHIBA', 739, '<ul><li>Toshiba Tecra A50-E 15.6\" Business Notebook Computer </li> <li>Intel Core i7-8550U 1.80GHz </li> <li> 8GB RAM - 256GB SSD </li>\r\n<li>Processor: Intel Core i7-8550U Quad-Core</li>\r\n<li>Clock Speed: 1.80GHz</li>\r\n<li>Maximum Turbo: 4GHz</li>\r\n<li>Operating System: Windows 10 Pro</li>\r\n</ul>', '51Z+P+KzFVL._AC_SL1264_.jpg', '61nP1cf+CuL._AC_SL1333_.jpg', '61FhwkTwk-L._AC_SL1177_.jpg', 220),
(6, 4, 6, 'ASUS Chromebook', 'ASUS', 277, ' <ul><li> T</li>\r\n<li>T2</li>\r\n<li>T3 </li>\r\n<li>T4</li></ul>\r\n', '71S3Rnugf7L._AC_SL1500_.jpg', '81QpyEAImcL._AC_SL1500_.jpg', '91D4UltELiL._AC_SL1500_.jpg', 100),
(7, 4, 6, 'HP ProDesk 600 G1 SFF Slim Business Desktop Computer', 'HP', 10, ' PC Barato que as escola preferem', '41wOehgwHOL._AC_.jpg', '51H5iBBsR4L._AC_.jpg', '51knCntLSfL._AC_.jpg', 25),
(8, 5, 9, 'Teste', 'Teste', 200, '    Teste Teste\r\n Teste\r\n Teste Teste Teste Teste   ', 'WKZN1gWP.jpg', '', '', 0),
(9, 5, 4, 'Google - Pixel 3 with 64GB Memory', 'Google', 700, ' <ul><li> Google </li>\r\n<li>Pixel</li>\r\n<li>3</li>\r\n<li>Caro</li></ul>\r\n', '71JvslYorPL._AC_SL1500_.jpg', '61txW56wUIL._AC_SL1500_.jpg', '71Wm1bu-2oL._AC_SL1500_.jpg', 193),
(10, 5, 4, 'Samsung Galaxy S20 5G Factory Unlocked', 'Samsung', 800, ' <ul><li> Agradecimentos a amazon </li>\r\n<li>Por me dar estas imagens todas</li>\r\n<li>e os detalhes  dos produtos</li></ul>\r\n', '71hM0EbYTtL._AC_SL1500_.jpg', '71h1NfW14xL._AC_SL1500_.jpg', '61MXdL2jpOL._AC_SL1500_.jpg', 200),
(11, 5, 4, 'Apple iPhone XR, 64GB, White - Fully Unlocked', 'Apple', 469, ' Fully unlocked and compatible with any carrier of choice (e.g. AT&T, T-Mobile, Sprint, Verizon, US-Cellular, Cricket, Metro, etc.).\r\nThe device does not come with headphones or a SIM card. It does include a charger and charging cable that may be generic, in which case it will be UL or Mfi (“Made for iPhone”) Certified.\r\nInspected and guaranteed to have minimal cosmetic damage, which is not noticeable when the device is held at arm’s length.\r\nSuccessfully passed a full diagnostic test which ensures like-new functionality and removal of any prior-user personal information.\r\nTested for battery health and guaranteed to have a minimum battery capacity of 80%.', '61wjAvw5B2L._AC_SL1500_.jpg', '51PuFBgBK4L._SL1024_.jpg', '41UGBBFxXtL._SL1024_.jpg', 130),
(12, 2, 8, 'Nvidia GEFORCE GTX 1070 Ti - FE Founder\'s Edition', 'Nvidia', 675, '<ul><li> \r\n THE WORLD\'S MOST ADVANCED GAMING GPU </li>\r\n<li>ARCHITECTURE Pascal</li>\r\n<li>NVIDIA CUDA Cores 2432</li>\r\n<li>8 GB GDDR5</li></ul>', '71QYxuv+ArL._AC_SL1500_.jpg', '71JvOfPD5cL._AC_SL1500_.jpg', '71xjmucx3KL._AC_SL1500_.jpg', 250),
(13, 2, 3, 'AMD XFX Radeon RX Vega 64', 'AMD', 650, ' <ul><li> Chipset - AMD rx Vega 64</li>\r\n<li>8GB HBM2 Memory</li>\r\n<li>\r\nGPU Core Clock - 1247Mhz boost mode - 1546Mhz</li>\r\n<li>\r\nVR premium ready</li></ul>\r\n\r\n\r\n', '51BoO8UUdiL._AC_SL1024_.jpg', '41Bh6Ryu+WL._AC_SL1024_.jpg', '51pE649JxtL._AC_SL1024_.jpg', 150),
(14, 3, 5, 'HyperX Alloy Core RGB', 'HyperX ', 50, 'Teste\r\nteste com enter como line break\r\n\r\n<ul>\r\n<li> teste formatado com lista </li>\r\n<li> teste formatado com lista </li> \r\n<ul>', '71HNsuO+fhL._AC_SL1428_.jpg', '61k4eGD7CZL._AC_SL1000_.jpg', '71VQxivDUFL._AC_SL1000_.jpg', 0),
(15, 5, 9, 'Teste insert depois edit', 'Kingston', 150, ' Filipina  ', '91RL+MhTWbL._AC_SL1500_.jpg', '81vCejH6FxL._AC_SL1500_.jpg', '715TdoIQyXL._AC_SL1500_.jpg', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `subcategory`
--

CREATE TABLE `subcategory` (
  `id` int(11) NOT NULL,
  `categoryid` int(11) DEFAULT NULL,
  `subcategory` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `subcategory`
--

INSERT INTO `subcategory` (`id`, `categoryid`, `subcategory`) VALUES
(1, 1, 'AMD'),
(2, 1, 'INTEL'),
(3, 2, 'GPU AMD'),
(4, 5, 'Telemoveis'),
(5, 3, 'Teclado'),
(6, 4, 'Pcs'),
(7, 3, 'Rato'),
(8, 2, 'GPU NVIDIA'),
(9, 5, 'Outros');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contactno` bigint(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `endShip` longtext DEFAULT NULL,
  `endPais` varchar(255) DEFAULT NULL,
  `endCid` varchar(255) DEFAULT NULL,
  `endPin` int(11) DEFAULT NULL,
  `fatEndereco` longtext DEFAULT NULL,
  `fatPais` varchar(255) DEFAULT NULL,
  `fatCid` varchar(255) DEFAULT NULL,
  `fatPin` int(11) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `contactno`, `password`, `endShip`, `endPais`, `endCid`, `endPin`, `fatEndereco`, `fatPais`, `fatCid`, `fatPin`, `admin`) VALUES
(22, '123', '123@gmail.com', 123, '202cb962ac59075b964b07152d234b70', '123', '123', '123', 123, '123', '123', '123', 123, 1),

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `productreviews`
--
ALTER TABLE `productreviews`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `productreviews`
--
ALTER TABLE `productreviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
