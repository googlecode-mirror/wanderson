CREATE TABLE people
(
    idpeople SERIAL,
    name VARCHAR(100),
    username VARCHAR(20) NOT NULL UNIQUE,
    password CHAR(32) NOT NULL DEFAULT MD5(''),
    role SMALLINT NOT NULL,
    email VARCHAR(100),
    active BOOLEAN NOT NULL DEFAULT TRUE,
    removed BOOLEAN NOT NULL DEFAULT FALSE,
    PRIMARY KEY(idpeople),
    CHECK (role >= 0)
);