
CREATE TABLE IF NOT EXISTS langue
(
    id                   integer                  primary key generated always as identity,
    code                 varchar(64)             not null,
    libelle              varchar(64)             not null,
    libelle_EN           varchar(64)             not null
--TODO : est-ce que l'on doit aussi prendre le libellé local (ie : Deutsh pour l'allemand)
);
CREATE UNIQUE INDEX IF NOT EXISTS langue_code_unique ON langue (code);

CREATE TABLE IF NOT EXISTS pays (
    id integer primary key generated always as identity,
    code char(2) NOT NULL DEFAULT '',
    langue_id integer NULL,
    alpha_3 char(3) NOT NULL DEFAULT '',
    ar varchar(255) NOT NULL DEFAULT '',
    bg varchar(255) NOT NULL DEFAULT '',
    cs varchar(255) NOT NULL DEFAULT '',
    da varchar(255) NOT NULL DEFAULT '',
    de varchar(255) NOT NULL DEFAULT '',
    el varchar(255) NOT NULL DEFAULT '',
    en varchar(255) NOT NULL DEFAULT '',
    eo varchar(255) NOT NULL DEFAULT '',
    es varchar(255) NOT NULL DEFAULT '',
    et varchar(255) NOT NULL DEFAULT '',
    eu varchar(255) NOT NULL DEFAULT '',
    fi varchar(255) NOT NULL DEFAULT '',
    fr varchar(255) NOT NULL DEFAULT '',
    hu varchar(255) NOT NULL DEFAULT '',
    it varchar(255) NOT NULL DEFAULT '',
    ja varchar(255) NOT NULL DEFAULT '',
    ko varchar(255) NOT NULL DEFAULT '',
    lt varchar(255) NOT NULL DEFAULT '',
    nl varchar(255) NOT NULL DEFAULT '',
    no varchar(255) NOT NULL DEFAULT '',
    pl varchar(255) NOT NULL DEFAULT '',
    pt varchar(255) NOT NULL DEFAULT '',
    ro varchar(255) NOT NULL DEFAULT '',
    ru varchar(255) NOT NULL DEFAULT '',
    sk varchar(255) NOT NULL DEFAULT '',
    sv varchar(255) NOT NULL DEFAULT '',
    th varchar(255) NOT NULL DEFAULT '',
    uk varchar(255) NOT NULL DEFAULT '',
    zh varchar(255) NOT NULL DEFAULT '',
    "zh_tw" varchar(255) NOT NULL DEFAULT '',
    FOREIGN KEY (langue_id) REFERENCES langue (id)
);
CREATE UNIQUE INDEX IF NOT EXISTS pays_code_unique ON pays (code);

ALTER TABLE pays
    OWNER TO ADMIN;