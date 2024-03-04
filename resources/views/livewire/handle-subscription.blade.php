<main>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <h1>subscriptions</h1>

    @if ($grouped_subscriptions && count($grouped_subscriptions) > 0)
    <div>
        @foreach ($grouped_subscriptions as $key => $subscription)
        <div class="subscription" wire:key='{{ $subscription['id'] }}'>
            @php
                $date = strtotime($subscription['start_time']);
                $date = date("d.m.Y H:i", $date);
            @endphp
            <p>{{ $subscription['title'] }}</p>
            <p class="date">{{ $date }}</p>
            @foreach ($subscription['users'] as $user)
                <p class="user">{{ $user }}</p>
            @endforeach
        </div>
        @endforeach
    </div>
    @else
        <p>Noone subscribed to your classes yet.</p>
    @endif
</main>
