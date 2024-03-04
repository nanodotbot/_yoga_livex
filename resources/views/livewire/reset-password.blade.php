<main>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <h1>Reset password</h1>
    
    <form x-data="{showpassword: false, toggle() { this.showpassword = !this.showpassword } }" wire:submit='updatepw'>
        @csrf
        
        <div class="input">
            <label for="password">New password</label>
            <input wire:model.blur='password' id="password" x-bind:type="showpassword ? 'text' : 'password'" autocomplete="off">
        </div>
        @error('password') <p class="feedback error">{{ $message }}</p> @enderror
        
        <div class="input">
            <label for="password_confirmation">Password confirmation</label>
            <input wire:model.live='password_confirmation' id="password_confirmation" x-bind:type="showpassword ? 'text' : 'password'" autocomplete="off">
        </div>
        @error('password_confirmation') <p class="feedback error">{{ $message }}</p> @enderror

        <div class="toggle" id="showpw-toggle">
            <p>Show password</p>
            <input x-on:change='toggle()' type="checkbox" class="toggle-input" id="showpw-input">
            <label for="showpw-input" class="toggle-label" id="showpw-label"></label>
        </div>
    
        <button class="submit" type="submit">Update password</button>
        
    </form>

    <div wire:loading wire:target='updatepw' class="spinner">
        <div></div>
    </div>

</main>
