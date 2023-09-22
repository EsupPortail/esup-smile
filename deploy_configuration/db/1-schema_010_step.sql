CREATE TABLE IF NOT EXISTS step (
    id          serial              primary key,
    code        varchar(64)         NOT NULL,
    libelle     varchar(64)         NOT NULL,
    needvalidation bool             NULL,
    status      bool    NULL,
    "order"     int       NULL,
    role_id           integer                    null
    constraint fk_role
    references unicaen_utilisateur_role
);

ALTER TABLE step
    OWNER TO ADMIN;

CREATE INDEX step_role_id
    ON step (role_id);

