CREATE DATABASE IF NOT EXISTS `yoobee_test`;

USE `yoobee_test`;

DROP TABLE IF EXISTS employer_info;

CREATE TABLE `employer_info` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `created_time` timestamp NOT NULL COMMENT 'created time',
  `updated_time` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated time',
  `company_name` varchar(255) NOT NULL COMMENT 'company_name',
  `official_web` varchar(255) NOT NULL DEFAULT '' COMMENT 'official website',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT 'email',
  `employee_num` int(10) unsigned zerofill NOT NULL COMMENT 'employee num',
  PRIMARY KEY (`id`),
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3; 

DROP TABLE IF EXISTS position_info;

CREATE TABLE `position_info` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `published_employer_id` int(10) unsigned zerofill NOT NULL COMMENT 'employer id',
  `planed_hired_num` int(10) unsigned zerofill NOT NULL COMMENT 'hired num',
  `applied_num` int(10) unsigned zerofill NOT NULL COMMENT 'applied num',
  `status` int(10) unsigned zerofill NOT NULL COMMENT 'position status, 1: open, 2: close',
  `position_name` varchar(255) NOT NULL,
  `postion_desc` text(2000),
  `start_time` timestamp NOT NULL COMMENT 'position start at',
  `end_time` timestamp NOT NULL COMMENT 'position end at',
  `created_time` timestamp NOT NULL,
  `updated_time` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS applied_info;

CREATE TABLE `applied_info` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `candidate_email` varchar(255) NOT NULL COMMENT 'candidate email',
  `position_id` int(10) unsigned zerofill NOT NULL COMMENT 'position id',
  `applied_times` int(10) unsigned zerofill NOT NULL COMMENT 'applied times for same candidate',
  `status` int(10) unsigned zerofill NOT NULL COMMENT 'applying status, 1: pass; 2: reject',
  `created_time` timestamp NOT NULL,
  `updated_time` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

-- just for test
insert into `employer_info`(`official_web`, `company_name`, `email`, `employee_num`, `created_time`, `updated_time`) values('www.lol.com', 'Dragon', 'email@gamil.com', 20, now(), now());