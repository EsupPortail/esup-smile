---------- Data
INSERT INTO source (code, libelle, importable)
VALUES ('smile', 'SMILE', false), ('pyc', 'Pick-Your-Courses', true)
    ON CONFLICT (code)
DO UPDATE SET
    libelle=excluded.libelle,
    importable=excluded.importable;

