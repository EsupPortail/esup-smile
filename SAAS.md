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

### 5. SHIBBOLETH

Pour le bon fonctionnement de Smile, il est nécessaire de déclarer le service Shibboleth sur votre portail Renater.

L'entity ID est le nom de domaine de votre instance de Smile suivi de /shibboleth-sp

Exemple :
``` 
https://smile.monuniversite.fr/shibboleth-sp
```

Les attributs nécessaires pour Smile sont :
- displayName
- mail
- eduPersonPrincipalName
- eduOrgLegalName
- shacDateOfBirth
- givenName
- sn (surname)
- homePostalAddress
- o (organizationName)
- shacHomeOrganization
