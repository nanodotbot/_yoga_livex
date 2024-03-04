@push('tags')
    <meta name="description" content="Angi Yoga – Yoga in Kingston, London">
    <meta name="keywords" content="Yoga, Kingston, London, Welcome">
    <meta name="robots" content="noindex"/> 
    {{-- <meta name="robots" content="index,follow"/> --}}
    <meta name="googlebot" content="noindex">
    {{-- <meta name="googlebot" content="index,follow"> --}}


    <meta name="og:image" content="{{ asset('logo.png') }}"/>
    <meta name="og:image:secure_url" content="{{ asset('logo.png') }}"/>
    <meta name="og:image:type" content="image/png"/>
    <meta name="og:image:width" content="40"/>
    <meta name="og:image:height" content="40"/>
    <meta name="og:image:alt" content="the logo, a bright red, blurred circle"/>
    <meta property=”og:title” content="Angi Yoga"/>
    <meta property="og:description" content="Angi Yoga – Yoga in Kingston, London"/>
    <meta property=”og:type” content="website"/>
    <meta property="og:locale" content="en_GB" />
    <meta property="og:sitename" content="Angi Yoga" />
    <meta property="og:url" content="https://www.angi.yoga"/>
@endpush

@php
// TODO: keep in mind
// Set your secret key. Remember to switch to your live secret key in production.
// See your keys here: https://dashboard.stripe.com/apikeys
$stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

$stripe->paymentMethodDomains->create(['domain_name' => 'yogax.nano.sx']);
@endphp

<main id="landing">
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    
    <img id="background-image" src="{{ asset('106659956_586192728991085_6196666465510040658_n_bwcool.jpg') }}" alt="background">

    <div id="header" class="blur-intersecting">
        <h1>Angi Yoga</h1>
        <h2>Yoga in Kingston</h2>

        <div>
            <div class="intro">
                <p>Hey beautiful souls!</p>
                <p>I'm Angi, and I'm thrilled to be your guide on this yoga journey.</p>
                <p>This is a space where breath meets movement, and we explore the transformative power of yoga beyond the mat. No need for mysticism, just a genuine commitment to your well-being. Whether you're a seasoned yogi or a newbie, I'm here to help you find strength, balance, and moments of peace in the midst of modern life.</p>
                <p>Join me in this exploration of body, mind, and soul. Let's breathe, flow, and grow together. Your practice, your pace, your journey.</p>
                <p>Looking forward to sharing the mat with you!</p>
                <p>Warmly,</p>
            </div>
            <div class="subscribe">
                <p>Subscribe for my monthly newsletter with resources to support your yoga journey. I take your privacy seriously and you can always unsubscribe.</p>
                <form wire:submit='subscribe'>
                    @csrf

                    <div class="input">
                        <label for="email">E-mail</label>
                        <input wire:model.blur='email' id="email" type="email" autocomplete="on">
                    </div>
                    @error('email') <p class="feedback error">{{ $message }}</p> @enderror
                    <button>Subscribe</button>

                </form>
            </div>
        </div>
    </div>
    
    <div wire:loading wire:target='subscribe' class="spinner">
        <div></div>
    </div>

</main>