<?php

//$path = OW::getPluginManager()->getPlugin('ode')->getRootDir() . 'langs.zip';
//BOL_LanguageService::getInstance()->importPrefixFromZip($path, 'ode');

$sql = 'DROP TABLE IF EXISTS `' . OW_DB_PREFIX . 'spodpr_private_room`;
CREATE TABLE `' . OW_DB_PREFIX . 'spodpr_private_room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ownerId` int(11) NOT NULL,
  `cardType` text,
  `card` text,
  `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum("approval","approved","blocked") NOT NULL DEFAULT "approved",
  `privacy` varchar(50) NOT NULL DEFAULT "everybody",
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `privacy` (`privacy`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;';

OW::getDbo()->query($sql);
