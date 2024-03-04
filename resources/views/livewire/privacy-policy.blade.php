@push('tags')
    <meta name="description" content="Angi Yoga's privacy policy">
    <meta name="keywords" content="Yoga, Kingston, London, Privacy, Policy">
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
    <meta property=”og:title” content="Angi Yoga - Privacy policy"/>
    <meta property="og:description" content="Angi Yoga's privacy policy"/>
    <meta property=”og:type” content="website"/>
    <meta property="og:locale" content="en_GB" />
    <meta property="og:sitename" content="Angi Yoga" />
    <meta property="og:url" content="https://www.angi.yoga"/>
@endpush

<main>
    {{-- In work, do what you enjoy. --}}
    <h1>privacy policy</h1>

    <div>
        <article>
            <p>In the following you will find all the information what personal data is collected by Angi Yoga and what your data is used for. If you have any questions or needs, please use the <a href="/contact" wire:navigate>contact form</a> to get in touch with me.</p>
        </article>
            
        <article>
            <h2>IP address</h2>
            <p>When you visit the internet or any website, you can be identified by a unique IP address:</p>
            <p>{{ $ip_address }}</p>
            <p>An IP address is needed for a computer like yours to communicate with websites like the one that you are currently visiting. There are services like <a href="https://protonvpn.com/">ProtonVPN</a> that will redirect all data traffic from you to their servers before forwarding your request to the website that you are visiting – so the website will only get requests from the IP address of the VPN service.</p>
            <p>Angi Yoga itself is not interested in your IP address and doesn't do any analysis based on your IP address. It's important to note though that Angi Yoga is hosted on an external hosting provider <a href="https://www.hoststar.ch/en/privacy-policy" target="_blank">Hoststar</a> in Switzerland and not on self-owned servers. <a href="https://www.hoststar.ch/en/privacy-policy" target="_blank">Hoststar</a> will process your IP address in a non-personalised form.</p>
        </article>
        
        <article>
            <h2>Contact form</h2>
            <h3>Name, e-mail address or phone number</h3>
            <p>If you want to get in touch with me, you can use the contact form. This will send me an e-mail with all the data that you provided there. Your name, e-mail address or phone number is only used as a means of communication. It isn't saved in any database.</p>
        </article>
            
        <article>
            <h2>Register</h2>
            <h3>Name, e-mail address</h3>
            <p>If you register an account on Angi Yoga, your name, your e-mail address and your password are saved in a password-protected database on <a href="https://www.hoststar.ch/en/privacy-policy" target="_blank">Hoststar</a>'s servers in Switzerland. This data is needed to authenticate you to register to yoga classes. If you delete your account, all the information related to your account will be deleted also.</p>
        </article>
        
        <article>
            <h2>Payment service – Stripe</h2>
            <h3>Name, e-mail address, credit card number</h3>
            <p>Angi Yoga uses <a href="https://stripe.com/en-gb/privacy" target="_blank" rel="noopener noreferrer">Stripe</a> as a payment service. They allow you to pay using your credit card or <a href="https://www.paypal.com/en/legalhub/privacy-full" target="_blank" rel="noopener noreferrer">PayPal</a>. As soon as you click to pay for a class, you will be redirected to <a href="https://stripe.com/en-gb/privacy" target="_blank" rel="noopener noreferrer">Stripe</a>'s payment service. And if you decide to pay via <a href="https://www.paypal.com/en/legalhub/privacy-full" target="_blank" rel="noopener noreferrer">PayPal</a>, you will redirected there. All the payments are listed in my personal Stripe account with your e-mail address and the payment amount. Your credit card number is only visible to the payment service <a href="https://stripe.com/en-gb/privacy" target="_blank" rel="noopener noreferrer">Stripe</a> and/or <a href="https://www.paypal.com/en/legalhub/privacy-full" target="_blank" rel="noopener noreferrer">PayPal</a>.</p>
        </article>

    </div>

</main>
