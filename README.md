# Système de Gestion de Projets

Un système de gestion de projets complet développé en PHP avec une architecture MVC.

## Fonctionnalités

- Gestion des utilisateurs (inscription, connexion, profil)
- Gestion des projets
- Gestion des tâches
- Gestion des employés
- Gestion des équipes
- Commentaires et notes
- Tableau de bord personnalisé

## Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Apache/Nginx
- Composer (pour la gestion des dépendances)

## Installation

1. Clonez le dépôt :
```bash
git clone https://github.com/nourane-hammouda/NexusCRUD.git
cd NexusCRUD 
```

2. Configurez la base de données :
- Créez une base de données MySQL
- Importez le fichier `db.sql`
- Copiez `config/config.example.php` vers `config/config.php`
- Modifiez les paramètres de connexion dans `config/config.php`

3. Configurez le serveur web :
- Assurez-vous que le répertoire `public` est le point d'entrée
- Activez le module rewrite d'Apache
- Configurez les permissions des dossiers

4. Installez les dépendances :
```bash
composer install
```

## Structure du Projet

```
├── config/             # Configuration
├── controllers/        # Contrôleurs
├── models/            # Modèles
├── public/            # Point d'entrée public
├── views/             # Vues
│   ├── includes/      # Partiels
│   ├── employees/     # Vues des employés
│   ├── projects/      # Vues des projets
│   └── tasks/         # Vues des tâches
├── assets/            # Ressources statiques
│   ├── css/          # Styles CSS
│   ├── js/           # Scripts JavaScript
│   └── images/       # Images
├── .gitignore         # Fichiers ignorés par Git
├── README.md          # Documentation
├──db.sql            # Structure de la base de données
├── index.html         # Page d'acceuil
├── Creer_nv_projet.html # Page contenant les tableaux de bords
├── profil.html       # Page de profil
└── style.css        # style css de toutes les pages
```

## Utilisation

1. Accédez à l'application via votre navigateur
2. Créez un compte administrateur
3. Commencez à gérer vos projets, tâches et équipes

## Sécurité

- Protection contre les injections SQL
- Validation des entrées utilisateur
- Gestion sécurisée des sessions
- Protection CSRF
- Hachage des mots de passe

## Contribution

1. Fork le projet
2. Créez une branche pour votre fonctionnalité (`git checkout -b feature/AmazingFeature`)
3. Committez vos changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrez une Pull Request

## Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## Contact

Nourane HAMMOUDA - nouranehamouda09@gmail@.com
Sow Penda- 43000120@parisnanterre.fr

Lien du projet: https://github.com/nourane-hammouda/NexusCRUD
