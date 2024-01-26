# SAAS SMILE

Le mode SAAS de Smile vous permet d'utiliser l'application sans avoir à la déployer.
 L'application est héberger sur nos infrastructures, vous avez simplement à la configurer et à fournir les élements nécessaires selon vos besoins.

## Elements nécessaires 

### 1. Accès à votre Offre de Formation

Il y a plusieurs moyens de fournir l'offre de formation :

- Apogée en direct, via notre module qui s'installe dans votre SI et fournit un webservice à Smile

- Import CSV directement sur l'application

- API : Non disponible pour le moment

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
une clé ACME, qui nous servira à générer automatiquement le certificat SSL de votre instance.