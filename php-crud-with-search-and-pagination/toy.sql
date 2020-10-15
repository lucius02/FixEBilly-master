CREATE TABLE IF NOT EXISTS `toy` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(20) NOT NULL,
  `category` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `stock_count` bigint(16) NOT NULL,
  PRIMARY KEY (`id`)
) 

INSERT INTO `toy` (`id`, `name`, `code`, `category`, `price`, `stock_count`) VALUES
(9, 'Music Aeroplane', 'TOY#MA01', 'Music Toys', 250, 500),
(10, 'Power Ranger', 'TOY#BT01', 'Battery Toys', 1000, 100),
(11, 'Remote Car', 'TOY#RMT01', 'Remote Control Toys', 280, 800),
(12, 'Bubbles', 'TOY#WT01', 'Water Games', 100, 1000),
(13, 'Cricket Cards', 'TOY#CD01', 'Card Games', 200, 80),
(14, 'Basket Ball', 'TOY#BB01', 'Outdoor Toys', 2000, 500),
(15, 'Word Puzzles', 'TOY#PZ01', 'Puzzles', 200, 200),
(16, 'Water Gun', 'TOY#WG01', 'Water Games', 100, 1000);