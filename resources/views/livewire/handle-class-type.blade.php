<main>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}

    <h1>manage class styles</h1>

    <div>

        <h2>add a new class type</h2>
        <form wire:submit='addclasstype'>
            @csrf

            <div class="input">
                <label for="title">Title</label>
                <input wire:model='title' id="title" type="text" autocomplete="off">
            </div>
            @error('title') <p class="feedback error">{{ $message }}</p> @enderror

            <div class="input">
                <label for="time_schedule">Date and time schedule (e.g. every Monday 7pm)</label>
                <input wire:model='time_schedule' id="time_schedule" type="text" autocomplete="off">
            </div>
            @error('time_schedule') <p class="feedback error">{{ $message }}</p> @enderror

            <div class="input">
                <label for="location">Location</label>
                <input wire:model='location' id="location" type="text" autocomplete="off">
            </div>
            @error('location') <p class="feedback error">{{ $message }}</p> @enderror

            <div class="input">
                <label for="order_position">Order position</label>
                <input wire:model='order_position' id="order_position" type="text" autocomplete="off">
            </div>
            @error('order_position') <p class="feedback error">{{ $message }}</p> @enderror

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

            <button class="submit" type="submit">Add new class type</button>

        </form>

        <h2>adjust existing class styles</h2>

        @if ($classtypesx && count($classtypesx) > 0)
            @foreach ($classtypesx as $index => $classx)

                <div wire:key='{{ $classx['id'] }}'>

                    <h3>{{ $classx['id'] }}</h3>

                    <form>
                        @csrf

                        <div class="input">
                            <label for="title{{ $index }}">Title</label>
                            <input wire:model='classtypesx.{{$index}}.title' id="title{{ $index }}" type="text" autocomplete="off">
                        </div>
                        @error('classtypesx' . $index . 'title') <p class="feedback error">{{ $message }}</p> @enderror

                        <div class="input">
                            <label for="time_schedule{{ $index }}">Date and time schedule</label>
                            <input wire:model='classtypesx.{{$index}}.time_schedule' id="time_schedule{{ $index }}" type="text" autocomplete="off">
                        </div>
                        @error('classtypesx' . $index . 'time_schedule') <p class="feedback error">{{ $message }}</p> @enderror

                        <div class="input">
                            <label for="location{{ $index }}">Location</label>
                            <input wire:model='classtypesx.{{$index}}.location' id="location{{ $index }}" type="text" autocomplete="off">
                        </div>
                        @error('classtypesx' . $index . 'location') <p class="feedback error">{{ $message }}</p> @enderror

                        <div class="input">
                            <label for="order_position">Order position</label>
                            <input wire:model='classtypesx.{{$index}}.order_position' id="order_position" type="text" autocomplete="off">
                        </div>
                        @error('classtypesx' . $index . 'order_position') <p class="feedback error">{{ $message }}</p> @enderror
            
                        <div class="input">
                            <label for="description{{ $index }}">Description</label>
                            <textarea
                                wire:model='classtypesx.{{$index}}.description'
            
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
                        @error('classtypesx' . $index . 'description') <p class="feedback error">{{ $message }}</p> @enderror
            
                        <button class="submit" wire:click.prevent='updateclasstype({{ $index }}, {{ $classx['id'] }})'>Save changes</button>
                        <button class="submit" wire:click.prevent='deleteclasstype({{ $classx['id'] }})'>Delete class type</button>
            
                    </form>

                </div>

            @endforeach
        @else
            <p>There are no class styles yet.</p>        
        @endif

    </div>

    <div wire:loading wire:target='addclasstype,updateclasstype,deleteclasstype' class="spinner">
        <div></div>
    </div>

</main>
