# Features

## Centrale

### Authentification

JWT + Refresh tokens.

On fournit un refresh token via une interface admin qui servira aux boutiques de faire toutes leurs
requêtes vers la centrale avec un JWT obtenu grâce au RefreshToken précédemment fourni.

Le refresh token a un mois de validité, renouvelable à chaque utilisation. (Théoriquement infini, mais regénérable à tout moment).

Cette authentification est nécessaire dans la mesure où nous avons besoin de savoir par qui ont été faites les requêtes
pour assurer une meilleure sécurité de la plateforme et pour réaliser des statistiques de vente.

### Base de données

+ Boutique (User)
  - Nom
  - URL
  - Username
  - Password -> génère le refresh token par défaut
  - ?
+ Spectacle
  - Nom
  - Datetime
  - Prix
  - Places
+ AvaiableSpectacle
  - ManyToMany (Boutique <=> Spectacle)
+ Ticket
  - Prenom
  - Nom
  - Boutique (vendeur)
  - Spectacle
  - Code unique de ticket (Génération de QR / Code-barre ?) 
+ Plans des spectacles (sièges réservés / dispos)
  - Spectacle
  - Row (A - x)
  - Column (1 - x)
  - ?Ticket (null => available)

## Boutique

### Config

Refresh token à passer en variable d'environnement / `parameters.yml`

### Base de données

+ User (Je crois que c'est la seule chose commune à chaque boutique en vrai ?)
+ ?

## Process

La boutique s'enregistre sur la centrale, ce qui va lui créer un refresh_token dont
elle se servira pour faire toutes les requêtes vers la centrale. Le token se trouvera dans
un onglet de l'interface sur la centrale.

La centrale possède une liste de spectacles. Chaque boutique peut avoir N spectacles à
vendre (la limite est de 3 dans les consignes). Les admins de la centrale peuvent assigner
à une boutique ses spectacles via une interface (/shops/{id}/spectacles) se présentant sous
la forme de tableau avec des lignes à cocher pour montrer / cacher les spectacles. Ces lignes
contiennent le nom, la date (et les effectifs de vente ? -> ex: 23/30).

Une route API sera disponible pour permettre aux boutiques de lister et vendre les spectacles
auxquels elles sont autorisées.
