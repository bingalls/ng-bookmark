/**
 * Copyright 2014 Bruce Ingalls
 * Saves URIs
 * Note that table prefix matches cfg.php
 *
 * @author bruce.ingall at gmail
 * @copyright (c) 2014, Bruce Ingalls
 */

CREATE TABLE `b_bookmarks` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user` VARCHAR(64) NOT NULL,
  `title` VARCHAR(128) NOT NULL,
  `uri` VARCHAR(512) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
