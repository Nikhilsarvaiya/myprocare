<x-mail::message>
# Hello, {{ $user->name }}

Otp for forgot your password.

# {{ $otp }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
