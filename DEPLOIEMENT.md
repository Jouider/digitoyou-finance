# Guide de Déploiement Automatique

Ce projet est configuré pour un déploiement automatique vers Heberjahiz via GitHub Actions et FTP.

## 🚀 Configuration initiale

### 1. Configurer les secrets GitHub

Allez sur votre repo GitHub : `https://github.com/Jouider/digitoyou-finance/settings/secrets/actions`

Ajoutez ces 3 secrets :

- **FTP_SERVER** : Adresse du serveur FTP (ex: `ftp.digitoyou.com` ou l'IP)
- **FTP_USERNAME** : Nom d'utilisateur FTP
- **FTP_PASSWORD** : Mot de passe FTP

### 2. Structure des dossiers sur le serveur

```
/public_html/
  └── finance/              # Tous les fichiers Laravel
      ├── app/
      ├── bootstrap/
      ├── config/
      ├── database/
      ├── public/          # ← Document Root du sous-domaine
      ├── resources/
      ├── routes/
      ├── storage/
      ├── vendor/
      └── .env
```

### 3. Configuration du sous-domaine dans cPanel

1. Créer le sous-domaine `finance.digitoyou.com`
2. Définir le **Document Root** sur : `/public_html/finance/public`

### 4. Premier déploiement manuel (via FTP)

1. **Uploader tous les fichiers** du projet vers `/public_html/finance/`

2. **Créer le fichier `.env`** (ne jamais le mettre dans Git) :
```bash
APP_NAME="Finance DigiToYou"
APP_ENV=production
APP_KEY=              # À générer
APP_DEBUG=false
APP_URL=https://finance.digitoyou.com

DB_CONNECTION=sqlite
# Le fichier SQLite sera créé dans database/database.sqlite

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

3. **Via SSH ou Terminal File Manager cPanel** :
```bash
cd /public_html/finance
php artisan key:generate
touch database/database.sqlite
php artisan migrate --force
php artisan db:seed --force
chmod -R 755 storage bootstrap/cache
chmod 664 database/database.sqlite
```

4. **Créer `.htaccess` à la racine** (`/public_html/finance/.htaccess`) :
```apache
# Protéger la racine Laravel
deny from all
```

### 5. Vérifier le `.htaccess` dans `/public` (déjà présent)

Le fichier `/public_html/finance/public/.htaccess` doit contenir :
```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## 🔄 Déploiements automatiques

Après la configuration initiale, **chaque push sur la branche `main`** déclenche automatiquement :

1. ✅ Installation des dépendances Composer
2. ✅ Envoi des fichiers via FTP
3. ✅ Optimisation du cache Laravel (si SSH disponible)

### Workflow de développement

```bash
# 1. Faire vos modifications localement
git add .
git commit -m "Ajout fonctionnalité X"

# 2. Pousser sur GitHub
git push origin main

# 3. GitHub Actions déploie automatiquement ! 🎉
```

## 📋 Commandes utiles après déploiement

Si vous avez accès SSH, après un déploiement :

```bash
cd /public_html/finance

# Vider et reconstruire les caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Si modifications de base de données
php artisan migrate --force

# Réparer les permissions
chmod -R 755 storage bootstrap/cache
```

## 🐛 Résolution de problèmes

### Erreur 500
- Vérifier les logs : `/storage/logs/laravel.log`
- Vérifier les permissions : `chmod -R 755 storage bootstrap/cache`
- Vérifier que `.env` existe avec `APP_KEY` généré

### Page blanche
- S'assurer que le Document Root pointe vers `/public_html/finance/public`
- Vérifier `.htaccess` dans le dossier public

### Erreur de base de données
- Vérifier que `database/database.sqlite` existe
- Permissions : `chmod 664 database/database.sqlite`
- Dossier database : `chmod 755 database`

### GitHub Actions échoue
- Vérifier les secrets : FTP_SERVER, FTP_USERNAME, FTP_PASSWORD
- Voir les logs d'exécution dans l'onglet "Actions" du repo

## 🔐 Sécurité

- ✅ `.env` n'est jamais envoyé (dans .gitignore)
- ✅ Seul `/public` est accessible publiquement
- ✅ `.htaccess` protège la racine Laravel
- ✅ `APP_DEBUG=false` en production
- ✅ Base de données SQLite avec permissions restreintes

## 📦 Fichiers exclus du déploiement

Le workflow exclut automatiquement :
- `node_modules/`
- Tests et fichiers de développement
- `.git/` et `.github/`
- `.env` (à créer manuellement sur le serveur)
- Caches et logs
- Base de données locale

## 🎯 Comptes par défaut

Après le seeding initial :

- **Abdellah** : `abdellah@agence.ma` / `password123`
- **Mouad** : `mouad@agence.ma` / `password123`
- **Admin** : `admin@agence.ma` / `admin123`

---

**🌐 URL de production** : https://finance.digitoyou.com
