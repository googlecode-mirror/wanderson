-- begin migration down
DROP TABLE IF EXISTS `wsl_documents`;
-- end
-- begin migration up
CREATE TABLE IF NOT EXISTS `wsl_documents`(
    -- Chave Primária
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    -- Usuário
    `user_id` BIGINT UNSIGNED NOT NULL,
    -- Chaves
    PRIMARY KEY(`id`),
    FOREIGN KEY(`user_id`) REFERENCES `wsl_users`(`id`)
        ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;
-- end

