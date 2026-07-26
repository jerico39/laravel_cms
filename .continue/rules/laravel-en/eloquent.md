# Eloquent Rules

Always prefer Eloquent.

## Relationships

- belongsTo
- hasMany
- belongsToMany
- morphMany

Always eager load relationships.

Never introduce N+1 queries.

Use:

- with()
- load()
- loadMissing()

Prefer query scopes.

Use casts.

Use SoftDeletes where applicable.

Avoid raw SQL unless absolutely necessary.

Prefer transactions when updating multiple tables.

Mass assignment must be protected.

Never use DB facade unless required.