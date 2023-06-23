create table if not exists unicaen_privilege_categorie
(
    id        serial
    primary key,
    code      varchar(150) not null,
    libelle   varchar(200) not null,
    namespace varchar(255),
    ordre     integer default 0
    );

alter table unicaen_privilege_categorie
    owner to admin;

create unique index un_unicaen_privilege_categorie_code
    on unicaen_privilege_categorie (code);

create table if not exists  unicaen_privilege_privilege
(
    id           serial
    primary key,
    categorie_id integer      not null
    constraint fk_unicaen_privilege_categorie
    references unicaen_privilege_categorie
    deferrable,
    code         varchar(150) not null,
    libelle      varchar(200) not null,
    ordre        integer default 0
    );

alter table unicaen_privilege_privilege
    owner to admin;

create unique index un_unicaen_privilege_code
    on unicaen_privilege_privilege (categorie_id, code);

create index ix_unicaen_privilege_categorie
    on unicaen_privilege_privilege (categorie_id);

create table if not exists  unicaen_privilege_privilege_role_linker
(
    role_id      integer not null
    constraint fk_unicaen_privilege_privilege_role_linker_role
    references unicaen_utilisateur_role
    on delete cascade,
    privilege_id integer not null
    constraint fk_unicaen_privilege_privilege_role_linker_privilege
    references unicaen_privilege_privilege
    on delete cascade,
    constraint pk_unicaen_privilege_privilege_role_linker
    primary key (role_id, privilege_id)
    );

alter table unicaen_privilege_privilege_role_linker
    owner to admin;

create index ix_unicaen_privilege_privilege_role_linker_role
    on unicaen_privilege_privilege_role_linker (role_id);

create index ix_unicaen_privilege_privilege_role_linker_privilege
    on unicaen_privilege_privilege_role_linker (privilege_id);
