# SAAS SMILE

Le mode SAAS de Smile vous permet d'utiliser l'application sans avoir à la déployer sur votre infrastructure.
 L'application est hébergée dans le datacenter de l'université de Strasbourg, vous avez simplement à la configurer et à fournir les élements nécessaires selon vos besoins.

## Elements nécessaires pour le déploiement en SAAS

### 1. Accès à votre Offre de Formation

Il y a plusieurs moyens de fournir l'offre de formation :

- Apogée en direct, via notre module qui s'installe dans votre SI et fournit un webservice à Smile : https://git.unicaen.fr/open-source/smile-connect il faut alors nous fournir l'url de smile-connect ainsi que les identifiants pour y accéder.


- Import CSV directement dans l'application "Administration => Import de données" de Smile

- API dans Smile : [A venir] 

### 2. Serveur SMTP

Pour l'envoi des mails depuis votre domaine, Smile à besoin d'un accès SMTP authentifié.

- Hôte
- Port
- Utilisateur
- Mot de passe

### 3. DNS

Pour le nom de domaine de Smile que vous souhaitez, vous devez ajouter ce DNS dans votre infrastructure.
L'ip du serveur vous sera fournit par nos équipes.

Exemple : 
```
smile.unicaen.fr A 123.14.15.16
www.smile.unicaen.fr CNAME smile.unicaen.fr
```

### 4. HTTPS

Pour que votre instance de Smile soit
chiffrés avec votre domaine, vous devrez nous fournir 
une clé ACME réstreint au nom de domaine de votre instance, qui nous servira à générer automatiquement le certificat SSL de votre instance.

Méthode utilisée à l'université de Caen pour avoir un compte ACME pour gérer les demandes de certificat d'un nom de domaine :

- Dans l'interface Sectigo, déclarer comme nouveau domaine le nom de serveur pour lequel vous voulez pouvoir demander des certificats.
- Dans la partie "Enrollment" puis "ACME", il faut créer un nouveau compte de type "https://acme.sectigo.com/v2/OV".
- Dans les paramètres de ce compte, il faut préciser qu'il n'a des droits que sur le nom de domaine définit précédement.
- Une fois le compte ACME créé, vous avez toutes les informations nécessaires pour gérer le cycle de vie du certificat.

### 5. RENATER/SHIBBOLETH

Pour le bon fonctionnement de Smile, il est nécessaire de déclarer le service Shibboleth sur votre portail Renater.

Rendez-vous sur le portail Renater : https://registry.federation.renater.fr/entities et ajoutez un nouveau service.

#### Présentation

Pour être éligible à la fédération Edugain les champs en anglais doivent être renseignés.
Nom (fr et en) : Smile
Logo : https://smile.unicaen.fr/img/logo_smile_RVB.jpg
Description (vous pouvez adapter) : Système de gestion en ligne des publics en mobilité internationale de l’université de XXXXXX.
Description (en) : Online management system for international students.
URL du service : https://smile.XXXXX.fr/ (exemple pour Caen : https://smile.unicaen.fr/)

Public du service : Service à portée nationale
Type du service : Application métier

#### Responsables

Langue: Français
Responsables : la/les personnes qui gèrent la déclaration du service.

Sélection de l'organisme : Votre établissement

#### Contacts

Les adresses de contact doivent être des adresses génériques sinon Edugain refusera la déclaration (on peut mettre deux adresses identiques).
Contact technique : (exemple: contact-smile@unicaen.fr)
Contact sécurité : (exemple: contact-smile@unicaen.fr)

#### Fédération

Si vous venez de créer le service, enregistrez-vous d'abord dans la fédération de Test pour vérifier que tout fonctionne correctement. Vous pourrez changer après pour la fédération de production.

Si vous voulez passer en production, ça se fait en 2 étapes.
- Il faut d'abord s'enregistrer dans la fédération Education-Recherche.
- Il faudra attendre la validaton de Renater, quand vous êtes validé, vous pouvez demander à vous enregistrer dans la fédération Edugain puis attendre la validation.

#### Attributs

Pour Smile, il faut fournir les attributs suivants :
Vous pouvez cocher obligatoire pour tous les éléments.

Nom : Finalité
- eduPersonPrincipalName : identification
- o (organizationName) : identification
- mail : identification
- displayName : Information obligatoire pour générer un contrat pédagogique
- eduOrgLegalName : Information obligatoire pour générer un contrat pédagogique
- homePostalAddress : Information obligatoire pour générer un contrat pédagogique
- shacDateOfBirth : Information obligatoire pour générer un contrat pédagogique
- shacHomeOrganization : Information obligatoire pour générer un contrat pédagogique

Cocher "Les données sont traitées en France ou dans un autre pays de l'UE"

#### Informations techniques

L'URL des métadonnées est l'URL de votre instance suivi de /Shibboleth.sso/Metadata
- Exemple : https://smile.unicaen.fr/Shibboleth.sso/Metadata

Vous faites ensuite "Chargez les métadonnées" pour que Renater récupère les métadonnées de votre instance.
Le reste de la page devrait se remplir automatiquement.

L'entity ID est le nom de domaine de votre instance de Smile suivi de /shibboleth-sp
- Exemple : https://smile.monuniversite.fr/shibboleth-sp

#### Conformité

A définir.

