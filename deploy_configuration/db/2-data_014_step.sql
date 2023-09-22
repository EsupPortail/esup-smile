-------------------------------------
-- Gestion des étapes
------------------------------------
-- Probablement une table temporaire, les données seront surement fournis par APOGEE/PEGASE
INSERT INTO step (code, libelle, needvalidation, status, "order", role_id)
VALUES ('pre-registration', 'Pre-registration', false, true, 1, 2),
       ('registered', 'Registered, waiting administrator validation', true, true, 2, 2),
       ('course', 'Course selection', false, true, 3, 6),
       ('approval_educational', 'Waiting approval by educational referent', true, true, 4, 2),
       ('approval_host', 'Waiting approval by host institution', true, true, 5, 2),
       ('approval_base', 'Waiting approval by home institution', true, true, 6, 2),
       ('approval_student', 'Waiting approval by student', false, true, 7, 6),
       ('contract', 'OLA Generated', false, true, 8, 2);
