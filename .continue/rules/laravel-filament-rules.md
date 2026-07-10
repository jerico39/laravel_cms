# Laravel & Filament Project Analysis Rules

You are an expert developer specializing in Laravel and Filament v3. Your task is to analyze the entire workspace of this project to understand its structure, relationships, and business logic. Adhere to the following rules and project patterns during your analysis.

## 1. Core Framework & Directory Patterns

### Laravel Standards
*   **Models**: Located in `app/Models/`. Check Eloquent relationships, `$fillable`, `$casts`, and Scopes.
*   **Migrations**: Located in `database/migrations/`. These define the database schema and table relationships.
*   **Providers**: Located in `app/Providers/`. Look at `AppServiceProvider` and `Filament/AdminPanelProvider` for global configurations.

### Filament Architecture
*   **Resources**: Located in `app/Filament/Resources/`. Each Resource manages a specific Model.
    *   `Pages/`: Contains List, Create, Edit, and View page classes.
    *   `form()` method: Defines the creation/editing UI fields (`Forms\Components\...`).
    *   `table()` method: Defines the data list columns, filters, and actions (`Tables\Columns\...`, `Tables\Filters\...`).
*   **Pages & Widgets**: Custom dashboards or visual components located in `app/Filament/Pages/` or `app/Filament/Widgets/`.
*   **Relation Managers**: Located inside the Resource directories (e.g., `RelationManagers/`). They handle `HasMany` or `BelongsToMany` UI relationships.

## 2. Analysis & Understanding Instructions

When analyzing the workspace, always cross-reference the following components:
1.  **UI to Database**: When a Filament Resource field is questioned, verify the underlying Laravel Model attributes and Database Migration schema.
2.  **Form & Table Schema**: Pay attention to Filament-specific logic like `dehydrated()`, `reactive()`, `required()`, and custom Lifecycle Hooks (`afterSave`, `mutateFormDataBeforeCreate`).
3.  **Authentication & Authorization**: Check `app/Models/User.php` and Filament panel configurations to see how roles, permissions, or Shield/Bouncer packages limit access to Resources.

## 3. Output Requirements

*   **Holistic View**: Do not isolate single files. Explain how a change in a Laravel Model impacts the Filament Resource UI and vice versa.
*   **Code References**: Always mention exact file paths (e.g., `app/Filament/Resources/UserResource.php`) when explaining components.
*   **Laravel/Filament Best Practices**: Standardize suggestions based on Filament v3 documentation (e.g., using proper Form layouts, optimized Eloquent eager loading in tables).
