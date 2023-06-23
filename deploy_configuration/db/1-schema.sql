-- -----------------------------------------------------
-- TABLE UNICAEN_UTILISATEUR_ROLE
-- -----------------------------------------------------
CREATE TABLE UNICAEN_UTILISATEUR_ROLE (
                                          ID                    SERIAL        PRIMARY KEY,
                                          ROLE_ID               VARCHAR(64)   NOT NULL,
                                          LIBELLE               VARCHAR(255)  NOT NULL,
                                          IS_DEFAULT            BOOLEAN       DEFAULT false NOT NULL,
                                          IS_AUTO               BOOLEAN       DEFAULT false NOT NULL,
                                          PARENT_ID             INTEGER,
                                          LDAP_FILTER           VARCHAR(255)  DEFAULT NULL::character varying,
                                          ACCESSIBLE_EXTERIEUR  BOOLEAN       DEFAULT true NOT NULL,
                                          DESCRIPTION           CHARACTER VARYING,
                                          CONSTRAINT FK_UNICAEN_UTILISATEUR_ROLE_PARENT FOREIGN KEY (PARENT_ID) REFERENCES UNICAEN_UTILISATEUR_ROLE (ID) DEFERRABLE INITIALLY IMMEDIATE
);

CREATE UNIQUE INDEX UN_UNICAEN_UTILISATEUR_ROLE_ROLE_ID ON UNICAEN_UTILISATEUR_ROLE (ROLE_ID);
CREATE INDEX IX_UNICAEN_UTILISATEUR_ROLE_PARENT ON UNICAEN_UTILISATEUR_ROLE (PARENT_ID);


-- -----------------------------------------------------
-- TABLE UNICAEN_UTILISATEUR_USER
-- -----------------------------------------------------
CREATE TABLE UNICAEN_UTILISATEUR_USER (
                                          ID                    SERIAL        PRIMARY KEY,
                                          USERNAME              VARCHAR(255)  NOT NULL,
                                          DISPLAY_NAME          VARCHAR(255)  NOT NULL,
                                          EMAIL                 VARCHAR(255),
                                          PASSWORD              VARCHAR(128)  DEFAULT 'application'::character varying NOT NULL,
                                          STATE                 BOOLEAN       DEFAULT true NOT NULL,
                                          PASSWORD_RESET_TOKEN  VARCHAR(256),
                                          LAST_ROLE_ID          INTEGER,
                                          CONSTRAINT UN_UNICAEN_UTILISATEUR_USER_USERNAME UNIQUE (USERNAME),
                                          CONSTRAINT UN_UNICAEN_UTILISATEUR_USER_PASSWORD_RESET_TOKEN UNIQUE (PASSWORD_RESET_TOKEN),
                                          CONSTRAINT FK_UNICAEN_UTILISATEUR_USER_LAST_ROLE FOREIGN KEY (LAST_ROLE_ID) REFERENCES UNICAEN_UTILISATEUR_ROLE(ID) DEFERRABLE INITIALLY IMMEDIATE
);

-- CREATE UNIQUE INDEX UN_UNICAEN_UTILISATEUR_USER_USERNAME ON UNICAEN_UTILISATEUR_USER(USERNAME);
-- CREATE UNIQUE INDEX UN_UNICAEN_UTILISATEUR_USER_PASSWORD_RESET_TOKEN ON UNICAEN_UTILISATEUR_USER(PASSWORD_RESET_TOKEN);
CREATE INDEX IX_UNICAEN_UTILISATEUR_USER_LAST_ROLE ON UNICAEN_UTILISATEUR_USER(LAST_ROLE_ID);


-- -----------------------------------------------------
-- TABLE UNICAEN_UTILISATEUR_ROLE_LINKER
-- -----------------------------------------------------
CREATE TABLE UNICAEN_UTILISATEUR_ROLE_LINKER (
                                                 USER_ID  INTEGER NOT NULL,
                                                 ROLE_ID         INTEGER NOT NULL,
                                                 CONSTRAINT PK_UNICAEN_UTILISATEUR_ROLE_LINKER PRIMARY KEY (USER_ID, ROLE_ID),
                                                 CONSTRAINT FK_UNICAEN_UTILISATEUR_ROLE_LINKER_USER FOREIGN KEY (USER_ID) REFERENCES UNICAEN_UTILISATEUR_USER (ID) DEFERRABLE INITIALLY IMMEDIATE,
                                                 CONSTRAINT FK_UNICAEN_UTILISATEUR_ROLE_LINKER_ROLE FOREIGN KEY (ROLE_ID) REFERENCES UNICAEN_UTILISATEUR_ROLE (ID) DEFERRABLE INITIALLY IMMEDIATE
);

CREATE INDEX IX_UNICAEN_UTILISATEUR_ROLE_LINKER_USER ON UNICAEN_UTILISATEUR_ROLE_LINKER (USER_ID);
CREATE INDEX IX_UNICAEN_UTILISATEUR_ROLE_LINKER_ROLE ON UNICAEN_UTILISATEUR_ROLE_LINKER (ROLE_ID);


-- -----------------------------------------------------
-- TABLE UNICAEN_PRIVILEGE_CATEGORIE
-- -----------------------------------------------------
CREATE TABLE UNICAEN_PRIVILEGE_CATEGORIE (
                                             ID        SERIAL        PRIMARY KEY,
                                             CODE      VARCHAR(150)  NOT NULL,
                                             LIBELLE   VARCHAR(200)  NOT NULL,
                                             NAMESPACE VARCHAR(255),
                                             ORDRE     INTEGER       DEFAULT 0
);

CREATE UNIQUE INDEX UN_UNICAEN_PRIVILEGE_CATEGORIE_CODE ON UNICAEN_PRIVILEGE_CATEGORIE (CODE);

-- -----------------------------------------------------
-- TABLE UNICAEN_PRIVILEGE
-- -----------------------------------------------------
CREATE TABLE UNICAEN_PRIVILEGE_PRIVILEGE (
                                             ID           SERIAL       PRIMARY KEY,
                                             CATEGORIE_ID INTEGER      NOT NULL,
                                             CODE         VARCHAR(150) NOT NULL,
                                             LIBELLE      VARCHAR(200) NOT NULL,
                                             ORDRE        INTEGER      DEFAULT 0,
                                             CONSTRAINT FK_UNICAEN_PRIVILEGE_CATEGORIE FOREIGN KEY (CATEGORIE_ID) REFERENCES UNICAEN_PRIVILEGE_CATEGORIE (ID) DEFERRABLE INITIALLY IMMEDIATE
);

CREATE UNIQUE INDEX UN_UNICAEN_PRIVILEGE_CODE ON UNICAEN_PRIVILEGE_PRIVILEGE (CATEGORIE_ID, CODE);
CREATE INDEX IX_UNICAEN_PRIVILEGE_CATEGORIE ON UNICAEN_PRIVILEGE_PRIVILEGE(CATEGORIE_ID);


-- -----------------------------------------------------
-- TABLE UNICAEN_ROLE_PRIVILEGE_LINKER
-- -----------------------------------------------------
CREATE TABLE UNICAEN_PRIVILEGE_PRIVILEGE_ROLE_LINKER (
                                                         ROLE_ID      INTEGER  NOT NULL,
                                                         PRIVILEGE_ID INTEGER  NOT NULL,
                                                         CONSTRAINT PK_UNICAEN_PRIVILEGE_PRIVILEGE_ROLE_LINKER PRIMARY KEY (ROLE_ID, PRIVILEGE_ID),
                                                         CONSTRAINT FK_UNICAEN_PRIVILEGE_PRIVILEGE_ROLE_LINKER_ROLE FOREIGN KEY (ROLE_ID) REFERENCES UNICAEN_UTILISATEUR_ROLE (ID) DEFERRABLE INITIALLY IMMEDIATE,
                                                         CONSTRAINT FK_UNICAEN_PRIVILEGE_PRIVILEGE_ROLE_LINKER_PRIVILEGE FOREIGN KEY (PRIVILEGE_ID) REFERENCES UNICAEN_PRIVILEGE_PRIVILEGE (ID) DEFERRABLE INITIALLY IMMEDIATE
);

CREATE INDEX IX_UNICAEN_PRIVILEGE_PRIVILEGE_ROLE_LINKER_ROLE ON UNICAEN_PRIVILEGE_PRIVILEGE_ROLE_LINKER (ROLE_ID);
CREATE INDEX IX_UNICAEN_PRIVILEGE_PRIVILEGE_ROLE_LINKER_PRIVILEGE ON UNICAEN_PRIVILEGE_PRIVILEGE_ROLE_LINKER (PRIVILEGE_ID);