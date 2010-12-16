CREATE TABLE blog.publisher_category
(
    idcategory TINYINT UNSIGNED AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY(idcategory)
);

CREATE TABLE blog.publisher_tag
(
    idtag SMALLINT UNSIGNED AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY(idtag)
);

CREATE TABLE blog.publisher_article
(
    idarticle INT UNSIGNED AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated TIMESTAMP NOT NULL,
    description TEXT,
    abstract TEXT NOT NULL,
    content MEDIUMTEXT NOT NULL,
    published BOOLEAN NOT NULL DEFAULT FALSE,
    idauthor TINYINT UNSIGNED NOT NULL,
    idcategory TINYINT UNSIGNED,
    PRIMARY KEY(idarticle),
    FOREIGN KEY(idauthor) REFERENCES blog.admin_user(iduser),
    FOREIGN KEY(idcategory) REFERENCES blog.publisher_category
);