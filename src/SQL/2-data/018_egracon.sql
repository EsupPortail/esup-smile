INSERT INTO unicaen_privilege_categorie (code, libelle, ordre, namespace)
VALUES ('unicaenegracon','Egracon - Gestion du module',10000,'UnicaenEgracon\Provider\Privilege');
INSERT INTO unicaen_privilege_privilege(CATEGORIE_ID, CODE, LIBELLE, ORDRE)
WITH d(code, lib, ordre) AS (
    SELECT 'unicaenegracon_index', 'Accéder à la fiche descriptive', 10 UNION
    SELECT 'unicaenegracon_conversions', 'Accéder à la table de conversion', 20 UNION
    SELECT 'unicaenegracon_bacasable', 'Accéder au bac à sable', 30
)
SELECT cp.id, d.code, d.lib, d.ordre
FROM d
JOIN unicaen_privilege_categorie cp ON cp.CODE = 'unicaenegracon';

INSERT INTO unicaen_privilege_categorie (code, libelle, ordre, namespace)
VALUES ('unicaenegraconpays', 'Egracon - Gestion des pays', 10100, 'UnicaenEgracon\Provider\Privilege');
INSERT INTO unicaen_privilege_privilege(CATEGORIE_ID, CODE, LIBELLE, ORDRE)
WITH d(code, lib, ordre) AS (
    SELECT 'unicaenegraconpays_index', 'Accéder à l''index', 10 UNION
    SELECT 'unicaenegraconpays_afficher', 'Afficher', 20 UNION
    SELECT 'unicaenegraconpays_ajouter', 'Ajouter', 30 UNION
    SELECT 'unicaenegraconpays_modifier', 'Modifier', 40 UNION
    SELECT 'unicaenegraconpays_supprimer', 'Supprimer', 50
)
SELECT cp.id, d.code, d.lib, d.ordre
FROM d
JOIN unicaen_privilege_categorie cp ON cp.CODE = 'unicaenegraconpays';

INSERT INTO unicaen_privilege_categorie (code, libelle, ordre, namespace)
VALUES ('unicaenegraconnote', 'Egracon - Gestion des notes', 10200, 'UnicaenEgracon\Provider\Privilege');
INSERT INTO unicaen_privilege_privilege(CATEGORIE_ID, CODE, LIBELLE, ORDRE)
WITH d(code, lib, ordre) AS (
    SELECT 'unicaenegraconnote_index', 'Accéder à l''index', 10 UNION
    SELECT 'unicaenegraconnote_afficher', 'Afficher', 20 UNION
    SELECT 'unicaenegraconnote_ajouter', 'Ajouter', 30 UNION
    SELECT 'unicaenegraconnote_modifier', 'Modifier', 40 UNION
    SELECT 'unicaenegraconnote_supprimer', 'Supprimer', 50
)
SELECT cp.id, d.code, d.lib, d.ordre
FROM d
JOIN unicaen_privilege_categorie cp ON cp.CODE = 'unicaenegraconnote';

INSERT INTO unicaen_egracon_pays (id, libelle, code) VALUES (4, 'Europe (ECTS)', 'ECTS');
INSERT INTO unicaen_egracon_pays (id, libelle, code) VALUES (5, 'France', 'FR');
INSERT INTO unicaen_egracon_pays (id, libelle, code) VALUES (6, 'Allemagne', 'DE');
INSERT INTO unicaen_egracon_pays (id, libelle, code) VALUES (7, 'Turquie', 'TR');
INSERT INTO unicaen_egracon_pays (id, libelle, code) VALUES (8, 'Italie', 'IT');

INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (11, 5, '16', '20', null, null);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (12, 4, 'F', 'F', 'Insufficient', 3);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (13, 4, 'E', 'E', 'Sufficient', 5);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (14, 4, 'D', 'D', 'Satisfactory', 6);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (3, 5, '0', '9.99', null, null);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (5, 5, '10', '10.99', null, null);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (6, 5, '11', '11.99', null, null);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (15, 4, 'C', 'C', 'Good', 7);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (16, 4, 'C', 'C', 'Good', 8);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (7, 5, '12', '12.99', null, null);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (8, 5, '13', '13.99', null, null);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (17, 4, 'B', 'B', 'Very good', 9);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (9, 5, '14', '14.99', null, null);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (10, 5, '15', '15.99', null, null);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (18, 4, 'B', 'B', 'Very good', 10);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (19, 4, 'A', 'A', 'Excellent', 11);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (20, 7, '0', '59', 'FF-FD', 3);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (21, 7, '60', '64', 'DD', 5);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (22, 7, '65', '69', 'DC', 6);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (23, 7, '70', '74', 'CC', 7);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (24, 7, '75', '79', 'CB', 8);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (26, 7, '85', '89', 'BA', 10);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (27, 7, '90', '100', 'AA', 11);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (25, 7, '80', '84', 'BB', 9);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (28, 6, '5.0', '4.0', 'Mangelhaft', 3);
INSERT INTO unicaen_egracon_note (id, pays_id, valeur_basse, valeur_haute, description, reference_id) VALUES (29, 6, '1.5', '1', 'Sehr Gut', 11);

