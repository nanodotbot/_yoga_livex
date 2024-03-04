<div id="flash-message" x-data='{show: true}' x-init='setTimeout(() => show = false, 3000)' x-show='show'>
    {{-- The best athlete wants his opponent at his best. --}}
    <p>
        {{-- The whole world belongs to you. --}}
        {{ session('message') }}
    </p>    

</div>
