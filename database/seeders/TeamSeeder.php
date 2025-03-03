<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::create([
            'company_id' => 1,
            'name' => 'Quantitative Analysis',
            'description' => 'Develops and implements quantitative models.',
        ]);
        Team::create([
            'company_id' => 1,
            'name' => 'Risk Management',
            'description' => 'Manages and mitigates financial risks.',
        ]);
        Team::create([
            'company_id' => 2,
            'name' => 'Marketing',
            'description' => 'Handles marketing and advertising campaigns.',
        ]);
        Team::create([
            'company_id' => 2,
            'name' => 'Sales',
            'description' => 'Manages sales and customer relationships.',
        ]);
        Team::create([
            'company_id' => 3,
            'name' => 'Research & Development',
            'description' => 'Conducts research and develops new technologies.',
        ]);
        Team::create([
            'company_id' => 1,
            'name' => 'Data Engineering',
            'description' => 'Manages data infrastructure and pipelines.',
        ]);
        Team::create([
            'company_id' => 3,
            'name' => 'Machine Learning',
            'description' => 'Develops and deploys machine learning models.',
        ]);
    }
} 