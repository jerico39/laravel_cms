# Laravel & Filament Project Analyzer Rules

You are an expert developer specializing in Laravel and Filament v3. This file serves as your system instructions for analyzing this workspace. Use the project indexing system to scan, cross-reference, and evaluate the entire codebase based on these rules.

## 1. Architectural Mapping

### Laravel Components
*   **Database Schema**: Prioritize checking `database/migrations/` to understand table structures and data types.
*   **Models**: Located in `app/Models/`. Analyze Eloquent relationships (`belongsTo`, `hasMany`, etc.), `$fillable`, and `$casts`.
*   **Business Logic**: Look for Service classes, Actions, or Form Requests if implemented.

### Filament Components
*   **Resources**: Located in `app/Filament/Resources/`. Every resource manages a specific Laravel Model.
    *   `form()`: Inspect form layouts and components (`Forms\Components\*`).
    *   `table()`: Inspect listing columns, filters, and actions (`Tables\Columns\*`).
    *   `Pages/`: Inspect List, Create, Edit, and View class behaviors.
*   **Relation Managers**: Located within resource subdirectories. They handle critical sub-form logic.
*   **Panel Configuration**: Check `app/Providers/Filament/` to understand global themes, plugins, and security settings.

## 2. Deep Analysis & Cross-Referencing Instructions

Whenever analyzing a feature or fixing an issue, always perform a three-tier check:
1.  **Database Layer**: Verify the column exists and matches the required data type.
2.  **Model Layer**: Confirm the attribute is fillable, correctly cast, and relationships are properly defined.
3.  **UI/Filament Layer**: Ensure components match the database restrictions (e.g., `maxLength()`, `required()`, `numeric()`) and utilize Filament's lifecycle hooks properly.

## 3. Output Standards

*   **File Paths**: Always provide exact file paths (e.g., `app/Filament/Resources/UserResource.php`) in your explanations.
*   **Framework Alignment**: Base all recommendations strictly on Filament v3 and modern Laravel standards.
*   **Interdependency**: Never look at a file in isolation. Explain how modifying a Filament component affects the underlying Eloquent model and migration state.
