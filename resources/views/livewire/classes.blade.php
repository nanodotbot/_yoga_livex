@push('tags')
    <meta name="description" content="Angi Yoga's yoga classes">
    <meta name="keywords" content="Yoga, Kingston, London, Classes">
    <meta name="robots" content="noindex"/> 
    {{-- <meta name="robots" content="index,follow"/> --}}
    <meta name="googlebot" content="noindex">
    {{-- <meta name="googlebot" content="index,follow"> --}}


    <meta name="og:image" content="{{ asset('logo.png') }}"/>
    <meta name="og:image:secure_url" content="{{ asset('logo.png') }}"/>
    <meta name="og:image:type" content="image/png"/>
    <meta name="og:image:width" content="40"/>
    <meta name="og:image:height" content="40"/>
    <meta name="og:image:alt" content="the logo, a bright red, blurred circle"/>
    <meta property=”og:title” content="Angi Yoga - Classes"/>
    <meta property="og:description" content="Angi Yoga's yoga classes"/>
    <meta property=”og:type” content="website"/>
    <meta property="og:locale" content="en_GB" />
    <meta property="og:sitename" content="Angi Yoga" />
    <meta property="og:url" content="https://www.angi.yoga"/>
@endpush

<main>
    {{-- Because she competes with no one, no one can compete with her. --}}

    <h1>classes</h1>

    <div class="classes">

        <div class="description">
            <p>If you're interested in a private yoga session, <a wire:navigate href="/contact">please use the contact form to get in touch with me.</a></p>
        </div>

        <div class="classtypes">
            @if ($classtypes)
                @foreach ($classtypes as $classtype)
                    <div x-data="{
                        isOpen: false
                    }" class="classtype">
                        @php
                            $description = $classtype->description;
                            $description = htmlentities($description);
                            $description = nl2br($description);
                        @endphp
                        <h3>{{ $classtype->title }}</h3>
                        <div x-on:click="isOpen = !isOpen" class="openclassinfo">
                            <hr><p x-bind:class="isOpen ? 'open' : ''">></p><hr>
                        </div>
                        <div x-bind:class="isOpen ? 'classinfo open' : 'classinfo'">
                            <p>{{ $classtype->time_schedule }}</p>
                            <p>{{ $classtype->location }}</p>
                            <p>{!! $description !!}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="calendar">
            <div class="navigation">
                <button class="arrow" wire:click='decreaseMonth'>&lsaquo;</button>
                <p>{{ date('F Y', strtotime($currentYear . '-' . $currentMonth . '-1')) }}</p>
                <button class="arrow" wire:click='increaseMonth'>&rsaquo;</button>
            </div>
            <div class="days large">
                <p>Monday</p>
                <p>Tuesday</p>
                <p>Wednesday</p>
                <p>Thursday</p>
                <p>Friday</p>
                <p>Saturday</p>
                <p>Sunday</p>
            </div>
            <div class="days small">
                <p>Mon</p>
                <p>Tue</p>
                <p>Wed</p>
                <p>Thu</p>
                <p>Fri</p>
                <p>Sat</p>
                <p>Sun</p>
            </div>
            <div class="content">

                @for ($i = 0; $i < $weeksInMonth; $i++)
                    @for ($j = 1; $j <= $weekdays; $j++)
                        @php
                            $cellNumber = $i * 7 + $j;

                            if (!$currentDay) {
                                $firstDayOfTheWeek = date('N', strtotime($this->currentYear . '-' . $this->currentMonth . '-01'));
                                if(intval($cellNumber) === intval($firstDayOfTheWeek)) {
                                    $currentDay = 1;
                                }
                            }
                            if ($currentDay && $currentDay <= intval($daysInMonth)) {
                                $currentDate = date('Y-m-d', strtotime($currentYear . '-' . $currentMonth . '-' . $currentDay));

                                $cellContent = $currentDay;
                                $currentDay++;
                            } else {
                                $currentDate = null;
                                $cellContent = null;
                            }
                            $mask = '';
                            if ($cellContent === null ) $mask = ' mask';
                        @endphp
                        
                        @if ($currentDate && $currentDate === $activeDate)
                            <div wire:click='filterClasses("{{ $currentDate }}")' id='{{ $currentDate }}' class='{{ 'cell' . $mask . ' active' }}'>
                        @else        
                            <div wire:click='filterClasses("{{ $currentDate }}")' id='{{ $currentDate }}' class='{{ 'cell' . $mask }}'>
                        @endif
                            <p>{{ $cellContent }}</p>
                            
                            @if ($classesx && count($classesx) !== 0)
                                @foreach ($classesx as $classx)
                                    @php
                                        $time = strtotime($classx['startTime']);
                                        $date = date("Y-m-d", $time);
                                        $start = date("H:i", $time);
                                    @endphp
                                    @if ($date === $currentDate)
                                        @if ($currentDate && $currentDate === $activeDate)
                                            <div>
                                                <p class="start active">
                                                    {{ $start }}
                                                </p>
                                                <p class="title active">
                                                    {{ $classx['title'] }}
                                                </p>
                                                <p class="dot active">
                                                    &bull;
                                                </p>
                                                <div class="active">
                                                    @guest
                                                    <p><a wire:navigate href="/login">login or register</a></p>
                                                    @endguest
                                                    @auth
                                                        @if (!$classx['subscribed'])
                                                            @if ($classx['places'] && $classx['places'] - $classx['count'] > 0)
                                                                @if ($classx['balance'] !== 0)
                                                                <button wire:click='register({{ $classx['id'] }}, {{'"' . $classx['price_id'] . '"' }})'>Register</button>
                                                                @else
                                                                    @if ($classx['type'] === 'studio')
                                                                        <p><a wire:navigate href="/pricing">buy a {{ $classx['type'] }} class</a></p>
                                                                    @else
                                                                        <p><a wire:navigate href="/pricing">buy an {{ $classx['type'] }} class</a></p>
                                                                    @endif
                                                                @endif
                                                            @else
                                                            <p class="registered">Unfortunately, there are no more available spots.</p>
                                                            @endif
                                                        @else
                                                        {{-- <p class="registered">You have successfully registered for this class.</p> --}}
                                                        <button wire:click='unregister({{ $classx['id'] }}, {{'"' . $classx['price_id'] . '"' }})'>Unregister</button>
                                                        @endif                        
                                                    @endauth
                                                </div>
                                            </div>
                                        @else
                                            <div>
                                                <p class="start">
                                                    {{ $start }}
                                                </p>
                                                <p class="title">
                                                    {{ $classx['title'] }}
                                                </p>
                                                <p class="dot">
                                                    &bull;
                                                </p>
                                                <div class="active">
                                                    @guest
                                                    <p><a wire:navigate href="/login">login or register</a></p>
                                                    @endguest
                                                    @auth
                                                        @if (!$classx['subscribed'])
                                                            @if ($classx['places'] && $classx['places'] - $classx['count'] > 0)
                                                                @if ($classx['balance'] !== 0)
                                                                <button wire:click='register({{ $classx['id'] }}, {{'"' . $classx['price_id'] . '"' }})'>Register</button>
                                                                @else
                                                                    @if ($classx['type'] === 'studio')
                                                                        <p><a wire:navigate href="/pricing">buy a {{ $classx['type'] }} class</a></p>
                                                                    @else
                                                                        <p><a wire:navigate href="/pricing">buy an {{ $classx['type'] }} class</a></p>
                                                                    @endif
                                                                @endif
                                                            @else
                                                            <p class="registered">Unfortunately, there are no more available spots.</p>
                                                            @endif
                                                        @else
                                                        {{-- <p class="registered">You have successfully registered for this class.</p> --}}
                                                        <button wire:click='unregister({{ $classx['id'] }}, {{'"' . $classx['price_id'] . '"' }})'>Unregister</button>
                                                        @endif                        
                                                    @endauth
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            @endif

                        </div>
                    @endfor    
                @endfor
            </div>
        </div>

        {{-- <div class="description">
            <h2>Private classes</h2>
            <p>A private session offers an ideal opportunity to enhance your practice and focus on specific areas of interest. </p>
            <p>I will be available to meet you in your home, offer yoga at work, or other appropriate location meets your need.</p>
            <p>During your private lessons, you'll receive comprehensive instruction and personalized guidance, a unique offering compared to a traditional group setting. Enjoy undivided attention, the freedom to pause or make adjustments at any time, and the flexibility to ask as many questions as you need.</p>
            <p>Moreover, with private yoga sessions, you can maintain your practice even when you're on the move. Whether traveling for work or leisure, I'm pleased to continue your private journey through Live Stream Yoga, bringing the practice to you wherever you are. It's all about creating a space that aligns with your comfort and allows you to stay connected with your practice, ensuring you feel at ease and in your element.</p>
            <p>Looking forward to practice with you.</p>
        </div>

        <div class="description">
            <h2>Elevate Your Wellness Together:<br>Group Yoga Classes</h2>
            <p>Embark on a journey to well-being with our group yoga classes!</p>
            <p>Discover the joy of practicing yoga in a supportive community. Our group classes offer:</p>
            - Sessions suitable for all levels.
            - A motivating and positive atmosphere.
            - Opportunities to connect with like-minded individuals.
            <p>Join me for a session and experience the benefits of group yoga.</p>
            <p>Take a step towards a healthier, balanced life.</p> 
            <p>Let's breathe, flow, and radiate positive energy together.</p>
            <p>See you on the mat!</p>
            <p>In light and love,</p>
            <p>Angi</p>
        </div> --}}

        @if(!$active)
            @if ($classesx && count($classesx) !== 0)

                @foreach ($classesx as $classx)

                    <article wire:key='{{ $classx['id'] }}'>

                    @php
                        $time = strtotime($classx['startTime']);
                        $date = date("d.m.Y H:i", $time);
                        $day = date('l', $time);
                    @endphp

                        <h2>{{ $classx['title'] }}</h2>
                        <p>{{ $day . ', ' . $date }}</p>
                        <p>{{ $classx['type'] }}</p>
                        @if ($classx['length'])
                        <p>{{ $classx['length'] }} minutes</p>
                        @endif
                        @if ($classx['places'] && $classx['places'] !== 9999)
                            <p>{{ $classx['places'] - $classx['count'] }} of {{ $classx['places'] }} spots left</p>                        
                        @endif
                        @if ($classx['teacher'])
                            <p>{{ $classx['teacher'] }}</p>
                        @endif
                        @if ($classx['level'])
                            <p>{{ $classx['level'] }}</p>
                        @endif
                        @if ($classx['description'])
                            <p>{{ $classx['description'] }}</p>
                        @endif

                        @guest
                        <p>Please <a wire:navigate href="/login">login or register</a> to register for classes.</p>
                        @endguest
                        @auth
                            @if (!$classx['subscribed'])
                                @if ($classx['places'] && $classx['places'] - $classx['count'] > 0)
                                    @if ($classx['balance'] !== 0)
                                    <button wire:click='register({{ $classx['id'] }}, {{'"' . $classx['price_id'] . '"' }})'>Register</button>
                                    @else
                                        @if ($classx['type'] === 'studio')
                                            <p>Please <a wire:navigate href="/pricing">buy a {{ $classx['type'] }} class first</a> to be able to register for {{ $classx['type'] }} classes.</p>
                                        @else
                                            <p>Please <a wire:navigate href="/pricing">buy an {{ $classx['type'] }} class first</a> to be able to register for {{ $classx['type'] }} classes.</p>
                                        @endif
                                    @endif
                                @else
                                <p class="registered">Unfortunately, there are no more available spots.</p>
                                @endif
                            @else
                            <p class="registered">You have successfully registered for this class.</p>
                            <button wire:click='unregister({{ $classx['id'] }}, {{'"' . $classx['price_id'] . '"' }})'>Unregister</button>
                            @endif                        
                        @endauth
                
                    </article>

                @endforeach

            @else

                    <article>

                        <h2>No classes</h2>
                        <p>Currently, there are no classes.</p>

                    </article>

            @endif

        @else
            
            @if ($classesSelection && count($classesx) !== 0)

                @foreach ($classesSelection as $classx)

                    <article wire:key='{{ $classx['id'] }}'>

                    @php
                        $time = strtotime($classx['startTime']);
                        $date = date("d.m.Y H:i", $time);
                        $day = date('l', $time);
                    @endphp

                        <h2>{{ $classx['title'] }}</h2>
                        <p>{{ $day . ', ' . $date }}</p>
                        @if ($classx['length'])
                        <p>{{ $classx['length'] }} minutes</p>
                        @endif
                        @if ($classx['places'] && $classx['places'] !== 9999)
                            <p>{{ $classx['places'] - $classx['count'] }} of {{ $classx['places'] }} spots left</p>                        
                        @endif
                        @if ($classx['teacher'])
                            <p>{{ $classx['teacher'] }}</p>
                        @endif
                        @if ($classx['level'])
                            <p>{{ $classx['level'] }}</p>
                        @endif
                        @if ($classx['description'])
                            <p>{{ $classx['description'] }}</p>
                        @endif

                        @guest
                        <p>Please <a wire:navigate href="/login">login or register</a> to register for classes.</p>
                        @endguest
                        @auth
                            @if (!$classx['subscribed'])
                                @if ($classx['places'] - $classx['count'] > 0)
                                    @if ($classx['balance'] !== 0)
                                    <button wire:click='register({{ $classx['id'] }}, {{'"' . $classx['price_id'] . '"' }})'>Register</button>
                                    @else
                                        @if ($classx['type'] === 'studio')
                                            <p>Please <a wire:navigate href="/pricing">buy a {{ $classx['type'] }} class first</a> to be able to register for {{ $classx['type'] }} classes.</p>
                                        @else
                                            <p>Please <a wire:navigate href="/pricing">buy an {{ $classx['type'] }} class first</a> to be able to register for {{ $classx['type'] }} classes.</p>
                                        @endif
                                    @endif
                                @else
                                <p class="registered">Unfortunately, there are no more available spots.</p>
                                @endif
                            @else
                            <p class="registered">You have successfully registered for this class.</p>
                            <button wire:click='unregister({{ $classx['id'] }}, {{'"' . $classx['price_id'] . '"' }})'>Unregister</button>
                            @endif                        
                        @endauth
                
                    </article>

                @endforeach

            @else

                <article>

                    <h2>No classes</h2>
                    <p>Currently, there are no classes for this date. Please choose another date.</p>

                </article>

            @endif

        @endif

        <div>
            <h3>What to bring with you?</h3>
            <p>Yoga mat, fresh water, towel and wear comfortable clothes that you can move freely in.</p>
            <p>If you have any props (such as yoga bricks or belts) feel free to bring them too.</p>
        </div>

    </div>

    <div wire:loading class="spinner">
        <div></div>
    </div>

</main>
