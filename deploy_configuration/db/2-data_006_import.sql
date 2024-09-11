---------- Data
INSERT INTO source (code, libelle, importable)
VALUES ('smile', 'SMILE', false), ('api', 'Smile API', true), ('csv', 'CSV', true)
    ON CONFLICT (code)
DO UPDATE SET
    libelle=excluded.libelle,
    importable=excluded.importable;

