#!/bin/bash

# Script de vérification post-déploiement
# À exécuter via SSH sur le serveur après le premier déploiement

echo "🚀 Vérification de l'installation Laravel..."

# Vérifier la structure des dossiers
echo "📁 Vérification de la structure..."
if [ ! -d "storage" ] || [ ! -d "bootstrap/cache" ] || [ ! -d "public" ]; then
    echo "❌ Structure de dossiers incomplète!"
    exit 1
fi
echo "✅ Structure OK"

# Vérifier le fichier .env
echo "🔧 Vérification de .env..."
if [ ! -f ".env" ]; then
    echo "❌ Fichier .env manquant!"
    echo "💡 Créez-le à partir de .env.example"
    exit 1
fi
echo "✅ .env présent"

# Vérifier APP_KEY
if ! grep -q "APP_KEY=base64:" .env; then
    echo "⚠️  APP_KEY non généré, génération..."
    php artisan key:generate --force
fi
echo "✅ APP_KEY configuré"

# Vérifier/créer la base de données SQLite
echo "🗄️  Vérification de la base de données..."
if [ ! -f "database/database.sqlite" ]; then
    echo "⚠️  Création de la base de données SQLite..."
    touch database/database.sqlite
    chmod 664 database/database.sqlite
    php artisan migrate --force
    php artisan db:seed --force
fi
echo "✅ Base de données OK"

# Réparer les permissions
echo "🔒 Configuration des permissions..."
chmod -R 755 storage bootstrap/cache
chmod 755 database
chmod 664 database/database.sqlite
echo "✅ Permissions configurées"

# Optimiser pour la production
echo "⚡ Optimisation Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✅ Optimisations appliquées"

# Vérifier le .htaccess de protection racine
if [ ! -f ".htaccess" ]; then
    echo "🛡️  Création du .htaccess de protection..."
    echo "deny from all" > .htaccess
fi
echo "✅ Protection racine active"

# Résumé
echo ""
echo "✨ Installation terminée avec succès!"
echo ""
echo "📌 Vérifications finales:"
echo "   1. Document Root doit pointer vers: $(pwd)/public"
echo "   2. URL du site: https://finance.digitoyou.com"
echo "   3. Comptes de connexion:"
echo "      - abdellah@agence.ma / password123"
echo "      - mouad@agence.ma / password123"
echo "      - admin@agence.ma / admin123"
echo ""
echo "🔗 Testez maintenant: https://finance.digitoyou.com/login"
