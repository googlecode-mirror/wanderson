-- Inicialização
DROP TABLE IF EXISTS `musics`;

-- Criação de Tabelas
CREATE TABLE IF NOT EXISTS `musics` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    `filename` TEXT NOT NULL,
    `counter` UNSIGNED INTEGER NOT NULL DEFAULT 0,
    `priority` INTEGER NOT NULL DEFAULT 0,
    `enabled` INTEGER NOT NULL DEFAULT 1
);
