# 💰 Système de Gestion Financière - Agence Digitale

Application Laravel pour la gestion financière de votre agence digitale (Abdellah & Mouad).

## 🎯 Fonctionnalités

### 📊 Dashboard
- Vue d'ensemble des statistiques financières
- Nombre de clients actifs et projets en cours
- Revenu total et charges mensuelles
- Répartition automatique des bénéfices
- Suivi des paiements à venir

### 👥 Gestion des Clients
- Création et gestion des clients
- Informations complètes (nom, email, téléphone, société, adresse)
- Statut actif/inactif

### 📁 Gestion des Projets
- Suivi des projets par client
- Prix, statut (en cours, terminé, maintenance)
- Dates de début et fin
- URL du site web
- **Suivi des paiements clients** (avance, paiements partiels, paiement final)
- Barre de progression des paiements reçus
- Calcul automatique du reste à payer

### 💰 Paiements Clients
- **Avances** : Paiement initial au démarrage du projet
- **Paiements partiels** : Paiements intermédiaires pendant le projet
- **Paiement final** : Solde à la livraison
- Suivi du total payé vs reste à payer
- Pourcentage de paiement complété
- Méthodes de paiement (virement, espèces, chèque, autre)
- Historique complet des paiements par projet

### 💳 Gestion des Paiements
- **Hébergements** : Suivi des coûts d'hébergement
- **Noms de domaine** : Gestion des renouvellements
- Fréquences : mensuel, annuel, unique
- Rappels automatiques des dates de paiement
- Statuts : payé, en attente, retard

### 📋 Gestion des Charges
- Abonnements (ChatGPT, GitHub Copilot, etc.)
- Logiciels (Adobe Creative Cloud, Figma, etc.)
- Matériel et autres dépenses
- Charges récurrentes ou uniques
- Calcul automatique des charges mensuelles

### 💰 Répartition des Bénéfices
Calcul automatique selon cette formule :

**Bénéfice = Prix du projet - (Hébergement + Domaine + Charges)**

Distribution automatique :
- **10%** : Part de l'agence (réinvestissement)
- **2.5%** : Sadaqah (aumône)
- **50%** : Part d'Abdellah (du reste)
- **50%** : Part de Mouad (du reste)

**Exemple** : Pour un projet de 25,000 DH
- Agence : 2,500 DH (10%)
- Sadaqah : 625 DH (2.5%)
- Reste : 21,875 DH
  - Abdellah : 10,937.50 DH
  - Mouad : 10,937.50 DH

## 🚀 Installation

### Prérequis
- PHP 8.2+
- Composer
- SQLite (inclus avec PHP)

### Étapes d'installation

1. **Cloner le projet** (déjà fait)
```bash
cd /Users/Abdellah/projects/digi-fianance
```

2. **Installer les dépendances** (déjà fait)
```bash
composer install
```

3. **Configuration** (déjà fait)
Le fichier `.env` est déjà configuré avec SQLite

4. **Générer la clé d'application** (déjà fait)
```bash
php artisan key:generate
```

5. **Exécuter les migrations** (déjà fait)
```bash
php artisan migrate
```

6. **Insérer les données de test** (déjà fait)
```bash
php artisan db:seed
```

## 🎨 Lancer l'application

```bash
php artisan serve
```

Puis ouvrez votre navigateur sur : **http://localhost:8000**

## 📱 Structure de la Base de Données

### Tables principales :
- **clients** : Informations clients
- **projects** : Projets par client
- **project_payments** : Paiements clients (avances, partiels, finaux)
- **payments** : Paiements récurrents (hébergement, domaines)
- **expenses** : Charges de l'agence
- **profit_distributions** : Répartition des bénéfices

## 🎯 Utilisation

### Ajouter un nouveau client
1. Aller dans "Clients"
2. Cliquer sur "Nouveau Client"
3. Remplir les informations

### Créer un projet
1. Aller dans "Projets"
2. Cliquer sur "Nouveau Projet"
3. Sélectionner le client
4. Entrer le prix et les détails

### Enregistrer les paiements
1. Aller dans "Paiements"
2. Cliquer sur "Nouveau Paiement"
3. Choisir le type (hébergement/domaine)
4. Définir la fréquence et le montant

### Gérer les charges
1. Aller dans "Charges"
2. Ajouter vos abonnements (ChatGPT, Adobe, etc.)
3. Le système calcule automatiquement les charges mensuelles

### Distribuer les bénéfices
1. Aller dans "Répartition"
2. Cliquer sur "Nouvelle Distribution"
3. Sélectionner le projet
4. Le système calcule automatiquement les parts

## 📊 Données de Test Incluses

Le système inclut des données de démonstration :
- 3 clients (Mohamed Alami, Fatima Zahra, Youssef Bennani)
- 3 projets (dont 2 terminés, 1 en cours)
- Paiements d'hébergement et domaines
- Charges mensuelles (ChatGPT, GitHub Copilot, Adobe, Figma)
- 2 distributions de bénéfices complètes

## 🔄 Prochaines Étapes Suggérées

### À développer :
1. **Authentification** : Système de login pour sécuriser l'accès
2. **Notifications** : Alertes email pour les paiements à venir
3. **Rapports** : Export PDF des distributions et statistiques
4. **Factures** : Génération automatique de factures clients
5. **Graphiques** : Visualisation des revenus/dépenses
6. **Multi-devises** : Support de plusieurs monnaies
7. **Backup automatique** : Sauvegarde régulière de la base de données

## 🛠️ Commandes Artisan Utiles

```bash
# Réinitialiser la base de données
php artisan migrate:fresh --seed

# Créer un nouveau contrôleur
php artisan make:controller NomController

# Créer un nouveau modèle
php artisan make:model NomModele

# Créer une migration
php artisan make:migration create_table_name

# Lancer les tests
php artisan test
```

## 📝 Notes Importantes

- Le système utilise **SQLite** pour faciliter le déploiement
- Les pourcentages de distribution sont configurables dans le modèle `ProfitDistribution`
- Tous les montants sont en **Dirhams marocains (DH)**
- Les dates de paiement sont trackées automatiquement

## 🤝 Support

Pour toute question ou problème :
- Vérifier les logs : `storage/logs/laravel.log`
- Effacer le cache : `php artisan cache:clear`
- Réinitialiser la config : `php artisan config:clear`

---

Créé avec ❤️ pour la gestion financière de l'agence digitale

