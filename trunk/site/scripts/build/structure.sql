-- migration people 8 lines
CREATE TABLE people
(
    id       BIGINT      PRIMARY KEY AUTO_INCREMENT NOT NULL,
    username VARCHAR(20) NOT NULL UNIQUE,
    password CHAR(32)    NOT NULL,
    deleted  BOOLEAN     DEFAULT FALSE,
    active   BOOLEAN     DEFAULT TRUE
);