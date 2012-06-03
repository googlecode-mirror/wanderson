-- begin migration down
DROP TABLE IF EXISTS `wsl_sessions`;
-- end
-- begin migration up
CREATE TABLE IF NOT EXISTS `wsl_sessions`(
    -- Chave Primária
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    -- Informações
    `user_id` BIGINT UNSIGNED NOT NULL,
    `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `token` CHAR(40) NOT NULL,
    -- Chaves
    PRIMARY KEY(`id`),
    FOREIGN KEY(`user_id`) REFERENCES `wsl_users`(`id`)
        ON UPDATE CASCADE ON DELETE CASCADE,
    INDEX `token`(`token`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;
-- end

