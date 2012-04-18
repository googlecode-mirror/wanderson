-- begin migration down
DROP TABLE IF EXISTS `wsl_users`;
-- end

-- begin migration up
CREATE TABLE IF NOT EXISTS `wsl_users`(
    `id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
    `hash` CHAR(40) NOT NULL UNIQUE,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `active` TINYINT UNSIGNED NOT NULL DEFAULT 1,
    `admin` TINYINT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY(`id`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

INSERT INTO `users`(`hash`,`email`,`admin`) VALUES
    ('7c4a8d09ca3762af61e59520943dc26494f8941b', 'root@localhost', 1);
-- end

