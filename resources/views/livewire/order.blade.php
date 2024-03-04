<main>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <h1>orders</h1>

    <div>
        <p>All of your payments are listed here. If one is missing, please let me know immediately. I will fix this manually then.</p>

        @if($orders)

        @foreach ($orders as $order)
        <div class="payments" wire:key='{{ $order['id'] }}'>
        @php
            $date = date("d.m.Y H:i", $order['created']);
        @endphp
            <p class="small header">{{ $date }}</p>
            <p class="small header">{{ $order['intent'] }}</p>
            <p class="small header">{{ $order['type'] }}</p>
            <p class="small header">{{ $order['amount'] }}</p>
            <p class="small">{{ $order['name'] }}</p>
            <p class="small">{{ $order['email'] }}</p>
        </div>
        @endforeach

        @else
            <p>There are no orders registered in the database.</p>
        @endif

    </div>

</main>
