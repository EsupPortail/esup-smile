-------------------------------------
-- Données pour faire des démonstration sans nécessairement avoir de réseaux/acces proxy ...
------------------------------------
--- Faux comptes
INSERT INTO UNICAEN_UTILISATEUR_USER (username, email, display_name, password, state)
VALUES -- mot de passe : azerty
       ('demo', 'toto@mail.com', 'Compte Démo', '$2y$10$PxXnVLYnGEzEnfqPqRKJSe9AabocES2H4bBK5VzzJlzuj1rVt7Lwu', true),
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
     where utilisateur.username in ('demo')
     and role.role_id not in ('Stagiaire')
)
on conflict do nothing;

-- 10 "Faux étudiants pour les tests avec des id forcée
-- !!! possible conflit
INSERT INTO UNICAEN_UTILISATEUR_USER (id,username, email, display_name, password, state)
VALUES -- mot de passe : azerty
       (601, 'etudiant1', 'max.jamieson@mail.com', 'Max Jamieson', '$2y$10$PxXnVLYnGEzEnfqPqRKJSe9AabocES2H4bBK5VzzJlzuj1rVt7Lwu', true),
       (602, 'etudiant2', 'lennon.boyle@mail.com', 'Lennon Boyle', '$2y$10$PxXnVLYnGEzEnfqPqRKJSe9AabocES2H4bBK5VzzJlzuj1rVt7Lwu', true),
       (603, 'etudiant3', 'janes.regan@mail.com', 'Janes Regan', '$2y$10$PxXnVLYnGEzEnfqPqRKJSe9AabocES2H4bBK5VzzJlzuj1rVt7Lwu', true),
       (604, 'etudiant4', 'niamh.birch@mail.com', 'Niamh Birch', '$2y$10$PxXnVLYnGEzEnfqPqRKJSe9AabocES2H4bBK5VzzJlzuj1rVt7Lwu', true),
       (605, 'etudiant5', 'tapio.sillanpää@mail.com', 'Tapio Sillanpää', '$2y$10$PxXnVLYnGEzEnfqPqRKJSe9AabocES2H4bBK5VzzJlzuj1rVt7Lwu', true),
       (606, 'etudiant6', 'kristian.wirtz@mail.com', 'Kristian Wirtz', '$2y$10$PxXnVLYnGEzEnfqPqRKJSe9AabocES2H4bBK5VzzJlzuj1rVt7Lwu', true),
       (607, 'etudiant7', 'maik.drechsler@mail.com', 'Maik Drechsler', '$2y$10$PxXnVLYnGEzEnfqPqRKJSe9AabocES2H4bBK5VzzJlzuj1rVt7Lwu', true),
       (608, 'etudiant8', 'kira.lindgren@mail.com', 'Kira Lindgren', '$2y$10$PxXnVLYnGEzEnfqPqRKJSe9AabocES2H4bBK5VzzJlzuj1rVt7Lwu', true),
       (609, 'etudiant9', 'letícia.gomes-dias@mail.com', 'Letícia Gomes-Dias', '$2y$10$PxXnVLYnGEzEnfqPqRKJSe9AabocES2H4bBK5VzzJlzuj1rVt7Lwu', true),
       (610, 'etudiant10', 'sánta.mozes@mail.com', 'Sánta Mozes', '$2y$10$PxXnVLYnGEzEnfqPqRKJSe9AabocES2H4bBK5VzzJlzuj1rVt7Lwu', true)
ON CONFLICT (username) DO UPDATE SET
                                     username=excluded.username,
                                     email=excluded.email,
                                     display_name=excluded.display_name,
                                     password=excluded.password,
                                     state=excluded.state;

SELECT setval('unicaen_utilisateur_user_id_seq', (
    SELECT case when MAX(id) is null then 0 else MAX(id) end
    FROM unicaen_utilisateur_user
)+1);

insert into inscription (id, firstname, lastname, birthdate, esi, city, postalcode, street, numstreet, firstmobilite, handicap, mailreferent, status, statuslibelle, user_id, mobilite_id, step_id, etablissement_id, diplomepays_id, year)
values  (601, 'Max', 'Jamieson', '1996-03-23', 'urn:schac:personalUniqueCode:int:esi:fr:1234567890G1', 'Edinburgh', '1125', null, null, null, null, null, '1', 'En attente du choix de mobilité', 601, null, 1, null, null, 2023),
        (602, 'Lennon', 'Boyle', '1998-02-11', 'urn:schac:personalUniqueCode:int:esi:fr:1234567890G2', 'Berlin', '10115', null, null, null, null, null, '2', 'En attente du choix de mobilité', 602, null, 2, null, null, 2023),
        (603, 'Janes', 'Regan', '2002-01-18', 'urn:schac:personalUniqueCode:int:esi:fr:1234567890G3', 'Salamanca', '37001', null, null, null, null, null, '3', 'En attente du choix de mobilité', 603, null, 3, null, null, 2023),
        (604, 'Niamh', 'Birch', '1996-08-24', 'urn:schac:personalUniqueCode:int:esi:fr:1234567890G4', 'Hamurg', '20095', null, null, null, null, null, '4', 'En attente du choix de mobilité', 604, null, 4, null, null, 2023),
        (605, 'Tapio', 'Sillanpää', '2002-08-04', 'urn:schac:personalUniqueCode:int:esi:fr:1234567890G5', 'Lisbon', '1000-004', null, null, null, null, null, '5', 'En attente du choix de mobilité', 605, null, 5, null, null, 2023),
        (606, 'Kristian', 'Wirtz', '2001-09-08', 'urn:schac:personalUniqueCode:int:esi:fr:1234567890G6', 'Budapest', '1007', null, null, null, null, null, '6', 'En attente du choix de mobilité', 606, null, 6, null, null, 2023),
        (607, 'Maik', 'Drechsler', '2003-07-24', 'urn:schac:personalUniqueCode:int:esi:fr:1234567890G7', 'Bern', '3007', null, null, null, null, null, '7', 'En attente du choix de mobilité', 607, null, 7, null, null, 2023),
        (608, 'Kira', 'Lindgren', '2003-05-23', 'urn:schac:personalUniqueCode:int:esi:fr:1234567890G7', 'Brno', '619 00', null, null, null, null, null, '1', 'En attente du choix de mobilité', 608, null, 7, null, null, 2023),
        (609, 'Letícia', 'Gomes-Dias', '2003-11-13', 'urn:schac:personalUniqueCode:int:esi:fr:1234567890G7', 'Madrid', '28015', null, null, null, null, null, '1', 'En attente du choix de mobilité', 609, null, 7, null, null, 2023),
        (610, 'Sánta', 'Mozes', '2004-09-17', 'urn:schac:personalUniqueCode:int:esi:fr:1234567890G7', 'Porto', '4049', null, null, null, null, null, '1', 'En attente du choix de mobilité', 610, null, 7, null, null, 2023);



INSERT INTO UNICAEN_UTILISATEUR_ROLE_LINKER(user_id, role_id)
    (select utilisateur.id, role.id
     from UNICAEN_UTILISATEUR_USER utilisateur,
          unicaen_utilisateur_role role
     where utilisateur.username like 'etudiant%'
       and role.role_id like'Etudiant'
    )
on conflict do nothing;

-- Faux priviléges temporaire qui ne sont liée à rien
-- Suppression du priviléges temporaire

delete from unicaen_privilege_privilege
where libelle like '%[DEV]%';

insert into composante (id, code, libelle, libelle_long, acronyme, source_id, source_code, histo_creation, histo_createur_id, histo_modification, histo_modificateur_id, histo_destruction, histo_destructeur_id)
values  (1, '918', 'UFR de Sciences, de Land', 'UFR de Sciences, antenne de Land', 'SC LAND', 2, '918', '2023-04-07 07:59:56.000000', 1, null, null, null, null),
        (2, '102', 'DAEU Land', 'DAEU Land', 'DAEU LAND', 2, '102', '2023-04-07 07:59:56.000000', 1, null, null, null, null);

insert into formation (id, code, libelle, acronyme, type_formation_id, domaine_formation_id, type_diplome_id, niveau_etude, composante_id, ouvert_mobilite, langue_enseignement_id, mention, objectifs, programme, prerequis_pedagogique, modalite_enseignement, bibliographie, contacts, informations_complementaires, source_id, source_code, histo_creation, histo_createur_id, histo_modification, histo_modificateur_id, histo_destruction, histo_destructeur_id)
values  (1, 'M1DOC1_201', 'M1 FORM Second degré - parcours Documentation', null, null, null, 2, 1, 98, true, null, null, null, null, null, null, null, null, null, 2, 'M1DOC1_201', '2023-04-07 07:59:56.000000', 1, null, null, null, null),
        (2, 'M1PD01_203', 'M1 FORM Premier Degré - parcours Professorat des écoles', null, null, null, 2, 1, 98, true, null, null, null, null, null, null, null, null, null, 2, 'M1PD01_203', '2023-04-07 07:59:56.000000', 1, null, null, null, null);


insert into cours (id, code_elp, libelle, langue_enseignement, s1, s2, ects, vol_elp, ouvert_mobilite, formation_id, objectif, description, type_cours, langue_enseignement_id, source_id, source_code, histo_creation, histo_createur_id, histo_modification, histo_modificateur_id, histo_destruction, histo_destructeur_id)
values  (1, 'YSEAEDS6', 'Accompagnement AED prépro 1er degré + stage filé', 'Français', '', '1', 6.00, 12.00, true, 599, null, null, null, 1, 2, 'YSEAEDS6', '2023-04-07 07:59:56.000000', 1, null, null, null, null),
        (2, 'YPLURI1', 'UE2-Développer une conscience critique', 'Français', '1', '', 3.00, 30.00, true, 687, null, null, null, 1, 2, 'YPLURI1', '2023-04-07 07:59:56.000000', 1, null, null, null, null),
        (3, 'LAE51B', 'UE 51 Disciplinaire', 'Français', '1', '', 6.00, 40.00, true, 536, null, null, null, 1, 2, 'LAE51B', '2023-04-07 07:59:56.000000', 1, null, null, null, null),
        (4, 'THEO1EAF', 'UE1-Mobiliser des savoirs spécialisés', 'Français', '1', '', 10.00, 50.00, true, 687, null, null, null, 1, 2, 'THEO1EAF', '2023-04-07 07:59:56.000000', 1, null, null, null, null);
