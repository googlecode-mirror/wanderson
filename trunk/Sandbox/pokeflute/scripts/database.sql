-- Inicialização
DROP TABLE IF EXISTS `musics`;

-- Criação de Tabelas
CREATE TABLE IF NOT EXISTS `musics` (
    `id` INTEGER,
    `filename` TEXT,
    `priority` INTEGER,
    PRIMARY KEY(`id`)
);
