INSERT INTO unicaen_renderer_template (code, description, document_type, document_sujet, document_corps, document_css, namespace) VALUES ('OLA', '<p>Ceci est mon OLA</p>', 'pdf', 'VAR[utilisateur#nom]VAR[utilisateur#prenom]', '<p>Etudiant VAR[utilisateur#prenom]VAR[utilisateur#nom] venant de VAR[etablissement#origine_nom]</p>', null, null);
INSERT INTO unicaen_renderer_template (code, description, document_type, document_sujet, document_corps, document_css, namespace) VALUES ('Enseignant_attente_validation', '<p>L''enseignant référent reçoit un mail l''invitant à valider ou pas les choix des cours de l''étuidant</p>', 'mail', 'Cours de [NOM PRENOM ETUDIANT] en attente de validation ', e'<p>[PRENOM,NOM ENSEIGNANT],</p>
<p>[PRENOM, NOM ETUDIANT] a formulé ses choix de cours pour sa mobilité à [NOM UNIVERSITE D\'ACCUEIL].</p>
<p>Pour visualiser et valider ses cours, veuillez vous connectez sur l\'application [smile....].</p>
<p>Bien cordialement</p>', null, null);
INSERT INTO unicaen_renderer_template (code, description, document_type, document_sujet, document_corps, document_css, namespace) VALUES ('Etudiant_Accuse_reception_choix_cours', '<p>Mail envoyé à l''étudiant lorsqu''il a validé ses choix de cours</p>', 'mail', 'Accusé réception de vos choix de cours', e'<p>[PRENOM, NOM]</p>
<p>Nous vous informons que vous venez de valider vos choix de cours pour votre mobilité à  [UNIVERSITE D\'ACCUEIL]. ces choix seront soumis à validation par votre enseignant référent, [UNIVERSITE D\'ORIGINE] et par [UNIVERSITE D\'ACCUEIL]. Vous pouvez suivre votre dossier sur l\'application [NOM DE L\'APPLICATION]</p>
<p>Bien cordialement</p>', null, null);
INSERT INTO unicaen_renderer_template (code, description, document_type, document_sujet, document_corps, document_css, namespace) VALUES ('Etudiant_Confirmation_cours_valide', '<p>Mail envoyé à l''étudiant lorsque tous les intervenants ont validé</p>', 'mail', 'Vos choix de cours ont été validés', e'<p>VAR[utilisateur#prenom] VAR[utilisateur#nom]</p>
<p>Nous vous informons que vos choix de cours ont été validés. Vous pouvez désormais générer votre contrat d\'étude (OLA)</p>
<p>Bien cordialement</p>', null, null);
INSERT INTO unicaen_renderer_template (code, description, document_type, document_sujet, document_corps, document_css, namespace) VALUES ('Etudiant_etape_suivante', '<p>Mail envoyé à l''étudiant lorsque il avance d''une étape</p>', 'mail', 'SMILE - Etape validé', e'<p>Bonjour VAR[utilisateur#prenom] VAR[utilisateur#nom],</p>
<p> </p>
<p>Nous vous informons que votre dossier est passé à l\'étape suivante sur SMILE : VAR[etape#libelle]</p>
<p>Pour accéder à votre dossier, rendez-vous dans votre espace SMILE.</p>
<p>Bien cordialement</p>
<p> </p>', null, null);
INSERT INTO unicaen_renderer_template (code, description, document_type, document_sujet, document_corps, document_css, namespace) VALUES ('Gestionnaire_etape_suivante', null, 'mail', 'SMILE - VAR[utilisateur#prenom] VAR[utilisateur#nom] est passé à l''étape suivante', e'<p>Bonjour,</p>
<p>VAR[utilisateur#prenom] VAR[utilisateur#nom] est passé à l\'étape suivante : VAR[etape#libelle].</p>
<p>En tant que gestionnaire, vous pouvez vérifier ses informations sur votre espace.</p>
<p>Bien Cordialement,</p>', null, null);
INSERT INTO unicaen_renderer_template (code, description, document_type, document_sujet, document_corps, document_css, namespace) VALUES ( 'Gestionnaire_abandon', null, 'mail', 'SMILE - VAR[utilisateur#prenom] VAR[utilisateur#nom] a abandonné', e'<p>Bonjour,</p>
<p>VAR[utilisateur#prenom] VAR[utilisateur#nom] a abandonné à l\'étape : VAR[etape#libelle].</p>
<p>En tant que gestionnaire, vous pouvez vérifier ses informations sur votre espace.</p>
<p>Bien Cordialement,</p>', null, null);
INSERT INTO unicaen_renderer_template (code, description, document_type, document_sujet, document_corps, document_css, namespace) VALUES ('Etudiant_refus', null, 'mail', 'SMILE - Etape refusé', e'<p>Bonjour VAR[utilisateur#prenom] VAR[utilisateur#nom],</p>
<p> </p>
<p>Nous vous informons que votre dossier est retourné à l\'étape précédente sur SMILE : VAR[etape#libelle]</p>
<p>Pour en savoir plus, accéder à votre dossier dans votre espace SMILE.</p>
<p>Bien cordialement</p>
<p> </p>', null, null);
INSERT INTO unicaen_renderer_template (code, description, document_type, document_sujet, document_corps, document_css, namespace) VALUES ( 'Accueil', null, 'texte', 'Accueil', e'<p>Système de gestion en ligne des étudiants en mobilité internationale</p>
<p>Attention : Les inscriptions du second semestre ferment bientôt !</p>', null, null);

INSERT INTO unicaen_renderer_template (code, description, document_type, document_sujet, document_corps, document_css, namespace)
VALUES ( 'cours_aide', null, 'texte', 'Aide page de cours', '<p>Besoin d''aide ? Contactez-nous à l''adresse smile@unicaen.fr</p><p>Need help ? Ask us smile@unicaen.fr</p>', null, null);