# Laravel Macroable-Eloquent Conflict Demo

This project demonstrates a bug that occurs when using Laravel's `Macroable` trait with `Eloquent` models, specifically when implementing relationship methods as macros.

## Bug Description

When adding the `Macroable` trait to an Eloquent model and moving instance methods to macros, certain queries break with a `BadMethodCallException` error because the Macroable trait's magic methods override Eloquent's own implementations.

## Demo Setup

1. **Install dependencies:**
   ```bash
   composer install
   ```

2. **Set up database:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   php artisan migrate
   php artisan db:seed
   ```

## Repository Branches

This repository has three branches demonstrating different stages:

1. **`before-macroable`**: The original implementation with `projectsByStatus()` as a direct method on the `Company` model.

2. **`macroable-bug`**: Shows the bug when using Macroable to define `projectsByStatus()` as a macro.

3. **`macroable-inline-fix`**: Demonstrates a workaround in the Model class to make it work (also `main` branch).

Note: A proper fix should be implemented in the Macroable trait itself, not in individual models.

## Reproducing the Bug

The project implements a simple data structure:
- Companies have many Teams
- Teams have many Projects

The bug appears when:

1. We implement a `projectsByStatus` method to get filtered projects from a company
2. We move this method from being a direct method on the `Company` model to a macro

### Working Example (Direct Method)

When `projectsByStatus` is implemented directly on the `Company` model:

```bash
php artisan tinker --execute="echo App\Models\Company::query()->first()->projectsByStatus('active')->count();"
# Output: 3
```

### Bug Example (Macro Implementation)

After converting to a macro by:
1. Adding `use Macroable;` to the `Company` model
2. Moving the method to a service provider as a macro

```bash
php artisan tinker --execute="echo App\Models\Company::query()->first()->projectsByStatus('active')->count();"
# Output: BadMethodCallException  Method App\Models\Company::hydrate does not exist.
```

## Inline Solution (Model-Level Fix)

The `macroable-inline-fix` branch demonstrates a workaround that preserves both Macroable functionality and Eloquent's magic method handling:

```php
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
}
```

This solution:
1. Aliases Macroable's magic methods to new names
2. Provides custom implementations of `__call` and `__callStatic` that:
   - First check if a macro exists for the method
   - If so, call the macro using the aliased method
   - If not, defer to Eloquent's implementation

With this fix, both macro methods and Eloquent's dynamic methods work correctly:

```bash
php artisan tinker --execute="echo App\Models\Company::query()->first()->projectsByStatus('active')->count();"
# Output: 3
```

## Technical Explanation

The issue occurs because:

1. **Magic Method Conflict**: Both Eloquent models and the Macroable trait use `__call` and `__callStatic` magic methods.

2. **Trait Method Precedence**: When Macroable is used in an Eloquent model, its magic methods override Eloquent's implementations due to PHP's trait precedence rules.

3. **Method Interception**: Dynamic calls like `hydrate` (which are part of Eloquent's internal workings) are intercepted by Macroable instead of being handled by Eloquent.

4. **Missing Implementation**: Since Macroable doesn't have macros for Eloquent's internal methods, it throws `BadMethodCallException`.

## Real-World Relevance

This issue is particularly important when working with **Laravel Modules** where:

1. A modular architecture may require an "extra" model to extend another model, but the extra model isn't always present.

2. The extra model depends on the first model and needs to dynamically add relationships.

3. In these scenarios, you have two options:
   - `resolveRelationUsing()`: Doesn't allow passing arguments to the relationship
   - `macro()`: Allows passing arguments but triggers this bug

This is why understanding and fixing this conflict is important for developers working with modular Laravel applications where dynamic extension of models is necessary.


