<main>
    {{-- Nothing in the world is as soft and yielding as water. --}}

    <h1>manage pricings</h1>

    <div>

        <h2>add a new pricing</h2>
        <form wire:submit='addpricing'>
            @csrf

            <div class="input">
                <label for="title">Title</label>
                <input wire:model='title' id="title" type="text" autocomplete="off">
            </div>
            @error('title') <p class="feedback error">{{ $message }}</p> @enderror

            <div class="input">
                <label for="type">Type (online, outdoor, studio, private online, private studio)</label>
                <input wire:model='type' id="type" type="text" autocomplete="off">
            </div>
            @error('type') <p class="feedback error">{{ $message }}</p> @enderror

            <div class="input">
                <label for="priceid">Price ID (Stripe)</label>
                <input wire:model='priceid' id="priceid" type="text" autocomplete="off">
            </div>
            @error('priceid') <p class="feedback error">{{ $message }}</p> @enderror

            <div class="input">
                <label for="price">Price</label>
                <input wire:model='price' id="price" type="number" autocomplete="off">
            </div>
            @error('price') <p class="feedback error">{{ $message }}</p> @enderror

            <div class="input">
                <label for="amount">Amount</label>
                <input wire:model='amount' id="amount" type="number" autocomplete="off">
            </div>
            @error('amount') <p class="feedback error">{{ $message }}</p> @enderror

            <div class="input">
                <label for="order_position">Order position</label>
                <input wire:model='order_position' id="order_position" type="number" autocomplete="off">
            </div>
            @error('order_position') <p class="feedback error">{{ $message }}</p> @enderror

            <div class="input">
                <label for="location">Header (location, e.g. Online classes)</label>
                <input wire:model='location' id="location" type="text" autocomplete="off">
            </div>
            @error('location') <p class="feedback error">{{ $message }}</p> @enderror

            <div class="input">
                <label for="description">Description</label>
                <textarea
                    wire:model='description'

                    x-data="{
                        resize(){
                            $el.style.height = '';
                            $el.style.height = $el.scrollHeight + 1 + 'px';
                        }
                    }"
                    x-init='resize'
                    x-on:input='resize'

                    id="description" 
                    type="text" 
                    autocomplete="off"
                ></textarea>
            </div>
            @error('description') <p class="feedback error">{{ $message }}</p> @enderror

            <button class="submit" type="submit">Add new pricing</button>

        </form>

        <h2>adjust existing pricings</h2>

        @if ($pricingsx && count($pricingsx) > 0)
            @foreach ($pricingsx as $index => $pricingx)

                <div wire:key='{{ $pricingx['id'] }}'>

                    <h3>{{ $pricingx['id'] }}</h3>

                    <form>
                        @csrf

                        <div class="input">
                            <label for="title{{ $index }}">Title</label>
                            <input wire:model='pricingsx.{{$index}}.title' id="title{{ $index }}" type="text" autocomplete="off">
                        </div>
                        @error('pricingsx' . $index . 'title') <p class="feedback error">{{ $message }}</p> @enderror

                        <div class="input">
                            <label for="type{{ $index }}">Type</label>
                            <input wire:model='pricingsx.{{$index}}.type' id="type{{ $index }}" type="text" autocomplete="off">
                        </div>
                        @error('pricingsx' . $index . 'type') <p class="feedback error">{{ $message }}</p> @enderror

                        <div class="input">
                            <label for="priceid{{ $index }}">Price ID (Stripe)</label>
                            <input wire:model='pricingsx.{{$index}}.priceid' id="priceid{{ $index }}" type="text" autocomplete="off">
                        </div>
                        @error('pricingsx' . $index . 'priceid') <p class="feedback error">{{ $message }}</p> @enderror

                        <div class="input">
                            <label for="price{{ $index }}">Price</label>
                            <input wire:model='pricingsx.{{$index}}.price' id="price{{ $index }}" type="number" autocomplete="off">
                        </div>
                        @error('pricingsx' . $index . 'price') <p class="feedback error">{{ $message }}</p> @enderror

                        <div class="input">
                            <label for="amount{{ $index }}">Amount</label>
                            <input wire:model='pricingsx.{{$index}}.amount' id="amount{{ $index }}" type="number" autocomplete="off">
                        </div>
                        @error('pricingsx' . $index . 'amount') <p class="feedback error">{{ $message }}</p> @enderror

                        <div class="input">
                            <label for="location{{ $index }}">Location</label>
                            <input wire:model='pricingsx.{{$index}}.location' id="location{{ $index }}" type="text" autocomplete="off">
                        </div>
                        @error('pricingsx' . $index . 'location') <p class="feedback error">{{ $message }}</p> @enderror

                        <div class="input">
                            <label for="order_position{{ $index }}">Order position</label>
                            <input wire:model='pricingsx.{{$index}}.order_position' id="order_position{{ $index }}" type="number" autocomplete="off">
                        </div>
                        @error('pricingsx' . $index . 'order_position') <p class="feedback error">{{ $message }}</p> @enderror
            
                        <div class="input">
                            <label for="description{{ $index }}">Description</label>
                            <textarea
                                wire:model='pricingsx.{{$index}}.description'
            
                                x-data="{
                                    resize(){
                                        $el.style.height = '';
                                        $el.style.height = $el.scrollHeight + 1 + 'px';
                                    }
                                }"
                                x-init='resize'
                                x-on:input='resize'
            
                                id="description{{ $index }}" 
                                type="text" 
                                autocomplete="off"
                            ></textarea>
                        </div>
                        @error('pricingsx' . $index . 'description') <p class="feedback error">{{ $message }}</p> @enderror
            
                        <button class="submit" wire:click.prevent='updatepricing({{ $index }}, {{ $pricingx['id'] }})'>Save changes</button>
                        <button class="submit" wire:click.prevent='deletepricing({{ $pricingx['id'] }})'>Delete pricing</button>
            
                    </form>

                </div>

            @endforeach
        @else
            <p>There are no pricings yet.</p>        
        @endif

    </div>

    <div wire:loading wire:target='addpricing,updatepricing,deletepricing' class="spinner">
        <div></div>
    </div>

</main>