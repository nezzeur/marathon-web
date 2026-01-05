# 🎵 Marathon Web - Blog sur la Musique

[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat&logo=php&logoColor=white)](https://www.php.net/)
[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=flat&logo=laravel&logoColor=white)](https://laravel.com/)
[![Blade](https://img.shields.io/badge/Blade-Template-FF2D20?style=flat&logo=laravel&logoColor=white)](https://laravel.com/docs/blade)
[![TailwindCSS](https://img.shields.io/badge/Tailwind-CSS-38B2AC?style=flat&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)

Application web de blog musical développée avec Laravel, Blade et TailwindCSS.  Ce projet fait partie du marathon de développement web universitaire (BUT25 - Groupe 11).

## 📋 Table des Matières

- [Fonctionnalités](#-fonctionnalités)
- [Prérequis](#-prérequis)
- [Installation](#-installation)
- [Configuration](#️-configuration)
- [Utilisation](#-utilisation)
- [Déploiement](#-déploiement)
- [Technologies](#-technologies)
- [Structure du Projet](#-structure-du-projet)
- [Contribution](#-contribution)
- [Licence](#-licence)

## ✨ Fonctionnalités

- 📝 Création et gestion d'articles de blog sur la musique
- 🎨 Interface moderne et responsive avec TailwindCSS
- 🖼️ Gestion des images et médias
- 🔍 Système de recherche et filtrage
- 💾 Base de données relationnelle (SQLite/MySQL)
- 🚀 Déploiement automatisé via GitLab CI/CD

## 🛠 Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- **PHP** >= 8.1
- **Composer** >= 2.0
- **Node.js** >= 16.x et **npm** >= 8.x
- **SQLite** ou **MySQL** (selon votre configuration)
- **Git**

## 📦 Installation

### 1. Cloner le dépôt

```bash
git clone https://github.com/nezzeur/marathon-web.git
cd marathon-web
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Installer les dépendances front-end

```bash
npm install
```

### 4. Construire les assets front-end

Pour le développement (avec hot-reload) : 
```bash
npm run dev
```

Pour la production :
```bash
npm run build
```

## ⚙️ Configuration

### 1. Créer le fichier d'environnement

```bash
cp .env.example .env
```

### 2. Configurer la base de données

Ouvrez le fichier `.env` et modifiez les paramètres selon votre environnement :

#### Pour SQLite (développement local) : 

```env
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=marathon_24
# DB_USERNAME=root
# DB_PASSWORD=
```

#### Pour MySQL (production) :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=but25_groupe11
DB_USERNAME=but25_groupe11
DB_PASSWORD=votre_mot_de_passe
```

### 3. Générer la clé d'application

```bash
php artisan key:generate
```

### 4. Créer les tables de la base de données

```bash
php artisan migrate
```

Ou pour réinitialiser complètement :

```bash
php artisan migrate:fresh
```

### 5. Initialiser les images et créer le lien symbolique

```bash
# Copier les images de base
cp -r resources/images storage/app/public

# Créer le lien symbolique pour le stockage public
php artisan storage:link
```

### 6. Peupler la base avec des données de test

```bash
php artisan db:seed
```

## 🚀 Utilisation

### Démarrer le serveur de développement

```bash
php artisan serve
```

Votre application sera accessible à l'adresse : **http://localhost:8000**

### Commandes utiles

```bash
# Effacer le cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Lancer les tests
php artisan test

# Voir les routes disponibles
php artisan route:list
```

## 🌐 Déploiement

### Déploiement sur le serveur Marathon

Le projet utilise GitLab CI/CD pour le déploiement automatique. Chaque modification sur la branche `main` déclenche automatiquement le déploiement.

#### Configuration des variables d'environnement sur GitLab

1. Accédez à votre projet sur [GitLab Univ-Artois](https://gitlab.univ-artois.fr)
2. Allez dans **Paramètres** > **CI/CD** > **Variables**
3. Créez les variables suivantes :

| Variable | Description |
|----------|-------------|
| `NAME` | Votre nom de login sur la machine Marathon (ex: `but25_groupe11`) |
| `SSH_PRIVATE_KEY` | Votre clé privée SSH (contenu de `~/.ssh/id_rsa`) |

#### Configuration initiale sur le serveur Marathon

Lors du premier déploiement, connectez-vous au serveur Marathon et exécutez :

```bash
# Créer le fichier d'environnement
cp .env.example .env

# Configurer la base de données dans . env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=but25_groupeXX
# DB_USERNAME=but25_groupeXX
# DB_PASSWORD=password_but25_groupeXX

# Générer la clé
php artisan key:generate

# Créer les tables
php artisan migrate

# Initialiser les données
cp -r resources/images storage/app/public
php artisan storage: link
php artisan db:seed
```

Votre site sera accessible à :  `http://marathon/~but25_groupe11`

## 🧰 Technologies

### Backend
- **[Laravel 10](https://laravel.com/)** - Framework PHP moderne et élégant
- **[PHP 8.1+](https://www.php.net/)** - Langage de programmation serveur
- **[Blade](https://laravel.com/docs/blade)** - Moteur de templates Laravel

### Frontend
- **[TailwindCSS](https://tailwindcss.com/)** - Framework CSS utility-first
- **[Vite](https://vitejs.dev/)** - Build tool moderne et rapide
- **[PostCSS](https://postcss.org/)** - Outil de transformation CSS

### Base de données
- **SQLite** (développement)
- **MySQL** (production)

### DevOps
- **GitLab CI/CD** - Intégration et déploiement continus

## 📁 Structure du Projet

```
marathon-web/
├── app/                    # Code applicatif (Models, Controllers, etc.)
├── bootstrap/              # Fichiers de bootstrap de Laravel
├── config/                 # Fichiers de configuration
├── database/               # Migrations, seeders et factories
│   ├── migrations/         # Migrations de base de données
│   └── seeders/            # Données de test
├── public/                 # Point d'entrée web et assets publics
├── resources/              # Vues, assets bruts et traductions
│   ├── css/                # Fichiers CSS (TailwindCSS)
│   ├── images/             # Images de base
│   ├── js/                 # Fichiers JavaScript
│   └── views/              # Templates Blade
├── routes/                 # Définition des routes
│   └── web.php             # Routes web
├── storage/                # Fichiers générés (logs, cache, uploads)
├── tests/                  # Tests unitaires et fonctionnels
├── . env. example            # Exemple de configuration environnement
├── .gitlab-ci.yml          # Configuration CI/CD GitLab
├── artisan                 # CLI Laravel
├── composer.json           # Dépendances PHP
├── package.json            # Dépendances Node.js
├── tailwind.config.js      # Configuration TailwindCSS
├── vite.config.js          # Configuration Vite
└── README.md               # Ce fichier
```

## 🤝 Contribution

Les contributions sont les bienvenues ! Pour contribuer : 

1. Forkez le projet
2. Créez une branche pour votre fonctionnalité (`git checkout -b feature/AmazingFeature`)
3. Committez vos changements (`git commit -m 'Add some AmazingFeature'`)
4. Poussez vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrez une Pull Request

### Standards de code

- Suivre les [PSR-12](https://www.php-fig.org/psr/psr-12/) pour PHP
- Respecter les conventions Laravel
- Écrire des tests pour les nouvelles fonctionnalités

## 📝 Licence

Ce projet est développé dans le cadre du marathon de développement web universitaire (BUT25 - Groupe 11).

## 👥 Auteurs

- **Groupe BUT25_groupe11** - *Développement initial*

## 📞 Support

Pour toute question ou problème : 
- Consultez la [documentation Laravel](https://laravel.com/docs)

---

