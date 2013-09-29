CREATE TABLE IF NOT EXISTS `bors_tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `worker_class_name` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `worker_id` int(10) unsigned DEFAULT NULL,
  `worker_method` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `target_class_name` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `target_id` varchar(255) DEFAULT NULL,
  `target_page` varchar(32) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `create_ts` timestamp NULL DEFAULT NULL,
  `exec_ts` timestamp NULL DEFAULT NULL,
  `priority` tinyint(4) NOT NULL,
  `process_ts` timestamp NULL DEFAULT NULL,
  `process_expire_ts` timestamp NULL DEFAULT NULL,
  `processor_id` varchar(32) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `runs_count` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `worker_class_name_2` (`worker_class_name`,`worker_id`,`worker_method`,`target_class_name`,`target_id`,`target_page`),
  KEY `create_time` (`create_ts`),
  KEY `execute_time` (`exec_ts`),
  KEY `priority` (`priority`),
  KEY `process_ts` (`process_ts`),
  KEY `process_timeout_ts` (`process_expire_ts`),
  KEY `processor_id` (`processor_id`),
  KEY `runs_count` (`runs_count`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
