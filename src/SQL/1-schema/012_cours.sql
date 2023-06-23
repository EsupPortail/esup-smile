--------------------
-- Les cours --
--------------------
CREATE TABLE IF NOT EXISTS cours
(
    id BIGSERIAL PRIMARY KEY,
    code_elp VARCHAR (64),
    libelle VARCHAR(255) NULL,
    langue_enseignement VARCHAR(20) NULL,
    s1 VARCHAR(1) NULL,
    s2 VARCHAR(1) NULL,
    ects NUMERIC(6,2) NULL,
    vol_elp NUMERIC(6,2) NULL,
    ouvert_mobilite boolean default true,
    formation_id BIGINT,
    objectif TEXT NULL,
    description TEXT NULL,
    type_cours TEXT NULL,
    FOREIGN KEY (formation_id) REFERENCES formation (id) on delete set null,
    langue_enseignement_id BIGINT,
    FOREIGN KEY (langue_enseignement_id) REFERENCES langue (id) on delete set null,

--  Historisation / Import
    source_id BIGINT not null,
    source_code VARCHAR(64) not null,
    histo_creation TIMESTAMP NOT NULL DEFAULT now(),
    histo_createur_id BIGINT NOT NULL,
    histo_modification TIMESTAMP,
    histo_modificateur_id BIGINT,
    histo_destruction TIMESTAMP,
    histo_destructeur_id BIGINT,
    FOREIGN KEY (source_id) REFERENCES source (id) on delete cascade,
    FOREIGN KEY (histo_createur_id) REFERENCES unicaen_utilisateur_user (id),
    FOREIGN KEY (histo_modificateur_id) REFERENCES unicaen_utilisateur_user (id),
    FOREIGN KEY (histo_destructeur_id) REFERENCES unicaen_utilisateur_user (id)
);
CREATE UNIQUE INDEX IF NOT EXISTS cours_code_source_unique ON cours (source_id, source_code);

--------------------
-- Tables pour des imports de sources externe
--------------------
CREATE TABLE IF NOT EXISTS import_cours
(
    id BIGSERIAL PRIMARY KEY,
    source_id BIGINT not null,
    code VARCHAR (100) NOT NULL,
    code_elp VARCHAR (64),
    libelle VARCHAR(255) NULL,
    langue_enseignement VARCHAR(20) NULL,
    s1 VARCHAR(1) NULL, -- Module do not handle boolean?
    s2 VARCHAR(1) NULL,
    ects NUMERIC(6,2) NULL,
    vol_elp NUMERIC(6,2) NULL,
    formation_code VARCHAR (64) default null,
    histo_creation TIMESTAMP NOT NULL DEFAULT now(),
    histo_createur_id BIGINT NOT NULL,
    histo_modification TIMESTAMP,
    histo_modificateur_id BIGINT,
    histo_destruction TIMESTAMP,
    histo_destructeur_id BIGINT
);

drop view src_cours cascade;
CREATE OR REPLACE VIEW src_cours AS
SELECT
    import.source_id as source_id,
    import.code_elp as code_elp,
    import.code as source_code,
    import.libelle  as libelle,
    import.ects  as ects,
    import.s1 as s1,
    import.s2 as s2,
    import.vol_elp as vol_elp,
    f.id as formation_id,
    l.id as langue_enseignement_id,
    l.libelle as langue_enseignement
FROM
    import_cours import
        INNER JOIN formation f ON (import.formation_code = f.code and  import.source_id=f.source_id)
        INNER JOIN langue l ON (import.langue_enseignement = l.libelle);

CREATE TABLE IF NOT EXISTS inscription_cours_linker (
                                                            inscription_id integer not null
                                                                constraint fk_inscription_cours_linker_inscription
                                                                    references inscription
                                                                    deferrable,
                                                            cours_id integer not null
                                                                constraint fk_inscription_cours_linker_cours
                                                                    references cours
                                                                    deferrable,
                                                            constraint pk_inscription_cours_linker
                                                                primary key (inscription_id, cours_id)
);

CREATE TABLE IF NOT EXISTS mobilite_cours_linker (
                                                     mobilite_id integer not null
                                                         constraint fk_mobilite_cours_linker_mobilite
                                                             references mobilite
                                                             deferrable,
                                                     cours_id integer not null
                                                         constraint fk_mobilite_cours_linker_cours
                                                             references cours
                                                             deferrable,
                                                     active bool default true,
                                                     constraint pk_mobilite_cours_linker
                                                         primary key (mobilite_id, cours_id)
);

INSERT INTO import_cours (histo_creation, histo_createur_id, source_id, CODE, FORMATION_CODE, CODE_ELP, LIBELLE, LANGUE_ENSEIGNEMENT, S1, S2, ECTS, VOL_ELP, id)
SELECT LOCALTIMESTAMP(0), 1, s.id, 'Y6V2AN2', 'LLR5L3_215', 'Y6V2AN2', 'LV2 Anglais Culture', 'Français', '', '1', '3.00', '24.00', nextval('import_cours_ID_SEQ')
FROM source s
WHERE s.code = 'pyc';