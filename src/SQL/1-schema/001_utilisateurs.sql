CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
create table if not exists unicaen_utilisateur_role
(
    id                   serial
    primary key,
    role_id              varchar(64)                not null,
    libelle              varchar(255)               not null,
    is_default           boolean      default false not null,
    is_auto              boolean      default false not null,
    parent_id            integer
    constraint fk_unicaen_utilisateur_role_parent
    references unicaen_utilisateur_role
    deferrable,
    ldap_filter          varchar(255) default NULL::character varying,
    accessible_exterieur boolean      default true  not null,
    description          character varying
    );

alter table unicaen_utilisateur_role
    owner to admin;

create unique index un_unicaen_utilisateur_role_role_id
    on unicaen_utilisateur_role (role_id);

create index ix_unicaen_utilisateur_role_parent
    on unicaen_utilisateur_role (parent_id);

create table if not exists unicaen_utilisateur_user
(
    id                   serial
    primary key,
    username             varchar(255)                                          not null
    constraint un_unicaen_utilisateur_user_username
    unique,
    display_name         varchar(255)                                          not null,
    email                varchar(255),
    password             varchar(128) default 'application'::character varying not null,
    state                boolean      default true                             not null,
    password_reset_token varchar(256)
    constraint un_unicaen_utilisateur_user_password_reset_token
    unique,
    last_role_id         integer
    constraint fk_unicaen_utilisateur_user_last_role
    references unicaen_utilisateur_role
    deferrable
    );

alter table unicaen_utilisateur_user
    owner to admin;

create index ix_unicaen_utilisateur_user_last_role
    on unicaen_utilisateur_user (last_role_id);

create table if not exists  unicaen_utilisateur_role_linker
(
    user_id integer not null
    constraint fk_unicaen_utilisateur_role_linker_user
    references unicaen_utilisateur_user
    deferrable,
    role_id integer not null
    constraint fk_unicaen_utilisateur_role_linker_role
    references unicaen_utilisateur_role
    deferrable,
    constraint pk_unicaen_utilisateur_role_linker
    primary key (user_id, role_id)
    );

alter table unicaen_utilisateur_role_linker
    owner to admin;

create index ix_unicaen_utilisateur_role_linker_user
    on unicaen_utilisateur_role_linker (user_id);

create index ix_unicaen_utilisateur_role_linker_role
    on unicaen_utilisateur_role_linker (role_id);