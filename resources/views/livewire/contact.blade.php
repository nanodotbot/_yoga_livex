@push('tags')
    <meta name="description" content="Angi Yoga's contact form">
    <meta name="keywords" content="Yoga, Kingston, London, Contact">
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
    <meta property=”og:title” content="Angi Yoga - Contact"/>
    <meta property="og:description" content="Angi Yoga's contact form"/>
    <meta property=”og:type” content="website"/>
    <meta property="og:locale" content="en_GB" />
    <meta property="og:sitename" content="Angi Yoga" />
    <meta property="og:url" content="https://www.angi.yoga"/>
@endpush

<main x-data="{
    isModalOpen: false
}">
    {{-- Stop trying to control. --}}

    <h1>contact</h1>

    <div>

        <form wire:submit='sendmail' novalidate>
        @csrf

            <div class="input">
                <label for="name">Name</label>
                <input wire:model.blur='name' name="name" id="name" type="text" autocomplete="on">
            </div>
            @error('name') <p class="feedback error">{{ $message }}</p> @enderror

            <div>
                <label for="email">E-mail</label>
                <input wire:model.blur='email' type="email" name="email" id="email" autocomplete="on">
            </div>

            <div>
                <label for="tel">Phone number (optional)</label>
                <input wire:model.blur='tel' type="tel" name="tel" id="tel" autocomplete="on">
            </div>
            @error('tel') <p class="feedback error">{{ $message }}</p> @enderror

            <div>
                <label for="message">A short message to me</label>
                <textarea 
                    wire:model.blur='message'
                    
                    x-data="{
                        resize(){
                            $el.style.height = '';
                            $el.style.height = $el.scrollHeight + 1 + 'px';
                        }
                    }"
                    x-init='resize'
                    x-on:input='resize'

                    id="message" 
                    name="message"
                    autocomplete="off"
                ></textarea>
            </div>
            @error('message') <p class="feedback error">{{ $message }}</p> @enderror

            <div class="toggle" id="data-protection">
                <p class="label">I have noticed the <button x-on:click.stop.prevent="isModalOpen = true" id="data-protection-button" class="link"><span>privacy policy</span></button>.</p>
                <input wire:model='privacy' type="checkbox" class="toggle-input" id="toggle-data-protection-agreement">
                <label for="toggle-data-protection-agreement" class="toggle-label" id="toggle-data-protection-agreement-label"></label>
                @error('privacy') <p class="feedback error">{{ $message }}</p> @enderror
            </div>

            <button>Send</button>

        </form>


    </div>

    <div x-bind:class="isModalOpen ? 'open modal' : 'modal'">

        <div class="modal-inner">

            <div class="modal-header">

                <button x-on:click.stop.prevent="isModalOpen = false" id="close-modal-2" class="modal-close link"><svg class="icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M256-213.847 213.847-256l224-224-224-224L256-746.153l224 224 224-224L746.153-704l-224 224 224 224L704-213.847l-224-224-224 224Z"/></svg></button>

            </div>

            <div class="modal-body" x-on:click.outside.stop.prevent='isModalOpen = false'>

                <h2>Privacy policy: contact form</h2>
                <p>All the data that you provide via the contact form will be sent to me as an e-mail. I just need the name to address you properly – you can choose whatever you like. I need an e-mail or a phone number to get in touch with you. And of course it makes sense that you leave me a short message.</p>
                <p>Thanks a lot!</p>

            </div>

        </div>

    </div>

    <div wire:loading wire:target='sendmail' class="spinner">
        <div></div>
    </div>

</main>

