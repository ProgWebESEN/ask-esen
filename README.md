# Ask ESEN

Ask ESEN est un simple forum (stack overflow like :star_struck:) créé avec le framework **Symfony 5.4.4** dans le cadre du cours *Programmation Web Avancée* enseigné à l'[Ecole Supérieure de l'Economie Numérique](https://www.esen.tn).

## Fonctionnalités proposées

* Authentification / Inscription des membres
* Publication des questions / réponses
* ...

## Prérequis

* PHP >=7.2.5
* MySQL 5.x
* Composer
* Git (optionnel)
* Symfony CLI (optionnel)

## Téléchargement et configuration

Téléchargez / Clônez le projet sur votre machine

```bash
$ git clone https://github.com/ProgWebESEN/ask-esen.git
```

Placez-vous dans le dossier de travail et installez les dépendances manquantes

```bash
$ cd ask-esen/
$ composer install
```

Maintenant, il faut configurer la base de données. Dans ce cadre, ouvrez le fichier `.env` avec votre éditeur de code et modifiez la ligne suivante (ligne 30) :

```env
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7
```

Changez les valeurs `db_user`, `db_password` et `db_name` par : le nom d'utilisateur (généralement c'est `root`), le mot de passe (si c'est vide supprimer le paramètre `db_password`) et le nom de votre base de données. Par exemple :

```env
DATABASE_URL="mysql://root:@127.0.0.1:3306/mon_forum?serverVersion=5.7
```

L'étape suivante consiste à créer la base de données. Il faut juste lancer la commande

```bash
$ symfony console doctrine:database:install
```

Si symfony CLI n'est pas installé sur votre machine, vous remplacez `symfony console` par `./bin/console`. Cette règle est appliquée pour le reste des commandes ci-dessous.

Une fois la base de données a bien été créée, il faut lancer les migrations (une étape obligatoire pour la création des tables)

```bash
$ symfony console make:migration
$ symfony console doctrine:migrations:migrate
```

Finalement, lancez le serveur local de PHP

```bash
$ symfony server:start
# si vous n'avez pas installé Symfony CLI tapez alors :
# php -S 127.0.0.1:8000 -t public
```

Ouvrez l'adresse `127.0.0.1:8000` dans votre navigateur.

## Responsable

[Nassim Bahri](https://www.nassimbahri.ovh)

## License

Ce projet est sous licence [Apache 2.0](https://choosealicense.com/licenses/apache-2.0/). 