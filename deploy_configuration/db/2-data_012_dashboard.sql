-------------------------------------
-- Gestion des inscriptions
------------------------------------
INSERT INTO unicaen_privilege_categorie (code, libelle, namespace, ordre)
VALUES ('dashboard', 'Gestion du Dashboard', 'Application\Provider\Privilege', 5)
ON CONFLICT (id) DO
    UPDATE SET
               code=excluded.code,
               libelle=excluded.libelle,
               namespace=excluded.namespace,
               ordre=excluded.ordre;


WITH categorieInscription AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'dashboard')
INSERT INTO unicaen_privilege_privilege (categorie_id, code, libelle, ordre)
SELECT c.id, 'dashboard_index', 'Accès au dashboard', 1 FROM categorieInscription AS c;

WITH categorieInscription AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'dashboard')
INSERT INTO unicaen_privilege_privilege (categorie_id, code, libelle, ordre)
SELECT c.id, 'dashboard_courses', 'Accès à la sélection des cours', 2 FROM categorieInscription AS c;

WITH privilegeInscriptionIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'dashboard_index')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 6, p.id FROM privilegeInscriptionIndex AS p;

WITH privilegeInscriptionIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'dashboard_index')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 4, p.id FROM privilegeInscriptionIndex AS p;

WITH privilegeInscriptionIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'dashboard_index')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 3, p.id FROM privilegeInscriptionIndex AS p;

-- SELECTION DES COURSES
WITH privilegeInscriptionIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'dashboard_courses')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 1, p.id FROM privilegeInscriptionIndex AS p;
WITH privilegeInscriptionIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'dashboard_courses')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 2, p.id FROM privilegeInscriptionIndex AS p;
WITH privilegeInscriptionIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'dashboard_courses')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 3, p.id FROM privilegeInscriptionIndex AS p;
WITH privilegeInscriptionIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'dashboard_courses')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 4, p.id FROM privilegeInscriptionIndex AS p;
WITH privilegeInscriptionIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'dashboard_courses')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 5, p.id FROM privilegeInscriptionIndex AS p;
WITH privilegeInscriptionIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'dashboard_courses')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 6, p.id FROM privilegeInscriptionIndex AS p;
WITH privilegeInscriptionIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'dashboard_courses')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 7, p.id FROM privilegeInscriptionIndex AS p;