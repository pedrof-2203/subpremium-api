# Project Guidelines

## Code Style
- **Language**: PHP 8.2+
- **Formatting**: Adhere to Laravel Pint strict standards. Avoid over-indenting arrays.
- **Typing**: Use strong return typing (e.g., `JsonResponse`, `array`) and heavily type-hint arguments.
- **Naming Conventions**:
  - **Controllers**: Pluralized names with the `Controller` suffix (e.g., `AlbumsController`, `BandsController`).
  - **Models**: Singular noun (e.g., `Album`, `Artist`, `Song`).

## Architecture
- **Framework**: Laravel 12 (MVC pattern without strict `Route::apiResource` abstractions).
- **Routing** (`routes/api.php`):
  - Grouped by prefix (e.g., `Route::prefix('albums')->group(...)`).
  - Uses explicit HTTP verbs mapped to specific controller methods.
- **Controllers**:
  - Automatically return JSON by casting standard `$models` wrapping in `response()->json(...)`. 
  - Validation typically bypasses `FormRequest` classes in favor of localized, private controller methods.
  - Read/update failures are wrapped in standard `try/catch (\Throwable $th)` blocks returning generic `["message" => $th->getMessage()]`.
- **Models**:
  - Keep models thin. Define `$fillable` fields explicitly and custom `$casts`.
  - Always implement the `HasFactory` trait to support test seeding.

## Build and Test
- **Testing Framework**: PHPUnit 11.5
- **Style**: Use PHP 8+ Attribute syntax (`#[Test]`). Rely on `$this->getJson(...)`, `$this->postJson(...)`. Prefix testing classes using the `RefreshDatabase` trait.
- **Commands**:
  - **Test**: `composer test` or `php artisan test`
  - **Local Dev Server**: `npm run dev` or `composer dev` (or `php artisan serve`)

## Project Conventions
- **API Responses**:
  - Return raw Eloquent Models/Collections directly converted to JSON for lists/fetches (avoid Laravel `JsonResource` unless specified).
  - State altering actions return a success message alongside the modified payload (e.g. `['message' => 'Album updated successfully', 'album' => $album]`). 
- **Database & Factories**: 
  - Database structure strongly relies on standard Eloquent foreign IDs (`artist_id`, `band_id`). 
  - Heavily use the Laravel Factory pattern (`Model::factory()->create()`) for bootstrapping state.

## Integration Points
- Interacts predominantly via the JSON API. Uses Laravel Sanctum (`config/sanctum.php`) if authentication is required.

## Security
- **Authentication**: Utilizes Personal Access Tokens mapping to `users` via Laravel Sanctum.
- Use native Eloquent methods to prevent SQL injection.
