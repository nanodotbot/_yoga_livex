<main>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    
    <h1>manage classes</h1>

    <div>

        <h2>add a new class</h2>
        <form wire:submit='addclass'>
            @csrf

            <div class="input">
                <label for="title">Title</label>
                <input wire:model='title' id="title" type="text" autocomplete="off">
            </div>
            @error('title') <p class="feedback error">{{ $message }}</p> @enderror

            <div class="input">
                <label for="price_id">Price id (Product, Stripe)</label>
                <input wire:model='price_id' id="price_id" type="text" autocomplete="off">
            </div>
            @error('price_id') <p class="feedback error">{{ $message }}</p> @enderror

            <div class="input">
                <label for="startTime">Date and start time</label>
                <input wire:model='startTime' id="startTime" type="datetime-local" autocomplete="off">
            </div>
            @error('startTime') <p class="feedback error">{{ $message }}</p> @enderror

            <div class="input">
                <label for="length">Length in minutes</label>
                <input wire:model='length' id="length" type="number" autocomplete="off">
            </div>
            @error('length') <p class="feedback error">{{ $message }}</p> @enderror

            <div class="input">
                <label for="places">Available spots for attendees</label>
                <input wire:model='places' id="places" type="number" autocomplete="off">
            </div>
            @error('places') <p class="feedback error">{{ $message }}</p> @enderror

            <div class="input">
                <label for="teacher">Teacher (optional)</label>
                <input wire:model='teacher' id="teacher" type="text" autocomplete="off">
            </div>
            @error('teacher') <p class="feedback error">{{ $message }}</p> @enderror

            <div class="input">
                <label for="level">Level (optional)</label>
                <input wire:model='level' id="level" type="text" autocomplete="off">
            </div>
            @error('level') <p class="feedback error">{{ $message }}</p> @enderror

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

            <button class="submit" type="submit">Add new class</button>

        </form>

        <h2>adjust existing class</h2>

        @if ($classesx && count($classesx) > 0)
            @foreach ($classesx as $index => $classx)

                <div wire:key='{{ $classx['id'] }}'>

                    <h3>{{ $classx['id'] }}</h3>

                    <form>
                        @csrf
            
                        <div class="input">
                            <label for="title{{ $index }}">Title</label>
                            <input wire:model='classesx.{{$index}}.title' id="title{{ $index }}" type="text" autocomplete="off">
                        </div>
                        @error('classesx' . $index . 'title') <p class="feedback error">{{ $message }}</p> @enderror
            
                        <div class="input">
                            <label for="price_id{{ $index }}">Price id (Product, Stripe)</label>
                            <input wire:model='classesx.{{$index}}.price_id' id="price_id{{ $index }}" type="text" autocomplete="off">
                        </div>
                        @error('classesx' . $index . 'price_id') <p class="feedback error">{{ $message }}</p> @enderror
            
                        <div class="input">
                            <label for="startTime{{ $index }}">Date and start time</label>
                            <input wire:model='classesx.{{$index}}.startTime' id="startTime{{ $index }}" type="datetime-local" autocomplete="off">
                        </div>
                        @error('classesx' . $index . 'startTime') <p class="feedback error">{{ $message }}</p> @enderror
            
                        <div class="input">
                            <label for="length{{ $index }}">Length in minutes</label>
                            <input wire:model='classesx.{{$index}}.length' id="length{{ $index }}" type="number" autocomplete="off">
                        </div>
                        @error('classesx' . $index . 'length') <p class="feedback error">{{ $message }}</p> @enderror
            
                        <div class="input">
                            <label for="places{{ $index }}">Available spots for attendees</label>
                            <input wire:model='classesx.{{$index}}.places' id="places{{ $index }}" type="number" autocomplete="off">
                        </div>
                        @error('classesx' . $index . 'places') <p class="feedback error">{{ $message }}</p> @enderror
            
                        <div class="input">
                            <label for="teacher{{ $index }}">Teacher (optional)</label>
                            <input wire:model='classesx.{{$index}}.teacher' id="teacher{{ $index }}" type="text" autocomplete="off">
                        </div>
                        @error('classesx' . $index . 'teacher') <p class="feedback error">{{ $message }}</p> @enderror
            
                        <div class="input">
                            <label for="level{{ $index }}">Level (optional)</label>
                            <input wire:model='classesx.{{$index}}.level' id="level{{ $index }}" type="text" autocomplete="off">
                        </div>
                        @error('classesx' . $index . 'level') <p class="feedback error">{{ $message }}</p> @enderror
            
                        <div class="input">
                            <label for="description{{ $index }}">Description</label>
                            <textarea
                                wire:model='classesx.{{$index}}.description'
            
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
                        @error('classesx' . $index . 'description') <p class="feedback error">{{ $message }}</p> @enderror
            
                        <button class="submit" wire:click.prevent='updateclass({{ $index }}, {{ $classx['id'] }})'>Save changes</button>
                        <button class="submit" wire:click.prevent='deleteclass({{ $classx['id'] }})'>Delete class</button>
            
                    </form>
                    
                </div>

            @endforeach
        @else
            <p>There are no classes.</p>        
        @endif

    </div>

    <div wire:loading wire:target='addclass,updateclass,deleteclass' class="spinner">
        <div></div>
    </div>

</main>
