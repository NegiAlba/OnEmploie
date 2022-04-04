# Walkthrough du projet

## Création & Setup du projet symfony

`symfony new --webapp OnEmploie`
`cd OnEmploi`
`symfony server:start`
`npm install`
`npm run watch`

**Modification du fichier .env**

## Création d'une page d'accueil

`symfony console make:controller DefaultController`

**Modification des templates**

## Création des entités Company & Offer

`symfony console make:user`

`symfony console make:entity Company ` _to update user Company_

`symfony console make:entity Offer`

`symfony console make:migration`

`symfony console doctrine:migrations:migrate`

## Création du formulaire de création d'Offers

`symfony console make:form`

**Création de la fonction** `public function create()` **dans le controller**

**Modification de l'entité Offer dans src/Entity/Offer.php pour les cycles de vie**
