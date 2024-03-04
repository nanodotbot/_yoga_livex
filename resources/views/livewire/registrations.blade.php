<main>
    {{-- The Master doesn't talk, he acts. --}}
    <h1>registrations</h1>

    @if ($classes && count($classes) > 0)
    <div>
        @foreach ($classes as $class)
        @php
            $date = strtotime($class['startTime']);
            $date = date("d.m.Y H:i", $date);
            $current = date("d.m.Y H:i");
        @endphp
        <div class="registrations" wire:key='{{ $class['id'] }}'>
            <div>
                <p>{{ $date }}</p>
                <p class="title">{{ $class['title'] }}</p>
            </div>
            @if ($date >= $current)
            <button wire:click='cancel({{ $class['id'] }})' class="link">Cancel</button>
            @endif
        </div>
        @endforeach
    </div>
    @else
        <p>You haven't registered for classes yet.</p>
    @endif

    <div wire:loading.delay wire:target='cancel' class="spinner">
        <div></div>
    </div>

</main>
