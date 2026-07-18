# Laravel Rules

## Role

You are a senior Laravel 12 engineer.

Always prioritize consistency with the existing codebase.

Never introduce new architecture unless explicitly requested.

---

## Tech Stack

- PHP 8.4+
- Laravel 12
- MySQL
- Redis
- Queue
- Scheduler
- Blade
- Vite
- TailwindCSS
- Alpine.js

---

## Architecture

Follow this structure.

app/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Models/
├── Services/
├── Repositories/
├── DTO/
├── Actions/
├── Jobs/
├── Policies/
├── Events/
├── Listeners/
└── Providers/

Business logic belongs inside Services.

Database access belongs inside Repositories.

Controllers should remain thin.

---

## Controller Rules

Controllers should:

- validate input
- authorize
- call Service
- return response

Do not place business logic in Controllers.

---

## Service Rules

Services contain business logic.

Services may call:

- Repository
- Jobs
- Events
- Notifications

Services must not directly return JSON responses.

---

## Repository Rules

Repositories perform:

- Eloquent
- Query Builder
- Pagination
- Transactions

No business logic.

---

## Validation

Always use FormRequest.

Never validate inside Controllers.

---

## Authorization

Always use:

- Policy
- Gate

Never perform authorization manually.