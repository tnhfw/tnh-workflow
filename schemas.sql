-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           10.2.14-MariaDB - mariadb.org binary distribution
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour db_wf
DROP DATABASE IF EXISTS `db_wf`;
CREATE DATABASE IF NOT EXISTS `db_wf` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `db_wf`;

-- Listage de la structure de la table db_wf. leaves
DROP TABLE IF EXISTS `leaves`;
CREATE TABLE IF NOT EXISTS `leaves` (
  `leav_id` int(11) NOT NULL AUTO_INCREMENT,
  `leav_desc` varchar(255) NOT NULL,
  `leav_bdate` date NOT NULL,
  `leav_edate` date NOT NULL,
  `leav_state` tinyint(4) NOT NULL DEFAULT 0,
  `wf_id` int(11) NOT NULL,
  PRIMARY KEY (`leav_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Listage des données de la table db_wf.leaves : 9 rows
/*!40000 ALTER TABLE `leaves` DISABLE KEYS */;
INSERT INTO `leaves` (`leav_id`, `leav_desc`, `leav_bdate`, `leav_edate`, `leav_state`, `wf_id`) VALUES
    (1, 'Congé annuel de TNH', '2019-12-30', '2020-01-31', 0, 1),
    (4, 'Demo conge', '2020-01-02', '2020-01-29', 0, 1),
    (5, 'qwertyuk;l&#039;\\lkjhgfvcxz', '2020-01-02', '2020-01-15', 0, 1),
    (12, 'dddd', '2020-01-11', '2020-01-16', 0, 1),
    (13, 'r', '2020-02-08', '2020-02-15', 0, 1),
    (14, 'reee', '2020-02-09', '2020-02-15', 1, 1),
    (15, 'please help', '2020-03-02', '2020-03-19', 1, 1),
    (16, 'jsgfgsjsfjsgsgfss', '2020-03-01', '2020-03-15', 1, 1),
    (17, 'Test exemple', '2020-10-07', '2020-10-08', 0, 4);
/*!40000 ALTER TABLE `leaves` ENABLE KEYS */;

-- Listage de la structure de la table db_wf. users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table db_wf.users : ~5 rows (environ)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `user_name`) VALUES
    (1, 'Tony'),
    (2, 'TNH'),
    (3, 'Ulrich'),
    (4, 'NGUEREZA'),
    (5, 'DANGANA');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Listage de la structure de la table db_wf. wf_instance
DROP TABLE IF EXISTS `wf_instance`;
CREATE TABLE IF NOT EXISTS `wf_instance` (
  `wf_inst_id` int(11) NOT NULL AUTO_INCREMENT,
  `wf_inst_state` enum('I','T','C') DEFAULT 'I' COMMENT 'I = Processing, T = Completed, C = cancel',
  `wf_inst_desc` varchar(255) DEFAULT NULL,
  `wf_inst_start_date` datetime NOT NULL DEFAULT current_timestamp(),
  `wf_inst_end_date` datetime DEFAULT NULL,
  `wf_inst_entity_id` varchar(255) DEFAULT NULL,
  `wf_inst_entity_name` varchar(255) DEFAULT NULL COMMENT 'the name of entity under workflow',
  `wf_inst_entity_detail` varchar(255) DEFAULT NULL COMMENT 'Displayed to help validator',
  `wf_inst_start_comment` varchar(255) DEFAULT NULL COMMENT 'comment for start',
  `start_by_id` int(11) NOT NULL COMMENT 'user start the workflow',
  `wf_id` int(11) NOT NULL,
  PRIMARY KEY (`wf_inst_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table db_wf.wf_instance : ~7 rows (environ)
/*!40000 ALTER TABLE `wf_instance` DISABLE KEYS */;
INSERT INTO `wf_instance` (`wf_inst_id`, `wf_inst_state`, `wf_inst_desc`, `wf_inst_start_date`, `wf_inst_end_date`, `wf_inst_entity_id`, `wf_inst_entity_name`, `wf_inst_entity_detail`, `wf_inst_start_comment`, `start_by_id`, `wf_id`) VALUES
    (1, 'T', 'Congé annuel de TNH validation', '2020-01-30 19:05:59', '2020-01-30 19:14:01', '1', 'leave', '', '', 4, 1),
    (2, 'T', '', '2020-01-30 19:21:51', '2020-01-30 19:22:15', '4', 'leave', '', '', 5, 1),
    (3, 'T', '', '2020-02-01 07:32:24', '2020-02-01 07:34:45', '14', 'leave', '', '', 5, 1),
    (4, 'T', '', '2020-02-01 07:47:28', '2020-02-01 07:47:38', '5', 'leave', '', '', 1, 1),
    (5, 'T', '', '2020-03-10 12:36:59', '2020-03-10 12:38:12', '15', 'leave', '', '', 1, 1),
    (6, 'T', '', '2020-03-10 12:39:52', '2020-03-10 12:41:40', '16', 'leave', '', '', 1, 1),
    (7, 'T', 'Aider a valider rapidement', '2020-10-27 06:13:27', '2020-10-27 06:21:18', '17', 'leave', 'Conge code 3473435454', 'Please do quicly', 2, 4);
/*!40000 ALTER TABLE `wf_instance` ENABLE KEYS */;

-- Listage de la structure de la table db_wf. wf_node
DROP TABLE IF EXISTS `wf_node`;
CREATE TABLE IF NOT EXISTS `wf_node` (
  `wf_node_id` int(11) NOT NULL AUTO_INCREMENT,
  `wf_node_name` varchar(100) NOT NULL,
  `wf_node_task_type` enum('1','2','3','4') NOT NULL DEFAULT '1' COMMENT '1 => User Node, 2 => Decision node, 3 => Script Node, 4 => Service Node',
  `wf_node_type` enum('1','2','3') NOT NULL COMMENT '1 => Start node, 2 => Intermediate node, 3 => End node',
  `wf_node_script` varchar(1000) DEFAULT NULL COMMENT 'script task (use eval())',
  `wf_node_service` text DEFAULT NULL COMMENT 'service task (use library: function:arg1,arg2)',
  `wf_node_status` int(11) NOT NULL,
  `wf_role_id` int(11) DEFAULT NULL,
  `wf_id` int(11) NOT NULL,
  PRIMARY KEY (`wf_node_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table db_wf.wf_node : ~15 rows (environ)
/*!40000 ALTER TABLE `wf_node` DISABLE KEYS */;
INSERT INTO `wf_node` (`wf_node_id`, `wf_node_name`, `wf_node_task_type`, `wf_node_type`, `wf_node_script`, `wf_node_service`, `wf_node_status`, `wf_role_id`, `wf_id`) VALUES
    (1, 'Start', '1', '1', NULL, NULL, 1, NULL, 1),
    (2, 'Approving', '1', '2', '', '', 1, 3, 1),
    (3, 'End', '1', '3', NULL, NULL, 1, NULL, 1),
    (4, 'Is Approve ?', '2', '2', '', '', 1, NULL, 1),
    (5, 'Set state = 0', '4', '2', '', 'setLeaveState: entity_id, 0', 1, 0, 1),
    (6, 'Signature', '1', '2', NULL, NULL, 1, 2, 1),
    (7, 'Is Sign ?', '2', '2', '', '', 1, NULL, 1),
    (8, 'Post processing (Set state = 1)', '4', '2', '', 'setLeaveState: entity_id, 1', 1, 0, 1),
    (47, 'Send E-mail', '3', '2', 'mail(\'app@example.com\', \'Leave request not approved\', \'Hello user, your leave request is not approved\');', '', 1, 0, 1),
    (52, 'Start', '1', '1', '', '', 1, 0, 4),
    (53, 'End', '1', '3', NULL, NULL, 1, NULL, 4),
    (54, 'Check document', '1', '2', '', '', 1, 15, 4),
    (55, 'Validation finale', '1', '2', '', '', 1, 14, 4),
    (56, 'Document Is Valid', '2', '2', '', '', 1, 0, 4),
    (57, 'Document Sign?', '2', '2', '', '', 1, 0, 4);
/*!40000 ALTER TABLE `wf_node` ENABLE KEYS */;

-- Listage de la structure de la table db_wf. wf_node_outcome
DROP TABLE IF EXISTS `wf_node_outcome`;
CREATE TABLE IF NOT EXISTS `wf_node_outcome` (
  `wf_oc_id` int(11) NOT NULL AUTO_INCREMENT,
  `wf_oc_code` varchar(255) NOT NULL,
  `wf_oc_name` varchar(255) NOT NULL,
  `wf_node_id` int(11) NOT NULL,
  PRIMARY KEY (`wf_oc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table db_wf.wf_node_outcome : ~15 rows (environ)
/*!40000 ALTER TABLE `wf_node_outcome` DISABLE KEYS */;
INSERT INTO `wf_node_outcome` (`wf_oc_id`, `wf_oc_code`, `wf_oc_name`, `wf_node_id`) VALUES
    (1, 'Y', 'Validated (Y)', 2),
    (2, 'N', 'Rejected (N)', 2),
    (3, 'N', 'Not sign (N)', 6),
    (4, 'Y', 'Sign (Y)', 6),
    (5, 'C', 'Need check (C)', 6),
    (8, 'code_accept', 'Accept', 9),
    (9, 'code_reject', 'Reject', 9),
    (13, 'Y', 'I&#039;m OK', 21),
    (14, 'N', 'No', 21),
    (15, 'C', 'Please check', 21),
    (16, 'Y', 'Ok for me', 40),
    (17, 'val_ok', 'Document is valid', 54),
    (18, 'val_fail', 'Document is not valid', 54),
    (19, 'doc_sign_ok', 'Signature success', 55),
    (20, 'doc_sign_nok', 'Signature refused', 55);
/*!40000 ALTER TABLE `wf_node_outcome` ENABLE KEYS */;

-- Listage de la structure de la table db_wf. wf_node_path
DROP TABLE IF EXISTS `wf_node_path`;
CREATE TABLE IF NOT EXISTS `wf_node_path` (
  `wf_np_id` int(11) NOT NULL AUTO_INCREMENT,
  `wf_np_name` varchar(255) DEFAULT NULL,
  `wf_np_cond_type` varchar(50) DEFAULT NULL COMMENT 'outcome, script, service, entity',
  `wf_np_cond_name` varchar(255) DEFAULT NULL COMMENT 'only if cond type is entity',
  `wf_np_cond_operator` varchar(10) DEFAULT NULL COMMENT '==, <, >=, etc.',
  `wf_np_cond_value` varchar(255) DEFAULT NULL COMMENT 'Y',
  `wf_np_is_default` tinyint(4) DEFAULT 0 COMMENT 'will use if condition not match',
  `wf_np_order` tinyint(4) DEFAULT NULL COMMENT 'used for decision node',
  `wf_id` int(11) NOT NULL,
  `wf_node_from_id` int(11) NOT NULL,
  `wf_node_to_id` int(11) NOT NULL,
  PRIMARY KEY (`wf_np_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table db_wf.wf_node_path : ~18 rows (environ)
/*!40000 ALTER TABLE `wf_node_path` DISABLE KEYS */;
INSERT INTO `wf_node_path` (`wf_np_id`, `wf_np_name`, `wf_np_cond_type`, `wf_np_cond_name`, `wf_np_cond_operator`, `wf_np_cond_value`, `wf_np_is_default`, `wf_np_order`, `wf_id`, `wf_node_from_id`, `wf_node_to_id`) VALUES
    (1, '', '', '', '', '', 0, 0, 1, 1, 2),
    (2, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 2, 4),
    (3, '', 'outcome', '', '==', 'N', 0, 0, 1, 4, 5),
    (4, '', 'outcome', '', '==', 'Y', 0, 0, 1, 4, 6),
    (5, '', '', '', '', '', 0, 0, 1, 5, 47),
    (6, NULL, NULL, '', NULL, '', 0, 0, 1, 6, 7),
    (7, '', 'outcome', '', '==', 'C', 1, 0, 1, 7, 2),
    (8, '', 'outcome', '', '==', 'N', 0, 0, 1, 7, 5),
    (9, '', 'outcome', '', '==', 'Y', 0, 0, 1, 7, 8),
    (10, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 8, 3),
    (44, '', '', '', '', '', 0, NULL, 1, 47, 3),
    (46, '', '', '', '', '', 0, NULL, 4, 52, 54),
    (47, '', '', '', '', '', 0, NULL, 4, 54, 56),
    (48, '', 'outcome', '', '==', 'val_ok', 0, NULL, 4, 56, 55),
    (49, '', 'outcome', '', '==', 'val_fail', 1, NULL, 4, 56, 53),
    (50, '', '', '', '', '', 0, NULL, 4, 55, 57),
    (51, '', 'outcome', '', '==', 'doc_sign_ok', 0, NULL, 4, 57, 53),
    (52, '', 'outcome', '', '==', 'doc_sign_nok', 1, NULL, 4, 57, 54);
/*!40000 ALTER TABLE `wf_node_path` ENABLE KEYS */;

-- Listage de la structure de la table db_wf. wf_role
DROP TABLE IF EXISTS `wf_role`;
CREATE TABLE IF NOT EXISTS `wf_role` (
  `wf_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `wf_role_name` varchar(255) DEFAULT NULL,
  `wf_id` int(11) NOT NULL,
  PRIMARY KEY (`wf_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table db_wf.wf_role : ~5 rows (environ)
/*!40000 ALTER TABLE `wf_role` DISABLE KEYS */;
INSERT INTO `wf_role` (`wf_role_id`, `wf_role_name`, `wf_id`) VALUES
    (2, 'DG', 1),
    (3, 'Chef de service', 1),
    (5, 'Responsable HR', 1),
    (14, 'DG', 4),
    (15, 'CS', 4);
/*!40000 ALTER TABLE `wf_role` ENABLE KEYS */;

-- Listage de la structure de la table db_wf. wf_task
DROP TABLE IF EXISTS `wf_task`;
CREATE TABLE IF NOT EXISTS `wf_task` (
  `wf_task_id` int(11) NOT NULL AUTO_INCREMENT,
  `wf_task_status` enum('I','T','C') NOT NULL DEFAULT 'I' COMMENT 'I = Processing, T = Completed, C = cancel',
  `wf_task_cancel_trigger` enum('U','S') DEFAULT NULL COMMENT '''U'' = By user, ''S'' = by system',
  `wf_task_comment` text DEFAULT NULL,
  `wf_task_start_time` datetime NOT NULL DEFAULT current_timestamp(),
  `wf_task_end_time` datetime DEFAULT NULL,
  `wf_inst_id` int(11) NOT NULL,
  `wf_oc_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `wf_node_id` int(11) NOT NULL,
  PRIMARY KEY (`wf_task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table db_wf.wf_task : ~30 rows (environ)
/*!40000 ALTER TABLE `wf_task` DISABLE KEYS */;
INSERT INTO `wf_task` (`wf_task_id`, `wf_task_status`, `wf_task_cancel_trigger`, `wf_task_comment`, `wf_task_start_time`, `wf_task_end_time`, `wf_inst_id`, `wf_oc_id`, `user_id`, `wf_node_id`) VALUES
    (1, 'C', 'S', 'Already validate by Ulrich', '2020-01-30 19:05:59', '2020-01-30 19:06:53', 1, NULL, 1, 2),
    (2, 'T', NULL, 'OK for me', '2020-01-30 19:05:59', '2020-01-30 19:06:53', 1, 1, 3, 2),
    (3, 'C', 'S', 'Already validate by Ulrich', '2020-01-30 19:05:59', '2020-01-30 19:06:53', 1, NULL, 5, 2),
    (4, 'C', 'S', 'Already validate by NGUEREZA', '2020-01-30 19:06:53', '2020-01-30 19:08:49', 1, NULL, 1, 6),
    (5, 'T', NULL, 'please I need money before sign it', '2020-01-30 19:06:53', '2020-01-30 19:08:49', 1, 5, 4, 6),
    (6, 'C', 'S', 'Already validate by NGUEREZA', '2020-01-30 19:06:53', '2020-01-30 19:08:49', 1, NULL, 5, 6),
    (7, 'T', NULL, 'Is OK now (35.000 FCFA)', '2020-01-30 19:08:49', '2020-01-30 19:10:52', 1, 1, 1, 2),
    (8, 'C', 'S', 'Already validate by Tony', '2020-01-30 19:08:49', '2020-01-30 19:10:52', 1, NULL, 3, 2),
    (9, 'C', 'S', 'Already validate by Tony', '2020-01-30 19:08:49', '2020-01-30 19:10:52', 1, NULL, 5, 2),
    (10, 'C', 'S', 'Already validate by DANGANA', '2020-01-30 19:10:52', '2020-01-30 19:14:00', 1, NULL, 1, 6),
    (11, 'C', 'S', 'Already validate by DANGANA', '2020-01-30 19:10:52', '2020-01-30 19:14:00', 1, NULL, 4, 6),
    (12, 'T', NULL, 'Can&#039;t sign, the money is not enough', '2020-01-30 19:10:52', '2020-01-30 19:14:00', 1, 3, 5, 6),
    (13, 'T', NULL, '', '2020-01-30 19:21:51', '2020-01-30 19:22:07', 2, 1, 5, 2),
    (14, 'T', NULL, '', '2020-01-30 19:22:07', '2020-01-30 19:22:15', 2, 3, 5, 6),
    (15, 'C', 'S', 'Already validate by DANGANA', '2020-02-01 07:32:24', '2020-02-01 07:32:59', 3, NULL, 3, 2),
    (16, 'T', NULL, '', '2020-02-01 07:32:24', '2020-02-01 07:32:59', 3, 1, 5, 2),
    (17, 'T', NULL, '', '2020-02-01 07:32:59', '2020-02-01 07:34:45', 3, 4, 1, 6),
    (18, 'C', 'S', 'Already validate by Tony', '2020-02-01 07:32:59', '2020-02-01 07:34:45', 3, NULL, 2, 6),
    (19, 'T', NULL, '', '2020-02-01 07:47:28', '2020-02-01 07:47:37', 4, 2, 1, 2),
    (20, 'T', NULL, '', '2020-03-10 12:36:59', '2020-03-10 12:37:31', 5, 1, 4, 2),
    (21, 'T', NULL, '', '2020-03-10 12:37:31', '2020-03-10 12:38:12', 5, 4, 1, 6),
    (22, 'T', NULL, 'ok', '2020-03-10 12:39:52', '2020-03-10 12:41:17', 6, 1, 2, 2),
    (23, 'C', 'S', 'Already validate by TNH', '2020-03-10 12:39:52', '2020-03-10 12:41:17', 6, NULL, 5, 2),
    (24, 'C', 'S', 'Already validate by TNH', '2020-03-10 12:39:52', '2020-03-10 12:41:17', 6, NULL, 3, 2),
    (25, 'T', NULL, 'ok cool', '2020-03-10 12:41:17', '2020-03-10 12:41:40', 6, 4, 1, 6),
    (26, 'T', NULL, 'OK le document est bien rempli', '2020-10-27 06:13:27', '2020-10-27 06:18:10', 7, 17, 3, 54),
    (27, 'T', NULL, 'La duree du conge est trop longue demande a l&#039;employer que 1 mois maximum', '2020-10-27 06:18:10', '2020-10-27 06:20:08', 7, 20, 1, 55),
    (28, 'C', 'S', 'Already validate by TNH', '2020-10-27 06:20:08', '2020-10-27 06:20:55', 7, NULL, 3, 54),
    (29, 'T', NULL, 'OK le document est modifie l&#039;employe a pris 1 mois', '2020-10-27 06:20:08', '2020-10-27 06:20:55', 7, 17, 2, 54),
    (30, 'T', NULL, 'OK', '2020-10-27 06:20:55', '2020-10-27 06:21:18', 7, 19, 1, 55);
/*!40000 ALTER TABLE `wf_task` ENABLE KEYS */;

-- Listage de la structure de la table db_wf. wf_user_role
DROP TABLE IF EXISTS `wf_user_role`;
CREATE TABLE IF NOT EXISTS `wf_user_role` (
  `wf_ur_id` int(11) NOT NULL AUTO_INCREMENT,
  `wf_role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `wf_inst_id` int(11) NOT NULL,
  PRIMARY KEY (`wf_ur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table db_wf.wf_user_role : ~23 rows (environ)
/*!40000 ALTER TABLE `wf_user_role` DISABLE KEYS */;
INSERT INTO `wf_user_role` (`wf_ur_id`, `wf_role_id`, `user_id`, `wf_inst_id`) VALUES
    (1, 2, 1, 1),
    (2, 3, 1, 1),
    (3, 2, 4, 1),
    (4, 2, 5, 1),
    (5, 3, 3, 1),
    (6, 3, 5, 1),
    (7, 2, 5, 2),
    (8, 3, 5, 2),
    (9, 2, 1, 3),
    (10, 3, 3, 3),
    (11, 3, 5, 3),
    (12, 2, 2, 3),
    (13, 2, 2, 4),
    (14, 3, 1, 4),
    (15, 2, 1, 5),
    (16, 3, 4, 5),
    (17, 3, 2, 6),
    (18, 3, 5, 6),
    (19, 2, 1, 6),
    (20, 3, 3, 6),
    (21, 14, 1, 7),
    (22, 15, 3, 7),
    (24, 15, 2, 7);
/*!40000 ALTER TABLE `wf_user_role` ENABLE KEYS */;

-- Listage de la structure de la table db_wf. workflow
DROP TABLE IF EXISTS `workflow`;
CREATE TABLE IF NOT EXISTS `workflow` (
  `wf_id` int(11) NOT NULL AUTO_INCREMENT,
  `wf_name` varchar(100) NOT NULL,
  `wf_desc` text DEFAULT NULL,
  `wf_status` int(11) NOT NULL,
  PRIMARY KEY (`wf_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table db_wf.workflow : ~2 rows (environ)
/*!40000 ALTER TABLE `workflow` DISABLE KEYS */;
INSERT INTO `workflow` (`wf_id`, `wf_name`, `wf_desc`, `wf_status`) VALUES
    (1, 'Validation leave request', 'employee leave request workflow', 1),
    (4, 'Exemple workflow', '', 1);
/*!40000 ALTER TABLE `workflow` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
