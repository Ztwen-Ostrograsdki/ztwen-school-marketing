<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
       <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>{{ $title ?? config('app.name') }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />


        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
    </head>
    <body class="min-h-screen pb-0 mb-0  from-sky-500 via-purple-700  to-indigo-500 bg-gradient-to-tr">

        @livewire('pages.nav-bar')

        <main class="pt-4 mt-14 px-2">
            {{ $slot }}
        </main>

        @livewire('pages.footer')

        @fluxScripts

        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

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

    </body>
</html>

