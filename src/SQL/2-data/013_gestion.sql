-------------------------------------
-- Gestion des inscriptions
------------------------------------
INSERT INTO unicaen_privilege_categorie (code, libelle, namespace, ordre)
VALUES ('gestion', 'Espace gestionnaire', 'Application\Provider\Privilege', 5)
ON CONFLICT (id) DO
    UPDATE SET
               code=excluded.code,
               libelle=excluded.libelle,
               namespace=excluded.namespace,
               ordre=excluded.ordre;


WITH categorieGestion AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'gestion')
INSERT INTO unicaen_privilege_privilege (categorie_id, code, libelle, ordre)
SELECT c.id, 'gestion_index', 'Espace gestionnaire', 1 FROM categorieGestion AS c;
WITH categorieGestion AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'gestion')
INSERT INTO unicaen_privilege_privilege (categorie_id, code, libelle, ordre)
SELECT c.id, 'gestion_generate', '[DEV] Génére des faux étudiants', 1 FROM categorieGestion AS c;
WITH categorieGestion AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'gestion')
INSERT INTO unicaen_privilege_privilege (categorie_id, code, libelle, ordre)
SELECT c.id, 'gestion_view', 'Vue et interaction avec les inscriptions', 1 FROM categorieGestion AS c;

WITH privilegeGestionIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'gestion_index')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 2, p.id FROM privilegeGestionIndex AS p;

WITH privilegeGestionIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'gestion_index')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 4, p.id FROM privilegeGestionIndex AS p;

WITH privilegeGestionIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'gestion_index')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 3, p.id FROM privilegeGestionIndex AS p;


WITH privilegeGestionIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'gestion_view')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 2, p.id FROM privilegeGestionIndex AS p;

WITH privilegeGestionIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'gestion_view')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 4, p.id FROM privilegeGestionIndex AS p;

WITH privilegeGestionIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'gestion_view')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 3, p.id FROM privilegeGestionIndex AS p;


WITH privilegeGestionIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'gestion_generate')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 2, p.id FROM privilegeGestionIndex AS p;

WITH privilegeGestionIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'gestion_generate')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 4, p.id FROM privilegeGestionIndex AS p;

WITH privilegeGestionIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'gestion_generate')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 3, p.id FROM privilegeGestionIndex AS p;