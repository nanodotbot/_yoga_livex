<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

{{-- @php
    // Set your secret key. Remember to switch to your live secret key in production.
    // See your keys here: https://dashboard.stripe.com/apikeys
    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
    $stripe->paymentMethodDomains->create(['domain_name' => 'yogax.nano.sx']);
@endphp --}}

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Angi Yoga' }}</title>

    <link rel="stylesheet" href="{{ asset('main.css') }}">
    <link rel="stylesheet" href="{{ asset('single.css') }}">
    <link rel="stylesheet" href="{{ asset('header.css') }}">
    <link rel="stylesheet" href="{{ asset('footer.css') }}">
    <link rel="stylesheet" href="{{ asset('flash-message.css') }}">

    @stack('tags')
    @stack('js')

</head>

<body>

    @if (session()->has('message'))
        <livewire:flash-message />
    @endif

    <livewire:header>

    {{ $slot }}

    <livewire:footer>

</body>

</html>