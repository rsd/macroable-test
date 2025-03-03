<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Traits\Macroable;

class Company extends Model
{
    use HasFactory;
    use Macroable {
        // Alias Macroable's magic methods to new names
        Macroable::__call as macroCall;
        Macroable::__callStatic as macroCallStatic;
    }

    public function __call($method, $parameters)
    {
        // If a macro is defined for this method, call it
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }
        // Otherwise, defer to Eloquent's normal behavior
        return parent::__call($method, $parameters);
    }

    public static function __callStatic($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return static::macroCallStatic($method, $parameters);
        }
        return parent::__callStatic($method, $parameters);
    }

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
} 