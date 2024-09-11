CREATE TABLE IF NOT EXISTS etablissement
(
    id                   integer                  primary key generated always as identity,
    code                 varchar(64)                not null,
    pic                  varchar(64)                null,
    oid                  varchar(64)                null,
    libelle              varchar(256)               not null,
    postCode             varchar(64)                null,
    street               varchar(256)               null,
    city                 varchar(64)                null,
    pays_code             varchar(64)                null,
    pays_id               integer
    constraint fk_pays_id
    references pays
    deferrable null
    );

ALTER TABLE etablissement
    OWNER TO ADMIN;

CREATE INDEX etablissement_pays_id
    ON etablissement (pays_id);
CREATE UNIQUE INDEX IF NOT EXISTS etablissement_code_unique ON etablissement (code);

