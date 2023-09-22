-------------------------------------
-- Gestion de l'offre de formation

-----------------
-- Composantes --
-----------------
CREATE TABLE IF NOT EXISTS composante
(
    id BIGSERIAL PRIMARY KEY,
    code VARCHAR (64) NOT NULL,
    libelle VARCHAR(120),
    libelle_long VARCHAR(256),
    acronyme VARCHAR(50),
--  Historisation / Import
    source_id BIGINT not null,
    source_code VARCHAR(64) not null,
    histo_creation TIMESTAMP NOT NULL DEFAULT now(),
    histo_createur_id BIGINT NOT NULL,
    histo_modification TIMESTAMP,
    histo_modificateur_id BIGINT,
    histo_destruction TIMESTAMP,
    histo_destructeur_id BIGINT,
    FOREIGN KEY (source_id) REFERENCES source (id) on delete cascade
);
-- CREATE UNIQUE INDEX IF NOT EXISTS composante_code_unique ON composante (code);
-- Code unique pose des problèmes pour des sources différente ayant un code identique
CREATE UNIQUE INDEX IF NOT EXISTS composante_code_source_unique ON composante (source_id, source_code);

CREATE TABLE IF NOT EXISTS import_composante
(
    id BIGSERIAL PRIMARY KEY,
    source_id BIGINT not null,
    code VARCHAR (64) NOT NULL,
    acronyme VARCHAR(10),
    libelle VARCHAR(120),
    libelle_long VARCHAR(256),
    histo_creation TIMESTAMP NOT NULL DEFAULT now(),
    histo_createur_id BIGINT NOT NULL,
    histo_modification TIMESTAMP,
    histo_modificateur_id BIGINT,
    histo_destruction TIMESTAMP,
    histo_destructeur_id BIGINT
);
---> Vue pour la synchronisation
CREATE OR REPLACE VIEW src_composante AS
SELECT source_id, code as source_code, code, libelle, libelle_long, acronyme from import_composante;
