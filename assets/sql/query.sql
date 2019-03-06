
-- ============== create table awards ======================
CREATE TABLE `awards` (
	`id` INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`alias` varchar(50) NOT NULL,
	`name` varchar(100) NOT NULL,
	`amount` int(10) NOT NULL,
	`active` tinyint(4) NOT NULL DEFAULT '1',
	`special` decimal(4,4) NULL,
	`pos` int(4) NOT NULL,
	`email_award_id` int(11) NULL,
	`user_created_id` int(11) NOT NULL,
	`date_created` datetime NOT NULL,
	`user_modified_id` int(11) NOT NULL,
	`date_modified` datetime NOT NULL,
	`deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ============== create table awards ======================
CREATE TABLE `oauth_users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`oauth_provider` enum('','facebook','google','twitter') COLLATE utf8_unicode_ci NOT NULL,
	`oauth_uid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
	`first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
	`last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
	`email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
	`birthday` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
	`gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
	`picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`spin` int(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
	`share` int(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ============== create table oauth_awards ======================
CREATE TABLE `oauth_awards` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`oauth_uid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
	`awards_alias` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
	`code` varchar(20) COLLATE utf8_unicode_ci NULL,
	`amount` int(10) COLLATE utf8_unicode_ci NULL,
	`description` varchar(255) COLLATE utf8_unicode_ci NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ============== create table template_email_award ======================
CREATE TABLE `template_email_award` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
	`content` text COLLATE utf8_unicode_ci NULL,
	`deleted` tinyint(4) NOT NULL DEFAULT '0',
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;