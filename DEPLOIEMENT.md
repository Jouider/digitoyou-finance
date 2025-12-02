# Guide de Déploiement Automatique via FTP

Ce projet est configuré pour un déploiement automatique vers Heberjahiz via GitHub Actions et FTP.

**⚠️ Important** : Le repo est privé, donc on utilise FTP pour le déploiement automatique.

## 🚀 Configuration initiale

### 1. Configurer les secrets GitHub

Allez sur : `https://github.com/Jouider/digitoyou-finance/settings/secrets/actions`

Ajoutez ces 3 secrets :

- **FTP_SERVER** : `ftp.digitoyou.com`
- **FTP_USERNAME** : `abdellah@finance.digitoyou.com`
- **FTP_PASSWORD** : Votre mot de passe FTP

📝 **Informations du serveur** :
- Serveur FTP: `ftp.digitoyou.com`
- Port: `21`
- Répertoire: `/home/digitfl9/finance.digitoyou.com/abdellah`

### 2. Structure des dossiers sur le serveur

```
/home/digitfl9/finance.digitoyou.com/
  └── abdellah/              # Racine FTP - Tous les fichiers Laravel ici
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

1. Le sous-domaine `finance.digitoyou.com` devrait déjà être créé
2. Vérifier que le **Document Root** pointe sur : `/home/digitfl9/finance.digitoyou.com/abdellah/public`
3. Si ce n'est pas le cas, le modifier dans cPanel → Domaines

### 4. Premier déploiement manuel (via cPanel File Manager)

**Étape A : Uploader les fichiers**
1. Télécharger le ZIP du repo depuis GitHub ou utiliser FileZilla
2. Se connecter avec : `abdellah@finance.digitoyou.com` / mot de passe
3. Uploader vers la racine FTP (correspond à `/home/digitfl9/finance.digitoyou.com/abdellah/`)
4. Extraire si nécessaire

**Étape B : Créer le fichier `.env`** (via File Manager → Éditeur)

Dans la racine (à côté de `artisan`) :
```env
APP_NAME="Finance DigiToYou"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://finance.digitoyou.com

DB_CONNECTION=sqlite

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

**Étape C : Configuration via Terminal cPanel** (ou PHP Selector)

Si tu as accès au Terminal (même limité) :
```bash
cd /home/digitfl9/finance.digitoyou.com/abdellah
php artisan key:generate
touch database/database.sqlite
php artisan migrate --force
php artisan db:seed --force
```

**Sinon, via File Manager** :
1. Créer manuellement `database/database.sqlite` (fichier vide)
2. Pour générer APP_KEY : utilise un générateur en ligne Laravel ou contacte le support
3. Permissions : Clic droit → Change Permissions → 755 pour `storage/` et `bootstrap/cache/`

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

1. ✅ Installation des dépendances Composer (optimisées)
2. ✅ Envoi des fichiers modifiés via FTP
3. ✅ Protection automatique de la racine Laravel

### Workflow de développement

```bash
# 1. Faire vos modifications localement
git add .
git commit -m "Ajout fonctionnalité X"

# 2. Pousser sur GitHub
git push origin main

# 3. GitHub Actions déploie automatiquement en 2-3 minutes ! 🎉
```

**📊 Suivi du déploiement** : Va sur https://github.com/Jouider/digitoyou-finance/actions

**⚠️ Note** : Sans accès SSH, tu devras parfois vider les caches manuellement via File Manager :
- Supprimer le contenu de `storage/framework/cache/data/`
- Supprimer le contenu de `storage/framework/views/`

## 📋 Maintenance (sans SSH)

**Vider les caches** (via File Manager cPanel) :
1. Aller dans `storage/framework/cache/data/` → Supprimer tout le contenu
2. Aller dans `storage/framework/views/` → Supprimer tout le contenu
3. Aller dans `bootstrap/cache/` → Supprimer `config.php` et `routes.php` (si présents)

**Mettre à jour la base de données** :
- Si tu as Terminal cPanel : `cd /public_html/finance && php artisan migrate --force`
- Sinon : Exécuter les migrations via un fichier PHP temporaire (voir support)

**Réparer les permissions** (via File Manager) :
- `storage/` → Clic droit → Change Permissions → 755
- `bootstrap/cache/` → Clic droit → Change Permissions → 755
- `database/database.sqlite` → 644

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
