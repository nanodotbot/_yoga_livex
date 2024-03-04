<main>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <h1>users</h1>

    <div>

        @foreach ($users as $key => $user)

        <div class="users" wire:key='{{ $user->id }}'>

            <h2>{{ $user->id }} {{ $user->name }}</h2>
            <p class='small'>{{ $user->created_at }} | {{ $user->updated_at }}</p>
            <p>{{ $user->email }}</p>

            @if ($user->goals)
                <p class='small'>{{ $user->goals }}</p>
            @else
                <p class='small'>The user has no goals defined.</p>
            @endif
            @if ($user->history)
                <p class='small'>{{ $user->history }}</p>
            @else
                <p class='small'>The user has no history defined.</p>
            @endif

            @if ($user->email_notifications)
                <p class='small'>– notifications</p>
            @endif
            @if ($user->is_admin)
                <p class='small'>– admin</p>
            @endif
            @if ($user->is_teacher)
                <p class='small'>– teacher</p>
            @endif
            <div class="balances">
            @foreach ($balancesx as $key => $balancex)
                {{-- @dd($balancesx[$key]); --}}
                @if ($user->id === $balancex['user_id'])
                <p class="balance">{{ $balancex['type'] }}</p>
                <button wire:click='decrease({{ $key }})'>-</button>
                <p class="balance">{{ $balancex['balance'] }}</p>
                <button wire:click='increase({{ $key }})'>+</button>
                <button wire:click='savebalance({{ $user->id }}, {{ '"' . $balancex['type'] . '"'}}, {{ $balancex['balance'] }})' class="savebalance">Save balance</button>
                @endif
            @endforeach
            </div>

            {{-- <div class="balance">
                <button wire:click='decrease({{ $key }})'>-</button>
                <p class="balance">{{ $balances[$key] }}</p>
                <button wire:click='increase({{ $key }})'>+</button>
            </div>
            <button wire:click='savebalance({{ $key }})' class="savebalance">Save balance</button> --}}

        </div>

        @endforeach

    </div>

    <div wire:loading wire:target='savebalance' class="spinner">
        <div></div>
    </div>

</main>
