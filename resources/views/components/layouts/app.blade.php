<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
       <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>{{ $title ?? config('app.name') }}</title>

        <link rel="icon" href="{{asset('icons/ztwen-black.png')}}" sizes="any">
        <link rel="icon" href="{{asset('icons/ztwen-black.png')}}" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" ></script>

        @livewireStyles


        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
    </head>
    <body class="min-h-screen pb-0 mb-0  from-sky-500 via-purple-700  to-indigo-500 bg-gradient-to-tr">

        @livewire('pages.nav-bar')
            <button type="button" class="hidden" data-drawer-target="drawer-admin-navigation" data-drawer-show="drawer-admin-navigation" aria-controls="drawer-admin-navigation"></button>

        <main class="pt-4 mt-14 px-2">
            @livewire("pages.live-notifications-toaster")
            @livewire("pages.offline-alert")
            
            {{ $slot }}

             @livewire('modals-manager') {{--INCLUDE OF APP MODALS --}}
        </main>

        @livewire('pages.footer')

        @fluxScripts

        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>


        <script>
            ScrollReveal().reveal('.headline');

            ScrollReveal().reveal('.card', { interval: 200, origin: 'bottom', distance: '200px'});

            function revealOnScroll() {
                const elements = document.querySelectorAll('.reveal');

                elements.forEach(el => {
                const rect = el.getBoundingClientRect();
                const isVisible = rect.top < window.innerHeight - 100; // seuil d'apparition

                if (isVisible) {
                    el.classList.remove('opacity-0', 'translate-y-10');
                    el.classList.add('opacity-100', 'translate-y-0');
                }
                });
            }

            window.addEventListener('scroll', revealOnScroll);
            window.addEventListener('load', revealOnScroll); // au cas où certains éléments sont visibles dès le début
        </script>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('letterAnimator', () => ({
                    words: ['Bonjour', 'Hello', 'Salut', 'Bienvenue'],
                    currentWordIndex: 0,
                    currentLetters: [],
                    start() {
                    this.setWord();
                    setInterval(() => {
                        this.nextWord();
                    }, 3500); // temps total entre chaque mot (ajuste si besoin)
                    },
                    setWord() {
                    const word = this.words[this.currentWordIndex];
                    this.currentLetters = []; // reset d'abord pour relancer les animations
                    setTimeout(() => {
                        this.currentLetters = word.split('');
                    }, 50); // petit délai pour que le DOM réinitialise proprement
                    },
                    nextWord() {
                    this.currentWordIndex = (this.currentWordIndex + 1) % this.words.length;
                    this.setWord();
                    }
                }))
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {

                initFlowbite();

                let message_focusable = document.getElementById('focusable-input');

                if(message_focusable) {message_focusable.focus();}

                // document.querySelectorAll('[id$="-modal"]').forEach(modal => {

                //     modal.setAttribute('aria-hidden', 'true');
                    
                // });

            });

            document.addEventListener('livewire:init', () => {

                Livewire.on('HideModalEvent', (event) => {

                    let modal_name = event[0];

                    let modalElement = document.querySelector(modal_name);

                    modal = new Modal(modalElement)

                    modal.hide();

                    let fixed = document.querySelector(".fixed.inset-0.z-40");

                    if(fixed){fixed.remove();}

                    // setTimeout(() => {

                    //     initAllSwipers(); 
                    // }, 300); 

                });

                Livewire.on('OpenModalEvent', (event) => {

                    let modal_name = event[0];

                    let modalElement = document.querySelector(modal_name);

                    modal = new Modal(modalElement)

                    modalElement.setAttribute('aria-hidden', 'false');

                    modal.show();

                    // initAllSwipers();

                });
                
            });

            window.User = {!! json_encode([
                    'id' => optional(auth()->user())->id,
                ]) 
            !!};

        </script>
        
        @livewireScripts

        @livewireSweetalertScripts
    </body>
</html>

