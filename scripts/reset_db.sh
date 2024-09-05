#!/bin/bash

# Supprimer la base de données existante
# php bin/console doctrine:database:drop --force --if-exists

# Recréer la base de données
php bin/console doctrine:database:create --if-not-exists

# Générer les migrations
php bin/console make:migration --no-interaction

# Exécuter les migrations
php bin/console doctrine:migrations:migrate --no-interaction

# Charger les fixtures (si nécessaire)
# php bin/console doctrine:fixtures:load --no-interaction

echo "Database reset complete"