# Déploiement sur Render.com

## 🚀 Étapes de déploiement

### 1. Créer un compte Render
- Va sur https://render.com
- Connecte-toi avec ton compte GitHub

### 2. Créer un nouveau Web Service
1. Clique sur **"New +"** → **"Web Service"**
2. Connecte ton repo GitHub: `Jouider/digitoyou-finance`
3. Render détectera automatiquement que c'est un projet PHP

### 3. Configuration du service

Utilise ces paramètres:

**Général:**
- **Name**: `digitoyou-finance`
- **Region**: Frankfurt (le plus proche)
- **Branch**: `main`
- **Root Directory**: (laisser vide)

**Build & Deploy:**
- **Runtime**: PHP
- **Build Command**: 
  ```bash
  bash render-build.sh
  ```
- **Start Command**:
  ```bash
  php artisan serve --host=0.0.0.0 --port=$PORT
  ```

**Instance Type:**
- Sélectionne **"Free"** (750h/mois gratuit)

### 4. Variables d'environnement

Render les configure automatiquement via `render.yaml`, mais tu peux les modifier dans le dashboard:

**Variables importantes:**
- `APP_KEY` → Sera généré automatiquement
- `APP_URL` → Sera l'URL fournie par Render (ex: `https://digitoyou-finance.onrender.com`)
- `DB_CONNECTION` → `sqlite`

**Note**: Le fichier `render.yaml` dans le repo configure tout automatiquement!

### 5. Déployer

1. Clique sur **"Create Web Service"**
2. Render va:
   - ✅ Cloner ton repo
   - ✅ Installer les dépendances
   - ✅ Créer la base SQLite
   - ✅ Lancer les migrations
   - ✅ Seeder les données
   - ✅ Optimiser Laravel
   - ✅ Démarrer l'application

**Premier déploiement**: ~5-10 minutes

### 6. Accéder à l'application

Render te donnera une URL comme:
```
https://digitoyou-finance.onrender.com
```

**Comptes de connexion:**
- `abdellah@agence.ma` / `password123`
- `mouad@agence.ma` / `password123`
- `admin@agence.ma` / `admin123`

## 🔄 Déploiement automatique

Chaque fois que tu fais `git push origin main`, Render redéploie automatiquement! 🎉

## 📊 Avantages

✅ **Gratuit** (750h/mois = 24/7 pour un petit site)
✅ **SSL automatique** (HTTPS)
✅ **Base de données** gérée automatiquement
✅ **Logs** accessibles dans le dashboard
✅ **Pas de problèmes** de permissions
✅ **Déploiement Git** automatique
✅ **Variables d'environnement** sécurisées

## ⚠️ Limitations du plan gratuit

- Se met en veille après **15 minutes d'inactivité**
- Redémarre en **~30 secondes** à la première requête
- Parfait pour une application interne d'équipe!

## 🔧 Dépannage

**Si l'application ne démarre pas:**
1. Va dans **Logs** dans le dashboard Render
2. Vérifie les erreurs de build
3. Les migrations SQLite se font automatiquement

**Pour forcer un redéploiement:**
- Dashboard → **Manual Deploy** → **Clear build cache & deploy**

## 🌐 Domaine personnalisé (optionnel)

Si tu veux utiliser `finance.digitoyou.com`:
1. Dans Render → **Settings** → **Custom Domains**
2. Ajoute `finance.digitoyou.com`
3. Configure le CNAME dans ton DNS:
   ```
   CNAME finance digitoyou-finance.onrender.com
   ```

## 📱 Surveillance

Render envoie des emails si:
- Le déploiement échoue
- L'application crash
- Utilisation élevée des ressources

---

**C'est tout!** Beaucoup plus simple que l'hébergement partagé FTP! 🚀
