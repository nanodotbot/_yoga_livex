<main>
    {{-- Stop trying to control. --}}
    <h1>Success</h1>
    <div>
        <p class="success-intro">The payment was successfull and your balance has been updated.</p>
        <div class="success">
            <h2>New balance</h2>
            <div class="new_balance">
                <p class="balance">{{ $type }}</p><p class="balance">{{ $balance }}</p>
            </div>
        </div>
        <div class="success">
            <h2>Payment details</h2>
            <p>{{ $type }}</p>
            <p>{{ $amount }}</p>
            <p>{{ $line_items[0]->description }}</p>
            <p>{{ $name }}</p>
            <p>{{ $email }}</p>
            <p>{{ $created }}</p>
        </div>
    </div>

</main>
