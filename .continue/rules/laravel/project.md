# Project Specific Rules

Use Service + Repository architecture.

Authentication uses Laravel Sanctum.

Admin routes

/admin

Customer routes

/mypage

Use UUID for primary keys.

Business models use SoftDeletes.

Dates use CarbonImmutable.

Never use DB facade directly.

Prefer dependency injection.

Controllers stay thin.

Business logic belongs in Services.

Repositories contain database access only.

Follow existing project conventions before introducing new patterns.