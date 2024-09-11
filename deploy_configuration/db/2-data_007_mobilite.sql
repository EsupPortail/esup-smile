-------------------------------------
-- Gestion des Mobilites
------------------------------------
-- Probablement une table temporaire, les données seront surement fournis par APOGEE/PEGASE
INSERT INTO mobilite (libelle)
VALUES  ('Ecoles d''été | Summer Schools'),
        ('Erasmus');

INSERT INTO unicaen_privilege_categorie (code, libelle, namespace, ordre)
VALUES ('mobilite', 'Mobilite', 'Application\Provider\Privilege', 12)
ON CONFLICT (id) DO
    UPDATE SET
               code=excluded.code,
               libelle=excluded.libelle,
               namespace=excluded.namespace,
               ordre=excluded.ordre;


WITH categorieMobilite AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'mobilite')
INSERT INTO unicaen_privilege_privilege (categorie_id, code, libelle, ordre)
SELECT c.id, 'mobilite_index', 'Gestion de la mobilite', 1 FROM categorieMobilite AS c;

WITH privilegeMobiliteIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'mobilite_index')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 3, p.id FROM privilegeMobiliteIndex AS p;

WITH privilegeMobiliteIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'mobilite_index')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 4, p.id FROM privilegeMobiliteIndex AS p;