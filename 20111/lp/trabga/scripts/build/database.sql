-- Esquema de Dados
CREATE SCHEMA sistema;
-- Elementos para Tipos de Referências
CREATE TYPE "sistema".TIPO_REFERENCIA AS ENUM('artigo');

-- Instituição Origem
CREATE TABLE "sistema".instituicao (
    idinstituicao SERIAL,
    endereco TEXT NOT NULL,
    PRIMARY KEY(idinstituicao)
);

-- Autoria de Documentos
CREATE TABLE "sistema".autor (
    idautor SERIAL,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    idinstituicao INT NOT NULL,
    PRIMARY KEY(idautor),
    FOREIGN KEY(idinstituicao) REFERENCES "sistema".instituicao
        ON UPDATE CASCADE ON DELETE RESTRICT
);

-- Autor Usuário do Sistema
CREATE TABLE "sistema".usuario (
    idusuario INT NOT NULL,
    identidade VARCHAR(20) NOT NULL UNIQUE,
    credencial CHAR(32),
    ativado BOOLEAN DEFAULT TRUE NOT NULL,
    PRIMARY KEY(idusuario),
    FOREIGN KEY(idusuario) REFERENCES "sistema".autor(idautor)
        ON UPDATE CASCADE ON DELETE CASCADE
);

-- Artigos
CREATE TABLE "sistema".artigo (
    idartigo BIGSERIAL,
    titulo VARCHAR(100) NOT NULL,
    conteudo TEXT,
    idusuario INT NOT NULL,
    PRIMARY KEY(idartigo),
    FOREIGN KEY(idusuario) REFERENCES "sistema".usuario(idusuario)
        ON UPDATE CASCADE ON DELETE CASCADE
);

-- Autores de Artigos
CREATE TABLE "sistema".r_artigo_autor (
    idartigo BIGINT NOT NULL,
    idautor INT NOT NULL,
    PRIMARY KEY(idartigo, idautor),
    FOREIGN KEY(idartigo) REFERENCES "sistema".artigo(idartigo)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY(idautor) REFERENCES "sistema".autor(idautor)
        ON UPDATE CASCADE ON DELETE CASCADE
);

-- Referências Bibliográficas
CREATE TABLE "sistema".referencia (
    idreferencia BIGSERIAL,
    tipo "sistema".TIPO_REFERENCIA NOT NULL,
    identificador VARCHAR(100) NOT NULL,
    conteudo TEXT,
    idusuario INT NOT NULL,
    PRIMARY KEY(idreferencia),
    FOREIGN KEY(idusuario) REFERENCES "sistema".usuario(idusuario)
        ON UPDATE CASCADE ON DELETE CASCADE
);

-- Imagens de Documentos
CREATE TABLE "sistema".figura (
    idfigura BIGSERIAL,
    legenda VARCHAR(100),
    arquivo VARCHAR(100) NOT NULL,
    identificador VARCHAR(100) NOT NULL,
    idusuario INT NOT NULL,
    PRIMARY KEY(idfigura),
    FOREIGN KEY(idusuario) REFERENCES "sistema".usuario(idusuario)
        ON UPDATE CASCADE ON DELETE CASCADE
);

-- Valores Iniciais
INSERT INTO "sistema".instituicao(endereco) VALUES ('Sistema');
INSERT INTO "sistema".autor(nome,email,idinstituicao) VALUES
    ('Administrador','root@localhost',1);
INSERT INTO "sistema".usuario(idusuario,identidade,credencial) VALUES
    (1,'root',MD5('102030'));