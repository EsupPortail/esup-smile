-- Roles de base
INSERT INTO UNICAEN_UTILISATEUR_ROLE (id, role_id, libelle, is_default, parent_id)
VALUES (1, 'Standard', 'Standard', true, NULL),
       (2, 'gestionnaire', 'Gestionnaire', false, 1),
       (3, 'admin_fonctionnel', 'Administrateur fonctionnel', false, 2),
       (4, 'administrateur', 'Administrateur technique', false, 3),
       (5, 'guest', 'Invité', false, NULL),
       (6, 'Etudiant', 'Etudiant', false, 1),
       (7, 'Stagiaire', 'Stagiaire', false, 1)
ON CONFLICT (id) DO UPDATE SET
                               role_id=excluded.role_id,
                               libelle=excluded.libelle,
                               is_default=excluded.is_default,
                               parent_id=excluded.parent_id;

-- Pour être sur de reparti d'une séquence correct
SELECT setval('unicaen_privilege_categorie_id_seq', (
                                                        SELECT case when MAX(id) is null then 0 else MAX(id) end
                                                        FROM unicaen_privilege_categorie
                                                    )+1);
SELECT setval('unicaen_privilege_privilege_id_seq', (
                                                        SELECT case when MAX(id) is null then 0 else MAX(id) end
                                                        FROM unicaen_privilege_privilege
                                                    )+1);

-- Devellopeur(s) (choix fait de garder les plages d'id de 1 à 50 pour les dev et autres personnes devant fréquement intervenir sur l'application
INSERT INTO UNICAEN_UTILISATEUR_USER (username, email, display_name, password, state)
VALUES -- utilisateur demo/azerty
       ('SMILE', '', 'SMILE', 'application', true),
       ('valleet01', 'thibaut.vallee@unicaen.fr', 'Thibaut Vallée', 'ldap', true),
       ('gautrea221', 'anthony.gautreau@unicaen.fr', 'Anthony Gautreau', 'ldap', true)
ON CONFLICT (username) DO UPDATE SET
                               username=excluded.username,
                               email=excluded.email,
                               display_name=excluded.display_name,
                               password=excluded.password,
                               state=excluded.state;

INSERT INTO UNICAEN_UTILISATEUR_ROLE_LINKER(user_id, role_id)
    (select utilisateur.id, role.id
     from UNICAEN_UTILISATEUR_USER utilisateur,
          unicaen_utilisateur_role role
     where utilisateur.username in (
        'valleet01',
        'gautrea221',
        'lobstein',
        'burel222',
        'houillier',
        'thibaut.vallee@unicaen.fr',
        'anthony.gautreau@unicaen.fr',
        'lobstein@unicaen.fr',
        'lea.burel@unicaen.fr',
        'fanny.houillier@unicaen.fr'
   )
--     and role.role_id not in ('Etudiant', 'Stagiaire', 'Doctorant')
)
on conflict do nothing;

SELECT setval('unicaen_utilisateur_user_id_seq', (
     SELECT case when MAX(id) is null then 0 else MAX(id) end
     FROM unicaen_utilisateur_user
)+1);
