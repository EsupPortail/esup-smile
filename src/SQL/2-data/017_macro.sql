INSERT INTO "unicaen_renderer_macro" ("id", "code", "description", "variable_name", "methode_name") VALUES
(1,	'utilisateur#prenom',	'',	'inscription',	'getFirstname'),
(2,	'utilisateur#nom',	'',	'inscription',	'getLastname'),
(3,	'etablissement#accueil_nom',	'',	'etablissement',	'getLibelle'),
(4,	'etablissement#origine_nom',	'',	'etablissementOrigine',	'getLibelle');

INSERT INTO "unicaen_renderer_template" ("id", "code", "description", "document_type", "document_sujet", "document_corps", "document_css") VALUES
    (1,	'OLA',	'<p>Ceci est mon OLA</p>',	'pdf',	'VAR[utilisateur#nom]VAR[utilisateur#prenom]',	'<p>Etudiant VAR[utilisateur#prenom]VAR[utilisateur#nom] venant de VAR[etablissement#origine_nom]</p>',	NULL);