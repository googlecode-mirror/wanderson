-- begin migration down
DROP TABLE IF EXISTS `wsl_users`;
-- end
-- begin migration up
CREATE TABLE IF NOT EXISTS `wsl_users`(
    -- Chave Primária
    `id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
    -- Informações
    `hash` CHAR(40) NOT NULL UNIQUE,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `active` TINYINT UNSIGNED NOT NULL DEFAULT 1,
    `admin` TINYINT UNSIGNED NOT NULL DEFAULT 0,
    -- Chaves
    PRIMARY KEY(`id`),
    INDEX `credentials`(`hash`,`email`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

INSERT INTO `wsl_users`(`hash`,`email`,`admin`) VALUES
    ('7c4a8d09ca3762af61e59520943dc26494f8941b', 'root@localhost', 1);
-- end

