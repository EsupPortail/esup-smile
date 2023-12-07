-- Missing column
ALTER TABLE unicaen_evenement_instance
    ADD mots_clefs VARCHAR;

-- Import privileges
INSERT INTO unicaen_privilege_categorie (code, libelle, namespace, ordre)
VALUES
    ('import', 'Gestion de l''importation des données', 'Import\Provider\Privilege', 112);

WITH categorieMyImport AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'import')
INSERT INTO unicaen_privilege_privilege (categorie_id, code, libelle, ordre)
VALUES
((select c.id from categorieMyImport c), 'import_index', 'Gérer', 1);

WITH privilegeImportIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'import_index')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
SELECT 4, p.id FROM privilegeImportIndex AS p;

-- EGRACON missing privileges
WITH privilegeEgraconIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'unicaenegracon_index')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
VALUES
    (4, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (3, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (2, (SELECT p.id FROM privilegeEgraconIndex AS p));
WITH privilegeEgraconIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'unicaenegracon_conversions')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
VALUES
    (4, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (3, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (2, (SELECT p.id FROM privilegeEgraconIndex AS p));
WITH privilegeEgraconIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'unicaenegracon_bacasable')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
VALUES
    (4, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (3, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (2, (SELECT p.id FROM privilegeEgraconIndex AS p));
WITH privilegeEgraconIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'unicaenegraconpays_index')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
VALUES
    (4, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (3, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (2, (SELECT p.id FROM privilegeEgraconIndex AS p));
WITH privilegeEgraconIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'unicaenegraconpays_afficher')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
VALUES
    (4, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (3, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (2, (SELECT p.id FROM privilegeEgraconIndex AS p));
WITH privilegeEgraconIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'unicaenegraconpays_ajouter')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
VALUES
    (4, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (3, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (2, (SELECT p.id FROM privilegeEgraconIndex AS p));
WITH privilegeEgraconIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'unicaenegraconpays_modifier')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
VALUES
    (4, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (3, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (2, (SELECT p.id FROM privilegeEgraconIndex AS p));
WITH privilegeEgraconIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'unicaenegraconpays_supprimer')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
VALUES
    (4, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (3, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (2, (SELECT p.id FROM privilegeEgraconIndex AS p));
WITH privilegeEgraconIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'unicaenegraconnote_index')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
VALUES
    (4, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (3, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (2, (SELECT p.id FROM privilegeEgraconIndex AS p));
WITH privilegeEgraconIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'unicaenegraconnote_afficher')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
VALUES
    (4, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (3, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (2, (SELECT p.id FROM privilegeEgraconIndex AS p));
WITH privilegeEgraconIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'unicaenegraconnote_ajouter')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
VALUES
    (4, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (3, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (2, (SELECT p.id FROM privilegeEgraconIndex AS p));
WITH privilegeEgraconIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'unicaenegraconnote_modifier')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
VALUES
    (4, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (3, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (2, (SELECT p.id FROM privilegeEgraconIndex AS p));
WITH privilegeEgraconIndex AS (SELECT id FROM unicaen_privilege_privilege WHERE code = 'unicaenegraconnote_supprimer')
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id)
VALUES
    (4, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (3, (SELECT p.id FROM privilegeEgraconIndex AS p)),
    (2, (SELECT p.id FROM privilegeEgraconIndex AS p));


-- Parametre privileges
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

-- Step
ALTER TABLE step
    ADD COLUMN movable bool NULL,
    ADD COLUMN fixed bool NULL,
    ADD COLUMN deletable bool NULL;

-- Composante
CREATE TABLE IF NOT EXISTS composante_groupe
(
    id BIGSERIAL PRIMARY KEY,
    libelle VARCHAR(120)
);

ALTER TABLE composante
    ADD COLUMN groupe_id BIGINT NULL,
    ADD CONSTRAINT composante_groupe__fk
        FOREIGN KEY (groupe_id) references composante_groupe;

CREATE TABLE IF NOT EXISTS composante_groupe_role_utilisateur
(
    id BIGSERIAL PRIMARY KEY,
    composante_groupe_id BIGINT NOT NULL,
    utilisateur_id BIGINT NOT NULL,
    role_id BIGINT NOT NULL,
    FOREIGN KEY (composante_groupe_id) REFERENCES composante_groupe (id) on delete cascade,
    FOREIGN KEY (utilisateur_id) REFERENCES unicaen_utilisateur_user (id) on delete cascade,
    FOREIGN KEY (role_id) REFERENCES unicaen_utilisateur_role (id) on delete cascade
);