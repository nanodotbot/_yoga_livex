@push('tags')
    <meta name="description" content="Angi Yoga's pricing for yoga classes">
    <meta name="keywords" content="Yoga, Kingston, London, Pricing, Classes">
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
    <meta property=”og:title” content="Angi Yoga - Pricing"/>
    <meta property="og:description" content="Angi Yoga's pricing for yoga classes"/>
    <meta property=”og:type” content="website"/>
    <meta property="og:locale" content="en_GB" />
    <meta property="og:sitename" content="Angi Yoga" />
    <meta property="og:url" content="https://www.angi.yoga"/>
@endpush

@push('js')
    <script src="https://js.stripe.com/v3/" async></script>
@endpush

<main>
    {{-- The whole world belongs to you. --}}
    <h1>pricing</h1>

    <div class='cards'>

        <div class="description">
            <p>If you click 'Buy', you will be redirected to the payment site and after the payment redirected back to a success page on this site. Please be patient and do not refresh the page during the payment process, redirections happen automatically.</p>
            @auth
            <p>You can see all your orders, all your registrations for classes and your actual balance for different classes in your <a href="{{ '/' . auth()->user()->id }}" wire:navigate>account</a>. If you ever see discrepancies, please let me know immediately.</p>
            @endauth
        </div>

        @if($locations)

            @foreach ($locations as $location)

                <h2>{{ $location }}</h2>

                @foreach ($pricings as $pricing)
                    @if ($pricing->location === $location)
                    <div class="card" wire:key='{{ $pricing->id }}'>
                        <h3>{{ $pricing->title }}</h3>
                        <p class="price">{{ $pricing->price }} &pound;</p>
                        @if ($pricing->description)
                        <p class="description">{{ $pricing->description }}</p>
                        @endif
                        @guest
                        <p>Please <a wire:navigate href="/login">login or register</a> to buy this class.</p>
                        @endguest
                        @auth
                        <button wire:click='processgeneral({{ '"' . $pricing->priceid . '"' }})'>Buy</button>
                        @endauth
                    </div>
                    @endif
                @endforeach

            @endforeach

        @else
            <p>Currently, no pricings have been defined.</p>
        @endif

    </div>

    <div wire:loading class="spinner">
        <div></div>
    </div>

</main>
