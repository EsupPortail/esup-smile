---------------------------------------------------------
-- Gestions des utilisateurs des roles et des priviléges
---------------------------------------------------------
INSERT INTO unicaen_privilege_categorie (code, libelle, namespace, ordre)
VALUES
-- Paramétres de Smile (générique pour des action d'administration
('smile', 'Gestion des paramétres globaux de SMILE', 'Application\Provider\Privilege', 1),
--
('inscription', 'Gestion des inscriptions', 'Application\Provider\Privilege', 2),
-- Construction de l'offre de formation
('formation', 'Gestion de l''offre de formation', 'Application\Provider\Privilege', 3),
    ----------------------------------------------------------------------------------
    -- Priviléges en liens avec les librairie Unicaen, souvent de l'administration
    ----------------------------------------------------------------------------------
-- Unicaen Utilisateur / Privilége
('utilisateur', 'Gestion des utilisateurs', 'UnicaenUtilisateur\Provider\Privilege', 101),
('role', 'Gestion des rôles', 'UnicaenUtilisateur\Provider\Privilege', 102),
('privilege', 'Gestion des privilèges', 'UnicaenPrivilege\Provider\Privilege', 103),
-- UnicaenEvenement
('evenementetat', 'UnicaenEvenement - Gestion des états', 'UnicaenEvenement\Provider\Privilege', 104),
('evenementtype', 'UnicaenEvenement - Gestion des types', 'UnicaenEvenement\Provider\Privilege', 105),
('evenementinstance', 'UnicaenEvenement - Gestion des instances', 'UnicaenEvenement\Provider\Privilege', 106),
-- UnicaenMail
('mail', 'Gestion des mails', 'UnicaenMail\Provider\Privilege', 107),
-- UnicaenRenderer
('documentmacro', 'UnicaenRenderer - Gestion des macros', 'UnicaenRenderer\Provider\Privilege', 102),
('documenttemplate', 'UnicaenRenderer - Gestion des templates', 'UnicaenRenderer\Provider\Privilege', 109),
('documentcontenu', 'UnicaenRenderer - Gestion des contenue', 'UnicaenRenderer\Provider\Privilege', 110),
-- Unicaen DB Import
('unicaen-db-import', 'Gestion de l''importation des données', 'UnicaenDbImport\Privilege', 111),
('authenticate', 'Authenticate Shibb', 'Application\Provider\Privilege', 2)
ON CONFLICT (code) DO
UPDATE SET
libelle=excluded.libelle,
namespace=excluded.namespace,
ordre=excluded.ordre;

------------------------------
-- Définition des priviléges
------------------------------
WITH
categorieSMILE AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'smile'),
categorieInscription AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'inscription'),
categorieFormation AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'formation'),
categorieUtilisateur AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'utilisateur'),
categorieRole AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'role'),
categoriePrivilege AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'privilege'),
categorieEvenementEtat AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'evenementetat'),
categorieEvenementType AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'evenementtype'),
categorieEvenementInstance AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'evenementinstance'),
categorieMail AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'mail'),
categorieDocumentMacro AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'documentmacro'),
categorieDocumentTemplate AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'documenttemplate'),
categorieDocumentContenue AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'documentcontenu'),
categorieImport AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'unicaen-db-import'),
categorieAuthenticate AS (SELECT id FROM unicaen_privilege_categorie WHERE code = 'authenticate')
INSERT INTO unicaen_privilege_privilege (categorie_id, code, libelle, ordre)
VALUES
-- Application
((select c.id from categorieSMILE c), 'source_afficher', 'Afficher la source des données', 1),
-- Inscription
((select c.id from categorieInscription c), 'inscription_index', 'Accès aux inscriptions', 1),
-- Formation
((select c.id from categorieFormation c), 'formation_index', 'Acces à l''offre de formation', 1),
((select c.id from categorieFormation c), 'formation_afficher',         'Afficher les formations', 11),
((select c.id from categorieFormation c), 'formation_ajouter',          'Ajouter une formation', 12),
((select c.id from categorieFormation c), 'formation_modifier',         'Modifier une formation', 13),
((select c.id from categorieFormation c), 'formation_supprimer',        'Supprimer une formation', 14),
((select c.id from categorieFormation c), 'formation_mobilite',        'Gestion mobilite', 15),
((select c.id from categorieFormation c), 'parametre_afficher',        'Afficher les paramétres des formations', 21),
((select c.id from categorieFormation c), 'parametre_modifier',        'Modifier les paramétres des formations', 22),

((select c.id from categorieFormation c), 'composante_afficher',   'Afficher les composantes', 31),
((select c.id from categorieFormation c), 'composante_ajouter',    'Ajouter une composante', 32),
((select c.id from categorieFormation c), 'composante_modifier',   'Modifier une composante', 33),
((select c.id from categorieFormation c), 'composante_supprimer',  'Supprimer une composante', 34),
-- utilisateur / Priviléges
((select c.id from categorieUtilisateur c), 'utilisateur_afficher', 'Consulter un utilisateur', 1),
((select c.id from categorieUtilisateur c), 'utilisateur_ajouter', 'Ajouter un utilisateur', 2),
((select c.id from categorieUtilisateur c), 'utilisateur_changerstatus', 'Changer le statut d''un utilisateur', 3),
((select c.id from categorieUtilisateur c), 'utilisateur_modifierrole', 'Modifier les rôles attribués à un utilisateur', 4),
--
((select c.id from categorieRole c), 'role_afficher', 'Consulter les rôles', 11),
((select c.id from categorieRole c), 'role_modifier', 'Modifier un rôle', 12),
((select c.id from categorieRole c), 'role_effacer', 'Supprimer un rôle', 13),
--
((select c.id from categoriePrivilege c), 'privilege_voir', 'Afficher les privilèges', 21),
((select c.id from categoriePrivilege c), 'privilege_ajouter', 'Ajouter un privilège', 22),
((select c.id from categoriePrivilege c), 'privilege_modifier', 'Modifier un privilège', 23),
((select c.id from categoriePrivilege c), 'privilege_supprimer', 'Supprimer un privilège', 24),
((select c.id from categoriePrivilege c), 'privilege_affecter', 'Attribuer un privilège', 25),
-- Evenements
((select c.id from categorieEvenementEtat c), 'etat_consultation', 'État - Visualiser les états', 1),
((select c.id from categorieEvenementEtat c), 'etat_ajout', 'État - Ajouter un état', 2),
((select c.id from categorieEvenementEtat c), 'etat_edition', 'État - Modifier un état', 3),
((select c.id from categorieEvenementEtat c), 'etat_suppression', 'État - Supprimer un état', 4),
--
((select c.id from categorieEvenementType c), 'type_consultation', 'Type - Visualiser les types', 11),
((select c.id from categorieEvenementType c), 'type_ajout', 'Type - Ajouter un type', 12),
((select c.id from categorieEvenementType c), 'type_edition', 'Type - Modifier un type', 13),
((select c.id from categorieEvenementType c), 'type_suppression', 'Type - Supprimer un type', 14),
--
((select c.id from categorieEvenementInstance c), 'instance_consultation', 'Instance - Visualiser les instances', 11),
((select c.id from categorieEvenementInstance c), 'instance_ajout', 'Instance - Ajouter une instance', 12),
((select c.id from categorieEvenementInstance c), 'instance_edition', 'Instance - Modifier une instance', 13),
((select c.id from categorieEvenementInstance c), 'instance_suppression', 'Instance - Supprimer une instance', 14),
((select c.id from categorieEvenementInstance c), 'instance_traitement', 'Instance - Traiter les instances en attente', 15),
-- mail
((select c.id from categorieMail c), 'mail_index', 'Affichage de l''index', 1),
((select c.id from categorieMail c), 'mail_afficher', 'Afficher un mail', 2),
((select c.id from categorieMail c), 'mail_reenvoi', 'Ré-envoi d''un mail', 3),
((select c.id from categorieMail c), 'mail_supprimer', 'Suppression d''un mail', 4),
((select c.id from categorieMail c), 'mail_test', 'Envoi d''un mail de test', 5),
-- Documents
((select c.id from categorieDocumentMacro c), 'documentmacro_index', 'Afficher l''index des macros', 1),
((select c.id from categorieDocumentMacro c), 'documentmacro_ajouter', 'Ajouter une macro', 2),
((select c.id from categorieDocumentMacro c), 'documentmacro_modifier', 'Modifier une macro', 3),
((select c.id from categorieDocumentMacro c), 'documentmacro_supprimer', 'Supprimer une macro', 4),
((select c.id from categorieDocumentTemplate c), 'documenttemplate_index', 'Afficher l''index des template', 11),
((select c.id from categorieDocumentTemplate c), 'documenttemplate_afficher', 'Afficher un template', 12),
((select c.id from categorieDocumentTemplate c), 'documenttemplate_ajouter', 'Ajouter un template', 13),
((select c.id from categorieDocumentTemplate c), 'documenttemplate_modifier', 'Modifier un template', 14),
((select c.id from categorieDocumentTemplate c), 'documenttemplate_supprimer', 'Supprimer un template', 15),
((select c.id from categorieDocumentContenue c), 'documentcontenu_index', 'Accès à l''index des contenus', 21),
((select c.id from categorieDocumentContenue c), 'documentcontenu_afficher', 'Afficher un contenu', 22),
((select c.id from categorieDocumentContenue c), 'documentcontenu_supprimer', 'Supprimer un contenu', 23),
-- unicaen-db-import
((select c.id from categorieImport c), 'import-lister', 'Lister les import', 1),
((select c.id from categorieImport c), 'import-consulter', 'Consulter les import', 2),
((select c.id from categorieImport c), 'import-lancer', 'Executer un import', 3),
((select c.id from categorieImport c), 'synchro-lister', 'Lister les synchros', 11),
((select c.id from categorieImport c), 'synchro-consulter', 'Consulter les synchros', 12),
((select c.id from categorieImport c), 'synchro-lancer', 'Executer une synchronisation', 13),
((select c.id from categorieImport c), 'log-lister', 'Lister les logs des imports', 21),
((select c.id from categorieImport c), 'log-consulter', 'Consulter un log d''import', 22),
-- authenticate
((select c.id from categorieAuthenticate c), 'authenticate_index', 'Authentication Shibb', 1),
-- TODO : a revoir, le système d'observation, requis pour l'import
((select c.id from categorieImport c), 'observation-lister', 'Lister les observations d''import',31),
((select c.id from categorieImport c), 'observation-consulter-resultat', 'Consulter une observations d''import', 32),
((select c.id from categorieImport c), 'observation-synchro-lister', 'Lister les observation de synchronisation', 33),
((select c.id from categorieImport c), 'observation-synchro-consulter', 'Consulter les observation de synchronisation', 34),
((select c.id from categorieImport c), 'observation-synchro-lancer', '', 35)
---
ON CONFLICT (categorie_id, code) DO
UPDATE SET
    libelle=excluded.libelle,
    ordre=excluded.ordre;

-------------------------------------------
-- Affectations des priviéges par défauts
-------------------------------------------
--- 1) l'administrateur : tout les priviléges (a voir si besoins d'en exclure)
WITH roleAdmin AS (SELECT id FROM unicaen_utilisateur_role WHERE role_id in ('administrateur'))
,privileges AS (SELECT p.id FROM unicaen_privilege_privilege p)
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id) (
    SELECT r.id, p.id
    FROM privileges p, roleAdmin r
) ON CONFLICT DO NOTHING;
--- 2) SuperGestionnaire : Non accés aux priviéges qui touche a du code (création de privilége ...)
-- Non accés a certains autres privilége
WITH roleSuperGestionnaire AS (SELECT id FROM unicaen_utilisateur_role WHERE role_id in ('admin_fonctionnel'))
   ,privileges AS (SELECT p.id FROM unicaen_privilege_privilege p
    JOIN unicaen_privilege_categorie c on p.categorie_id = c.id
    where
      -- Cas particulier : roles et priviléges
        (p.code not like 'role_modifier')
        and (p.code not like 'role_effacer')
        and (p.code not like 'privilege_ajouter')
        and (p.code not like 'privilege_modifier')
        and (p.code not like 'privilege_supprimer')
      -- Macro que pour l'admin car implique des besoins de toucher au codes derriéres
        and (p.code not like 'documentmacro_ajouter')
        and (p.code not like 'documentmacro_modifier')
        and (p.code not like 'documentmacro_supprimer')
      -- Evenement a voir, a priori que l'admin
      and (c.code not like 'evenement%')
      -- Import a voir, a priori que l'admin
        and (c.code not like 'unicaen-db-import')
      -- Mail a voir pour le moment que l'admin
        and (c.code not like 'mail')
    )
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id) (
    SELECT r.id, p.id
    FROM privileges p, roleSuperGestionnaire r
) ON CONFLICT DO NOTHING;

--- 3) Gestionnaire : Mode restint pour la partie Administration :
WITH roleGestionnaire AS (SELECT id FROM unicaen_utilisateur_role WHERE role_id in ('gestionnaire'))
   ,privileges AS (SELECT p.id FROM unicaen_privilege_privilege p
                                        JOIN unicaen_privilege_categorie c on p.categorie_id = c.id
                   where (c.code in ('smile', 'inscription', 'formation', 'authenticate'))
)
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id) (
    SELECT r.id, p.id
    FROM privileges p, roleGestionnaire r
) ON CONFLICT DO NOTHING;

--- 4) Standard : a voir pour le momment uniquement aux liste (devra être remplacer par le fait de pouvoir gérer sa fiche ...)
WITH roleGestionnaire AS (SELECT id FROM unicaen_utilisateur_role WHERE role_id in ('Standard'))
   ,privileges AS (SELECT p.id FROM unicaen_privilege_privilege p
                                        JOIN unicaen_privilege_categorie c on p.categorie_id = c.id
                   where (p.code in ('inscription_index', 'authenticate_index'))
--                    where (p.code in ('formation_index', 'formation_afficher', 'inscription_index', 'composante_afficher'))
)
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id) (
    SELECT r.id, p.id
    FROM privileges p, roleGestionnaire r
) ON CONFLICT DO NOTHING;

--- 5) guest : accueil et inscription
WITH roleGestionnaire AS (SELECT id FROM unicaen_utilisateur_role WHERE role_id in ('guest'))
   ,privileges AS (SELECT p.id FROM unicaen_privilege_privilege p
                                        JOIN unicaen_privilege_categorie c on p.categorie_id = c.id
                   where (p.code in ('inscription_index', 'authenticate_index'))
)
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id) (
    SELECT r.id, p.id
    FROM privileges p, roleGestionnaire r
) ON CONFLICT DO NOTHING;

--- 6) Etudiant
WITH roleGestionnaire AS (SELECT id FROM unicaen_utilisateur_role WHERE role_id in ('Etudiant'))
   ,privileges AS (SELECT p.id FROM unicaen_privilege_privilege p
                                        JOIN unicaen_privilege_categorie c on p.categorie_id = c.id
                   where (p.code in ('authenticate_index'))
--                    where (p.code in ('formation_index', 'formation_afficher', 'inscription_index', 'composante_afficher'))
)
INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id) (
    SELECT r.id, p.id
    FROM privileges p, roleGestionnaire r
) ON CONFLICT DO NOTHING;