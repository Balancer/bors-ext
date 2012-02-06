CREATE TABLE IF NOT EXISTS `user_hactions` (
  `id` varchar(255) NOT NULL,
  `actor_class_name` varchar(255) NOT NULL,
  `actor_target_id` int(10) unsigned DEFAULT NULL,
  `actor_method` varchar(255) DEFAULT NULL,
  `actor_attributes` longtext,
  `create_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `expire_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `create_timestamp` (`create_timestamp`),
  KEY `expire_timestamp` (`expire_timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
