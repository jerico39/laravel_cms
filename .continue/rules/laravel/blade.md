# Blade Rules

Escape output by default.

Use:

{{ $value }}

Only use:

{!! !!}

when HTML is trusted.

Prefer Blade Components.

Avoid large templates.

Keep logic outside Blade.

Use:

@can

@auth

@foreach

instead of raw PHP.

Avoid @php blocks.