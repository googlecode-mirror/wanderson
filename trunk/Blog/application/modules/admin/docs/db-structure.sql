CREATE TABLE blog.admin_user
(
    iduser TINYINT UNSIGNED AUTO_INCREMENT,
    username VARCHAR(20) UNIQUE NOT NULL,
    password CHAR(32) NOT NULL,
    displayname VARCHAR(100),
    active BOOLEAN NOT NULL DEFAULT TRUE,
    deleted BOOLEAN NOT NULL DEFAULT FALSE,
    PRIMARY KEY(iduser)
);