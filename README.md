# Centrale de réservation

## Setup

### Prérequis

+ PHP >= 7.2
+ Nginx
+ MySql >= 5.6 (Je ne suis pas sûr que tout le monde ait la 5.7)
+ Node >= 10

### Installation

Installer nginx et ajouter le fichier de configuration présent dans le dossier `nginx` à la configuration locale nginx de votre machine.

Des commentaires préciseront dans le fichier les lignes à modifier, à savoir:
+ `server_name` => Sous quel "nom" le serveur va répondre. Penser à l'ajouter dans les fichiers des hosts de votre machine (`/etc/hosts`)
+ `root` => Le chemin absolu jusqu'au dossier public du serveur Symfony.
+ `include` => Le chemin jusqu'aux `fastcgi_params` de votre version de PHP. Dépend de votre installation.
+ `error_log`, `access_log` => Chemin absolu jusqu'au dossier des fichiers temporaires de l'application Symfony.

La commande `nginx -t` permet de tester le fichier de configuration et `nginx -s reload` permettra d'appliquer les changements.

Dans le dossier `symfony`, copier le fichier `.env` vers `.env.local` et entrer les informations de connexion à la base de données.

### Installation des dépendances

Dans les dossiers respects, installer les dépendances nécessaires.

```sh
# ./vue
npm i
npm run serve # Lance le serveur de développement
```

```sh
# ./symfony
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migration:make
php bin/console doctrine:fixtures:load
```
