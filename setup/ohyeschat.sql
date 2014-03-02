CREATE TABLE IF NOT EXISTS `prefix_ohyes_chat` (
  `mid` bigint(20) NOT NULL AUTO_INCREMENT,
  `reciever` bigint(20) NOT NULL,
  `sender` bigint(20) NOT NULL,
  `message` longtext NOT NULL,
  `view` int(11) NOT NULL,
  `time` text NOT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;