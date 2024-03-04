@push('tags')
    <meta name="description" content="Angi Yoga's register form">
    <meta name="keywords" content="Yoga, Kingston, London, Register">
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
    <meta property=”og:title” content="Angi Yoga - Register"/>
    <meta property="og:description" content="Angi Yoga's register form"/>
    <meta property=”og:type” content="website"/>
    <meta property="og:locale" content="en_GB" />
    <meta property="og:sitename" content="Angi Yoga" />
    <meta property="og:url" content="https://www.angi.yoga"/>
@endpush

<main x-data="{
    isPrivacyModalOpen: false,
    isMedicalModalOpen: false,
}">
    {{-- Be like water. --}}
    <h1>register</h1>

    <div x-data="{showpassword: false, toggle() { this.showpassword = !this.showpassword } }">

        <form wire:submit='register'>
        @csrf
            
            <div class="input">
                <label for="name">Name</label>
                <input wire:model.live='name' id="name" type="text" autocomplete="on">
            </div>
            @error('name') <p class="feedback error">{{ $message }}</p> @enderror
            
            <div class="input">
                <label for="email">E-mail</label>
                <input wire:model.blur='email' id="email" type="text" autocomplete="on">
            </div>
            @error('email') <p class="feedback error">{{ $message }}</p> @enderror
    
            <div class="input">
                <label for="password">Password</label>
                <input wire:model.blur='password' id="password" x-bind:type="showpassword ? 'text' : 'password'" autocomplete="on">
            </div>
            @error('password') <p class="feedback error">{{ $message }}</p> @enderror
    
            <div class="input">
                <label for="password_confirmation">Password confirmation</label>
                <input wire:model.live='password_confirmation' id="password_confirmation" x-bind:type="showpassword ? 'text' : 'password'" autocomplete="on">
            </div>
            @error('password_confirmation') <p class="feedback error">{{ $message }}</p> @enderror

            <div class="toggle" id="showpw-toggle">
                <p>Show password</p>
                <input x-on:change='toggle()' type="checkbox" class="toggle-input" id="showpw-input">
                <label for="showpw-input" class="toggle-label" id="showpw-label"></label>
            </div>

            <div class="input">
                <label for="goals">What are your goals by practising yoga? (optional)</label>
                <textarea 
                    wire:model.blur='goals'
                    
                    x-data="{
                        resize(){
                            $el.style.height = '';
                            $el.style.height = $el.scrollHeight + 1 + 'px';
                        }
                    }"
                    x-init='resize'
                    x-on:input='resize'

                    id="goals" 
                    name="goals"
                    autocomplete="off"
                ></textarea>
            </div>
            <div class="input">
                <label for="history">Have you practiced yoga or any other sport before? If yes, could you shortly tell me about it. (optional)</label>
                <textarea 
                    wire:model.blur='history'
                    
                    x-data="{
                        resize(){
                            $el.style.height = '';
                            $el.style.height = $el.scrollHeight + 1 + 'px';
                        }
                    }"
                    x-init='resize'
                    x-on:input='resize'

                    id="history" 
                    name="history"
                    autocomplete="off"
                ></textarea>
            </div>
            
            <div class="toggle" id="data-protection">
                <p>I have read the <button x-on:click.stop.prevent="isPrivacyModalOpen = true" id="data-protection-button" class="link"><span>privacy policy</span></button>.</p>
                <input wire:model='privacy' type="checkbox" class="toggle-input" id="toggle-data-protection-agreement">
                <label for="toggle-data-protection-agreement" class="toggle-label" id="toggle-data-protection-agreement-label"></label>
                @error('privacy') <p class="feedback error">{{ $message }}</p> @enderror
            </div>

            <div class="toggle" id="health-matters">
                <p>I have read the <button x-on:click.stop.prevent="isMedicalModalOpen = true" id="health-matters-button" class="link"><span>medical disclaimer</span></button>.</p>
                <input wire:model='health' type="checkbox" class="toggle-input" id="toggle-health-matters-agreement">
                <label for="toggle-health-matters-agreement" class="toggle-label" id="toggle-health-matters-agreement-label"></label>
                @error('health') <p class="feedback error">{{ $message }}</p> @enderror
            </div>

            <button class="submit" type="submit">Register</button>
            
        </form>
    
        <p>You are already a registered user? <a href="/login" wire:navigate>Please login.</a></p>

    </div>

    <div x-bind:class="isPrivacyModalOpen ? 'open modal' : 'modal'">

        <div class="modal-inner">

            <div class="modal-header">

                <button x-on:click.stop.prevent="isPrivacyModalOpen = false" id="close-privacy-modal" class="modal-close link"><svg class="icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M256-213.847 213.847-256l224-224-224-224L256-746.153l224 224 224-224L746.153-704l-224 224 224 224L704-213.847l-224-224-224 224Z"/></svg></button>

            </div>

            <div class="modal-body" x-on:click.outside.stop.prevent='isPrivacyModalOpen = false'>

                <h2>Privacy policy: register</h2>
                <p>All the data that you enter here is needed to register to the yoga classes. You can pick any name that you want. The e-mail address is necessary to confirm your registration, for the user authentication, and to be able to reset your password. The password itself will be encrypted before being saved to the database and is also needed for the user authentication. It will never be visible to anyone else but you. All data is securely – in a encrypted manner – transfered from your device to the database on servers in Switzerland. Even if someone was able to intercept data in your wifi network or anywhere in between, it would be encrypted and not readable in plain text.</p>
                <p>You can read the <a href="/privacy-policy">complete privacy policy here.</a></p>

            </div>

        </div>

    </div>
    <div x-bind:class="isMedicalModalOpen ? 'open modal' : 'modal'">

        <div class="modal-inner">

            <div class="modal-header">

                <button x-on:click.stop.prevent="isMedicalModalOpen = false" id="close-medical-modal" class="modal-close link"><svg class="icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M256-213.847 213.847-256l224-224-224-224L256-746.153l224 224 224-224L746.153-704l-224 224 224 224L704-213.847l-224-224-224 224Z"/></svg></button>

            </div>

            <div class="modal-body" x-on:click.outside.stop.prevent='isMedicalModalOpen = false'>

                <h2>Medical disclaimer: register</h2>
                <p>Please consult with your physician before beginning any exercise program. By participating in this exercise or exercise program, you agree that you do so at your own risk, are voluntarily participating in these activities, assume all risk of injury to yourself, and agree to release and discharge Angi Yoga from any and all claims or causes of action, known or unknown, arising out of Angi Yoga negligence.</p>

            </div>

        </div>

    </div>

    <div wire:loading.delay wire:target='register' class="spinner">
        <div></div>
    </div>

</main>
