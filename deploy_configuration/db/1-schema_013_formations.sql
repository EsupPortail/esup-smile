------------------------------------------------------
-- Types de formations et autres tables en lien     --
------------------------------------------------------
-- Ces tables sont non historisable, non importable
-- Les tables de mapping permette de faire le liens entre les bases sources et les infos local pour l'import
--
CREATE TABLE IF NOT EXISTS type_formation
(
    id BIGSERIAL PRIMARY KEY,
    code VARCHAR (64) NOT NULL,
    libelle VARCHAR(120),
    acronyme VARCHAR(10),
    ordre int NOT NULL default 1
);
CREATE UNIQUE INDEX IF NOT EXISTS type_formation_code_unique ON type_formation (code);
-- TODO : permettre de rajouter en backend des mapping entre les sources
-- Table de mapping pour faire les jointures entre les types de formations dans une base source et les types de formations dans SMILE
CREATE TABLE IF NOT EXISTS type_formation_mapping
(
    id BIGSERIAL PRIMARY KEY,
    type_formation_id BIGINT NOT NULL,
    source_id BIGINT NOT NULL,
    code_src VARCHAR(64) NOT NULL,
    FOREIGN KEY (type_formation_id) REFERENCES type_formation (id) on delete cascade,
    FOREIGN KEY (source_id) REFERENCES source (id) on delete cascade
);


-- Ie : Informatique, Droit, autres ??? a vérifier
CREATE TABLE IF NOT EXISTS domaine_formation
(
    id BIGSERIAL PRIMARY KEY,
    code VARCHAR (64) NOT NULL,
    libelle VARCHAR(120),
    acronyme VARCHAR(10),
    ordre int NOT NULL default 1
);
CREATE UNIQUE INDEX IF NOT EXISTS domaine_formation_code_unique ON domaine_formation (code);

-- Licence, master, DU ... ? a vérifer
CREATE TABLE IF NOT EXISTS type_diplome
(
    id BIGSERIAL PRIMARY KEY,
    code VARCHAR (64) NOT NULL,
    libelle VARCHAR(120),
    acronyme VARCHAR(10),
    ordre int NOT NULL default 1
);
CREATE UNIQUE INDEX IF NOT EXISTS type_diplome_code_unique ON type_diplome (code);

CREATE TABLE IF NOT EXISTS type_diplome_mapping
(
    id BIGSERIAL PRIMARY KEY,
    type_diplome_id BIGINT NOT NULL,
    source_id BIGINT NOT NULL,
    code_src VARCHAR(64) NOT NULL,
    FOREIGN KEY (type_diplome_id) REFERENCES type_diplome (id) on delete cascade,
    FOREIGN KEY (source_id) REFERENCES source (id) on delete cascade
);
CREATE UNIQUE INDEX IF NOT EXISTS type_diplome_mapping_unique ON type_diplome_mapping (type_diplome_id, source_id, code_src);


--------------------
-- Les formations --
--------------------
CREATE TABLE IF NOT EXISTS formation
(
    id BIGSERIAL PRIMARY KEY,
    code VARCHAR (64) NOT NULL,
    libelle VARCHAR(120),
    acronyme VARCHAR(10),

--     type_formation_id BIGINT NOT NULL,
    type_formation_id BIGINT,
    FOREIGN KEY (type_formation_id) REFERENCES type_formation (id) on delete set null,

--     domaine_formation_id BIGINT NOT NULL,
    domaine_formation_id BIGINT,
    FOREIGN KEY (domaine_formation_id) REFERENCES domaine_formation (id) on delete set null,

-- La formation n'est pas forcément diplomante
    type_diplome_id BIGINT default null,
    niveau_etude int default null,

-- Composante de ratachement Q : doit-on le rendre not null ? a priori non
    composante_id BIGINT,
    FOREIGN KEY (composante_id) REFERENCES composante (id) on delete set null,

--     Choix a confirmé, a priori si une formation est présente dans SMILE, elle devrait être ouvert à la mobilité
--  défaut de cette hypothèse : l'import depuis une source externe peux faire apparaitres des formations qui ne sont pas ouvert à la mobilité et que l'on s'en rend compte trop tard
    ouvert_mobilite boolean default true,
--
    langue_enseignement_id BIGINT,
    FOREIGN KEY (langue_enseignement_id) REFERENCES langue (id) on delete set null,
--     Champ libre en text ou as confirmer
    mention text,
    objectifs text,
    programme text,
    prerequis_pedagogique text,
    modalite_enseignement text, -- TODO : en faire une table
    bibliographie text,
    contacts varchar(250),
    informations_complementaires text,

--  Historisation / Import
    source_id BIGINT not null,
    source_code VARCHAR(64) not null,
    histo_creation TIMESTAMP NOT NULL DEFAULT now(),
    histo_createur_id BIGINT NOT NULL,
    histo_modification TIMESTAMP,
    histo_modificateur_id BIGINT,
    histo_destruction TIMESTAMP,
    histo_destructeur_id BIGINT
--     FOREIGN KEY (source_id) REFERENCES source (id) on delete cascade,
--     FOREIGN KEY (histo_createur_id) REFERENCES unicaen_utilisateur_user (id),
--     FOREIGN KEY (histo_modificateur_id) REFERENCES unicaen_utilisateur_user (id),
--     FOREIGN KEY (histo_destructeur_id) REFERENCES unicaen_utilisateur_user (id)
);
CREATE UNIQUE INDEX IF NOT EXISTS formation_code_source_unique ON formation (source_id, source_code);

CREATE TABLE IF NOT EXISTS inscription_formation_linker (
    inscription_id integer not null
        constraint fk_inscription_formation_linker_inscription
            references inscription
            deferrable,
    formation_id integer not null
        constraint fk_inscription_formation_linker_formation
            references formation
            deferrable,
    constraint pk_inscription_formation_linker
        primary key (inscription_id, formation_id)
);

CREATE TABLE IF NOT EXISTS mobilite_formation_linker (
     mobilite_id integer not null
         constraint fk_mobilite_formation_linker_mobilite
             references mobilite
             deferrable,
     formation_id integer not null
         constraint fk_mobilite_formation_linker_formation
             references formation
             deferrable,
     constraint pk_mobilite_formation_linker
         primary key (mobilite_id, formation_id)
);