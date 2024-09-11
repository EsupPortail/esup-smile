-------------------------------------
-- Gestion des étapes
------------------------------------
-- Probablement une table temporaire, les données seront surement fournis par APOGEE/PEGASE
INSERT INTO step (code, libelle, needvalidation, status, "order", movable, role_id, fixed, deletable)
VALUES ('pre-registration', 'Pre-registration', false, true, 1, false, 2, true, false),
       ('registered', 'Registered, waiting administrator validation', true, true, 2,false, 2, true, false),
       ('course', 'Course selection', false, true, 3, true, 6, false, false),
       ('approval_educational', 'Waiting approval by educational referent', true, true, 4,true, 2, false, true),
       ('approval_host', 'Waiting approval by host institution', true, true, 5,true, 2, false, true),
       ('approval_student', 'Waiting approval by student', false, true, 7,true, 6, false, true),
       ('contract', 'Student contract generated', false, true, 8,false, 2, true, false);

