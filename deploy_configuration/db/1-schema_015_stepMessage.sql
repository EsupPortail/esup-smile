CREATE TABLE IF NOT EXISTS stepMessage (
                                           id          serial              primary key,
                                           libelle     varchar(64)         NOT NULL,
                                           currentStatus varchar(64)   NULL,
                                           "type"      varchar(64)    NULL,
                                           "date"      timestamp     NULL,
                                           "showed"      bool     NULL,
                                           step_id           integer                    null
                                               constraint fk_step
                                                   references step,
                                           inscription_id           integer                    null
                                               constraint fk_inscription
                                                   references inscription,
                                           validator_id           integer                    null
                                               constraint fk_unicaen_validator
                                                   references unicaen_utilisateur_user
);

ALTER TABLE stepMessage
    OWNER TO ADMIN;

CREATE INDEX step_id
    ON stepMessage (step_id);
CREATE INDEX user_id
    ON stepMessage (inscription_id);
CREATE INDEX user_id
    ON stepMessage (validator_id);