-- migration begin
DROP TABLE IF EXISTS `acl_permissions`;
DROP TABLE IF EXISTS `acl_privileges`;
DROP TABLE IF EXISTS `acl_resources`;
DROP TABLE IF EXISTS `acl_roles`;
-- end

-- migration begin
CREATE TABLE IF NOT EXISTS `acl_roles` (
    `name` VARCHAR(20) NOT NULL,
    `alias` VARCHAR(255),
    `enabled` TINYINT NOT NULL DEFAULT 1,
    `parent` VARCHAR(20) NULL COMMENT 'Parent Role',
    PRIMARY KEY(`name`),
    FOREIGN KEY(`parent`) REFERENCES `acl_roles`(`name`)
        ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `acl_resources` (
    `name` VARCHAR(20) NOT NULL,
    `alias` VARCHAR(255),
    `enabled` TINYINT NOT NULL DEFAULT 1,
    `parent` VARCHAR(20) NULL COMMENT 'Parent Resource',
    PRIMARY KEY(`name`),
    FOREIGN KEY(`parent`) REFERENCES `acl_resources`(`name`)
        ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `acl_privileges` (
    `resource` VARCHAR(20) NOT NULL,
    `name` VARCHAR(20) NOT NULL,
    `alias` VARCHAR(255),
    `enabled` TINYINT NOT NULL DEFAULT 1,
    PRIMARY KEY(`resource`,`name`),
    FOREIGN KEY(`resource`) REFERENCES `acl_resources`(`name`)
        ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `acl_permissions` (
    `role` VARCHAR(20) NOT NULL,
    `resource` VARCHAR(20) NOT NULL,
    `privilege` VARCHAR(20) NOT NULL,
    `description` TEXT,
    `allowed` TINYINT NOT NULL DEFAULT 1,
    PRIMARY KEY(`role`,`resource`,`privilege`),
    FOREIGN KEY(`role`) REFERENCES `acl_roles`(`name`)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY(`resource`,`privilege`) REFERENCES `acl_privileges`(`resource`,`name`)
        ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;
-- end

