@push('tags')
    <meta name="description" content="About Angi Yoga and Angi's yoga journey">
    <meta name="keywords" content="Yoga, Kingston, London, Classes, About">
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
    <meta property=”og:title” content="Angi Yoga - Contact"/>
    <meta property="og:description" content="About Angi Yoga and Angi's yoga journey"/>
    <meta property=”og:type” content="website"/>
    <meta property="og:locale" content="en_GB" />
    <meta property="og:sitename" content="Angi Yoga" />
    <meta property="og:url" content="https://www.angi.yoga"/>
@endpush

<main>
    {{-- Care about people's approval and you will be their prisoner. --}}

    <h1>my yoga journey</h1>

    <div>
        
        <p>My introduction to yoga was as random as stumbling upon a hidden gem. One day, I discovered a yoga studio and, with no prior knowledge, decided to step into the unknown. Nervous, I placed my mat at the back, unsure of what was about to unfold. As the class began, I followed the teacher's lead, navigating through poses I'd never imagined. To my surprise, at the end of that first class, I felt an incredible sense of relaxation. All the work stress and anxiety had vanished—I felt free. For the first time, my mind was empty, and I loved it. That initial experience kept me coming back.</p>

        <p>Enchanted by the physical practice and eager to master advanced poses, I attended numerous workshops, treating yoga purely as a physical pursuit. The desire to deepen my understanding led me to sign up for a 200-hour yoga teacher training, initially with no intention to teach — I simply wanted to learn the poses.</p>

        <p>During the training, I discovered that yoga was more than just a series of exercises; it was a lifestyle. The philosophy behind the practice fascinated me, and I found joy in sharing yoga with friends and family.</p>
        
        <p>Driven to understand the roots, I journeyed to India for a transformative 300-hour yoga teacher training. During that intense month, my mind and body transformed. Philosophy classes revealed the profound wisdom of yoga as a guidebook for life. I learned that yoga couldn't be rushed; it’s a lifelong journey. Advanced poses emerge naturally with consistent practice. Daily meditation is a key to letting go and allowing thoughts to settle.</p>

        <p>After the training, my focus shifted. I no longer chased advanced poses; instead, I embraced yoga as a tool for maintaining a healthy and balanced body and mind. In my teaching, I aim to bring my students back to that initial feeling of release and connection, fostering a mind-body harmony that I experienced ten years ago. My goal is to help them release tension and feel good in both mind and body, just as yoga has done for me.</p>

        <p>I know that every individual's journey of yoga is unique and worthy. Through breath, movement, and mindful connection, we uncover the incredible strength within.. Together, let's cultivate strength, find peace, and embrace the beauty of the present moment. I can't wait to share this transformative experience with you. See you on the mat!</p>
        
        <p>In light and love,</p>

        <p>Angi</p>

        {{-- @if ($paragraphs && count($paragraphs) > 0)
            
            @foreach ($paragraphs as $paragraph)

                <p wire:key='{{ $paragraph->id }}'>{{$paragraph->paragraph}}</p>

            @endforeach
        
        @else
            <p>I will tell you about me soon. Promised.</p>
        @endif --}}

    </div>

</main>
