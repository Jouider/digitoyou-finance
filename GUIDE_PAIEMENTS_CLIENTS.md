# 💰 Guide des Paiements Clients

## 📋 Vue d'Ensemble

Le système gère maintenant les **paiements progressifs** des clients. Vous pouvez enregistrer :
- Les **avances** au démarrage du projet
- Les **paiements partiels** en cours de réalisation
- Le **paiement final** à la livraison
- Le **reste** si nécessaire

## 🎯 Cas d'Usage Pratiques

### Scénario 1 : Projet avec Avance 50%

**Client "Ahmed Boutique" - Site E-commerce 30,000 DH**

1. **Au démarrage** (1er Novembre) :
   - Type : Avance
   - Montant : 15,000 DH (50%)
   - Méthode : Virement
   - Notes : "Avance 50% au démarrage"

2. **À la livraison** (15 Décembre) :
   - Type : Paiement Final
   - Montant : 15,000 DH (50%)
   - Méthode : Virement
   - Notes : "Solde à la livraison du site"

**Résultat** : Le système affiche automatiquement que 100% du projet est payé ✅

---

### Scénario 2 : Projet en 3 Paiements

**Client "FZ Consulting" - Site Vitrine 15,000 DH**

1. **Au démarrage** :
   - Type : Avance
   - Montant : 5,000 DH (33%)
   - Notes : "Premier tiers à la signature"

2. **Mi-projet** :
   - Type : Paiement Partiel
   - Montant : 5,000 DH (33%)
   - Notes : "Deuxième tiers après validation maquettes"

3. **À la livraison** :
   - Type : Paiement Final
   - Montant : 5,000 DH (34%)
   - Notes : "Solde à la mise en ligne"

---

### Scénario 3 : Projet avec Retard de Paiement

**Client "Bennani Tech" - Application Web 35,000 DH**

1. **Au démarrage** :
   - Type : Avance
   - Montant : 15,000 DH (43%)

2. **À la livraison** :
   - Type : Paiement Final
   - Montant : 15,000 DH (43%)

3. **Plus tard** :
   - Type : Reste
   - Montant : 5,000 DH (14%)
   - Notes : "Solde final après délai de paiement"

---

## 📊 Suivi et Visualisation

### Sur la Page du Projet

Vous verrez :
- **Barre de progression** : Visualisation graphique du % payé
- **Montant total payé** : En vert
- **Reste à payer** : En rouge
- **Liste chronologique** de tous les paiements

### Sur la Liste des Projets

Chaque projet affiche :
- Prix total du projet
- Montant déjà payé
- Barre de progression
- Reste à payer

---

## 💡 Bonnes Pratiques

### 1. Toujours demander une avance
```
Recommandation : 30% à 50% au démarrage
```
Cela garantit l'engagement du client et couvre vos premiers frais.

### 2. Structurer les paiements selon les livrables
```
Exemple :
- 40% à la signature
- 30% à la validation des maquettes
- 30% à la mise en ligne
```

### 3. Enregistrer immédiatement chaque paiement
Dès réception du virement, enregistrez-le dans le système pour un suivi en temps réel.

### 4. Utiliser les notes
Ajoutez des détails pour chaque paiement :
- Numéro de transaction
- Date de virement
- Raison du paiement
- Observations particulières

---

## 🔍 Exemples de Répartitions Courantes

### Modèle Standard (2 paiements)
- **50%** Avance au démarrage
- **50%** Solde à la livraison

### Modèle Sécurisé (3 paiements)
- **40%** Avance à la signature
- **30%** Paiement intermédiaire (validation design)
- **30%** Solde à la mise en ligne

### Modèle Progressive (4 paiements)
- **30%** Avance au démarrage
- **20%** Après validation maquettes
- **30%** Après développement
- **20%** À la livraison finale

### Modèle Confiance (1 paiement)
- **100%** À la livraison
⚠️ **Attention** : À éviter sauf clients de confiance établie

---

## 📈 Analyse Financière

### Calculer le Taux de Paiement Moyen
1. Allez dans "Projets"
2. Regardez la colonne "Paiements"
3. Identifiez les projets avec faible % de paiement

### Identifier les Clients à Relancer
- Projets terminés avec paiement < 100%
- Projets en cours avec avance < 30%
- Projets avec délai de paiement dépassé

---

## 🎨 Interface Utilisateur

### Page "Paiements Clients"

Accédez à **tous** les paiements enregistrés :
- Filtre par projet
- Filtre par client
- Recherche par montant
- Vue chronologique

### Actions Disponibles

Pour chaque paiement :
- 👁️ **Voir** : Détails complets
- ✏️ **Modifier** : Corriger montant/date
- 🗑️ **Supprimer** : Retirer un paiement erroné

---

## 📱 Navigation Rapide

### Pour Ajouter un Paiement Client

**Méthode 1** : Depuis la liste
```
Menu > Paiements Clients > Nouveau Paiement Client
```

**Méthode 2** : Depuis un projet
```
Projets > [Sélectionner projet] > Ajouter Paiement
```

### Pour Voir l'Historique d'un Projet

```
Projets > [Sélectionner projet] > Section "Suivi des Paiements Clients"
```

---

## 🔐 Règles de Gestion

### Validation des Paiements
- Un paiement ne peut pas être négatif
- La somme des paiements peut dépasser le prix (si modification de prix)
- Tous les montants sont en Dirhams marocains (DH)

### Types de Paiements
- **Avance** : Premier paiement au démarrage
- **Partiel** : Paiement intermédiaire
- **Final** : Dernier paiement principal
- **Reste** : Complément après le final

### Méthodes de Paiement
- **Virement** : Transfert bancaire (recommandé)
- **Espèces** : Paiement cash
- **Chèque** : Paiement par chèque bancaire
- **Autre** : Autres méthodes (PayPal, Stripe, etc.)

---

## 📊 Exemples Concrets

### Projet A : Paiement Complet
```
Prix total : 25,000 DH
- Avance (01/09) : 10,000 DH
- Final (15/10) : 15,000 DH
Total payé : 25,000 DH ✅
Reste : 0 DH
Statut : 100% payé
```

### Projet B : En Cours de Paiement
```
Prix total : 35,000 DH
- Avance (15/11) : 15,000 DH
Total payé : 15,000 DH
Reste : 20,000 DH ⚠️
Statut : 43% payé
```

### Projet C : Surpayé (avec ajustement)
```
Prix initial : 30,000 DH
- Avance : 15,000 DH
- Final : 18,000 DH (augmentation scope)
Total payé : 33,000 DH
Prix ajusté à : 33,000 DH
Statut : 100% payé ✅
```

---

## 🚀 Workflow Recommandé

### 1. Création du Projet
- Créer le client
- Créer le projet avec le prix convenu
- Définir les dates

### 2. Premier Paiement
- Demander l'avance (30-50%)
- Attendre réception du virement
- Enregistrer immédiatement dans "Paiements Clients"

### 3. Développement
- Si paiements intermédiaires : les enregistrer au fur et à mesure
- Vérifier régulièrement la progression dans la page du projet

### 4. Livraison
- Enregistrer le paiement final
- Vérifier que le total = 100%
- Créer la distribution des bénéfices

---

## 💡 Astuces Pro

### Rappel Automatique
Créez une checklist mensuelle :
- [ ] Vérifier les projets < 100% payés
- [ ] Relancer les clients en retard
- [ ] Mettre à jour les paiements reçus

### Notes Utiles
Exemples de notes à ajouter :
- "Ref virement: TRX123456789"
- "Payé après relance du 15/12"
- "Bonus client fidèle -500 DH"
- "Paiement anticipé -5% discount"

### Exportation
Pour vos rapports comptables :
1. Ouvrir "Paiements Clients"
2. Prendre des captures d'écran
3. Ou copier les montants dans Excel

---

## 📞 Cas Particuliers

### Client qui paie en plusieurs petites tranches
```
Utilisez le type "Partiel" pour chaque tranche
Exemple : 5 paiements de 2,000 DH = 10,000 DH total
```

### Client qui négocie une réduction
```
1. Modifier le prix du projet
2. Enregistrer les paiements selon le nouveau montant
```

### Paiement enregistré par erreur
```
1. Aller dans Paiements Clients
2. Trouver le paiement
3. Cliquer sur "Supprimer" (icône poubelle)
```

### Changement de méthode de paiement
```
1. Modifier le paiement existant
2. Changer la "Méthode de Paiement"
3. Enregistrer
```

---

## ✅ Checklist Projet Type

- [ ] Client créé dans le système
- [ ] Projet créé avec prix convenu
- [ ] Avance demandée et reçue
- [ ] Avance enregistrée dans le système
- [ ] Développement en cours
- [ ] Paiements intermédiaires enregistrés (si applicable)
- [ ] Livraison effectuée
- [ ] Paiement final reçu
- [ ] Paiement final enregistré
- [ ] Vérification : Total payé = Prix projet ✅
- [ ] Distribution des bénéfices créée

---

**Félicitations ! Vous maîtrisez maintenant le système de paiements clients !** 🎉

Pour toute question, consultez le README.md ou le GUIDE_UTILISATION.md
