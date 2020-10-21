--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `sid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`sid`, `name`, `price`) VALUES
(1, '口罩', 22),
(2, '衛生紙', 20),
(3, '帽子', 300),
(4, '雨傘', 200),
(5, '鉛筆', 10),
(6, '雨衣', 350),
(7, '鞋子', 1000),
(8, '手帕', 120);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
