--------------------
-- Les cours --
--------------------
CREATE TABLE IF NOT EXISTS inscription
(
    id                    serial                  primary key,
    uuid                  uuid                       DEFAULT uuid_generate_v4(),
    firstname             varchar(64)                null,
    lastname              varchar(64)                null,
    birthDate             date                       null,
    esi                   varchar(100)               null,
    city                  varchar(100)               null,
    postalCode            varchar(100)               null,
    street                varchar(255)               null,
    numStreet             integer                    null,
    firstMobilite         boolean                    null,
    email                 varchar(255)               null,
    handicap              boolean                    null,
    mailReferent          varchar(255)               null,
    status                varchar(255)               null,
    statusLibelle         varchar(255)               null,
    created_at             timestamp     default now(),
    year                  integer                    null,
    user_id               integer                    null
        constraint fk_unicaen_user
            references unicaen_utilisateur_user
            deferrable,
    composante_id           integer                    null
        constraint fk_composante
            references composante
            deferrable,
    mobilite_id           integer                    null
        constraint fk_mobilite
            references mobilite
            deferrable,
    step_id           integer                    null
        constraint fk_step
            references step
            deferrable,
    etablissement_id      integer                    null
        constraint fk_etablissement
            references etablissement
            deferrable,
    diplomePays_id      integer                      null
        constraint fk_pays
            references pays
            deferrable
);

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
    histo_destructeur_id BIGINT
--    FOREIGN KEY (source_id) REFERENCES source (id) on delete cascade,
--    FOREIGN KEY (histo_createur_id) REFERENCES unicaen_utilisateur_user (id),
--    FOREIGN KEY (histo_modificateur_id) REFERENCES unicaen_utilisateur_user (id),
--    FOREIGN KEY (histo_destructeur_id) REFERENCES unicaen_utilisateur_user (id)
);
CREATE UNIQUE INDEX IF NOT EXISTS cours_code_source_unique ON cours (source_id, source_code);

create sequence inscription_cours_linker_id_seq
    as integer;

CREATE TABLE IF NOT EXISTS inscription_cours_linker (
                                                        id             serial
                                                            unique,
                                                        constraint pk_inscription_cours_linker
                                                            primary key (inscription_id, cours_id),
                                                        inscription_id integer not null
                                                            constraint fk_inscription_cours_linker_inscription
                                                                references inscription
                                                                deferrable,
                                                        cours_id integer not null
                                                            constraint fk_inscription_cours_linker_cours
                                                                references cours
                                                                deferrable,
                                                        note varchar
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