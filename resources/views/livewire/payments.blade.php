<main>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <h1>payments</h1>

    <div>

        <p class="payments-introduction">All of Stripe's payments have to be listed here. If one is missing, it also means that the user's balance hasn't been updated. You have to fix that manually.</p>

        <a wire:navigate href="/add-payment">Manage payments manually</a>
        @if($payments)

            @foreach ($payments as $payment)
            <div class="payments" wire:key='{{ $payment->stripeid }}'>
            @php
                $date = date("d.m.Y H:i", $payment->created);
            @endphp
                <p class="small">{{ $payment->username }}</p>
                <p class="small">{{ $payment->useremail }}</p>
                <p class="small header">{{ $date }}</p>
                <p class="small header">{{ $payment->stripeid }}</p>
                <p class="small header">{{ $payment->intent }}</p>
                <p class="small">{{ $payment->amount }}</p>
                <p class="small">{{ $payment->name }}</p>
                <p class="small">{{ $payment->email }}</p>
            </div>
            @endforeach

        @else
            <p>There are no payments registered in the database.</p>
        @endif

    </div>

</main>
