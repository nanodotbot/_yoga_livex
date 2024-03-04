<main>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}

    <h1>manage about</h1>

    <div>

        <h2>add a new paragraph</h2>
        <form wire:submit='addparagraph'>
            @csrf

            <div class="input">
                <label for="position">position</label>
                <input wire:model='position' id="position" type="text" autocomplete="off">
            </div>
            @error('position') <p class="feedback error">{{ $message }}</p> @enderror

            <div class="input">
                <label for="paragraph">paragraph</label>
                <textarea
                    wire:model='paragraph'

                    x-data="{
                        resize(){
                            $el.style.height = '';
                            $el.style.height = $el.scrollHeight + 1 + 'px';
                        }
                    }"
                    x-init='resize'
                    x-on:input='resize'

                    id="paragraph" 
                    type="text" 
                    autocomplete="off"
                ></textarea>
            </div>
            @error('paragraph') <p class="feedback error">{{ $message }}</p> @enderror

            <button class="submit" type="submit">Add paragraph</button>

        </form>
    
        <h2>adjust existing paragraphs</h2>

        @if ($paragraphsx && count($paragraphsx) > 0)
            @foreach ($paragraphsx as $index => $paragraphx)

                {{-- @dd($paragraphx['id']); --}}
                {{-- @dd($paragraphs[0]->position); --}}
                <form wire:key='{{ $paragraphx['id'] }}'>
                    @csrf
        
                    <h3>id: {{ $paragraphx['id'] }}</h3>

                    {{-- <p>{{$paragraphs[$index]->id}}</p> --}}

                    <div class="input">
                        <label for="position{{ $index }}" type="text">position</label>
                        <input wire:model='paragraphsx.{{$index}}.position' id="position{{ $index }}" name="position{{ $index }}" type="text" autocomplete="off">
                    </div>
                    @error('paragraphsx' . $index . 'position') <p class="feedback error">{{ $message }}</p> @enderror

                    <div class="input">
                        <label for="paragraph{{$index}}">paragraph</label>
                        <textarea
                            wire:model='paragraphsx.{{$index}}.paragraph'
                            x-data="{
                                resize(){
                                    $el.style.height = '';
                                    $el.style.height = $el.scrollHeight + 1 + 'px';
                                }
                            }"
                            x-init='resize'
                            x-on:input='resize'
                            id="paragraph{{$index}}" 
                            name="paragraph{{$index}}" 
                            type="text" 
                            autocomplete="off"
                        ></textarea>
                    </div>
                    @error('paragraphsx'. $index . 'paragraph') <p class="feedback error">{{ $message }}</p> @enderror

                    <button class="submit" wire:click.prevent='updateparagraph({{ $index }}, {{ $paragraphx['id'] }})'>Save changes</button>
                    <button class="submit" wire:click.prevent='deleteparagraph({{ $paragraphx['id'] }})'>Delete paragraph</button>
        
                </form>

            @endforeach
        @else
            <p>There are no paragraphs.</p>        
        @endif

    </div>

    <div wire:loading wire:target='addparagraph,updateparagraph,deleteparagraph' class="spinner">
        <div></div>
    </div>

</main>
