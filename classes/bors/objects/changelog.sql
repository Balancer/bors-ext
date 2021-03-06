CREATE TABLE IF NOT EXISTS `bors_changes_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `property_name` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `create_ts` timestamp NULL DEFAULT NULL,
  `old_value` longtext,
  `target_class_name` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `target_id` int(10) unsigned NOT NULL,
  `comment` text,
  `last_editor_id` int(10) unsigned DEFAULT NULL,
  `last_editor_ip` varchar(16) DEFAULT NULL,
  `last_editor_ua` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `property_name` (`property_name`,`create_ts`,`old_value`(255),`target_class_name`,`target_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
