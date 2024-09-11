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
    groupe_id BIGINT,
--  Historisation / Import
    source_id BIGINT,
    source_code VARCHAR(64),
    histo_creation TIMESTAMP NOT NULL DEFAULT now(),
    histo_createur_id BIGINT,
    histo_modification TIMESTAMP,
    histo_modificateur_id BIGINT,
    histo_destruction TIMESTAMP,
    histo_destructeur_id BIGINT,
    deleted_on            timestamp,
    created_on            timestamp default now(),
    updated_on            timestamp,
    FOREIGN KEY (source_id) REFERENCES source (id) on delete set null ,
    FOREIGN KEY (histo_createur_id) REFERENCES unicaen_utilisateur_user (id),
    FOREIGN KEY (histo_modificateur_id) REFERENCES unicaen_utilisateur_user (id),
    FOREIGN KEY (histo_destructeur_id) REFERENCES unicaen_utilisateur_user (id)
);
-- CREATE UNIQUE INDEX IF NOT EXISTS composante_code_unique ON composante (code);
-- Code unique pose des problèmes pour des sources différente ayant un code identique
CREATE UNIQUE INDEX IF NOT EXISTS composante_code_source_unique ON composante (source_id, source_code);

CREATE TABLE IF NOT EXISTS composante_groupe
(
    id BIGSERIAL PRIMARY KEY,
    libelle VARCHAR(120)
);

CREATE TABLE IF NOT EXISTS composante_groupe_role_utilisateur
(
    id BIGSERIAL PRIMARY KEY,
    composante_groupe_id BIGINT NOT NULL,
    utilisateur_id BIGINT NOT NULL,
    role_id BIGINT,
    FOREIGN KEY (composante_groupe_id) REFERENCES composante_groupe (id) on delete cascade,
    FOREIGN KEY (utilisateur_id) REFERENCES unicaen_utilisateur_user (id) on delete cascade,
    FOREIGN KEY (role_id) REFERENCES unicaen_utilisateur_role (id) on delete cascade
);