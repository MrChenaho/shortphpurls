
CREATE TABLE IF NOT EXISTS `urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(164) DEFAULT NULL,
  `timestamp` varchar(64) DEFAULT NULL,
  `ip` varchar(64) DEFAULT NULL,
  `url_short` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;
