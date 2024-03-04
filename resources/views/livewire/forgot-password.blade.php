<main>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <h1>Forgot password</h1>

    <div>

        <p>If you have forgotten your password, you can order a link to your e-mail address to reset your password.</p>
        <form wire:submit='sendMail'>
            @csrf

            <div class="input">
                <label for="email">E-mail</label>
                <input wire:model.blur='email' id="email" type="text" autocomplete="on">
            </div>
            @error('email') <p class="feedback error">{{ $message }}</p> @enderror

            <button type="submit">Send me a reset link</button>
        </form>
        
    </div>

    <div wire:loading class="spinner">
        <div></div>
    </div>

</main>
