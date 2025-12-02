# 🎯 Guide d'Utilisation - Système Finance Agence

## 📝 Vue d'Ensemble

Votre système de gestion financière est maintenant opérationnel ! Il vous permet de gérer tous les aspects financiers de votre agence digitale.

## 🚀 Comment Lancer l'Application

1. Ouvrez un terminal
2. Naviguez vers le dossier du projet :
   ```bash
   cd /Users/Abdellah/projects/digi-fianance
   ```
3. Lancez le serveur :
   ```bash
   php artisan serve
   ```
4. Ouvrez votre navigateur sur : **http://localhost:8000**

## 💡 Scénarios d'Utilisation

### Scénario 1 : Nouveau Client et Projet

**Exemple** : Un client "Ahmed Boutique" vous contacte pour créer un site e-commerce à 30,000 DH

1. **Ajouter le client** :
   - Cliquez sur "Clients" dans le menu
   - "Nouveau Client"
   - Remplissez : Nom, Email, Téléphone, Société
   - Enregistrez

2. **Créer le projet** :
   - Cliquez sur "Projets"
   - "Nouveau Projet"
   - Sélectionnez "Ahmed Boutique"
   - Nom : "Site E-commerce Ahmed"
   - Prix : 30000 DH
   - Statut : "En cours"
   - Date début : aujourd'hui
   - Enregistrez

### Scénario 2 : Enregistrer les Paiements Récurrents

**Pour chaque projet, vous devez payer l'hébergement et le domaine**

1. **Hébergement** :
   - Allez dans "Paiements"
   - "Nouveau Paiement"
   - Sélectionnez le projet
   - Type : "Hébergement"
   - Description : "Hébergement OVH Shared"
   - Montant : 150 DH (par exemple)
   - Fréquence : "Annuel"
   - Date paiement : aujourd'hui
   - Prochaine date : dans 1 an
   - Statut : "Payé"

2. **Nom de domaine** :
   - Même processus
   - Type : "Domaine"
   - Description : "ahmed-boutique.ma"
   - Montant : 200 DH
   - Fréquence : "Annuel"

### Scénario 3 : Gérer vos Charges

**Vos abonnements mensuels**

1. Allez dans "Charges"
2. Ajoutez chaque abonnement :
   - ChatGPT Plus : 200 DH/mois
   - GitHub Copilot : 100 DH/mois
   - Adobe Creative Cloud : 600 DH/mois
   - Figma Pro : 150 DH/mois
   - Etc.

Le système calculera automatiquement le total mensuel.

### Scénario 4 : Distribuer les Bénéfices d'un Projet Terminé

**Le projet "Ahmed Boutique" est terminé, il faut répartir les gains**

1. Allez dans "Répartition"
2. "Nouvelle Distribution"
3. Sélectionnez le projet "Ahmed Boutique"
4. Entrez le bénéfice total :
   - Prix du projet : 30,000 DH
   - Moins l'hébergement : -150 DH
   - Moins le domaine : -200 DH
   - **Bénéfice net = 29,650 DH**

5. Le système calcule automatiquement :
   - **Agence (10%)** : 2,965 DH → Pour réinvestir dans l'agence
   - **Sadaqah (2.5%)** : 741.25 DH → Part charitable
   - **Reste** : 25,943.75 DH
     - **Abdellah (50%)** : 12,971.88 DH
     - **Mouad (50%)** : 12,971.88 DH

6. Date de distribution : aujourd'hui
7. Enregistrez

## 📊 Utilisation du Dashboard

Le Dashboard vous montre en un coup d'œil :

### Statistiques en Haut
- **Clients Actifs** : Nombre de clients avec lesquels vous travaillez
- **Projets Actifs** : Projets en cours
- **Revenu Total** : Somme de tous vos projets
- **Charges Mensuelles** : Vos dépenses fixes

### Répartition Totale
- Combien vous avez gagné chacun (Abdellah & Mouad)
- Combien pour l'agence
- Total des Sadaqah versées

### Paiements à Venir
- Liste des hébergements et domaines à renouveler ce mois
- **Important** : Vérifiez régulièrement pour ne pas oublier un renouvellement !

### Charges Récurrentes
- Tous vos abonnements actifs
- Dates de prochain paiement

## 💰 Comprendre la Répartition

### Formule Complète

Pour un projet à **30,000 DH** :

1. **Coûts directs du projet** :
   - Hébergement : 150 DH
   - Domaine : 200 DH
   - Total coûts : 350 DH

2. **Bénéfice brut** : 30,000 - 350 = **29,650 DH**

3. **Distribution** :
   ```
   Part Agence = 29,650 × 10% = 2,965 DH
   Part Sadaqah = 29,650 × 2.5% = 741.25 DH
   Reste = 29,650 - 2,965 - 741.25 = 25,943.75 DH
   
   Abdellah = 25,943.75 ÷ 2 = 12,971.88 DH
   Mouad = 25,943.75 ÷ 2 = 12,971.88 DH
   ```

### Pourquoi cette répartition ?

- **10% Agence** : Pour investir dans de nouveaux outils, formations, marketing
- **2.5% Sadaqah** : Aumône obligatoire (zakat) pour purifier les gains
- **50-50** : Partage équitable entre les deux associés

## 🔔 Conseils Pratiques

### Chaque Mois :
1. Vérifier les "Paiements à venir" pour les renouvellements
2. Payer les charges mensuelles (ChatGPT, Adobe, etc.)
3. Mettre à jour le statut des projets

### Chaque Projet Terminé :
1. Marquer le projet comme "Terminé"
2. Créer une nouvelle distribution
3. Calculer le bénéfice réel (prix - coûts)
4. Enregistrer la répartition

### Bon à Savoir :
- Les montants sont en **Dirhams marocains (DH)**
- Les dates sont au format **jj/mm/aaaa**
- Le système garde l'historique de toutes les distributions
- Vous pouvez modifier les pourcentages dans le code si besoin

## 🛠️ Maintenance

### Réinitialiser les données de test :
```bash
php artisan migrate:fresh --seed
```

### Sauvegarder votre base de données :
```bash
cp database/database.sqlite database/backup-$(date +%Y%m%d).sqlite
```

### Voir les erreurs si problème :
```bash
tail -f storage/logs/laravel.log
```

## 📞 Structure des Données

### Pour chaque client, vous avez :
- Ses informations de contact
- Tous ses projets
- Historique des paiements

### Pour chaque projet, vous voyez :
- Le client associé
- Le prix et le statut
- Les paiements (hébergement, domaine)
- Les distributions de bénéfices

## 🎯 Prochaines Améliorations Possibles

1. **Notifications Email** : Recevoir un email 1 semaine avant un renouvellement
2. **Export PDF** : Générer des rapports mensuels en PDF
3. **Graphiques** : Visualiser l'évolution des revenus
4. **Factures Automatiques** : Générer les factures pour les clients
5. **Calendrier** : Vue calendrier des paiements à venir
6. **Multi-utilisateurs** : Login séparé pour Abdellah et Mouad
7. **Backup Cloud** : Sauvegarde automatique sur Dropbox/Google Drive

## ✅ Checklist Mensuelle

- [ ] Vérifier tous les paiements à venir
- [ ] Payer les charges mensuelles
- [ ] Mettre à jour les statuts des projets
- [ ] Calculer et distribuer les bénéfices des projets terminés
- [ ] Faire une sauvegarde de la base de données
- [ ] Consulter le total des revenus et dépenses

---

**Bon travail avec votre système de gestion financière !** 🚀

Si vous avez des questions, consultez le README.md pour plus de détails techniques.
