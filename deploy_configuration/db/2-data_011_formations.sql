-------------------------------------
-- Gestion des formations
------------------------------------

-- Type de formations (pour en avoir par défaut en cas de reset de la bdd
INSERT INTO type_diplome (code, libelle, acronyme, ordre)
VALUES ('L','Licence','L',1),
('M','Master','M',2)
on conflict (code) DO
UPDATE SET
libelle=excluded.libelle,
acronyme=excluded.acronyme,
ordre=excluded.ordre;

-- Mapping avec PYC. Le mapping ne peut pas encore être fait à la main
INSERT INTO type_diplome_mapping (type_diplome_id, source_id, code_src)
VALUES (
        (select td.id from type_diplome td where td.code='L'),
        (select src.id from source src where src.code='pyc'),
        'L'
),
(
   (select td.id from type_diplome td where td.code='M'),
   (select src.id from source src where src.code='pyc'),
   'M'
)
on conflict (type_diplome_id, source_id, code_src)
do nothing;

INSERT INTO type_formation (code, libelle, acronyme, ordre)
VALUES ('Diplome','Diplomante','Diplo.',1),
       ('Certif','Certifiante','Certif.',2)
on conflict (code) DO
    UPDATE SET
               libelle=excluded.libelle,
               acronyme=excluded.acronyme,
               ordre=excluded.ordre;