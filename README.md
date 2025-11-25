# Système de Parking Partagé

Projet de 3ème année HETIC - 2025

## Description

Application web en PHP permettant la gestion d'un système de parking partagé avec réservations, abonnements et gestion des stationnements.

## Architecture

Ce projet suit les principes de la **Clean Architecture** avec les couches suivantes :

### 1. Domain (Couche Domaine)
- **Entities** : Entités métier (User, ParkingOwner, Parking, Reservation, Stationnement, Abonnement)
- **ValueObjects** : Objets valeur (GPS Coordinates, TimeSlot, Price, etc.)
- **Repositories** : Interfaces des repositories
- **Exceptions** : Exceptions métier

### 2. UseCase (Couche Application)
- Use cases pour les utilisateurs
- Use cases pour les propriétaires de parking
- Use cases pour la gestion des réservations et abonnements
- Use cases pour les stationnements

### 3. Infrastructure (Couche Infrastructure)
- **Persistence** : Implémentations des repositories (MySQL, NoSQL, File)
- **Security** : JWT, Password Hashing
- **Services** : Services externes (PDF generation, etc.)

### 4. Presentation (Couche Présentation)
- **Web** : Controllers et Views HTML
- **Api** : REST API en JSON
- **Middleware** : Authentification, validation

## Installation

### Prérequis
- PHP 8.0 ou supérieur
- Composer
- MySQL ou SQLite
- Serveur web (Apache/Nginx) ou PHP built-in server

### Étapes d'installation

1. Cloner le projet
```bash
git clone [url-du-projet]
cd Projet_Clean_Architecture
```

2. Installer les dépendances
```bash
composer install
```

3. Configurer l'environnement
```bash
cp .env.example .env
```
Modifier le fichier `.env` avec vos paramètres de base de données

4. Initialiser la base de données
```bash
php config/init_database.php
```

5. Lancer le serveur de développement
```bash
php -S localhost:8000 -t public
```

6. Accéder à l'application
- Interface Web : http://localhost:8000
- API : http://localhost:8000/api

## Tests

### Lancer tous les tests
```bash
vendor/bin/phpunit
```

### Lancer les tests unitaires uniquement
```bash
vendor/bin/phpunit --testsuite=Unit
```

### Lancer les tests fonctionnels uniquement
```bash
vendor/bin/phpunit --testsuite=Functional
```

### Générer le rapport de couverture
```bash
vendor/bin/phpunit --coverage-html coverage
```

## Utilisation

### Authentification
Le système utilise JWT pour l'authentification. Après connexion, le token doit être inclus dans le header :
```
Authorization: Bearer [votre-token]
```

### API Endpoints

#### Authentification
- POST `/api/auth/register/user` - Créer un compte utilisateur
- POST `/api/auth/register/owner` - Créer un compte propriétaire
- POST `/api/auth/login` - Se connecter

#### Utilisateurs
- GET `/api/parkings/search?lat=X&lng=Y` - Rechercher des parkings
- POST `/api/reservations` - Créer une réservation
- GET `/api/reservations` - Liste des réservations
- POST `/api/stationnements/entry` - Entrer dans un parking
- POST `/api/stationnements/exit` - Sortir d'un parking
- POST `/api/abonnements` - Souscrire à un abonnement

#### Propriétaires
- POST `/api/parkings` - Créer un parking
- PUT `/api/parkings/{id}/tarifs` - Modifier les tarifs
- GET `/api/parkings/{id}/revenue` - Chiffre d'affaires
- GET `/api/parkings/{id}/violations` - Conducteurs hors créneau

## Structure des données

### Parking
- Coordonnées GPS
- Nombre de places
- Tarifs horaires
- Horaires d'ouverture

### Réservation
- Utilisateur
- Parking
- Début et fin (timestamp)

### Abonnement
- Types : Total, Weekend, Spécifique, Soir
- Créneaux horaires hebdomadaires
- Durée : 1 mois à 1 an

### Pénalités
- 20€ de pénalité en cas de dépassement de créneau
- Temps additionnel facturé au tarif normal

## Technologies utilisées

- PHP 8.x
- PHPUnit pour les tests
- JWT pour l'authentification
- MySQL/PostgreSQL pour la base de données relationnelle
- Système de fichiers/NoSQL pour le stockage alternatif
- Composer pour la gestion des dépendances

## Équipe

### Projet réalisé par : 
- 
- 
- 
- 

## Licence

Projet académique - HETIC 2025
