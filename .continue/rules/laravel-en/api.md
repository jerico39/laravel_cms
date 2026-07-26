# API Rules

Always use Resource classes.

Never return Models directly.

Use proper HTTP status codes.

Validation must use FormRequest.

Authorization must use Policies.

Error responses should be consistent.

JSON structure

{
    "success": true,
    "data": {},
    "message": ""
}

Pagination should use Laravel Resources.