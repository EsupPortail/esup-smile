-- ETAT ----------------------------------------------------------------------------------------------------------------
create table UNICAEN_EVENEMENT_ETAT
(
    ID SERIAL PRIMARY KEY,
    CODE VARCHAR(255) not null,
    LIBELLE VARCHAR(255) not null,
    DESCRIPTION VARCHAR(2047)
);
create unique index UNICAEN_EVENEMENT_ETAT_ID_UINDEX on UNICAEN_EVENEMENT_ETAT (ID);
create unique index UNICAEN_EVENEMENT_ETAT_CODE_UINDEX  on UNICAEN_EVENEMENT_ETAT (CODE);

-- TYPE ----------------------------------------------------------------------------------------------------------------

create table UNICAEN_EVENEMENT_TYPE
(
    ID BIGSERIAL PRIMARY KEY,
    CODE VARCHAR(255) not null,
    LIBELLE VARCHAR(255) not null,
    DESCRIPTION VARCHAR(2047),
    PARAMETRES VARCHAR(2047),
    RECURSION VARCHAR(2047)
);
create unique index UNICAEN_EVENEMENT_TYPE_ID_UINDEX on UNICAEN_EVENEMENT_TYPE (ID);
create unique index UNICAEN_EVENEMENT_TYPE_CODE_UINDEX on UNICAEN_EVENEMENT_TYPE (CODE);

-- JOURNAL ------------------------------------------------------------------------------------------------------------
create table UNICAEN_EVENEMENT_JOURNAL
(
    ID BIGSERIAL PRIMARY KEY,
    DATE_EXECUTION TIMESTAMP not null,
    LOG VARCHAR(2047),
    ETAT_ID BIGINT not null,
    FOREIGN KEY (ETAT_ID) REFERENCES UNICAEN_EVENEMENT_ETAT (id)
);
create unique index UNICAEN_EVENEMENT_JOURNAL_ID_UINDEX on UNICAEN_EVENEMENT_JOURNAL (ID);


-- INSTANCE ------------------------------------------------------------------------------------------------------------

create table UNICAEN_EVENEMENT_INSTANCE
(
    ID BIGSERIAL PRIMARY KEY,
    TYPE_ID BIGINT not null,
    ETAT_ID BIGINT not null,
    NOM varchar(255),
    DESCRIPTION varchar(1024),
    PARAMETRES TEXT,
    DATE_CREATION TIMESTAMP not null,
    DATE_PLANIFICATION TIMESTAMP not null,
    DATE_TRAITEMENT TIMESTAMP,
    DATE_FIN TIMESTAMP,
    LOG TEXT,
    PARENT_ID BIGINT default NULL,
    FOREIGN KEY (TYPE_ID) REFERENCES UNICAEN_EVENEMENT_TYPE (ID),
    FOREIGN KEY (ETAT_ID) REFERENCES UNICAEN_EVENEMENT_ETAT (ID),
    FOREIGN KEY (PARENT_ID) REFERENCES UNICAEN_EVENEMENT_INSTANCE (ID) on delete CASCADE
);
create unique index UNICAEN_EVENEMENT_INSTANCE_ID_UINDEX on UNICAEN_EVENEMENT_INSTANCE (ID);
