# Subpremium Music API Reference

This documentation serves as the high-level reference for backend software engineers working on the Subpremium Music API. It compiles the structural concepts, domain models, and architectural patterns embedded within the codebase.

## Tech Stack Overview
- **Framework:** Laravel 12 (PHP 8.2+)
- **Testing:** PHPUnit 11.5
- **Authentication:** Laravel Sanctum (Personal Access Tokens)

---

## Domain Architecture

The API operates around four core music domain concepts:

1.  **Artist (`App\Models\Artist`)**
    -   Represents individual musicians. 
    -   Can optionally belong to a `Band` (`band_id`).
    -   *Properties:* `name`, `country`, `genres` (array cast), `birthday` (date cast).

2.  **Band (`App\Models\Band`)**
    -   Represents musical groups.
    -   Utilizes standard Soft Deletions.
    -   *Properties:* `name`, `country`, `genres` (array cast), `formed_at`, `disbanded_at`.

3.  **Album (`App\Models\Album`)**
    -   Represents a collection of tracks.
    -   Can explicitly belong to either an `Artist` (`artist_id`) or a `Band` (`band_id`).
    -   *Properties:* `title`, `description`, `genres`, `release_date`.

4.  **Song (`App\Models\Song`)**
    -   Represents an individual track.
    -   Belongs to an `Album` (`album_id`), and optionally an `Artist` or `Band`.
    -   *Properties:* `title`, `description`, `genres`, `release_date`.

5.  **Album Rating (`App\Models\AlbumRating`)**
    -   Pivot/interaction model storing user reviews.
    -   Links an `Album` (`album_id`) to a `User` (`user_id`).
    -   *Properties:* `rating`, `title`, `comment`, `favorite`. Soft deleted.

---

## Request Lifecycle & Controllers

The standard controller footprint (e.g., `AlbumsController`, `ArtistsController`, `BandsController`, `SongsController`) follows standard RESTful verb-mapping while omitting strict `Route::apiResource` abstractions.

### General Controller Conventions
-   **Fetching (Index/Show):** Returns raw Eloquent Models or Database Collections directly cast to JSON payloads. Model-Not-Found failures are wrapped in standard `try/catch (\Throwable $th)` blocks returning a consistent `["message" => "error text"]` wrapper.
-   **State Altering (Create/Update/Destroy):** Action operations successfully return the modified payload accompanied by a localized success message (e.g., `['message' => 'Record updated successfully', 'model' => $model]`).

### Specialized Handling (`AlbumRatingsController`)
Note that the `AlbumRatingsController` currently serves a slightly modified mapping structure. It handles routing mapped heavily to standard `API Resources` and explicit `FormRequest` validations for `Band` records, acting distinctly compared to the core domain controllers.

---

## Data Validation & Transformers

When handling complex data transformations (such as nested inputs or localized API output schemas), standard Laravel abstraction tools are enforced.

### Validation Constraints (`App\Http\Requests`)
Classes like `StoreBandRequest` and `StoreSongRequest` provide isolated validation logic mapping rules conditionally depending on the HTTP Verb executing them:
-   **POST (Creation):** Strict requirement (`required`) logic is applied to core properties.
-   **PUT/PATCH (Updating):** Requirements are relaxed (`sometimes`) supporting sparse/partial payload hydration.

### API Response Localization (`App\Http\Resources`)
Classes like `BandResource`, `AlbumResource`, and `SongResource` are responsible for translating standard English database properties into localized Portuguese presentation keys for external consumption (e.g., mapping `name` to `nome_banda`, and handling formatting for derived states such as `ativa`).

---

## Authentication (`AuthController`)

Endpoints requiring authenticated interactions communicate using `Laravel Sanctum`.
-   **Register/Login:** Validated credentials result in issuing an atomic, plain-text `auth_token`.
-   **Logout:** Revokes *strictly* the `currentAccessToken()` attached to the authenticated Request, leaving alternative concurrent sessions unaffected.

---

## Developer Operations

Starting a local development flow relies on standard ecosystem tools.

```bash
# Run local migrations and seeders (using Factories)
php artisan migrate:fresh --seed

# Spin up the local development web server
php artisan serve

# Run the unified test suites
php artisan test
```
