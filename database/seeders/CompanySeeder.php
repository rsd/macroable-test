<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'Jumba Investments',
            'description' => 'A leading quantitative investment firm.',
        ]);

        Company::create([
            'name' => 'Acme Corporation',
            'description' => 'A general-purpose company.',
        ]);

        Company::create([
            'name' => 'Beta Technologies',
            'description' => 'A technology research and development firm.',
        ]);
    }
} 