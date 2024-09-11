-------------------------------------
-- Gestion de la configuration
------------------------------------
INSERT INTO unicaen_privilege_categorie (code, libelle, namespace, ordre)
VALUES ('configuration', 'Configuration', 'Application\Provider\Privilege', 5)
ON CONFLICT (id) DO
    UPDATE SET
               code=excluded.code,
               libelle=excluded.libelle,
               namespace=excluded.namespace,
               ordre=excluded.ordre;


WITH categorieConfiguration AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'configuration')
INSERT INTO unicaen_privilege_privilege (categorie_id, code, libelle, ordre)
SELECT c.id, 'configuration_index', 'Configuration Index', 1 FROM categorieConfiguration AS c;

WITH privilegeConfigurationIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'configuration_index')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 3, p.id FROM privilegeConfigurationIndex AS p;

WITH privilegeConfigurationIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'configuration_index')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 4, p.id FROM privilegeConfigurationIndex AS p;