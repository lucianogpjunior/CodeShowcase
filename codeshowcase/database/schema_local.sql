-- CodeShowcase - banco local para desenvolvimento e testes
-- MySQL 8.0+
-- Execute-o somente em uma instancia local.
/* 
    Necessario XAMPP
    
*/

CREATE DATABASE IF NOT EXISTS `codeshowcase_local`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `codeshowcase_local`;

CREATE TABLE IF NOT EXISTS `usuario` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nome_usuario` VARCHAR(80) NOT NULL,
    `nome_completo` VARCHAR(150) NOT NULL,
    `email` VARCHAR(254) NOT NULL,
    `senha` VARCHAR(255) NOT NULL,
    `dt_nascimento` DATE NOT NULL,
    `cpf` CHAR(11) NULL,
    `dt_cadastro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `status` TINYINT(1) NOT NULL DEFAULT 1,
    `role` ENUM('COMUM', 'DESENVOLVEDOR') NOT NULL DEFAULT 'COMUM',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_usuario_nome_usuario` (`nome_usuario`),
    UNIQUE KEY `uq_usuario_email` (`email`),
    UNIQUE KEY `uq_usuario_cpf` (`cpf`),
    KEY `idx_usuario_status` (`status`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `usuario_dev` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `usuario_id` INT UNSIGNED NOT NULL,
    `dt_cadastro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `github_url_perfil` VARCHAR(2048) NULL,
    `linkedin_url` VARCHAR(2048) NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_usuario_dev_usuario` (`usuario_id`),
    CONSTRAINT `fk_usuario_dev_usuario`
        FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `categorias` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `categoria` VARCHAR(80) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_categorias_categoria` (`categoria`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `projetos` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `url` VARCHAR(2048) NULL,
    `image` VARCHAR(2048) NULL,
    `nome` VARCHAR(120) NOT NULL,
    `titulo` VARCHAR(180) NOT NULL,
    `descricao` TEXT NOT NULL,
    `preco` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `status` TINYINT(1) NOT NULL DEFAULT 1,
    `categoria_id` INT UNSIGNED NOT NULL,
    `dev_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_projetos_status` (`status`),
    KEY `idx_projetos_categoria_id` (`categoria_id`),
    KEY `idx_projetos_dev_id` (`dev_id`),
    CONSTRAINT `fk_projetos_categoria`
        FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT `fk_projetos_dev`
        FOREIGN KEY (`dev_id`) REFERENCES `usuario_dev` (`id`)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT `ck_projetos_preco` CHECK (`preco` >= 0)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `compras` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `projeto_id` INT UNSIGNED NOT NULL,
    `comprador_id` INT UNSIGNED NOT NULL,
    `vendedor_id` INT UNSIGNED NOT NULL,
    `valor` DECIMAL(10,2) NOT NULL,
    `status` ENUM('PENDENTE', 'PAGO', 'CANCELADO', 'ENTREGUE') NOT NULL DEFAULT 'PENDENTE',
    `metodo` ENUM('STRIPE', 'PIX', 'BOLETO', 'CARTAO') NOT NULL DEFAULT 'STRIPE',
    `stripe_session_id` VARCHAR(255) NULL,
    `stripe_payment_intent_id` VARCHAR(255) NULL,
    `data_criacao` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `data_atualizacao` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_compras_projeto_id` (`projeto_id`),
    KEY `idx_compras_comprador_id` (`comprador_id`),
    KEY `idx_compras_vendedor_id` (`vendedor_id`),
    CONSTRAINT `fk_compras_projeto`
        FOREIGN KEY (`projeto_id`) REFERENCES `projetos` (`id`)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT `fk_compras_comprador`
        FOREIGN KEY (`comprador_id`) REFERENCES `usuario` (`id`)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT `fk_compras_vendedor`
        FOREIGN KEY (`vendedor_id`) REFERENCES `usuario` (`id`)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `chat_mensagens` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `compra_id` INT UNSIGNED NOT NULL,
    `remetente_id` INT UNSIGNED NOT NULL,
    `destinatario_id` INT UNSIGNED NOT NULL,
    `mensagem` TEXT NOT NULL,
    `tipo` ENUM('TEXT', 'SYSTEM') NOT NULL DEFAULT 'TEXT',
    `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_chat_compra_id` (`compra_id`),
    CONSTRAINT `fk_chat_compra`
        FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO `categorias` (`categoria`) VALUES
    ('Web'),
    ('Mobile'),
    ('Desktop'),
    ('API'),
    ('Outro')
ON DUPLICATE KEY UPDATE `categoria` = VALUES(`categoria`);