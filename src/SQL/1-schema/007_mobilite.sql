
CREATE TABLE IF NOT EXISTS mobilite (
    id          serial              primary key,
    libelle     varchar(64)         NOT NULL,
    active      bool                default true
);

ALTER TABLE mobilite
    OWNER TO ADMIN;
