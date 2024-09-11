-------------------------------------
-- Sources d'informations
------------------------------------
create table IF NOT EXISTS SOURCE
(
    ID serial not null constraint SOURCE_PK primary key,
    CODE varchar(64) not null constraint SOURCE_CODE_UN unique,
    LIBELLE varchar(128) not null,
    IMPORTABLE boolean not null
);

create table if not exists import_log
(
    id bigserial primary key,
    type varchar(128) not null,
    name varchar(128) not null,
    success boolean not null,
    log text not null,
    started_on timestamp not null,
    ended_on timestamp not null
);

create table import_composante
(
    id                    bigserial primary key,
    code                  varchar(64)             not null,
    libelle               varchar(120),
    libelle_long          varchar(256),
    acronyme              varchar(50)
);

create table import_cours
(
    id                     bigserial primary key,
    code_elp               varchar(64),
    libelle                varchar(255),
    langue_enseignement    varchar(20),
    s1                     varchar(1),
    s2                     varchar(1),
    ects                   numeric(6, 2),
    vol_elp                numeric(6, 2),
    code_formation         varchar(64),
    objectif               text,
    description            text,
    formation_id           bigint
);

create table import_formation
(
    id                           bigserial primary key,
    code                         varchar(64)             not null,
    libelle                      varchar(120),
    acronyme                     varchar(10),
    niveau_etude                 integer,
    cod_cmp                      varchar,
    type_formation               varchar,
    libelle_type_formation       varchar,
    composante_id                bigint,
    type_formation_id            bigint,
    langue_enseignement_id       bigint,
    ouvert_mobilite              boolean   default true
);

alter table import_composante
    owner to admin;

alter table import_formation
    owner to admin;

alter table import_cours
    owner to admin;

-------------------------------------
-- Pour chaque table xxx à importer/synchroniser depuis une base source :
-- 1) Mettre des champs sur les dates/modificateur et source
--     source_id BIGINT not null,
--     source_code VARCHAR(64) not null,
--     histo_creation TIMESTAMP NOT NULL DEFAULT now(),
--     histo_createur_id BIGINT NOT NULL,
--     histo_modification TIMESTAMP,
--     histo_modificateur_id BIGINT,
--     histo_destruction TIMESTAMP,
--     histo_destructeur_id BIGINT
--
-- 2) Creer la table [xxx]_[source]
--     CREATE TABLE IF NOT EXISTS [xxx]_[source]
--     (
--         id BIGSERIAL PRIMARY KEY,
--         source_id BIGINT not null,
--         code VARCHAR (64) NOT NULL,
--         [... les champs à importer]
--         histo_creation TIMESTAMP NOT NULL DEFAULT now(),
--         histo_createur_id BIGINT NOT NULL,
--         histo_modification TIMESTAMP,
--         histo_modificateur_id BIGINT,
--         histo_destruction TIMESTAMP,
--         histo_destructeur_id BIGINT
--     );
-- Cette table dont le contenue sera écrasé à chaque import récupérera les données de la base source

-- 3) Creer la vue src_[xxx]
-- CREATE VIEW src_[xxx] AS
-- SELECT source_id, code as source_code, [... les champs à importer] from  [xxx]_[source];
-- !!! ne pas mettre les champs Histo
-- Cette vue permet de faire le diff entre les sources et la table final*
-- Faire dans cette vue les jointures éventuelles, une union sur plusieurs sources ...
-- Faire la config pour l'import
