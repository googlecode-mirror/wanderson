-- Esquema de Dados
CREATE SCHEMA sistema;

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

-- Elementos para Arquivos
CREATE TYPE REFERENCIA AS ENUM('artigo');

-- Referências Bibliográficas
CREATE TABLE "sistema".referencia (
    idreferencia BIGSERIAL,
    tipo REFERENCIA NOT NULL,
    identificador VARCHAR(100) NOT NULL,
    conteudo TEXT,
    PRIMARY KEY(idreferencia)
);

-- Referências para Artigos
CREATE TABLE "sistema".r_artigo_referencia (
    idartigo BIGINT NOT NULL,
    idreferencia BIGINT NOT NULL,
    PRIMARY KEY(idartigo, idreferencia),
    FOREIGN KEY(idartigo) REFERENCES "sistema".artigo(idartigo)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY(idreferencia) REFERENCES "sistema".referencia(idreferencia)
        ON UPDATE CASCADE ON DELETE CASCADE
);

-- Imagens de Documentos
CREATE TABLE "sistema".figura (
    idfigura BIGSERIAL,
    legenda VARCHAR(100),
    arquivo VARCHAR(100) NOT NULL,
    identificador VARCHAR(100) NOT NULL,
    PRIMARY KEY(idfigura)
);

-- Figuras para Artigos
CREATE TABLE "sistema".r_artigo_figura (
    idartigo BIGINT NOT NULL,
    idfigura BIGINT NOT NULL,
    PRIMARY KEY(idartigo, idfigura),
    FOREIGN KEY(idartigo) REFERENCES "sistema".artigo(idartigo)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY(idfigura) REFERENCES "sistema".figura(idfigura)
        ON UPDATE CASCADE ON DELETE CASCADE
);
