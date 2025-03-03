<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Project;
use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\ServiceProvider;

class ModelMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Company::macro('projectsByStatus', function (string $status): HasManyThrough {
            /** @var \App\Models\Company $this */
            return $this->hasManyThrough(
                Project::class, // Final Model
                Team::class,    // Intermediate Model
                'company_id',  // Foreign key on the intermediate model
                'team_id',     // Foreign key on the final model
                'id',          // Local key on the current model
                'id'           // Local key on the intermediate model
            )->where('projects.status', $status); // Apply the filter
        });
    }
}
