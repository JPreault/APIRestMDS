# LANCEMENT DU PROJET :

Lancement du serveur -> symfony server:start

#### PARAMETRÉ POUR LES BASES DE DONNÉES MYSQL LANCÉES EN LOCAL SUR LE PORT 3306

Créer la base de données -> php bin/console doctrine:database:create

Préparer la migration de la base -> php bin/console make:migration

Effectuer la migration -> php bin/console doctrine:migrations:migrate


# REQUÊTES POSSIBLES :

#### LISTE DES PRODUITS :  [GET] -> http://127.0.0.1:8000/product/

Pas de paramètres

#### AJOUT D'UN PRODUIT : [POST] -> http://127.0.0.1:8000/product/create

name : Doit être un string de moins de 255 caractères
stock : Foit etre un nombre entier

#### AJOUT D'UN PRODUIT : [GET] -> http://127.0.0.1:8000/product/read

id : Doit être un nombre entier

#### AJOUT D'UN PRODUIT : [POST] -> http://127.0.0.1:8000/product/update

name : Doit être un string de moins de 255 caractères
stock : Foit etre un nombre entier
id : Doit être un nombre entier

#### AJOUT D'UN PRODUIT : [DELETE] -> http://127.0.0.1:8000/product/delete

id : Doit être un nombre entier

#### AJOUT D'UN PRODUIT : [POST] -> http://127.0.0.1:8000/product/removeStock

stock : Foit etre un nombre entier
id : Doit être un nombre entier

#### AJOUT D'UN PRODUIT : [POST] -> http://127.0.0.1:8000/product/addStock

stock : Foit etre un nombre entier
id : Doit être un nombre entier

# Requêtes GraphQL :

### Les requêtes se font sur cette adresse : http://127.0.0.1:8000

### Création d'un produit : 

Le 'code valable' qui est spécifié ci-dessous est un code à 13 chiffre qui doit être en relation avec un produit présent sur ce site : https://fr.openfoodfacts.org/

Requête GraphQL :

````
mutation CreateProduct {
  createProduct(product: {name: "*Insérer un nom*", code: "**Insérer un code valable" , stock: *Insérer le nombre en stock*}){
    id, 
    name,
    code,
    stock
  }
}
````

### Avoir la liste des produits entré par l'utilisateur : 


Requête GraphQL :

````
query getAllProducts {
  products {
    id
    code
    stock
    name
  }
}
````

### Récupérer les données d'un seul produit : 

````
query getProduct {
  product(id: *Insérer un code valable ou un id*) {
    id
    code
    stock
    name
  }
}
````

### Si une erreur survient lors d'une des requête, elle est renvoyé dans les champs 'id', 'code' et 'name', assurez-vous de récupérer au moins un de ces 3 champs en réponse
