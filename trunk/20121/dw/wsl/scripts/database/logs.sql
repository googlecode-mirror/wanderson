-- begin migration down
DROP TABLE IF EXISTS `wsl_logs_tables`;
-- end
-- begin migration up
CREATE TABLE IF NOT EXISTS `wsl_logs_tables`(
    `id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
    `user` BIGINT UNSIGNED NULL,
    `table` VARCHAR(100) NOT NULL,
    `reference` BIGINT UNSIGNED NOT NULL,
    `action` ENUM('CREATE', 'UPDATE', 'DELETE') NOT NULL,
    `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(`id`),
    INDEX `search`(`table`, `reference`),
    INDEX `interval`(`timestamp`)
)
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;
-- end

