CREATE TABLE IF NOT EXISTS inscription
(
    id                    serial                  primary key,
    uuid                  uuid                       DEFAULT public.uuid_generate_v4(),
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
    montharrival          varchar(255)               null,
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

ALTER TABLE inscription
    OWNER TO ADMIN;

CREATE UNIQUE INDEX inscription_user_id
    ON inscription (user_id);

CREATE INDEX inscription_step_id
    ON inscription (step_id);

CREATE INDEX inscription_composante_id
    ON inscription (composante_id);

CREATE INDEX inscription_mobilite_id
    ON inscription (mobilite_id);

CREATE INDEX inscription_etablissement_id
    ON inscription (etablissement_id);

CREATE UNIQUE INDEX inscription_diplomePays_id
    ON inscription (diplomePays_id);