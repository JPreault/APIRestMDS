# LANCEMENT DU PROJET :

Lancement du serveur -> symfony server:start

## PARAMETRÉ POUR LES BASES DE DONNÉES MYSQL LANCÉES EN LOCAL SUR LE PORT 3306

Créer la base de données -> php bin/console doctrine:database:create

Préparer la migration de la base -> php bin/console make:migration

Effectuer la migration -> php bin/console doctrine:migrations:migrate


# REQUÊTES POSSIBLES :

## LISTE DES PRODUITS :  [GET] -> http://127.0.0.1:8000/product/

Pas de paramètres

## AJOUT D'UN PRODUIT : [POST] -> http://127.0.0.1:8000/product/create

name : Doit être un string de moins de 255 caractères
stock : Foit etre un nombre entier

## AJOUT D'UN PRODUIT : [GET] -> http://127.0.0.1:8000/product/read

id : Doit être un nombre entier

## AJOUT D'UN PRODUIT : [POST] -> http://127.0.0.1:8000/product/update

name : Doit être un string de moins de 255 caractères
stock : Foit etre un nombre entier
id : Doit être un nombre entier

## AJOUT D'UN PRODUIT : [DELETE] -> http://127.0.0.1:8000/product/delete

id : Doit être un nombre entier

## AJOUT D'UN PRODUIT : [POST] -> http://127.0.0.1:8000/product/removeStock

stock : Foit etre un nombre entier
id : Doit être un nombre entier

## AJOUT D'UN PRODUIT : [POST] -> http://127.0.0.1:8000/product/addStock

stock : Foit etre un nombre entier
id : Doit être un nombre entier
