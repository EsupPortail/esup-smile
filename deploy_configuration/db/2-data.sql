
-- Données

INSERT INTO UNICAEN_UTILISATEUR_ROLE (id, role_id, libelle, is_default, parent_id) VALUES
(1, 'Standard', 'Standard', true, NULL),
(2, 'Gestionnaire', 'Gestionnaire', false, 1),
(3, 'Super-gestionnaire', 'Super-gestionnaire', false, 2),
(4, 'Administrateur', 'Administrateur', false, 3);

INSERT INTO UNICAEN_UTILISATEUR_USER (username, email, display_name, password, state) VALUES
    -- utilisateur demo/azerty
    ('demo', 'demo@mail.fr', 'Demo Crite', '$2y$10$PxXnVLYnGEzEnfqPqRKJSe9AabocES2H4bBK5VzzJlzuj1rVt7Lwu', true);
INSERT INTO UNICAEN_UTILISATEUR_ROLE_LINKER(user_id, role_id) values (1, 1);


INSERT INTO unicaen_privilege_categorie (id, code, libelle, ordre) VALUES
(1, 'droit', 'Gestion des droits', 1),
(2, 'role', 'Gestion des rôles', 2),
(3, 'privilege', 'Gestion des privilèges', 3);

INSERT INTO unicaen_privilege_privilege (id, categorie_id, code, libelle, ordre) VALUES
(1, 1 , 'utilisateur_afficher', 'Consulter un utilisateur', 1),
(2, 1 , 'utilisateur_ajouter', 'Ajouter un utilisateur', 2),
(3, 1 , 'utilisateur_changerstatus', 'Changer le statut d''un utilisateur', 3),
(4, 1 , 'utilisateur_modifierrole', 'Modifier les rôles attribués à un utilisateur', 4),
(5, 2, 'role_afficher', 'Consulter les rôles', 1),
(6, 2, 'role_modifier', 'Modifier un rôle', 2),
(7, 2, 'role_effacer', 'Supprimer un rôle', 3),
(8, 3, 'privilege_voir', 'Afficher les privilèges', 1),
(9, 3, 'privilege_ajouter' , 'Ajouter un privilège', 2),
(10, 3, 'privilege_modifier' , 'Modifier un privilège', 3),
(11, 3, 'privilege_supprimer' , 'Supprimer un privilège', 4),
(12, 3, 'privilege_affecter' , 'Attribuer un privilège', 5);

INSERT INTO unicaen_privilege_privilege_role_linker (role_id, privilege_id) VALUES
(4, 1),
(4, 2),
(4, 3),
(4, 4);

