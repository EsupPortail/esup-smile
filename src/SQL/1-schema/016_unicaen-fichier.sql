create table fichier_nature
(
    id          serial
        constraint fichier_nature_pk
            primary key,
    code        varchar(64)  not null,
    libelle     varchar(256) not null,
    description varchar(2048)
);

create unique index fichier_nature_code_uindex
    on fichier_nature (code);

create unique index fichier_nature_id_uindex
    on fichier_nature (id);

create table fichier_fichier
(
    id                    varchar(13)  not null
        constraint fichier_fichier_pk
            primary key,
    nom_original          varchar(256) not null,
    nom_stockage          varchar(256) not null,
    nature                integer      not null,
    type_mime             varchar(256) not null,
    taille                varchar(256),
    histo_creation        timestamp    not null,
    histo_createur_id     integer      not null,
    histo_modification    timestamp,
    histo_modificateur_id integer,
    histo_destruction     timestamp,
    histo_destructeur_id  integer
);


create unique index fichier_fichier_id_uindex
    on fichier_fichier (id);

create unique index fichier_fichier_nom_stockage_uindex
    on fichier_fichier (nom_stockage);

create table document
(
    id          serial
        constraint contrat_pk
            primary key,
    user_id        int  not null,
    fichier_id     varchar(13) not null,
    typedocument_id int null
);
create index document_user_id
    on document (user_id);
create index document_fichier_id
    on document (fichier_id);
create index document_typedocument_id
    on document (typedocument_id);

create table typedocument
(
    id      serial
        constraint typedocument_pk
            primary key,
    libelle int not null
);

CREATE TABLE IF NOT EXISTS mobilite_typedocument_linker (
         mobilite_id integer not null
             constraint fk_mobilite_typedocument_linker_mobilite
                 references mobilite
                 on delete cascade
                 deferrable,
         typedocument_id integer not null
             constraint fk_mobilite_typedocument_linker_document
                 references typedocument
                 on delete cascade
                 deferrable,
         constraint pk_mobilite_typedocument_linker
             primary key (mobilite_id, typedocument_id)
);