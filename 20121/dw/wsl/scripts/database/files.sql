-- begin migration down
DROP TABLE IF EXISTS `wsl_files`;
-- end
-- begin migration up
CREATE TABLE IF NOT EXISTS `wsl_files`(
	-- Chave Primária
	`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	-- Informações de Arquivo
	`hash` CHAR(40) NOT NULL,
	`filename` VARCHAR(255) NOT NULL DEFAULT '',
	-- MetaInformações
	`container` VARCHAR(20) NOT NULL,
	`category` VARCHAR(20) NOT NULL,
	`reference` BIGINT UNSIGNED NOT NULL,
	`order` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
	PRIMARY KEY(`id`),
	INDEX `hash`(`hash`),
	INDEX `search`(`container`, `category`, `reference`)
)
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;
-- end

