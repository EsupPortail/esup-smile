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

--
-- Tables nécessaires pour l'observation de la synchro.
--
create table IF NOT EXISTS IMPORT_OBSERV (
    ID serial not null constraint IMPORT_OBSERV_PK primary key,
    CODE VARCHAR(50) not null constraint IMPORT_OBSERV_CODE_UN unique,
    TABLE_NAME VARCHAR(50) not null,
    COLUMN_NAME VARCHAR(50) not null,
    OPERATION VARCHAR(50) default 'UPDATE' not null,
    TO_VALUE VARCHAR(1000),
    DESCRIPTION VARCHAR(200),
    ENABLED boolean default false not null,
    FILTER text,
    constraint IMPORT_OBSERV_UN unique (TABLE_NAME, COLUMN_NAME, OPERATION, TO_VALUE)
);
create table IF NOT EXISTS IMPORT_OBSERV_RESULT (
    ID serial not null constraint IMPORT_OBSERV_RESULT_PK primary key,
    IMPORT_OBSERV_ID integer not null constraint IMPORT_OBSERV_RESULT_IOE_FK references IMPORT_OBSERV on delete cascade,
    DATE_CREATION DATE default now() not null,
    SOURCE_CODE VARCHAR(64) not null,
    RESULTAT text not null
);
create sequence IMPORT_OBSERV_ID_SEQ;
create sequence IMPORT_OBSERV_RESULT_ID_SEQ;

create table if not exists import_log
(
    id bigserial primary key,
    type varchar(128) not null,
    name varchar(128) not null,
    success boolean not null,
    log text not null,
    started_on timestamp not null,
    ended_on timestamp not null,
    import_hash varchar(64),
    has_problems boolean not null default false
);

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
