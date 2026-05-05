CREATE DATABASE IF NOT EXISTS mymtg;
USE mymtg;

-- =========================
-- USERS
-- =========================
CREATE TABLE IF NOT EXISTS users(
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =========================
-- DECK FORMAT
-- =========================
CREATE TABLE IF NOT EXISTS deck_format(
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    label VARCHAR(100) NOT NULL,
    description TEXT,
    quantity_of_cards INT NOT NULL
);

-- =========================
-- COLLECTIONS
-- =========================
CREATE TABLE IF NOT EXISTS collections(
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    card_id VARCHAR(100) NOT NULL,
    lang VARCHAR(10) NOT NULL DEFAULT 'fr',
    quantity INT NOT NULL DEFAULT 1,
    variant ENUM('nonfoil', 'foil') DEFAULT 'nonfoil',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_collections_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

CREATE INDEX idx_collections_user ON collections(user_id);
CREATE INDEX idx_collections_card ON collections(card_id);
CREATE UNIQUE INDEX uniq_user_card_variant
ON collections(user_id, card_id, variant);

-- =========================
-- FAVORITES
-- =========================
CREATE TABLE IF NOT EXISTS favorites(
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    card_id VARCHAR(100) NOT NULL,
    lang VARCHAR(10) NOT NULL DEFAULT 'fr',
    variant ENUM('nonfoil', 'foil') DEFAULT 'nonfoil',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_favorites_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

CREATE INDEX idx_favorites_user ON favorites(user_id);
CREATE INDEX idx_favorites_card ON favorites(card_id);

-- =========================
-- WANTED
-- =========================
CREATE TABLE IF NOT EXISTS wanted(
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    card_id VARCHAR(100) NOT NULL,
    lang VARCHAR(10) NOT NULL DEFAULT 'fr',
    variant ENUM('nonfoil', 'foil') DEFAULT 'nonfoil',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_wanted_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

CREATE INDEX idx_wanted_user ON wanted(user_id);
CREATE INDEX idx_wanted_card ON wanted(card_id);

-- =========================
-- DECKS
-- =========================
CREATE TABLE IF NOT EXISTS decks(
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    deck_format_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_decks_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_decks_format
        FOREIGN KEY (deck_format_id)
        REFERENCES deck_format(id)
        ON DELETE RESTRICT
);

CREATE INDEX idx_decks_user ON decks(user_id);

-- =========================
-- DECK CARDS
-- =========================
CREATE TABLE IF NOT EXISTS deck_cards(
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    deck_id BIGINT NOT NULL,
    card_id VARCHAR(100) NOT NULL,
    lang VARCHAR(10) NOT NULL DEFAULT 'fr',
    variant ENUM('nonfoil', 'foil') DEFAULT 'nonfoil',
    quantity_owned INT DEFAULT 0,
    quantity_total INT NOT NULL,
    is_commander BOOLEAN DEFAULT FALSE,

    CONSTRAINT fk_deck_cards_deck
        FOREIGN KEY (deck_id)
        REFERENCES decks(id)
        ON DELETE CASCADE
);

CREATE INDEX idx_deck_cards_deck ON deck_cards(deck_id);
CREATE INDEX idx_deck_cards_card ON deck_cards(card_id);