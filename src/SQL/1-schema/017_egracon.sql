create table unicaen_egracon_pays
(
    id          serial
        constraint unicaen_egracon_pays_pk primary key,
    code        varchar(1024) not null unique,
    libelle     varchar(1024) not null
);

create table unicaen_egracon_note
(
    id           serial
        constraint unicaen_egracon_note_pk primary key,
    pays_id      integer       not null
        constraint unicaen_egracon_note_unicaen_egracon_pays_id_fk references unicaen_egracon_pays on delete cascade,
    valeur_basse varchar(1024) not null,
    valeur_haute varchar(1024) not null,
    description  text,
    reference_id integer
        constraint unicaen_egracon_note_unicaen_egracon_note_id_fk references unicaen_egracon_note on delete set null
);


