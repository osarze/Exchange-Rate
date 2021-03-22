@component('mail::message')
# Hello {{ $currencyThreshold->user->name }},

The current exchange rate for {{ $currencyThreshold->currency }} has gone below the threshold amount you set

Thanks,<br>
{{ config('app.name') }}
@endcomponent
