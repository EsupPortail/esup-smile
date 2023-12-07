

INSERT INTO public.unicaen_parametre_categorie (id, code, libelle, description, ordre) VALUES (2, 'global', 'Global', null, 2);
INSERT INTO public.unicaen_parametre_categorie (id, code, libelle, description, ordre) VALUES (3, 'ects', 'ECTS', null, 3);
INSERT INTO public.unicaen_parametre_categorie (id, code, libelle, description, ordre) VALUES (1, 'contenu', 'Contenu', '<p>Tout le contenu, image, texte, etc</p>', 2);

INSERT INTO public.unicaen_parametre_parametre (id, categorie_id, code, libelle, description, valeurs_possibles, valeur, ordre) VALUES (3, 1, 'color-1', 'Couleur Principale', '<p>Couleur principale de votre DA (nom, hexadecimal, rgb)</p>
<p>&nbsp;</p>', 'String', 'yellow', 3);
INSERT INTO public.unicaen_parametre_parametre (id, categorie_id, code, libelle, description, valeurs_possibles, valeur, ordre) VALUES (5, 3, 'max', 'max', null, 'Number', null, 2);
INSERT INTO public.unicaen_parametre_parametre (id, categorie_id, code, libelle, description, valeurs_possibles, valeur, ordre) VALUES (4, 3, 'min', 'min', null, 'Number', '45', 1);
INSERT INTO public.unicaen_parametre_parametre (id, categorie_id, code, libelle, description, valeurs_possibles, valeur, ordre) VALUES (6, 3, 'ratio', 'ratio', '<p>Ratio de la composante principale requis en pourcentage</p>', 'Number', '50', 3);
INSERT INTO public.unicaen_parametre_parametre (id, categorie_id, code, libelle, description, valeurs_possibles, valeur, ordre) VALUES (1, 1, 'logo', 'logo', null, 'String', 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f9/Universit%C3%A9_de_Strasbourg.svg/800px-Universit%C3%A9_de_Strasbourg.svg.png', 1);
INSERT INTO public.unicaen_parametre_parametre (id, categorie_id, code, libelle, description, valeurs_possibles, valeur, ordre) VALUES (2, 1, 'url-institution', 'Url Institution', '<p>Site web de l''universit&eacute;</p>', 'String', 'https://unistra.fr/', 2);


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