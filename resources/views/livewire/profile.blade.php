<main x-data="{
    isModalOpen: false
}">
    {{-- Do your work, then step back. --}}
    <h1>{{ $user->name }}</h1>

    <div>

        <div class="profile">

            <h2>Balances</h2>
            <div class="balances">
            @foreach ($balances as $balance)
                <p class="balance">{{ $balance->type }}</p>
                <p class="balance">{{ $balance->balance }}</p>                
            @endforeach
            </div>
            <p>There is a balance for each class type. They are not interchangeable. <a wire:navigate href="/pricing">You can order points for different class styles here.</a></p>
            
        </div>

        <div class="profile">

            <h2>Your classes and orders</h2>
            <div>
                <a wire:navigate href="/registrations">Your class registrations</a> |
                <a wire:navigate href="/orders">Your orders</a>
            </div>

        </div>

        <div class="profile">

            <h2>Personal settings</h2>
            <form wire:submit='updateemail'>
                @csrf
                
                <div class="input">
                    <label for="email">E-mail</label>
                    <input wire:model.blur='email' id="email" type="text" autocomplete="off">
                </div>
                @error('email') <p class="feedback error">{{ $message }}</p> @enderror
                
                <button class="submit" type="submit">Update e-mail</button>
                
            </form>
            
            <form wire:submit='updatepw'>
                @csrf
                
                <div class="input">
                    <label for="old_password">Old password</label>
                    <input wire:model.blur='old_password' id="old_password" type="text" autocomplete="off">
                </div>
                @error('old_password') <p class="feedback error">{{ $message }}</p> @enderror
                
                <div class="input">
                    <label for="new_password">New password</label>
                    <input wire:model.live='new_password' id="new_password" type="text" autocomplete="off">
                </div>
                @error('new_password') <p class="feedback error">{{ $message }}</p> @enderror
                
                <button class="submit" type="submit">Update password</button>
                
            </form>
            
            <form wire:submit='updatesubscription'>
                @csrf
                
                <p>You can subscribe to my mailing list. I will share with you resources to support you on your yoga journey.</p>
                <div class="toggle">
                    <p>Receive e-mail notifications</p>
                    <div >
                        <input @if($subscription) checked @endif wire:model='subscription' class="toggle-input" id="subscription" type="checkbox" autocomplete="off">
                        <label class="toggle-label" for="subscription">
                        </label>
                    </div>
                </div>
                @error('subscription') {{ $message }} @enderror
                
                <button class="submit" type="submit">Save preference</button>
                
            </form>

            <form wire:submit='updategoals'>
                @csrf
                
                <div class="input">
                    <label for="goals">Goals</label>
                    <textarea 
                        wire:model.blur='goals'
                        
                        x-data="{
                            resize(){
                                $el.style.height = '';
                                $el.style.height = $el.scrollHeight + 1 + 'px';
                            }
                        }"
                        x-init='resize'
                        x-on:input='resize'

                        id="goals" 
                        name="goals"
                        autocomplete="off"
                    ></textarea>
                </div>
                @error('goals') <p class="feedback error">{{ $message }}</p> @enderror
                
                <button class="submit" type="submit">Update goals</button>
                
            </form>

            <form wire:submit='updatehistory'>
                @csrf
                
                <div class="input">
                    <label for="history">History</label>
                    <textarea 
                        wire:model.blur='history'
                        
                        x-data="{
                            resize(){
                                $el.style.height = '';
                                $el.style.height = $el.scrollHeight + 1 + 'px';
                            }
                        }"
                        x-init='resize'
                        x-on:input='resize'

                        id="history" 
                        name="history"
                        autocomplete="off"
                    ></textarea>
                </div>
                @error('history') <p class="feedback error">{{ $message }}</p> @enderror
                
                <button class="submit" type="submit">Update history</button>
                
            </form>

            @admin
            <div>
                <a href="{{ '/handle-classes' }}" wire:navigate>Manage classes</a> | 
                <a href="{{ '/handle-class-type' }}" wire:navigate>Manage class styles</a> | 
                <a href="{{ '/handle-pricing' }}" wire:navigate>Manage pricings</a> | 
                <a href="{{ '/handle-subscription' }}" wire:navigate>Manage subscriptions</a> | 
                <a href="{{ '/handle-users' }}" wire:navigate>Manage users</a> | 
                {{-- <a href="{{ '/handle-about' }}" wire:navigate>Adjust about page</a> |  --}}
                <a href="{{ '/payments' }}" wire:navigate>View and manage payments</a> | 
                <a href="{{ '/mailings' }}" wire:navigate>View and manage mailings</a>
            </div>
            @endadmin

        </div>

        <div class="profile">
            
            <h2>Delete account</h2>
            <p>This can't be undone. You will delete not only your account but all related data like subscriptions and points.</p>
            <button x-on:click.stop.prevent="isModalOpen = true">Delete account</button>

        </div>
            
    </div>

    <div x-bind:class="isModalOpen ? 'open modal' : 'modal'">

        <div class="modal-inner">

            <div class="modal-header">

                <button x-on:click.stop.prevent="isModalOpen = false" id="close-modal-2" class="modal-close link"><svg class="icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M256-213.847 213.847-256l224-224-224-224L256-746.153l224 224 224-224L746.153-704l-224 224 224 224L704-213.847l-224-224-224 224Z"/></svg></button>

            </div>

            <div class="modal-body" x-on:click.outside.stop.prevent='isModalOpen = false'>

                <h2>Delete account</h2>
                <p>Do you really want to delete your account and all related data inclucing your purchased class visits? This step is absolute, all data will be lost.</p>
                <button wire:click='deleteaccount'>Delete account</button>

            </div>

        </div>

    </div>
    
    <div wire:loading wire:target='updateemail,updatepw,updatesubscription,deleteaccount' class="spinner">
        <div></div>
    </div>

</main>
