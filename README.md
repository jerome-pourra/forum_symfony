### Installation
```bash
composer install
```

Créer un nouveau fichier .env.local à la racine du projet
Override la variable DATABASE_URL avec tes paramètres
```bash
DATABASE_URL="mysql://{YOUR_DB_USER}:{YOUR_DB_PASSWORD}@127.0.0.1:3306/{YOUR_DB_NAME}?serverVersion={YOUR_VERSION}&charset=utf8mb4"
```

### Lancement du projet

Il y a plusieurs fichiers .sh dans le dossier ./scripts

- start.sh - Lance le serveur symfony
- reset_db.sh - Réinitialise et recréer la base de données
- fixtures.sh - Permet de sauvegarder des données de demo dans la base