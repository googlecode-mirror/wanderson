-- migration drop-people 1 line
DROP TABLE IF EXISTS "site".people;

-- migration drop-schema 1 line
DROP SCHEMA IF EXISTS site;

-- migration schema 1 line
CREATE SCHEMA site;

-- migration people 9 lines
CREATE TABLE "site".people
(
    id       SERIAL      NOT NULL,
    username VARCHAR(20) NOT NULL UNIQUE,
    password CHAR(32)    NOT NULL,
    deleted  BOOLEAN     DEFAULT FALSE,
    active   BOOLEAN     DEFAULT TRUE,
    PRIMARY KEY(id)
);