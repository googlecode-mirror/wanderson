CREATE TABLE people
(
    idpeople SERIAL,
    name VARCHAR(100),
    username VARCHAR(20) NOT NULL UNIQUE,
    password CHAR(32) NOT NULL,
    role SMALLINT NOT NULL,
    email VARCHAR(100),
    active BOOLEAN NOT NULL DEFAULT TRUE,
    removed BOOLEAN NOT NULL DEFAULT FALSE,
    PRIMARY KEY(idpeople),
    CHECK(role >= 0)
);

CREATE TABLE message
(
    idmessage SERIAL,
    created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    priority SMALLINT NOT NULL DEFAULT 6,
    priorityName VARCHAR(20),
    content TEXT NOT NULL,
    info TEXT,
    ip VARCHAR(17),
    idpeople INTEGER,
    PRIMARY KEY(idmessage),
    FOREIGN KEY(idpeople) REFERENCES people(idpeople),
    CHECK (priority >= 0)
);