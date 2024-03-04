<main>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <h1>mailings</h1>

    <form wire:submit='sendthismail' class="mailings">
        @csrf
        
        @if ($registeredList && count($registeredList) !== 0)
            <div class="mailings">
                @foreach ($registeredList as $registered)
                    <p>{{ $registered }}</p>
                @endforeach
            </div>
        @else
            <p class="mailings">None of the registered users has subscribed to the newsletter.</p>
        @endif
        @if ($registeredList && count($registeredList) !== 0)
        <div class="toggle" id="registered-users">
            <p>Include registered users' mailing list.</p>
            <input wire:model='registered' type="checkbox" class="toggle-input" id="registered">
            <label for="registered" class="toggle-label" id="registered"></label>
        </div>            
        @endif
        @error('registered') <p class="feedback error">{{ $message }}</p> @enderror

        @if ($unregisteredList && count($unregisteredList) !== 0)
        <div class="mailings">
            @foreach ($unregisteredList as $unregistered)
                <p>{{ $unregistered->email }}</p>
            @endforeach
        </div>
        @else
            <p class="mailings">No unregistered user has subscribed to the newsletter.</p>
        @endif
        @if ($unregisteredList && count($unregisteredList) !== 0)
        <div class="toggle" id="unregistered-users">
            <p>Include unregistered users' mailing list.</p>
            <input wire:model='unregistered' type="checkbox" class="toggle-input" id="unregistered">
            <label for="unregistered" class="toggle-label" id="unregistered"></label>
        </div>            
        @endif
        @error('unregistered') <p class="feedback error">{{ $message }}</p> @enderror

        <div class="input">
            <label for="subject">Subject</label>
            <input wire:model.blur='subject' id="subject" type="text" autocomplete="on">
        </div>
        @error('subject') <p class="feedback error">{{ $message }}</p> @enderror

        <div class="input">
            <label for="mailtext">Message</label>
            <textarea 
                wire:model='mailtext'
                
                x-data="{
                    resize(){
                        $el.style.height = '';
                        $el.style.height = $el.scrollHeight + 1 + 'px';
                    }
                }"
                x-init='resize'
                x-on:input='resize'

                id="mailtext" 
                name="mailtext"
                autocomplete="off"
            ></textarea>
            @error('mailtext') <p class="feedback error">{{ $message }}</p> @enderror
        </div>

        @if (($registeredList && count($registeredList) !== 0) || ($unregisteredList && count($unregisteredList) !== 0))
        <button class="submit" type="submit">Send mail</button>
        @endif
        
    </form>

    <div wire:loading wire:target='sendthismail' class="spinner">
        <div></div>
    </div>

</main>
