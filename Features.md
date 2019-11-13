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
+ Places de spectacle (sièges réservés / dispos)
  - Spectacle
  - Seat ID (1 à N places, le mapping est à faire en fonction du plan de la salle, on ne gère pas.)
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

### Problèmes soulevés

> Ne pas pouvoir acheter un billet pour une place qui n'est plus disponible à une date donnée

-> Poser une contrainte côté boutique pour ne plus afficher les spectacles qui sont déjà 
passés et/ou filtrer les spectacles côté centrale qui sont passés.

> Ne pas pouvoir se placer à deux au même endroit au même moment

-> Faire un serveur qui gèrerait les sockets des personnes sélectionnant leur place. Au 
moment de la sélection de la place, on se connecte à un serveur de socket qui mapperait par 
utilisateur la ou les places sélectionnées en attente de paiement. Lorsque le socket se 
déconnecte, délocker la place.

> Où met-on la bdd des utilisateurs ?

-> Dans la boutique. Les seuls "utilisateurs" que la centrale gère sont les administrateurs 
de la centrale ou les comptes boutiques pour leur permettre d'obtenir leur token

> Qui émet le PDF ?

-> La centrale, elle permettra l'unicité et la conformité des tickets.

> Où se fait le choix du placement ? (qui affiche ?)

-> Sur la boutique. Les places sont numérotées de 1 à N où N est le nombre de places dans la 
salle. Un plan de la salle peut être récupéré sous la forme d'un array à plusieurs dimension 
par exemple pour obtenir des lignes et des colonnes.

> Lock des places avant paiement ou premier qui paie qui gagne ? à quel moment est-ce décidé ?
> combien de temps ?

-> Lock des places avant avec le serveur de Socket. Toujours penser au check avant de payer, on ne 
sait jamais.

> Où se trouve les factures ?

-> Sur la boutique. Le prix de vente des billets est très probablement différent de celui en 
centrale.

> Suivi des ventes côté centrale

-> Chaque Ticket est rattaché à une boutique, on peut donc retracer facilement qui a vendu le 
billet.


### TODO

+ Réservation des places depuis la boutique
  - Visualisation des places dans la salle

