<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::create([
            'team_id' => 1,
            'name' => 'Options Gamma Analysis',
            'description' => 'Develop a model for analyzing options gamma exposure.',
            'status' => 'active',
            'start_date' => '2024-01-01',
            'end_date' => null,
        ]);
        Project::create([
            'team_id' => 1,
            'name' => 'Volatility Prediction',
            'description' => 'Create a machine learning model to predict market volatility.',
            'status' => 'completed',
            'start_date' => '2023-10-01',
            'end_date' => '2023-12-31',
        ]);
        Project::create([
            'team_id' => 2,
            'name' => 'Stress Testing Framework',
            'description' => 'Develop a framework for stress testing the company\'s portfolio.',
            'status' => 'active',
            'start_date' => '2024-01-15',
            'end_date' => null,
        ]);
        Project::create([
            'team_id' => 3,
            'name' => 'New Product Launch Campaign',
            'description' => 'Plan and execute the marketing campaign for a new product.',
            'status' => 'active',
            'start_date' => '2024-02-01',
            'end_date' => null,
        ]);
        Project::create([
            'team_id' => 4,
            'name' => 'Q1 Sales Target',
            'description' => 'Achieve the sales target for the first quarter.',
            'status' => 'completed',
            'start_date' => '2024-01-01',
            'end_date' => '2024-03-31',
        ]);
        Project::create([
            'team_id' => 5,
            'name' => 'AI-Powered Chatbot',
            'description' => 'Research and develop an AI-powered chatbot for customer service.',
            'status' => 'on-hold',
            'start_date' => '2023-11-01',
            'end_date' => '2023-12-15',
        ]);
        Project::create([
            'team_id' => 5,
            'name' => 'New Algorithm',
            'description' => 'Develop a new algorithm to improve efficiency.',
            'status' => 'active',
            'start_date' => '2024-03-01',
            'end_date' => '2024-06-01',
        ]);
        Project::create([
            'team_id' => 6,
            'name' => 'Data Pipeline Optimization',
            'description' => 'Optimize the existing data pipeline for performance and scalability.',
            'status' => 'active',
            'start_date' => '2024-02-15',
            'end_date' => null,
        ]);
        Project::create([
            'team_id' => 6,
            'name' => 'Data Warehouse Migration',
            'description' => 'Migrate the data warehouse to a new platform.',
            'status' => 'planning',
            'start_date' => '2024-04-01',
            'end_date' => '2024-06-30',
        ]);
        Project::create([
            'team_id' => 7,
            'name' => 'Credit Risk Model',
            'description' => 'Develop a machine learning model to assess credit risk.',
            'status' => 'active',
            'start_date' => '2024-03-01',
            'end_date' => null,
        ]);
        Project::create([
            'team_id' => 7,
            'name' => 'Fraud Detection System',
            'description' => 'Build a real-time fraud detection system using machine learning.',
            'status' => 'development',
            'start_date' => '2024-02-01',
            'end_date' => '2024-05-31',
        ]);
        Project::create([
            'team_id' => 1,
            'name' => 'High-Frequency Trading Algorithm',
            'description' => 'Develop and test a high-frequency trading algorithm.',
            'status' => 'backlogged',
            'start_date' => null,
            'end_date' => null,
        ]);
        Project::create([
            'team_id' => 2,
            'name' => 'Regulatory Reporting System',
            'description' => 'Implement a system for automated regulatory reporting.',
            'status' => 'completed',
            'start_date' => '2023-09-01',
            'end_date' => '2023-12-31',
        ]);
    }
} 