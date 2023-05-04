
--
-- Database: `demo` and php web application user
CREATE DATABASE cars;
GRANT USAGE ON *.* TO 'appuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON demo.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;

USE cars;
--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(100) NOT NULL,
  `model` varchar(255) NOT NULL,
  `year` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `employees`
--

INSERT INTO `cars` (`id`, `brand`, `model`, `year`) VALUES
(1, 'Mercedes', 'GLC', 2022),
(2, 'Audi', 'Q5', 2018),
(3, 'Porsche', 'panamera', 2019);

