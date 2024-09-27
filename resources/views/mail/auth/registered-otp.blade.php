<x-mail::message>
# Hello, {{ $user->name }}

Otp for verify your account.

# {{ $otp }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
