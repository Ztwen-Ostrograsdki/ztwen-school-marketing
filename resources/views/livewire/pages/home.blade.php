<div x-data="letterAnimator" x-init="start()" >
    <section class="w-full flex items-center justify-center min-h-screen overflow-hidden ">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <!-- Content -->
        <div class="relative z-10 container mx-auto px-4 text-center text-white">
            
            <h1 class="mb-6 text-4xl font-bold tracking-tight sm:text-5xl md:text-6xl lg:text-7xl" style="line-height: 1.2">
            La plateforme publicitaire des <span class="text-lime-500">meilleurs</span> écoles, <span class="relative whitespace-nowrap text-purple-400 dark:text-purple-400">
                <svg aria-hidden="true" viewBox="0 0 418 42" class="absolute top-2/3 left-0 h-[0.58em] w-full fill-purple-400/70 dark:fill-purple-300/60" preserveAspectRatio="none">
                <path d="M203.371.916c-26.013-2.078-76.686 1.963-124.73 9.946L67.3 12.749C35.421 18.062 18.2 21.766 6.004 25.934 1.244 27.561.828 27.778.874 28.61c.07 1.214.828 1.121 9.595-1.176 9.072-2.377 17.15-3.92 39.246-7.496C123.565 7.986 157.869 4.492 195.942 5.046c7.461.108 19.25 1.696 19.17 2.582-.107 1.183-7.874 4.31-25.75 10.366-21.992 7.45-35.43 12.534-36.701 13.884-2.173 2.308-.202 4.407 4.442 4.734 2.654.187 3.263.157 15.593-.780 35.401-2.686 57.944-3.488 88.365-3.143 46.327.526 75.721 2.23 130.788 7.584 19.787 1.924 20.814 1.98 24.557 1.332l.066-.011c1.201-.203 1.53-1.825.399-2.335-2.911-1.31-4.893-1.604-22.048-3.261-57.509-5.556-87.871-7.36-132.059-7.842-23.239-.254-33.617-.116-50.627.674-11.629.540-42.371 2.494-46.696 2.967-2.359.259 8.133-3.625 26.504-9.810 23.239-7.825 27.934-10.149 28.304-14.005 .417-4.348-3.529-6-16.878-7.066Z"></path>
                </svg>
                <span class="relative">{{ config('app.name') }}</span>
            </span>
            </h1>
            <p style="letter-spacing: 2px;" class="mx-auto mb-8 max-w-2xl text-lg font-semibold letter-spacing-2 text-lime-500">
            Grâce à nous, votre école est connue, ...vos prestations, vos résulats, vos performances annuelles, nous faisons votre promotion!
            </p>

            <!-- CTA Button -->
            <div class="flex justify-center items-center mt-8" data-aos="fade-up" data-aos-delay="400">
                @auth
                    @if(auth_user()->current_school)
                        @if(auth_user()->current_school->current_subscription)
                            <a href="{{auth_user()->current_school->to_profil_route()}}" rel="noopener noreferrer"
                            class="relative flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-lg font-thin rounded-full shadow-lg transform hover:scale-105 transition-transform duration-200 letter-spacing-2">
                                <span class="absolute inset-0 rounded-full bg-indigo-600 opacity-50 animate-ping"></span>
                                <span class="relative z-10 pr-2">Votre école {{ auth_user()->current_school->simple_name }} </span>
                            </a>
                        @else
                        <a href="{{route('packs.page')}}" rel="noopener noreferrer"
                            class="relative flex items-center justify-center px-6 py-3 bg-lime-600 hover:bg-lime-700 text-white text-lg font-thin rounded-full shadow-lg transform hover:scale-105 transition-transform duration-200 letter-spacing-2">
                                <span class="absolute inset-0 rounded-full bg-lime-600 opacity-50 animate-ping"></span>
                                <span class="relative z-10 pr-2">S'abonner maintenant</span>
                            </a>
                        @endif
                    @else
                    <a href="{{ auth_user()->to_create_school_route() }}" rel="noopener noreferrer"
                    class="relative flex items-center justify-center px-6 py-3 bg-amber-600 hover:bg-amber-600 text-black text-lg font-thin rounded-full shadow-lg transform hover:scale-105 transition-transform duration-200 letter-spacing-2">
                        <span class="absolute inset-0 rounded-full bg-amber-600 opacity-50 animate-ping"></span>
                        <span class="relative z-10 pr-2">Enregistrer votre école</span>
                    </a>
                    @endif
                @else
                <a href="{{route('login')}}" rel="noopener noreferrer"
                    class="relative flex items-center justify-center px-6 py-3 bg-green-400 hover:bg-green-400 text-black text-lg font-thin rounded-full shadow-lg transform hover:scale-105 transition-transform duration-200 letter-spacing-2">
                    <span class="absolute inset-0 rounded-full bg-green-400 opacity-50 animate-ping"></span>
                    <span class="relative z-10 pr-2">Connectez - vous ici</span>
                </a>
                @endauth
            </div>

        </div>

        <!-- Scroll Down Icon -->
        <div class="absolute sm:bottom-14 bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="{{route('packs.page')}}" class="cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
            </a>
        </div>
    </section>
    <div class="">
        <div class="w-full bg-transparent pt-12 p-4">
            <div class="grid gap-14 md:grid-cols-3 md:gap-5">
                <div data-aos-delay="150" class="rounded-xl bg-white p-6 text-center shadow-xl card">
                    <div
                        class="mx-auto flex h-16 w-16 -translate-y-12 transform items-center justify-center rounded-full shadow-lg bg-amber-500 shadow-amber-500/40">
                        <span class="text-white fas fa-screwdriver-wrench"></span>
                    </div>
                    <h1 class="text-darken mb-3 text-lg font-semibold lg:px-14 text-amber-600">CREEZ VOTRE ECOLE</h1>
                    <p class="px-4 text-gray-900 font-semibold letter-spacing-1">
                        Lancer la crétion de votre institution puis personnalisez-la, décrivez-la!
                    </p>
                </div>
                <div data-aos-delay="150" class="rounded-xl bg-white p-6 text-center shadow-xl card">
                    <div
                        class="mx-auto flex h-16 w-16 -translate-y-12 transform items-center justify-center rounded-full shadow-lg bg-green-500 shadow-green-500/40">
                        <span class=" text-white fas fa-chart-pie"></span>
                    </div>
                    <h1 class="text-darken mb-3 text-lg font-semibold lg:px-14 text-green-600">PUBLIEZ LES STATISTIQUES DE VOTRE ECOLE</h1>
                    <p class="px-4 text-gray-900 font-semibold letter-spacing-1">
                        Faites connaître au grand public, vos performances, et le leadership que vous êtes!
                    </p>
                </div>
                <div data-aos-delay="300" class="rounded-xl bg-white p-6 text-center shadow-xl card">
                    <div
                        class="mx-auto flex h-16 w-16 -translate-y-12 transform items-center justify-center rounded-full shadow-lg bg-sky-500 shadow-sky-500/40">
                        <span class=" text-white fas fa-icons"></span>
                    </div>
                    <h1 class="text-darken mb-3 text-lg font-semibold lg:px-14 text-sky-800">PUBLIEZ DES IMAGES, DES VIDEOS... POUR PLUS DE VISIBILITES</h1>
                    <p class="px-4 text-gray-900 font-semibold letter-spacing-1">
                        ... laissez les visiteurs apprécier la beauté de votre école, ...et l'épanouissement dans votre institution!
                    </p>
                </div>
            </div>
        </div>
        @if(count($quotes) > 0)
        <div class="mx-auto p-4">
            <h3 class="font-semibold letter-spacing-1 p-3 rounded-md bg-black/80 text-amber-600 md:text-2xl text-lg my-4" > # Quelques pensées de nos partenaires</h3>
            <div class="w-full mx-auto mt-5">
                <div class="swiper mySwiper rounded-2xl shadow-lg overflow-hidden bg-sky-100">
                    <div class="swiper-wrapper">
                        @foreach ($quotes as $quote)
                            @php
                                $user = $quote->user;
                            @endphp
                            <div wire:key='defilement-reviews-membre-{{$user->id}}' class="swiper-slide bg-sky-100 p-6">
                                <div class="flex items-center space-x-4">
                                    <img src="{{user_profil_photo($user)}}" class="w-14 h-14 md:w-24 md:h-24 rounded-full border-2 border-cyan-700" />
                                    <div>
                                        <h3 class="text-sm md:text-lg font-semibold text-gray-800">
                                        {{ $user->getFullName(true) }}
                                        </h3>
                                        <span class="flex flex-col text-xs md:text-sm">
                                            <a href="#" class=" text-cyan-600 hover:underline">
                                                <span class="fas fa-user-check"></span>
                                                {{ $user->pseudo }}
                                            </a>
                                            
                                            <a href="mailto:{{$user->email}}" class=" text-cyan-600 hover:underline">
                                                <span class="fas fa-envelope"></span>
                                                {{ $user->email }}
                                            </a>
                                            @if($user->current_school)
                                                <a href="{{$user->current_school->to_profil_route()}}" class=" text-cyan-600 hover:underline hover:underline-offset-4">
                                                    <span class="fas fa-school"></span>
                                                    {{ $user->current_school->name  }}
                                                </a>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <blockquote class="text-gray-700 font-semibold letter-spacing-1 border-l-4 border-cyan-600 pl-4 mt-4">
                                    “{{ $quote->content }}”
                                </blockquote>
                            </div>
                        @endforeach
                    </div>
                    <!-- Pagination -->
                    <div class="swiper-pagination mt-3"></div>
                </div>
            </div>
            
            
        </div>
        @endif
    </div>

</div>
