{{-- The whole world belongs to you. --}}
<header x-data='{ open: false, toggle() { this.open = ! this.open } }' @click.stop>

    <nav id="nav-modal" :class="open ? 'active' : ''" @click.outside='open = false'>
        @auth
            <a href="{{ '/' . auth()->user()->id }}" wire:navigate @class(['link', 'modal-link', 'active' => request()->getPathInfo() === '/' . auth()->user()->id])>account</a>        
        @endauth
        <a href="/classes" wire:navigate @class(['link', 'modal-link', 'active' => request()->getPathInfo() === '/classes']) @click='open = false'>classes</a>
        <a href="/pricing" wire:navigate @class(['link', 'modal-link', 'active' => request()->getPathInfo() === '/pricing']) @click='open = false'>pricing</a>
        <a href="/about" wire:navigate @class(['link', 'modal-link', 'active' => request()->getPathInfo() === '/about'])>about</a>
        <a href="/contact" wire:navigate @class(['link', 'modal-link', 'active' => request()->getPathInfo() === '/contact'])>contact</a>
        @guest
            <a href="/login" wire:navigate @class(['link', 'modal-link', 'active' => request()->getPathInfo() === '/login'])>login</a>
        @endguest
        @auth
            <livewire:logout>
        @endauth    
    </nav>

    <div id="nav-header">
        
        <a href="/" wire:navigate id="logo"><img src="{{ asset('logo.png') }}" alt="the logo, a bright red, blurred circle"></a>

        <nav id="nav-links">
            @auth
                <a href="{{ '/' . auth()->user()->id }}" wire:navigate @class(['link', 'active' => request()->getPathInfo() === '/' . auth()->user()->id])>account</a>            
            @endauth
            <a href="/classes" wire:navigate @class(['link', 'active' => request()->getPathInfo() === '/classes'])>classes</a>
            <a href="/pricing" wire:navigate @class(['link', 'active' => request()->getPathInfo() === '/pricing'])>pricing</a>
            <a href="/about" wire:navigate @class(['link', 'active' => request()->getPathInfo() === '/about'])>about</a>
            <a href="/contact" wire:navigate @class(['link', 'active' => request()->getPathInfo() === '/contact'])>contact</a>
            @guest
                <a href="/login" wire:navigate @class(['link', 'active' => request()->getPathInfo() === '/login'])>login</a>            
            @endguest
            @auth
                <livewire:logout>
            @endauth    
        </nav>

        <div id="nav-menu" :class="open ? 'active' : ''" @click='toggle()'>
            <span class="menu-line"></span>
            <span class="menu-line"></span>
        </div>

    </div>

</header>
