--
-- Table structure for table `pictures`
--

CREATE TABLE IF NOT EXISTS `pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `fileExtension` varchar(5) NOT NULL,
  `md5` varchar(32) NOT NULL,
  `insertDate` datetime NOT NULL,
  `source` text NOT NULL,
  `uploader` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=385 ;

