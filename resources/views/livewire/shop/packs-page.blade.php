<div class="w-full max-w-[85rem] py-3 px-4 sm:px-6 lg:px-8 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2">

    <section class="bg-black/90 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-extrabold text-gray-300 sm:text-5xl">
                    Les packs <span class="text-sky-800">{{ env('APP_NAME') }}</span> disponibles
                </h2>
                <p class="mt-4 text-xl text-lime-400 font-thin">
                    Choisissez votre pack cadeau, et façonner votre établissement sur la toîle!!!
                </p>
            </div>

            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Free Plan -->
                <div class="bg-black/40  rounded-lg shadow-sm shadow-lime-400 p-6 transform hover:scale-105 transition duration-300">
                    <div class="mb-8">
                        <h3 class="text-2xl font-semibold text-white">Free</h3>
                        <p class="mt-4 text-gray-400">Get started with our basic features.</p>
                    </div>
                    <div class="mb-8">
                        <span class="text-5xl font-extrabold text-white">$0</span>
                        <span class="text-xl font-medium text-gray-400">/mo</span>
                    </div>
                    <ul class="mb-8 space-y-4 text-gray-400">
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>1 user account</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>10 transactions per month</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Basic support</span>
                        </li>
                    </ul>
                    <a href="{{route('pack.profil', ['uuid' => "free", 'slug' => "pack-free"])}}" class="block w-full py-3 px-6 text-center rounded-md text-white font-medium bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600">
                    Sign Up
                    </a>
                </div>

                <!-- Starter Plan -->
                <div class="bg-black/40  rounded-lg shadow-sm shadow-lime-400 p-6 transform hover:scale-105 transition duration-300">
                    <div class="mb-8">
                        <h3 class="text-2xl font-semibold text-white">Starter</h3>
                        <p class="mt-4 text-gray-400">Perfect for small businesses and startups.</p>
                    </div>
                    <div class="mb-8">
                        <span class="text-5xl font-extrabold text-white">$49</span>
                        <span class="text-xl font-medium text-gray-400">/mo</span>
                    </div>
                    <ul class="mb-8 space-y-4 text-gray-400">
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>5 user accounts</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>100 transactions per month</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Standard support</span>
                        </li>
                    </ul>
                    <a href="{{route('pack.profil', ['uuid' => "starter", 'slug' => "pack-starter"])}}" class="block w-full py-3 px-6 text-center rounded-md text-white font-medium bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600">
                    Get Started
                    </a>
                </div>

                <!-- Pro Plan -->
                <div class="bg-black/40  rounded-lg shadow-sm shadow-lime-400 p-6 transform hover:scale-105 transition duration-300">
                    <div class="mb-8">
                        <h3 class="text-2xl font-semibold text-white">Pro</h3>
                        <p class="mt-4 text-gray-400">Ideal for growing businesses and enterprises.</p>
                    </div>
                    <div class="mb-8">
                        <span class="text-5xl font-extrabold text-white">$99</span>
                        <span class="text-xl font-medium text-gray-400">/mo</span>
                    </div>
                    <ul class="mb-8 space-y-4 text-gray-400">
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Unlimited user accounts</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Unlimited transactions</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Priority support</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Advanced analytics</span>
                        </li>
                    </ul>
                    <a href="{{route('pack.profil', ['uuid' => "pro", 'slug' => "pack-pro"])}}" class="block w-full py-3 px-6 text-center rounded-md text-white font-medium bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600">
                    Get Started
                    </a>
                </div>

                <!-- Enterprise Plan -->
                <div class="bg-black/40  rounded-lg shadow-sm shadow-lime-400 p-6 transform hover:scale-105 transition duration-300">
                    <div class="mb-8">
                        <h3 class="text-2xl font-semibold text-white">Enterprise</h3>
                        <p class="mt-4 text-gray-400">Tailored for large-scale deployments and custom needs.</p>
                    </div>
                    <div class="mb-8">
                        <span class="text-5xl font-extrabold text-white">Custom</span>
                    </div>
                    <ul class="mb-8 space-y-4 text-gray-400">
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Dedicated infrastructure</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Custom integrations</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Dedicated support team</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Premium SLAs</span>
                        </li>
                    </ul>
                    <a href="{{route('pack.profil', ['uuid' => "basic", 'slug' => "pack-basic"])}}" class="block w-full py-3 px-6 text-center rounded-md text-white font-medium bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600">
                    Contact Sales
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <div class="mt-10 hidden">
        <div>
            <h5 class="card letter-spacing-1 flex bg-black/70 text-center mx-auto flex-col gap-y-2 text-gray-200">
                <p class="py-2 relative inline-block text-transparent bg-clip-text text-xl  uppercase font-bold letter-spacing-2 from-indigo-700 via-lime-500 to-blue-700 bg-linear-to-r"> 
                    <span class="">
                        BOUTIQUE: Les packs disponibles
                    </span>
                    <span class="card absolute -bottom-1 left-0 w-full from-indigo-700 via-lime-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
                </p>
            
            </h5>
        </div>
        <div class="w-full bg-transparent pt-12 p-4">
            <div class="grid gap-14 md:grid-cols-2 md:gap-5">
                
                <div data-aos-delay="150" class="rounded-xl opacity-80 card hover:opacity-100 transition-opacity duration-150 bg-blue-800/80 border border-white p-6 text-center shadow-2xl ">
                    <div class="mx-auto flex h-20 w-20 -translate-y-16 transform items-center justify-center rounded-full my-0 shadow-sm shadow-lime-400 bg-sky-500 shadow-sky-500/40">
                        <span class="fas fa-star"></span>
                        <span class="">BASIC</span>
                        <span class="fas fa-star"></span>
                    </div>
                    <h1 class="text-transparent my-0 bg-clip-text uppercase letter-spacing-2 from-indigo-700 via-lime-500 to-blue-700 bg-linear-to-r text-base font-semibold lg:px-14 "> 
                        - Pack BASIC -
                    </h1>
                    <div>
                        <ul class="flex  flex-col text-transparent my-0 bg-clip-text gap-y-2 text-left font-semibold letter-spacing-1 from-gray-300 via-sky-500 to-zinc-200 bg-linear-to-r">
                            <li>Première page à plein temps pendant toute la durée d'abonnement</li>
                            <li>Publications des statistiques limitée</li>
                            <li>Notifications par mail</li>
                            <li>Possibilité de faire des annonces (limitées)</li>
                            <li>Images (Max: 5 images) de votre école à la une</li>
                            <li>Contrôle du profil de votre école</li>
                        </ul>
                    </div>
                    <div class="my-5">
                        <h6 class="text-transparent bg-clip-text uppercase letter-spacing-2 from-orange-500 via-lime-500 to-blue-700 bg-linear-to-r text-base font-semibold lg:px-14 "> 
                            10 000 FCFA (TTC) / mois
                        </h6>
                    </div>

                    <div class="flex w-full justify-center items-center my-4">
                        <a href="{{route('pack.profil', ['uuid' => "basic", 'slug' => "pack-basic"])}}" class="cursor-pointer py-3 px-4 col-span-3 flex w-full justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-black from-purple-800 to-indigo-700 bg-linear-90 via-zinc-300 mx-auto hover:bg-gradient-to-r hover:from-indigo-500 hover:via-green-800 hover:text-white hover:to-indigo-400 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                            <span>Souscrire à ce pack</span>
                            <span class="fas fa-check"></span>
                        </a>
                    </div>
                </div>

                <div data-aos-delay="150" class="rounded-xl bg-black/60 border border-white p-6 text-center shadow-2xl opacity-80 card hover:opacity-100 transition-opacity duration-150">
                    <div class="mx-auto flex h-20 w-20 -translate-y-16 transform items-center justify-center rounded-full my-0 shadow-sm shadow-lime-400 bg-green-500 shadow-green-500/40">
                        <span class="fas fa-star"></span>
                        <span class="">PRO</span>
                        <span class="fas fa-star"></span>
                    </div>
                    <h5 class="inline-block mb-3 p-2 px-8 text-green-950 bg-green-600 text-center">
                        Recommandé
                    </h5>
                    <h1 class="text-transparent my-0 bg-clip-text uppercase letter-spacing-2 from-indigo-700 via-lime-500 to-blue-700 bg-linear-to-r text-base font-semibold lg:px-14 "> 
                        - Pack Pro -
                    </h1>
                    <div>
                        <ul class="flex  flex-col text-transparent my-0 bg-clip-text gap-y-2 text-left font-semibold letter-spacing-1 from-gray-300 via-sky-500 to-zinc-200 bg-linear-to-r">
                            <li>Première page à plein temps pendant toute la durée d'abonnement</li>
                            <li>Qui a visité ma page (Notifications)</li>
                            <li>Publications des statistiques illimitée</li>
                            <li>Notifications par SMS et par mail</li>
                            <li>Possibilité de faire des annonces (illimitées)</li>
                            <li>Images (Max: 15 images) de votre école à la une</li>
                            <li>Contrôle total et autonome du profil de votre école</li>
                        </ul>
                    </div>
                    <div class="my-4">
                        <h6 class="text-transparent bg-clip-text uppercase letter-spacing-2 from-orange-500 via-lime-500 to-blue-700 bg-linear-to-r text-base font-semibold lg:px-14 "> 
                            30 000 FCFA (TTC) / mois
                        </h6>
                    </div>

                    <div class="flex w-full justify-center items-center my-4">
                        <a href="{{route('pack.profil', ['uuid' => "pro", 'slug' => "pack-pro"])}}" class="cursor-pointer py-3 px-4 col-span-3 flex w-full justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-black from-blue-800 to-indigo-700 bg-linear-90 via-zinc-300 mx-auto hover:bg-gradient-to-r hover:from-indigo-500 hover:via-blue-800 hover:text-white hover:to-indigo-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                            <span>Souscrire à ce pack</span>
                            <span class="fas fa-check"></span>
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

