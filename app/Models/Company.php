<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the teams for the company.
     */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    /**
     * Get all projects of a given status for the company.
     */
    public function projectsByStatus(string $status): HasManyThrough
    {
        return $this->hasManyThrough(
            Project::class, // Final Model
            Team::class,    // Intermediate Model
            'company_id',  // Foreign key on the intermediate model
            'team_id',     // Foreign key on the final model
            'id',          // Local key on the current model
            'id'           // Local key on the intermediate model
        )->where('projects.status', $status); // Apply the filter
    }
} 