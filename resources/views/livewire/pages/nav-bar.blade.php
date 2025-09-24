
<div>
    <nav class="fixed w-full top-0 z-40 bg-black/60 backdrop-blur-lg transition-colors duration-300 md:px-10 lg:px-10  shadow-lg shadow-purple-600 ">
        <div class="container mx-auto flex h-20 items-center justify-between px-4">
            <!-- Logo and Home Link -->
            <!-- <a href="#" class="flex items-center">
            <img class="h-10 w-auto" src="https://little-joy-studio.vercel.app/studio.png" width="999" height="999" alt="little joys studio" />
            </a> -->
            <a href="/" class="flex items-center shrink-0">
                <img class="h-10 rounded-4xl mr-1" src="{{asset('images/ztwen.png')}}" alt="Logo {{config('app.name')}}">
                <span class="md:flex text-2xl mt-0.5 font-bold text-primary-600 text-white">
                    {{config('app.name')}}
                </span>
            </a>

            <!-- Desktop Menu Links -->
            <div class="hidden text-xs lg:text-sm md:flex items-center md:gap-4 text-white letter-spacing-1">
                <a href="{{route('home')}}" class=" font-medium @if(request()->route()->named('home')) text-lime-500 shadow-sm shadow-lime-400 @else hover:shadow-xl hover:border hover:border-purple-700 hover:shadow-purple-700 @endif  px-2 py-2 rounded-lg transition">Acceuil</a>
                @auth
                    <a href="{{auth_user()->to_profil_route()}}" class=" font-medium @if(request()->route()->named('user.profil')) text-lime-500 shadow-sm shadow-lime-400 @else hover:shadow-xl hover:border hover:border-purple-700 hover:shadow-purple-700 @endif  px-2 py-2 rounded-lg transition">
                        Profil
                    </a>
                    <a href="{{route('admin')}}" class=" font-medium @if(request()->route()->named('admin')) text-lime-500 shadow-sm shadow-lime-400 @else hover:shadow-xl hover:border hover:border-purple-700 hover:shadow-purple-700 @endif  px-2 py-2 rounded-lg transition">
                        Administration
                    </a>
                @endauth
                <a href="{{route('schools.page')}}" class=" font-medium @if(request()->route()->named('schools.page')) text-lime-500 shadow-sm shadow-lime-400 @else hover:shadow-xl hover:border hover:border-purple-700 hover:shadow-purple-700 @endif px-2 py-2 rounded-lg transition">
                    Les écoles
                </a>
                <a href="{{route('about.us')}}" class=" font-medium @if(request()->route()->named('about.us')) text-lime-500 shadow-sm shadow-lime-400 @else hover:shadow-xl hover:border hover:border-purple-700 hover:shadow-purple-700 @endif px-2 py-2 rounded-lg transition">
                    A propos
                </a>
                <a href="{{route('schools.searching')}}" class="@if(request()->route()->named('schools.searching')) text-lime-500 shadow-sm shadow-lime-400 @else hover:shadow-xl hover:border hover:border-purple-700 hover:shadow-purple-700 @endif  font-medium  px-2 py-2 rounded-lg transition">
                    Rechercher
                </a>
                <a href="{{route('packs.page')}}" class="@if(request()->route()->named('packs.page')) text-lime-500 shadow-sm shadow-lime-400 @else hover:shadow-xl hover:border hover:border-purple-700 hover:shadow-purple-700 @endif  font-medium  px-2 py-2 rounded-lg transition">
                    Services
                </a>
                
                @guest
                    @if(!request()->route()->named('register'))
                        <a href="{{route('register')}}" class="cursor-pointer rounded-full border-2 py-2 px-6 border-white bg-white text-purple-900 hover:bg-purple-900 hover:text-white hover:shadow-lg transition duration-300 ease-in-out hidden lg:inline">
                            S'inscire
                        </a>
                    @endif
                    @if(!request()->route()->named('login'))
                        <a href="{{route('login')}}" class="cursor-pointer rounded-full py-2 px-6 border-white bg-purple-700 text-gray-100 hover:bg-indigo-900 hover:text-white hover:shadow-lg transition duration-300 ease-in-out">
                            Connexion
                        </a>
                    @endif
                @endguest

                {{-- USER DROPDOWN MENU --}}
                @auth
                <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">

                    <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 cursor-pointer focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-8 h-8 rounded-full border-2 border-indigo-500" src="{{user_profil_photo(auth_user())}}" alt="profil de photo de {{auth_user()->getFullName()}}">
                    </button>
                    <!-- Dropdown menu -->
                    
                    <div class="z-50 hidden my-4 text-base list-none bg-black border border-amber-400 divide-y divide-gray-100 rounded-lg shadow-md shadow-gray-900 dark:divide-gray-600 " id="user-dropdown">
                        <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900 dark:text-white">
                            {{ auth_user()->getFullName() }}
                        </span>
                        <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">
                            {{ auth_user()->email }}
                        </span>
                        </div>
                        <ul class="py-2" aria-labelledby="user-menu-button" class="">
                            
                            @if(auth_user()->isAdminsOrMaster())
                            <li>
                                <a href="{{route('admin')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Administrations</a>
                            </li>
                            @endif
                            <li>
                                <a href="{{auth_user()->to_profil_route()}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Mon profil</a>
                            </li>
                            <li>
                                <a href="{{auth_user()->to_quotes_route()}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Mes Citations</a>
                            </li>
                            <li>
                                <a href="{{auth_user()->to_my_notifications_route()}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Mes notifications</a>
                            </li>
                            <li>
                                <a href="{{auth_user()->to_my_assistants_list_route()}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Mes assistants</a>
                            </li>
                            <li>
                                <a href="{{auth_user()->to_my_receiveds_assistants_requests_list_route()}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Mes Demandes</a>
                            </li>
                            <li>
                                <a href="{{auth_user()->to_subscribes_route()}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Mes abonnements</a>
                            </li>
                            @if(!auth_user()->current_school)
                            <li>
                                <a href="{{auth_user()->to_create_school_route()}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Ajouter une école</a>
                            </li>
                            @else
                            <li title="Charger le profil de mon école {{auth_user()->current_school->name}}">
                                <a href="{{auth_user()->current_school->to_profil_route()}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Mon école</a>
                            </li>
                            @endif
                            <li>
                                <a href="{{auth_user()->to_profil_edit_route()}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Editer mon profil</a>
                            </li>
                            <li>
                                <a href="{{ route('schools.searching') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Trouvez une école</a>
                            </li>
                            <li>
                                <a x-on:click="$dispatch('LogoutLiveEvent')" type="button" class="block px-4 py-2 text-sm text-gray-700 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Se déconnecter</a>
                            </li>
                        </ul>
                    </div>
                    
                </div>
                @endauth
                {{-- END USER DROPDOWN MENU --}}
            </div>
            {{-- SMALL SCREEN  SIDEBAR BUTTON--}}
            <div class="md:hidden">
                <button type="button" class="collapse-toggle text-white btn btn-outline btn-secondary btn-sm btn-square cursor-pointer" data-drawer-target="drawer-navigation" data-drawer-show="drawer-navigation" aria-controls="drawer-navigation">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
            {{-- END SMALL SCREEN  SIDEBAR BUTTON--}}
        </div>
    </nav>

    {{-- SMALL SCREEN SIDEBAR --}}
    <div id="drawer-navigation" class="fixed top-0 left-0 z-50 w-[80%] h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-black/90 border-r border-sky-700" tabindex="-1" aria-labelledby="drawer-label">
        <a href="{{route('home')}}" class="flex justify-start items-center">
            <img class="h-10 rounded-4xl mr-1 border border-amber-600" src="{{asset('images/ztwen.png')}}" alt="Logo {{config('app.name')}}">
            <h5 id="drawer-navigation-label" class="text-base font-semibold uppercase text-amber-600">
                {{config('app.name')}}
            </h5>
        </a>
        <button type="button" data-drawer-hide="drawer-navigation" aria-controls="drawer-navigation" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" >
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Close menu</span>
        </button>
        <div class="py-4 overflow-y-auto">
            <ul class="space-y-2 font-medium">
                @auth
                <li>
                    <a href="{{auth_user()->to_profil_route()}}" class="items-center p-2 flex rounded-lg text-white  @if(request()->route()->named('user.profil')) bg-indigo-700/55 hover:text-yellow-400 @else hover:bg-gray-700 @endif group group justify-start gap-x-1.5 letter-spacing-1">
                        <img class="w-10 h-10 rounded-full bg-cover border-2 border-indigo-700" src="{{user_profil_photo(auth_user())}}" alt="Photo de profil de {{auth_user()->getFullName()}}">
                        <span class="inline-flex justify-start flex-col">
                            <span class="text-sm font-semibold">{{ auth_user()->getFullName() }}</span>
                            <span class="text-xs text-indigo-600"> {{ auth_user()->email }} </span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('home')}}" class="flex items-center p-2 rounded-lg text-white  @if(request()->route()->named('home')) bg-indigo-700/55 hover:text-yellow-400 @else hover:bg-gray-700 @endif group">
                    <span class="fas fa-home"></span>
                    <span class="flex-1 ms-3 whitespace-nowrap">Acceuil</span>
                    </a>
                </li>
                @if(auth_user()->isAdminsOrMaster())
                <li>
                    <a href="{{route('admin')}}" class="flex items-center p-2 rounded-lg text-white  @if(request()->route()->named('admin')) bg-indigo-700/55 hover:text-yellow-400 @else hover:bg-gray-700 @endif group">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ms-3">Administration</span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{auth_user()->to_my_notifications_route()}}" class="flex items-center p-2 rounded-lg text-white  @if(request()->route()->named('my.notifications')) bg-indigo-700/55 hover:text-yellow-400 @else hover:bg-gray-700 @endif group">
                    <span class="fas fa-message"></span>
                    <span class="flex-1 ms-3 whitespace-nowrap">Mes notifications</span>
                    <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ count(auth_user()->unreadNotifications) }}</span>
                    </a>
                </li>
                @if(count(auth_user()->schools))
                <li>
                    <a href="{{auth_user()->to_my_assistants_list_route()}}" class="flex items-center p-2 rounded-lg text-white  @if(request()->route()->named('my.assistants')) bg-indigo-700/55 hover:text-yellow-400 @else hover:bg-gray-700 @endif group">
                    <span class="fas fa-users"></span>
                    <span class="flex-1 ms-3 whitespace-nowrap">Mes assistants</span>
                    </a>
                </li>
                @else
                <li>
                    <a href="{{auth_user()->to_my_receiveds_assistants_requests_list_route()}}" class="flex items-center p-2 rounded-lg text-white  @if(request()->route()->named('my.assistants.requests')) bg-indigo-700/55 hover:text-yellow-400 @else hover:bg-gray-700 @endif group">
                    <span class="fas fa-user-shield"></span>
                    <span class="flex-1 ms-3 whitespace-nowrap">Mes demandes d'assistance</span>
                    </a>
                </li>
                @endif
                @endauth
                <li>
                    <a href="{{route('schools.page')}}" class="flex items-center p-2 rounded-lg text-white  @if(request()->route()->named('schools.page')) bg-indigo-700/55 hover:text-yellow-400 @else hover:bg-gray-700 @endif group">
                    <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                        <path d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Les écoles à la une</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('about.us')}}" class="flex items-center p-2 rounded-lg text-white  @if(request()->route()->named('about.us')) bg-indigo-700/55 hover:text-yellow-400 @else hover:bg-gray-700 @endif group">
                    <span class="fas fa-newspaper"></span>
                    <span class="flex-1 ms-3 whitespace-nowrap">A propos de nous</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('packs.page')}}" class="flex items-center p-2 rounded-lg text-white  @if(request()->route()->named('packs.page')) bg-indigo-700/55 hover:text-yellow-400 @else hover:bg-gray-700 @endif group">
                    <span class="fab fa-shopify"></span>
                    <span class="flex-1 ms-3 whitespace-nowrap">Services</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('schools.searching')}}" class="flex items-center p-2 rounded-lg text-white  @if(request()->route()->named('schools.searching')) bg-indigo-700/55 hover:text-yellow-400 @else hover:bg-gray-700 @endif group">
                    <span class="fas fa-newspaper"></span>
                    <span class="flex-1 ms-3 whitespace-nowrap">Trouvez une école</span>
                    </a>
                </li> 
                @guest
                    @if(!request()->route()->named('login'))
                    <li>
                        <a href="{{route('login')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Se connecter</span>
                        </a>
                    </li>
                    @endif
                    @if(!request()->route()->named('register'))
                    <li>
                        <a href="{{route('register')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z"/>
                            <path d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z"/>
                            <path d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .49-.263l6.118-6.117a2.884 2.884 0 0 0-4.079-4.078l-6.117 6.117a.96.96 0 0 0-.263.491l-.679 3.4A.961.961 0 0 0 8.961 16Zm7.477-9.8a.958.958 0 0 1 .68-.281.961.961 0 0 1 .682 1.644l-.315.315-1.36-1.36.313-.318Zm-5.911 5.911 4.236-4.236 1.359 1.359-4.236 4.237-1.7.339.341-1.699Z"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">S'inscrire</span>
                        </a>
                    </li>
                    @endif
                @endguest
            </ul>
        </div>
    </div>
    {{-- END SMALL SCREEN SIDEBAR --}}

<!-- Middle Section -->


{{-- ADMIN MENU SIDEBAR --}}
    @auth
    <div id="drawer-admin-navigation" class="fixed top-0 left-0 z-50 w-[70%] h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-black/90 border-r-2 border-amber-600" tabindex="-1" aria-labelledby="drawer-label">
        <h5 id="drawer-admin-navigation-label" class="text-base font-semibold text-amber-600 uppercase  text-center">
            <span class="fas fa-user-secret"></span>
            <span>Administration</span>
        </h5>
        <button type="button" data-drawer-hide="drawer-admin-navigation" aria-controls="drawer-admin-navigation" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer" >
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Close menu</span>
        </button>
        <div class="py-4 overflow-y-auto">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.roles')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white @if(request()->route()->named('admin.roles')) text-lime-500 shadow-sm shadow-lime-400 px-3 mx-1 @else dark:hover:bg-gray-700 @endif group">
                        <span class="fas fa-user-gear"></span>
                        <span class="flex-1 ms-3 whitespace-nowrap">Les rôles</span>
                        <span class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">
                            {{ __zero(count(admin_roles())) }}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.users.listing')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white @if(request()->route()->named('admin.users.listing')) text-lime-500 shadow-sm shadow-lime-400 px-3 mx-1 @else dark:hover:bg-gray-700 @endif group">
                        <span class="fas fa-users"></span>
                        <span class="flex-1 ms-3 whitespace-nowrap">Utilisateurs</span>
                        <span class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">
                            {{ __zero(count(getUsers())) }}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.assistants.listing')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white @if(request()->route()->named('admin.assistants.listing')) text-lime-500 shadow-sm shadow-lime-400 px-3 mx-1 @else dark:hover:bg-gray-700 @endif group">
                        <span class="fas fa-person"></span>
                        <span class="flex-1 ms-3 whitespace-nowrap">Les assistants</span>
                        <span class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">12</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.schools.listing')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white @if(request()->route()->named('admin.schools.listing')) text-lime-500 shadow-sm shadow-lime-400 px-3 mx-1 @else dark:hover:bg-gray-700 @endif group">
                        <span class="fas fa-home"></span>
                        <span class="flex-1 ms-3 whitespace-nowrap">Les écoles</span>
                        <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                            {{ __zero($schools) }}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('schools.searching')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white @if(request()->route()->named('schools.searching')) text-lime-500 shadow-sm shadow-lime-400 px-3 mx-1 @else dark:hover:bg-gray-700 @endif group">
                        <span class="fas fa-home"></span>
                        <span class="flex-1 ms-3 whitespace-nowrap">Trouvez une école</span>
                        <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                            
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{auth_user()->to_my_notifications_route()}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white @if(request()->route()->named('my.notifications')) text-lime-500 shadow-sm shadow-lime-400 px-3 mx-1 @else dark:hover:bg-gray-700 @endif group">
                        <span class="fas fa-message"></span>
                        <span class="flex-1 ms-3 whitespace-nowrap">Notifications</span>
                        <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                            {{ __zero(count(auth_user()->unreadNotifications)) }}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.packs.subscriptions.list')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white @if(request()->route()->named('admin.packs.subscriptions.list')) text-lime-500 shadow-sm shadow-lime-400 px-3 mx-1 @else dark:hover:bg-gray-700 @endif group">
                        <span class="fas fa-question"></span>
                        <span class="flex-1 ms-3 whitespace-nowrap">Demandes d'abonnements</span>
                        <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300"> {{ __zero($subscription_demandes) }} </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.packs.abonnements.list')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white @if(request()->route()->named('admin.packs.abonnements.list')) text-lime-500 shadow-sm shadow-lime-400 px-3 mx-1 @else dark:hover:bg-gray-700 @endif group">
                        <span class="fas fa-user-tag"></span>
                        <span class="flex-1 ms-3 whitespace-nowrap">Abonnements</span>
                        <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ __zero($subscriptions) }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.payments')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white @if(request()->route()->named('admin.payments')) text-lime-500 shadow-sm shadow-lime-400 px-3 mx-1 @else dark:hover:bg-gray-700 @endif group">
                        <span class="fas fa-money-bill-transfer"></span>
                        <span class="flex-1 ms-3 whitespace-nowrap">Les payements</span>
                        <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ __zero($payments) }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.packs.list')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white @if(request()->route()->named('admin.packs.list')) text-lime-500 shadow-sm shadow-lime-400 px-3 mx-1 @else dark:hover:bg-gray-700 @endif group">
                        <span class="fab fa-shopify"></span>
                        <span class="flex-1 ms-3 whitespace-nowrap">Les Packs</span>
                        <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ __zero($packs) }}</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white @if(request()->route()->named('admin.roles')) text-lime-500 shadow-sm shadow-lime-400 px-3 mx-1 @else dark:hover:bg-gray-700 @endif group">
                    <span class="fas fa-credit-card"></span>
                    <span class="flex-1 ms-3 whitespace-nowrap">Les Payements</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex cursor-default items-center p-2 group">
                    
                    </a>
                </li>
                <li>
                    <a x-on:click="$dispatch('LogoutLiveEvent')" type="button" class="flex cursor-pointer items-center p-2 bg-amber-600 text-gray-900 rounded-lg hover:bg-amber-800 group">
                        <span class="fas fa-user-large-slash"></span>
                        <span class="flex-1 ms-3 whitespace-nowrap">Se déconnecter</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    @endauth


</div>


