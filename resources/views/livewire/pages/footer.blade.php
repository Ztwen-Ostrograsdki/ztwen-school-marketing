<footer class="from-gray-900 to-black bg-linear-to-tl  w-full mt-80 border-t-2">
    <div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 lg:pt-20 mx-auto">
        <!-- Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
        <div class="col-span-full lg:col-span-1 footer-element">
            <a class=" flex-none text-xl font-semibold text-white dark:focus:outline-none dark:focus:ring-1 pl-2 dark:focus:ring-gray-600" href="\" aria-label="Brand">{{ config('app.name') }}</a>

            <div class="mt-3 flex flex-col gap-y-2 ">
                <p class="m-0 p-0">
                    <a class="inline-block my-0 hover:bg-gray-800 py-1 w-full pl-2 footer-element gap-x-2 text-gray-400 hover:text-gray-200 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{route('packs.page')}}">
                    La boutique des packs
                    </a>
                </p>
                @auth
                <p class="m-0 p-0">
                    <a class=" hover:bg-gray-800 pl-2 py-1 footer-element w-full inline-block my-0 gap-x-2 text-gray-400 hover:text-gray-200 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#">
                        Mes notifications
                    </a>
                </p>

                <p class="m-0 p-0">
                    <a class=" hover:bg-gray-800 pl-2 py-1 footer-element w-full inline-block my-0 gap-x-2 text-gray-400 hover:text-gray-200 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{auth_user()->to_profil_route()}}">
                        Mon profil
                    </a>
                </p>
                
                <p class="m-0 p-0">
                    <a class=" hover:bg-gray-800 pl-2 py-1 footer-element w-full inline-block my-0 gap-x-2 text-gray-400 hover:text-gray-200 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ auth_user()->to_my_assistants_list_route() }}">
                        Mes Assistants
                    </a>
                </p>

                <p class="m-0 p-0">
                    <a class=" hover:bg-gray-800 pl-2 py-1 footer-element w-full inline-block my-0 gap-x-2 text-gray-400 hover:text-gray-200 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ auth_user()->to_my_receiveds_assistants_requests_list_route() }}">
                        Mes demandes
                    </a>
                </p>
                <p class="m-0 p-0">
                    <a class=" hover:bg-gray-800 pl-2 py-1 footer-element w-full inline-block my-0 gap-x-2 text-gray-400 hover:text-gray-200 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#">
                        Mes citations
                    </a>
                </p>
                
                <p class="m-0 p-0">
                    <a x-on:click="$dispatch('LogoutLiveEvent')" class=" hover:bg-gray-800 pl-2 py-1 footer-element w-full inline-block my-0 gap-x-2 text-amber-500 hover:text-amber-600 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 cursor-pointer" type="button">
                        Se déconnecter
                    </a>
                </p>
                @endauth
                
            </div>

        </div>
        <!-- End Col -->

        <div class="col-span-1">
            <h4 class="font-semibold text-gray-100 footer-element pl-2">Outils bibliothèques </h4>

            <div class="mt-3 grid gap-y-2">
                <p>
                    <a class="inline-block footer-element my-0 hover:bg-gray-800 py-1 w-full pl-2 gap-x-2 text-gray-400 hover:text-gray-200 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#">La banques des épreuves</a>
                </p>
                
            </div>
        </div>
        <!-- End Col -->

        <div class="col-span-1">
            <h4 class="font-semibold text-gray-100 footer-element pl-2">
                La plateforme 
                <span class="text-purple-600">{{ config('app.name') }}</span>
            </h4>

            <div class="mt-3 grid gap-y-2">
                <p class="m-0 p-0">
                    <a class="inline-block my-0 hover:bg-gray-800 py-1 w-full pl-2 footer-element gap-x-2 text-gray-400 hover:text-gray-200 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{route('packs.page')}}">
                    Les packs disponibles
                    </a>
                </p>
                <p class="m-0 p-0">
                    <a class="inline-block my-0 hover:bg-gray-800 py-1 w-full pl-2 footer-element gap-x-2 text-gray-400 hover:text-gray-200 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{route('about.us')}}">
                    A propos de nous
                    </a>
                </p>
                <p class="m-0 p-0">
                    <a title="Signaler une anormalie technique sur la plateforme aux web-masters" type="button" class="inline-block my-0 footer-element gap-x-2 text-orange-500 hover:bg-gray-800 py-1 w-full pl-2 hover:text-gray-200 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 cursor-pointer">
                    Signaler un bugg
                    </a>
                </p>
            </div>
        </div>
        <!-- End Col -->

        <div class="col-span-2">
            <h4 class="font-semibold text-gray-100 footer-element">S'abonner à la newsletter</h4>
            <form>
                <div class="mt-4 flex flex-col items-center gap-2 sm:flex-row sm:gap-3 bg-white rounded-lg p-2 dark:bg-gray-800">
                    <div class="w-full">
                    <input wire:model.live='subscriber_mail' type="text" id="subscriber_mail" name="subscriber_mail" class="py-3 px-4 block w-full border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-transparent dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Entrer votre addrese mail">
                    </div>
                    @error('subscriber_mail')
                        <span class="text-red-500 letter-spacing-1 font-semibold text-xs"> {{ $message }} </span>
                    @enderror
                    <span wire:click='subscribeTo' class="w-full sm:w-auto whitespace-nowrap p-3 cursor-pointer inline-flex footer-element justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                        <span wire:loading.remove wire:target='subscribeTo'>S'abonner</span>
                        <span wire:loading wire:target='subscribeTo' class="">
                            <span class="fas fa-rotate animate-spin"></span>
                            <span>En cours d'envoi</span>
                        </span>
                    </span>
                </div>
            </form>
        </div>
        <!-- End Col -->
        </div>
        <!-- End Grid -->

        <div class="mt-5 sm:mt-12 grid gap-y-2 sm:gap-y-0 sm:flex sm:justify-between sm:items-center">
        <div class="flex justify-between gap-x-2 items-center footer-element">
            <img class="w-16 h-10 border-2 border-sky-100" src="{{asset('icons/ztwen-black.png')}}" alt="">
            <p class="text-sm text-gray-400">© {{ $date }} {{ config('app.name') }}. {{__('Tout droits réservés')}}.</p>
        </div>
        <div class="flex gap-x-4">
            
            <a class="inline-flex footer-element justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-white hover:bg-gray-800 p-2 hover:text-gray-950 focus:outline-none focus:ring-1 focus:ring-gray-600" href="#">
                <span class="fab fa-facebook text-blue-500"></span>
            </a>
            <a class="inline-flex footer-element justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-white hover:bg-gray-800 p-2 hover:text-gray-950 focus:outline-none focus:ring-1 focus:ring-gray-600" href="#">
                <span class="fab fa-facebook-messenger text-white"></span>
            </a>
            <a class="inline-flex footer-element justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-white hover:bg-gray-800 p-2 hover:text-gray-950 focus:outline-none focus:ring-1 focus:ring-gray-600" href="#">
                <span class="fab fa-whatsapp text-green-500"></span>
            </a>
            <a class="inline-flex footer-element justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-white hover:bg-gray-800 p-2 hover:text-gray-950 focus:outline-none focus:ring-1 focus:ring-gray-600" href="#">
                <span class="fab fa-google text-red-500"></span>
            </a>
            @guest
            <a title="S'inscrire" href="{{route('register')}}" class="w-10  h-10 inline-flex footer-element justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-primary-500 hover:bg-gray-800 p-2 hover:text-gray-950 focus:outline-none focus:ring-1 focus:ring-gray-600" >
            <span class="fas fa-user-plus"></span>
            </a>
            <a title="Se connecter" href="{{route('login')}}" class="w-10  h-10 inline-flex footer-element justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-success-500 hover:bg-gray-800 p-2 hover:text-gray-950disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:ring-1 focus:ring-gray-600" >
            <span class="fas fa-user"></span>
            </a>
            @endguest

        </div>
        <!-- End Social Brands -->
        </div>
    </div>
</footer>
