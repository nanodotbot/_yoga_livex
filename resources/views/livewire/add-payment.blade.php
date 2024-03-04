<main>
    {{-- Be like water. --}}
    <h1>handle payments</h1>

    <div>

        <div class="description">
            <p>You should be really careful, when adding payments manually. This should only be done, when a payment is missing from the Stripe payments. If you add a payment to a user, it automatically updates the user's balance. You will find all necessary information in the Stripe payment (checkout.session.completed) and the user's table.</p>
        </div>

        <div class="handle-payments">

            <h2>Add payment</h2>

            <form wire:submit='addPayment'>
                @csrf
                
                <div class="input">
                    <label for="user_id">User ID (User)</label>
                    <input wire:model='user_id' id="user_id" type="number" autocomplete="off">
                </div>
                @error('user_id') <p class="feedback error">{{ $message }}</p> @enderror
                
                <div class="input">
                    <label for="stripeid">Check-out session id (e.g. cs_, Stripe)</label>
                    <input wire:model='stripeid' id="stripeid" type="text" autocomplete="off">
                </div>
                @error('stripeid') <p class="feedback error">{{ $message }}</p> @enderror

                <div class="input">
                    <label for="intent">Payment intent (e.g. pi_, Stripe)</label>
                    <input wire:model='intent' id="intent" type="text" autocomplete="off">
                </div>
                @error('intent') <p class="feedback error">{{ $message }}</p> @enderror

                <div class="input">
                    <label for="price_id">Price id (product, Stripe)</label>
                    <input wire:model='price_id' id="price_id" type="text" autocomplete="off">
                </div>
                @error('price_id') <p class="feedback error">{{ $message }}</p> @enderror
                                
                <div class="input">
                    <label for="type">Type (online, outdoor, ...)</label>
                    <input wire:model='type' id="type" type="text" autocomplete="off">
                </div>
                @error('type') <p class="feedback error">{{ $message }}</p> @enderror
                
                <div class="input">
                    <label for="amount">Amount (1 or 5, Stripe)</label>
                    <input wire:model='amount' id="amount" type="number" autocomplete="off">
                </div>
                @error('amount') <p class="feedback error">{{ $message }}</p> @enderror
                
                <div class="input">
                    <label for="email">E-mail (Stripe)</label>
                    <input wire:model='email' id="email" type="email" autocomplete="off">
                </div>
                @error('email') <p class="feedback error">{{ $message }}</p> @enderror
                
                <div class="input">
                    <label for="name">Name (Stripe)</label>
                    <input wire:model='name' id="name" type="text" autocomplete="off">
                </div>
                @error('name') <p class="feedback error">{{ $message }}</p> @enderror
                
                <div class="input">
                    <label for="created">Created (e.g. 1706117847, Stripe)</label>
                    <input wire:model='created' id="created" type="text" autocomplete="off">
                </div>
                @error('created') <p class="feedback error">{{ $message }}</p> @enderror
                                
                <button class="submit" type="submit">Add new payment</button>

            </form>

        </div>

        <div class="delete-payments">

            <h2>Delete payment</h2>

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
                        <p class="small header">{{ $payment->price_id }}</p>
                        <p class="small header">{{ $payment->type }}</p>
                        <p class="small">{{ $payment->amount }}</p>
                        <p class="small">{{ $payment->name }}</p>
                        <p class="small">{{ $payment->email }}</p>
                        <button wire:click='deletepayment({{ $payment->id }})'>Delete payment</button>
                    </div>
                @endforeach

            @else
                <p>There are no payments registered in the database.</p>
            @endif

        </div>

    </div>

    <div wire:loading wire:target='addPayment,deletepayment' class="spinner">
        <div></div>
    </div>

</main>
