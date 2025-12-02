<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Models\Expense;
use App\Models\ProfitDistribution;
use App\Models\ProjectPayment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer les utilisateurs
        $this->call(UserSeeder::class);

        // Créer des clients
        $client1 = Client::create([
            'name' => 'Mohamed Alami',
            'email' => 'mohamed@example.com',
            'phone' => '0612345678',
            'company' => 'Alami Trading',
            'address' => 'Casablanca, Maroc',
            'is_active' => true
        ]);

        $client2 = Client::create([
            'name' => 'Fatima Zahra',
            'email' => 'fatima@example.com',
            'phone' => '0623456789',
            'company' => 'FZ Consulting',
            'address' => 'Rabat, Maroc',
            'is_active' => true
        ]);

        $client3 = Client::create([
            'name' => 'Youssef Bennani',
            'email' => 'youssef@example.com',
            'phone' => '0634567890',
            'company' => 'Bennani Tech',
            'address' => 'Marrakech, Maroc',
            'is_active' => true
        ]);

        // Créer des projets
        $project1 = Project::create([
            'client_id' => $client1->id,
            'name' => 'Site E-commerce Alami Trading',
            'description' => 'Site de vente en ligne pour produits traditionnels',
            'url' => 'https://alamitrading.ma',
            'price' => 25000.00,
            'status' => 'termine',
            'start_date' => '2025-09-01',
            'end_date' => '2025-10-15'
        ]);

        $project2 = Project::create([
            'client_id' => $client2->id,
            'name' => 'Site Vitrine FZ Consulting',
            'description' => 'Site de présentation des services',
            'url' => 'https://fzconsulting.ma',
            'price' => 15000.00,
            'status' => 'termine',
            'start_date' => '2025-10-01',
            'end_date' => '2025-11-01'
        ]);

        $project3 = Project::create([
            'client_id' => $client3->id,
            'name' => 'Application Web Bennani Tech',
            'description' => 'Application de gestion interne',
            'url' => 'https://app.bennanitech.ma',
            'price' => 35000.00,
            'status' => 'en_cours',
            'start_date' => '2025-11-15',
            'end_date' => null
        ]);

        // Créer des charges (hébergements et domaines inclus)
        Expense::create([
            'name' => 'Hébergement Alami Trading - OVH',
            'description' => 'Hébergement Shared OVH pour alamitrading.ma',
            'type' => 'hebergement',
            'amount' => 150.00,
            'frequency' => 'annuel',
            'expense_date' => '2025-10-15',
            'next_expense_date' => '2026-10-15',
            'status' => 'actif'
        ]);

        Expense::create([
            'name' => 'Domaine alamitrading.ma',
            'description' => 'Nom de domaine pour projet Alami Trading',
            'type' => 'domaine',
            'amount' => 200.00,
            'frequency' => 'annuel',
            'expense_date' => '2025-10-15',
            'next_expense_date' => '2026-10-15',
            'status' => 'actif'
        ]);

        Expense::create([
            'name' => 'Hébergement FZ Consulting - VPS',
            'description' => 'Hébergement VPS pour fzconsulting.ma',
            'type' => 'hebergement',
            'amount' => 80.00,
            'frequency' => 'mensuel',
            'expense_date' => '2025-11-01',
            'next_expense_date' => '2025-12-01',
            'status' => 'actif'
        ]);

        Expense::create([
            'name' => 'Domaine fzconsulting.ma',
            'description' => 'Nom de domaine pour FZ Consulting',
            'type' => 'domaine',
            'amount' => 180.00,
            'frequency' => 'annuel',
            'expense_date' => '2025-11-01',
            'next_expense_date' => '2026-11-01',
            'status' => 'actif'
        ]);

        Expense::create([
            'name' => 'Hébergement Bennani Tech - AWS',
            'description' => 'Hébergement Cloud AWS pour app.bennanitech.ma',
            'type' => 'hebergement',
            'amount' => 200.00,
            'frequency' => 'mensuel',
            'expense_date' => '2025-12-01',
            'next_expense_date' => '2026-01-01',
            'status' => 'actif'
        ]);

        // Charges logiciels et outils
        Expense::create([
            'name' => 'ChatGPT Plus',
            'description' => 'Abonnement ChatGPT pour développement',
            'type' => 'abonnement',
            'amount' => 200.00,
            'frequency' => 'mensuel',
            'expense_date' => '2025-11-01',
            'next_expense_date' => '2025-12-01',
            'status' => 'actif'
        ]);

        Expense::create([
            'name' => 'GitHub Copilot',
            'description' => 'Abonnement GitHub Copilot',
            'type' => 'abonnement',
            'amount' => 100.00,
            'frequency' => 'mensuel',
            'expense_date' => '2025-11-01',
            'next_expense_date' => '2025-12-01',
            'status' => 'actif'
        ]);

        Expense::create([
            'name' => 'Adobe Creative Cloud',
            'description' => 'Suite Adobe pour design',
            'type' => 'logiciel',
            'amount' => 600.00,
            'frequency' => 'mensuel',
            'expense_date' => '2025-11-01',
            'next_expense_date' => '2025-12-01',
            'status' => 'actif'
        ]);

        Expense::create([
            'name' => 'Figma Pro',
            'description' => 'Abonnement Figma',
            'type' => 'logiciel',
            'amount' => 150.00,
            'frequency' => 'mensuel',
            'expense_date' => '2025-11-01',
            'next_expense_date' => '2025-12-01',
            'status' => 'actif'
        ]);

        Expense::create([
            'name' => 'MacBook Pro M3',
            'description' => 'Ordinateur pour développement',
            'type' => 'materiel',
            'amount' => 25000.00,
            'frequency' => 'unique',
            'expense_date' => '2025-10-15',
            'next_expense_date' => null,
            'status' => 'actif'
        ]);

        Expense::create([
            'name' => 'Licence JetBrains',
            'description' => 'PhpStorm + WebStorm',
            'type' => 'logiciel',
            'amount' => 2500.00,
            'frequency' => 'annuel',
            'expense_date' => '2025-01-01',
            'next_expense_date' => '2026-01-01',
            'status' => 'actif'
        ]);

        Expense::create([
            'name' => 'Notion Team',
            'description' => 'Gestion de projets',
            'type' => 'abonnement',
            'amount' => 80.00,
            'frequency' => 'mensuel',
            'expense_date' => '2025-11-01',
            'next_expense_date' => '2025-12-01',
            'status' => 'actif'
        ]);

        Expense::create([
            'name' => 'AWS Credits',
            'description' => 'Crédits cloud pour tests',
            'type' => 'autre',
            'amount' => 500.00,
            'frequency' => 'unique',
            'expense_date' => '2025-09-15',
            'next_expense_date' => null,
            'status' => 'actif'
        ]);

        Expense::create([
            'name' => 'Ancien Slack Premium',
            'description' => 'Abonnement Slack (remplacé par Discord)',
            'type' => 'abonnement',
            'amount' => 120.00,
            'frequency' => 'mensuel',
            'expense_date' => '2025-08-01',
            'next_expense_date' => null,
            'status' => 'inactif'
        ]);

        // Créer des distributions de bénéfices
        // Pour le projet 1 (prix: 25000 DH)
        $profit1 = 25000.00 - 350.00; // Prix - coûts hébergement/domaine
        $shares1 = ProfitDistribution::calculateShares($profit1);
        ProfitDistribution::create([
            'project_id' => $project1->id,
            'total_profit' => $profit1,
            'agency_share' => $shares1['agency_share'],
            'sadaqah_share' => $shares1['sadaqah_share'],
            'abdellah_share' => $shares1['abdellah_share'],
            'mouad_share' => $shares1['mouad_share'],
            'agency_percentage' => 10.00,
            'sadaqah_percentage' => 10.00,
            'distribution_date' => '2025-10-20',
            'notes' => 'Distribution projet Alami Trading'
        ]);

        // Pour le projet 2 (prix: 15000 DH)
        $profit2 = 15000.00 - 260.00; // Prix - coûts
        $shares2 = ProfitDistribution::calculateShares($profit2);
        ProfitDistribution::create([
            'project_id' => $project2->id,
            'total_profit' => $profit2,
            'agency_share' => $shares2['agency_share'],
            'sadaqah_share' => $shares2['sadaqah_share'],
            'abdellah_share' => $shares2['abdellah_share'],
            'mouad_share' => $shares2['mouad_share'],
            'agency_percentage' => 10.00,
            'sadaqah_percentage' => 10.00,
            'distribution_date' => '2025-11-05',
            'notes' => 'Distribution projet FZ Consulting'
        ]);

        // Créer des paiements clients (avances et paiements progressifs)
        // Projet 1 : Payé en totalité (avance + reste)
        ProjectPayment::create([
            'project_id' => $project1->id,
            'type' => 'avance',
            'amount' => 10000.00,
            'payment_date' => '2025-09-01',
            'payment_method' => 'virement',
            'notes' => 'Avance de 40% au démarrage'
        ]);

        ProjectPayment::create([
            'project_id' => $project1->id,
            'type' => 'final',
            'amount' => 15000.00,
            'payment_date' => '2025-10-15',
            'payment_method' => 'virement',
            'notes' => 'Paiement final à la livraison'
        ]);

        // Projet 2 : Payé en 3 fois
        ProjectPayment::create([
            'project_id' => $project2->id,
            'type' => 'avance',
            'amount' => 5000.00,
            'payment_date' => '2025-10-01',
            'payment_method' => 'cheque',
            'notes' => 'Avance de 33%'
        ]);

        ProjectPayment::create([
            'project_id' => $project2->id,
            'type' => 'partiel',
            'amount' => 5000.00,
            'payment_date' => '2025-10-20',
            'payment_method' => 'virement',
            'notes' => 'Paiement partiel en cours de projet'
        ]);

        ProjectPayment::create([
            'project_id' => $project2->id,
            'type' => 'final',
            'amount' => 5000.00,
            'payment_date' => '2025-11-01',
            'payment_method' => 'virement',
            'notes' => 'Solde à la livraison'
        ]);

        // Projet 3 : En cours - seulement une avance
        ProjectPayment::create([
            'project_id' => $project3->id,
            'type' => 'avance',
            'amount' => 15000.00,
            'payment_date' => '2025-11-15',
            'payment_method' => 'virement',
            'notes' => 'Avance de 43% au démarrage du projet'
        ]);
    }
}
