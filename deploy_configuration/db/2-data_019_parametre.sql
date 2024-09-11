
INSERT INTO unicaen_parametre_categorie (id, code, libelle, description, ordre) VALUES (3, 'ects', 'ECTS', null, 3);
INSERT INTO unicaen_parametre_categorie (id, code, libelle, description, ordre) VALUES (1, 'contenu', 'Contenu', '<p>Tout le contenu, image, texte, etc</p>', 2);

INSERT INTO unicaen_parametre_parametre (id, categorie_id, code, libelle, description, valeurs_possibles, valeur, ordre) VALUES (5, 3, 'max', 'max', null, 'Number', null, 2);
INSERT INTO unicaen_parametre_parametre (id, categorie_id, code, libelle, description, valeurs_possibles, valeur, ordre) VALUES (4, 3, 'min', 'min', null, 'Number', '45', 1);
INSERT INTO unicaen_parametre_parametre (id, categorie_id, code, libelle, description, valeurs_possibles, valeur, ordre) VALUES (6, 3, 'ratio', 'ratio', '<p>Ratio de la composante principale requis en pourcentage</p>', 'Number', '50', 3);
INSERT INTO unicaen_parametre_parametre (id, categorie_id, code, libelle, description, valeurs_possibles, valeur, ordre) VALUES (1, 1, 'logo', 'logo', null, 'String', 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f9/Universit%C3%A9_de_Strasbourg.svg/800px-Universit%C3%A9_de_Strasbourg.svg.png', 1);
INSERT INTO unicaen_parametre_parametre (id, categorie_id, code, libelle, description, valeurs_possibles, valeur, ordre) VALUES (2, 1, 'url-institution', 'Url Institution', '<p>Site web de l''universit&eacute;</p>', 'String', 'https://unistra.fr/', 2);

-- PRIVILEGES ----------------------------------------------------------------------------------------------------------

INSERT INTO unicaen_privilege_categorie (code, libelle, ordre, namespace) VALUES ('parametrecategorie', 'UnicaenParametre - Gestion des catégories de paramètres', 70000, 'UnicaenParametre\Provider\Privilege');
WITH privilegeParametreCategorie AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'parametrecategorie')
INSERT INTO unicaen_privilege_privilege (categorie_id, code, libelle, ordre)
       VALUES
((SELECT p.id FROM privilegeParametreCategorie AS p), 'parametrecategorie_index', 'Affichage de l''index des paramètres', 10),
((SELECT p.id FROM privilegeParametreCategorie AS p), 'parametrecategorie_modifier', 'Modifier une catégorie de paramètre', 40),
((SELECT p.id FROM privilegeParametreCategorie AS p), 'parametrecategorie_ajouter', 'Ajouter une catégorie de paramètre', 30),
((SELECT p.id FROM privilegeParametreCategorie AS p), 'parametrecategorie_supprimer', 'Supprimer une catégorie de paramètre', 60),
((SELECT p.id FROM privilegeParametreCategorie AS p), 'parametrecategorie_afficher', 'Affichage des détails d''une catégorie', 20);

INSERT INTO unicaen_privilege_categorie (code, libelle, ordre, namespace) VALUES ('parametre', 'UnicaenParametre - Gestion des paramètres', 70001, 'UnicaenParametre\Provider\Privilege');
WITH privilegeParametreC AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'parametre')
INSERT INTO unicaen_privilege_privilege (categorie_id, code, libelle, ordre)
    VALUES
((SELECT p.id FROM privilegeParametreC AS p), 'parametre_afficher', 'Afficher un paramètre', 10),
((SELECT p.id FROM privilegeParametreC AS p), 'parametre_ajouter', 'Ajouter un paramètre', 20),
((SELECT p.id FROM privilegeParametreC AS p), 'parametre_modifier', 'Modifier un paramètre', 30),
((SELECT p.id FROM privilegeParametreC AS p), 'parametre_supprimer', 'Supprimer un paramètre', 50),
((SELECT p.id FROM privilegeParametreC AS p), 'parametre_valeur', 'Modifier la valeur d''un parametre', 100);

WITH privilegeParametreIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'parametrecategorie_index')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 4, p.id FROM privilegeParametreIndex AS p;
WITH privilegeParametreIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'parametrecategorie_index')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 3, p.id FROM privilegeParametreIndex AS p;

WITH privilegeParametreIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'parametrecategorie_afficher')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 4, p.id FROM privilegeParametreIndex AS p;
WITH privilegeParametreIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'parametrecategorie_afficher')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 3, p.id FROM privilegeParametreIndex AS p;

WITH privilegeParametreIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'parametrecategorie_ajouter')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 4, p.id FROM privilegeParametreIndex AS p;
WITH privilegeParametreIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'parametrecategorie_ajouter')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 3, p.id FROM privilegeParametreIndex AS p;

WITH privilegeParametreIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = ' 	parametrecategorie_modifier')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 4, p.id FROM privilegeParametreIndex AS p;
WITH privilegeParametreIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = ' 	parametrecategorie_modifier')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 3, p.id FROM privilegeParametreIndex AS p;

WITH privilegeParametreIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = ' 	parametrecategorie_supprimer')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 4, p.id FROM privilegeParametreIndex AS p;
WITH privilegeParametreIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = ' 	parametrecategorie_supprimer')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 3, p.id FROM privilegeParametreIndex AS p;