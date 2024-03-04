@push('js')
    <script src="https://js.stripe.com/v3/"></script>
@endpush

<main>
    {{-- Stop trying to control. --}}

    <form wire:submit='processpayment'>
        <button type="submit">process payment</button>
    </form>

    <div wire:loading wire:target='processpayment' class="spinner">
        <div></div>
    </div>

</main>
