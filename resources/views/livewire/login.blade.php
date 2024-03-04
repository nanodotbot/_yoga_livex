@push('tags')
    <meta name="description" content="Angi Yoga's login page">
    <meta name="keywords" content="Yoga, Kingston, London, Login">
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
    <meta property=”og:title” content="Angi Yoga - Login"/>
    <meta property="og:description" content="Angi Yoga's login page"/>
    <meta property=”og:type” content="website"/>
    <meta property="og:locale" content="en_GB" />
    <meta property="og:sitename" content="Angi Yoga" />
    <meta property="og:url" content="https://www.angi.yoga"/>
@endpush

<main>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <h1>login</h1>

    <div x-data="{showpassword: false, toggle() { this.showpassword = !this.showpassword } }">

        <form wire:submit='login'>
            @csrf
    
            <div class="input">
                <label for="email">E-mail</label>
                <input wire:model.blur='email' id="email" type="text" autocomplete="on">
            </div>
            @error('email') <p class="feedback error">{{ $message }}</p> @enderror
    
            <div class="input">
                <label for="password">Password</label>
                <input wire:model.live='password' id="password" x-bind:type="showpassword ? 'text' : 'password'" autocomplete="on">
            </div>
            @error('password') <p class="feedback error">{{ $message }}</p> @enderror
    
            <div class="toggle" id="showpw-toggle">
                <p>Show password</p>
                <input x-on:change='toggle()' type="checkbox" class="toggle-input" id="showpw-input">
                <label for="showpw-input" class="toggle-label" id="showpw-label"></label>
            </div>
    
            <div class="toggle" id="rememberme-toggle">
                <p>Remember me</p>
                <input wire:model='rememberme' type="checkbox" class="toggle-input" id="rememberme-input">
                <label for="rememberme-input" class="toggle-label" id="rememberme-label"></label>
            </div>

            <button class="submit" type="submit">Login</button>
    
        </form>
    
        <p>You don't have a user account yet? <a href="/register" wire:navigate>You can register here.</a></p>
        <p>Forgot your password? <a href="/forgot-password" wire:navigate>Ask for a password reset here.</a></p>

    </div>

    <div wire:loading wire:target='login,rememberme' class="spinner">
        <div></div>
    </div>

</main>
