# Driver Valence — Plateforme VTC

Application web de réservation de courses VTC développée avec **Laravel** (backend) et **Vue.js** (frontend).

---

## Description

Driver Valence permet à des clients de demander des courses de taxi, et à des chauffeurs de les accepter. L'accès à chaque espace est sécurisé selon le rôle de l'utilisateur (client ou chauffeur).

---

## Stack technique

| Côté | Technologie | Rôle |
|---|---|---|
| Backend | Laravel 11 | API REST, base de données, authentification |
| Frontend | Vue.js 3 | Interface utilisateur, navigation entre pages |
| Auth | Laravel Sanctum | Génération et vérification des tokens |
| HTTP | Axios | Communication entre Vue.js et l'API Laravel |
| BDD | MySQL | Stockage des utilisateurs et des courses |

---

## Fonctionnalités

### Client
- Inscription et connexion
- Demander une course (départ, destination, horaire)
- Voir le statut de sa course

### Chauffeur
- Inscription et connexion
- Voir les courses en attente
- Accepter une course

### Admin *(en cours)*
- Gérer les chauffeurs

---

## Architecture du projet

```
vtc-project/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php      → inscription, connexion, déconnexion
│   │   └── CourseController.php    → gestion des courses
│   └── Models/
│       ├── Client.php              → modèle client (authentifiable)
│       ├── Chauffeur.php           → modèle chauffeur (authentifiable)
│       └── Course.php              → modèle course (avec relations)
├── routes/
│   └── api.php                     → toutes les routes de l'API
├── database/
│   └── migrations/                 → création des tables en BDD
└── resources/js/
    ├── app.js                      → point d'entrée Vue.js
    ├── App.vue                     → composant racine
    ├── router/
    │   └── index.js                → routes Vue (quelle page selon l'URL)
    └── components/
        ├── Home.vue                → page d'accueil
        ├── Login.vue               → connexion
        ├── Register.vue            → inscription
        ├── CourseRequest.vue       → demande de course (client)
        ├── CourseList.vue          → liste des courses (chauffeur)
        └── ChauffeurCourses.vue    → dashboard chauffeur
```

---

## Base de données

### Table `clients`
Stocke les comptes clients. Chaque client peut passer plusieurs courses.

### Table `chauffeurs`
Stocke les comptes chauffeurs. Chaque chauffeur peut accepter plusieurs courses.

### Table `courses`
| Colonne | Description |
|---|---|
| `client_id` | Qui a demandé la course |
| `chauffeur_id` | Qui l'a acceptée (vide si en attente) |
| `departure` | Adresse de départ |
| `destination` | Adresse d'arrivée |
| `scheduled_at` | Date et heure prévues |
| `status` | `pending` (en attente) ou `accepted` |

---

## Routes API

### Routes publiques (sans connexion)
| Méthode | URL | Description |
|---|---|---|
| POST | `/api/register/client` | Inscrire un client |
| POST | `/api/register/chauffeur` | Inscrire un chauffeur |
| POST | `/api/login` | Se connecter (client ou chauffeur) |

### Routes protégées (token requis)
| Méthode | URL | Description |
|---|---|---|
| POST | `/api/logout` | Se déconnecter |
| POST | `/api/courses` | Créer une course (client) |
| GET | `/api/courses` | Lister les courses en attente (chauffeur) |
| POST | `/api/courses/{id}/accept` | Accepter une course (chauffeur) |
| GET | `/api/courses/{id}` | Détail d'une course |

---

## Comment fonctionne l'authentification

1. L'utilisateur se connecte via `/api/login`
2. Laravel génère un **token** unique et le renvoie avec le **rôle** (client ou chauffeur)
3. Vue.js stocke ces deux infos dans le **localStorage** du navigateur
4. À chaque requête suivante, Vue envoie le token dans le header `Authorization: Bearer ...`
5. Laravel vérifie le token via **Sanctum** avant d'autoriser l'accès

---

## Installation

### Prérequis
- PHP 8.2+
- Composer
- Node.js + npm
- MySQL

### Étapes

```bash
# 1. Cloner le projet
git clone <url-du-repo>
cd vtc-project

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances JS
npm install

# 4. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 5. Configurer la base de données dans .env
# DB_DATABASE=vtc_project
# DB_USERNAME=root
# DB_PASSWORD=...

# 6. Lancer les migrations
php artisan migrate

# 7. Démarrer les serveurs
php artisan serve        # Laravel sur http://localhost:8000
npm run dev              # Vue.js sur http://localhost:5173
```

---

## Ce qui reste à faire

- [ ] Guards Vue.js sur les routes `/client` et `/chauffeur/dashboard`
- [ ] Option d'inscription chauffeur dans le formulaire Register
- [ ] Page admin pour gérer les chauffeurs

---

## Auteur

Projet développé par Yassi dans le cadre d'une formation développement web.
