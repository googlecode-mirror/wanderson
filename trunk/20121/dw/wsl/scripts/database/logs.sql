-- begin migration down
DROP TABLE IF EXISTS `wsl_logs`;
-- end

-- begin migration up
CREATE TABLE IF NOT EXISTS `wsl_logs`(
    `id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `content` TEXT NOT NULL,
    PRIMARY KEY(`id`),
    FOREIGN KEY(`user_id`) REFERENCES `wsl_users`(`id`)
        ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;
-- end

