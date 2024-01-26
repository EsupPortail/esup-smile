CREATE TABLE calendar
(
    id serial NOT NULL PRIMARY KEY,
    year int NOT NULL UNIQUE,
    libelle varchar(255) NOT NULL
);

CREATE TABLE period
(
    id serial NOT NULL PRIMARY KEY,
    start_date date NOT NULL,
    end_date date NOT NULL,
    year_id int NOT NULL,
    disabled_inscription boolean NOT NULL DEFAULT false,
    CONSTRAINT check_dates CHECK (start_date <= end_date),
    CONSTRAINT year_fk FOREIGN KEY (year_id) REFERENCES calendar (id)
);

CREATE UNIQUE INDEX calendar_id_uindex
    ON calendar (id);

CREATE UNIQUE INDEX period_id_uindex
    ON period (id);