-- ETATS ---------------------------------------------------------------------------------------------------------------
INSERT INTO UNICAEN_EVENEMENT_ETAT (CODE, LIBELLE, DESCRIPTION) VALUES
    ('en_attente', 'Événement en attente de traitement', null),
    ('en_cours', 'Événement en cours de traitement', 'L''événement est en cours de traitement et sera mis à jour après celui-ci'),
    ('echec', 'Événement dont le traitement a échoué', null),
    ('succes', 'Événement dont le traitement a réussi', null)
    ON CONFLICT (code) DO
UPDATE SET
    libelle=excluded.libelle,
    description=excluded.description;

-- TYPES ---------------------------------------------------------------------------------------------------------------
INSERT INTO UNICAEN_EVENEMENT_TYPE (CODE, LIBELLE, DESCRIPTION, PARAMETRES) VALUES
    ('mail', 'Envoi de courrier électronique', null, 'sujet;corps;destinataires;copies;cachés'),
    ('collection', 'Collection d''événements', 'Événement liant plusieurs événements associés', 'description;événements')
ON CONFLICT (code) DO
UPDATE SET
    libelle=excluded.libelle,
    description=excluded.description,
    parametres=excluded.parametres;
