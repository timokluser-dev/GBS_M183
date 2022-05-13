CREATE DATABASE IF NOT EXISTS modul183ag;

USE modul183ag;

CREATE TABLE IF NOT EXISTS `kunde`
(
    `id`                int(10) unsigned                     NOT NULL AUTO_INCREMENT,
    `email`             varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `passw`             varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `vorname`           varchar(255) COLLATE utf8_unicode_ci NULL,
    `nachname`          varchar(255) COLLATE utf8_unicode_ci NULL,
    `created_at`        timestamp                            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`        timestamp                            NULL     DEFAULT NULL,
    `aclallaccounts`    varchar(255) COLLATE utf8_unicode_ci          DEFAULT NULL,
    `passwortcode`      varchar(255) COLLATE utf8_unicode_ci          DEFAULT NULL,
    `passwortcode_time` timestamp                            NULL     DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE (`email`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE USER 'vmadmin'@'%';
SET PASSWORD FOR 'vmadmin@%' = PASSWORD ('Riethuesli>12345');

GRANT ALL ON modul183ag.kunde TO 'vmadmin@%';
SHOW GRANTS FOR 'vmadmin@%';
