@component('mail::message')
# Hello!

reset your password through this link.

@component('mail::button', ['url' => "www.google.com?token=$token"])
Click Here
@endcomponent

Thanks,
{{ config('app.name') }}
@endcomponent
