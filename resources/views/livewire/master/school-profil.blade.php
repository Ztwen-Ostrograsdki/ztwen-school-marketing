<div class="w-full max-w-[85rem] py-3 px-4 mx-auto my-2" x-data="{ show: false, currentImage: '', schoolName: '', simple_name: '' }">
        
    <div class="card mx-auto mt-10 shadow-gray-900 bg-black/20">
        <h5 class="card letter-spacing-1 flex bg-black/70 text-center mx-auto flex-col gap-y-2 text-gray-200 rounded-sm">
            <p class="py-2 relative inline-block text-transparent bg-clip-text text-xl font-bold letter-spacing-2 from-indigo-700 via-lime-500 to-blue-700 bg-linear-to-r"> 
                <span class="card absolute -top-1 left-0 w-full to-lime-400 via-amber-500 from-sky-900 bg-linear-to-r h-1 rounded-full"></span>
                <span class="uppercase px-3">
                    Bienvenue sur la page de l'école <span class="uppercase text-orange-500"> {{$uuid}} </span>
                </span>
                <span class="block text-sm my-2 px-3">
                    Nous vous garantissons de faire de vos enfants, des personnes touts batis, des ronommées aux compétences incommensurables...
                </span>
                <span class="card absolute -bottom-1 left-0 w-full from-lime-400 via-amber-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
            </p>
        
        </h5>
    </div>
    <div class="mx-auto pb-10 mt-6 bg-transparent flex flex-col gap-y-20  overflow-hidden">
        <div class="p-6 card bg-black/60">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0" @click="currentImage = '{{ school_images()[0] }}'; schoolName = '{{ $school_name }}'; simple_name = '{{ $simple_name }}'; show = true">
                    <img class="h-16 w-16 rounded-full object-cover border-2 border-indigo-500" src="{{school_images()[0]}}" alt="Profile picture">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-lg font-bold text-sky-500 truncate">Sarah Johnson</p>
                    <p class="text-sm text-gray-400 truncate">Photographer & Traveler</p>
                    <div class="flex space-x-4 mt-2">
                        <span class="text-sm font-medium text-gray-400">542 <span class="font-normal text-gray-400">posts</span></span>
                        <span class="text-sm font-medium text-gray-400">12.8k <span class="font-normal text-gray-400">followers</span></span>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-indigo-500">Capturing moments around the world 🌍 | Based in NYC | Prints available</p>
            </div>
            <div class="px-6 mt-6 overflow-x-auto card">
                <div class="text-xs sm:text-sm mt-4 md:mt-0 flex flex-wrap gap-3 justify-start ">
                    <a href="{{route('user.profil', ['id' => 3, 'uuid' => "uudeuueueu"])}}" class="block text-black cursor-pointer bg-yellow-300 focus:ring-4 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-yellow-500 focus:ring-yellow-800" type="button">
                        <span>
                            <span class="fas fa-home mr-1"></span>
                            Mon profil
                        </span>
                    </a>
                    <a href="#" class="block text-white cursor-pointer bg-purple-700 focus:ring-4 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-purple-900 focus:ring-purple-800" type="button">
                        <span>
                            <span class="fas fa-newspaper mr-1"></span>
                            Communiqué
                        </span>
                    </a>
                    <button wire:click='openAddAssistantModal' class="block text-white cursor-pointer bg-blue-600 focus:ring-4 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-blue-800 focus:ring-blue-800" type="button">
                        <span wire:loading.remove wire:target='openAddAssistantModal'>
                            <span class="fas fa-user-plus mr-1"></span>
                            Ajouter un assistant
                        </span>
                        <span wire:loading wire:target='openAddAssistantModal'>
                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                            <span>Un instant, chargement...</span>
                        </span>
                    </button>
                    <button title="Enregistrer une statistique" wire:click="manageSchoolStat" class="cursor-pointer shadow-sm bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                        <span wire:loading.remove wire:target="manageSchoolStat">
                            <span class="fas fa-chart-simple"></span>
                            <span>Ajouter</span>
                        </span>
                        <span wire:loading wire:target="manageSchoolStat">
                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                            <span>En cours...</span>
                        </span>
                    </button>
                    
                    <button title="Enregistrer une info, un offre..." wire:click="manageSchoolInfo" class="cursor-pointer shadow-sm bg-gray-500 hover:bg-gray-700 text-black font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                        <span wire:loading.remove wire:target="manageSchoolInfo">
                            <span class="fas fa-newspaper"></span>
                            <span>Ajouter</span>
                        </span>
                        <span wire:loading wire:target="manageSchoolInfo">
                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                            <span>En cours...</span>
                        </span>
                    </button>
                    
                    <button class="bg-red-600 cursor-pointer hover:bg-red-800 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                        <span class="fas fa-trash mr-1"></span>
                        Suppr. les assistants.
                    </button>
                    <button class="bg-green-600 cursor-pointer hover:bg-green-800 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                        <span class="fas fa-message mr-1"></span>
                        Message
                    </button>
                    <button class="bg-rose-400 cursor-pointer hover:bg-rose-700 text-black font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                        <span class="fas fa-thumbs-up mr-1"></span>
                        Suivre | Aimer
                    </button>
                </div>
            </div>
        </div>

        <div class="p-6 card text-sm shadow-xl bg-black/60 shadow-gray-900 rounded-lg">
            <div class="px-6 mt-2 overflow-x-auto card">
                <h5 class="text-sky-400 text-sm sm:text-xl  font-semibold letter-spacing-1 pb-4"># Contenu de la page</h5>
                <div class="text-xs sm:text-sm mt-4 md:mt-0 flex flex-wrap gap-3 justify-start ">
                    <a href="#school_images" class="block text-black cursor-pointer bg-yellow-300 focus:ring-4 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-yellow-500 focus:ring-yellow-800" type="button">
                        <span>
                            <span class="fas fa-images mr-1"></span>
                            #L'école en images
                        </span>
                    </a>
                    <a href="#school_stats" class="block text-black cursor-pointer bg-amber-500 focus:ring-4 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-amber-700 focus:ring-amber-800" type="button">
                        <span>
                            <span class="fas fa-chart-simple mr-1"></span>
                            # Les statistiques
                        </span>
                    </a>
                    <a href="#school_infos" class="block text-black cursor-pointer bg-orange-400 focus:ring-4 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-orange-500 focus:ring-orange-800" type="button">
                        <span>
                            <span class="fas fa-newspaper mr-1"></span>
                            # Communiqués
                        </span>
                    </a>
                    <a href="#school_offers" class="block text-black cursor-pointer bg-orange-500 focus:ring-4 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-orange-700 focus:ring-orange-800" type="button">
                        <span>
                            <span class="fab fa-leanpub mr-1"></span>
                            # Annonces
                        </span>
                    </a>
                    
                </div>
            </div>
        </div>
    
        <!-- Posts Grid -->
        <div id="school_images" class="text-sm p-6 shadow-xl bg-black/60 shadow-gray-900 rounded-lg">
            <h5 class="text-sky-400 text-sm sm:text-xl font-semibold letter-spacing-1 pb-4"># L'école en images</h5>
            <div class="grid grid-cols-3 my-4 gap-1 card">
                @foreach (school_images() as $school_image)
                    <div class="aspect-square bg-gray-100 relative group card">
                        <img class="w-full h-full object-cover border shadow-sm" src="{{$school_image}}" alt="Image N° {{$loop->iteration}} de l'école">
                        <div  @click="currentImage = '{{ $school_image }}'; schoolName = 'image N° {{$loop->iteration}} de {{ $school_name }}'; simple_name = '{{ $simple_name }}'; show = true" class="absolute cursor-pointer inset-0 bg-black/75 bg-opacity-0 group-hover:bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200">
                            <div class="flex space-x-4 cursor-pointer text-sky-600 text-center letter-spacing-1 font-semibold text-xs">
                                <span class="text-center">Cliquer pour agrandir cette image</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div id="school_stats" class="text-sm p-6 shadow-xl bg-black/60 shadow-gray-900 rounded-lg">
            <h5 class="card text-sky-400 text-sm sm:text-xl  font-semibold letter-spacing-1 pb-4">
                # Les statistiques de l'école aux examens
            </h5>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 card my-4">
                @for ($i = 1; $i < 4; $i++)
                    <div class="aspect-square shadow-inner shadow-sky-100 from-green-800 to-blue-900 via-sky-900 bg-linear-180 bg-black rounded-lg relative group card p-3 flex items-center justify-center flex-col font-bold letter-spacing-1 cursor-pointer hover:shadow-md hover:shadow-sky-400 gap-y-2 md:gap-y-5 ">
                        <div>
                            <h4 class="text-center text-lg md:text-3xl animate-pulse">
                                BEPC 2025
                            </h4>
                            <h3 class="text-xl md:text-8xl text-center text-transparent bg-clip-text from-blue-300 via-yellow-400 to-gray-500 bg-linear-to-bl">
                                <span class="fas"> 98 </span>
                                <span class="fas fa-percent"></span>
                            </h3>
                        </div>
                        <div class="my-3 flex justify-end gap-x-2">
                            <button wire:click="manageSchoolStat({{$i}})" class="cursor-pointer shadow-sm bg-blue-500 hover:bg-blue-700 text-white p-2">
                                <span wire:loading.remove wire:target="manageSchoolStat({{$i}})">
                                    <span class="fas fa-edit"></span>
                                    <span>Modifier</span>
                                </span>
                                <span wire:loading wire:target="manageSchoolStat({{$i}})">
                                    <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                    <span>En cours...</span>
                                </span>
                            </button>
                            <button class="cursor-pointer shadow-sm bg-amber-500 hover:bg-amber-700 text-white p-2">
                                <span class="fas fa-eye-slash"></span>
                                <span>Masquer</span>
                            </button>
                            <button class="cursor-pointer shadow-sm bg-red-500 hover:bg-red-700 text-white p-2">
                                <span class="fas fa-trash"></span>
                                <span>Supprimer</span>
                            </button>
                        </div>
                    </div>
                    
                @endfor
            </div>
        </div>


        <div id="school_infos" class="text-sm p-6 shadow-xl bg-black/60 shadow-gray-900 rounded-lg">
            <h5 class="card text-sky-400 text-sm sm:text-xl  font-semibold letter-spacing-1 pb-4">
                # Les Infos et Communiqués
            </h5>
            <div class="flex flex-wrap gap-y-7 card my-4">
                @for ($i = 1; $i < 4; $i++)
                    <div class="border border-r-gray-500 bg-black/60 p-3 letter-spacing-1 rounded-xl shadow-inner shadow-sky-400">
                        <h4 class="text-start text-purple-400 font-bold uppercase">
                            # Annonce | Info N° {{$i}}
                        </h4>
                        <div class="text-gray-300 text-base md:text-lg">
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quisquam omnis blanditiis dolor, corrupti accusantium id perspiciatis alias labore molestias esse quos, mollitia molestiae placeat. Magnam cum nobis maiores necessitatibus amet.
                        </div>
                        <div class="my-3 flex justify-end gap-x-2">
                            <button wire:click="manageSchoolInfo({{$i}})" class="cursor-pointer shadow-sm bg-blue-500 hover:bg-blue-700 text-white p-2">
                                <span wire:loading.remove wire:target="manageSchoolInfo({{$i}})">
                                    <span class="fas fa-newspaper"></span>
                                    <span>Modifier</span>
                                </span>
                                <span wire:loading wire:target="manageSchoolInfo({{$i}})">
                                    <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                    <span>En cours...</span>
                                </span>
                            </button>
                            <button class="cursor-pointer shadow-sm bg-amber-500 hover:bg-amber-700 text-white p-2">
                                <span class="fas fa-eye-slash"></span>
                                <span>Masquer</span>
                            </button>
                            <button class="cursor-pointer shadow-sm bg-red-500 hover:bg-red-700 text-white p-2">
                                <span class="fas fa-trash"></span>
                                <span>Supprimer</span>
                            </button>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <div id="school_offers" class="text-sm p-6 shadow-xl bg-black/60 shadow-gray-900 rounded-lg">
            <h5 class="card text-sky-400 text-sm sm:text-xl  font-semibold letter-spacing-1 pb-4">
                # Les Offres
            </h5>
            <div class="flex flex-wrap gap-y-7 card my-4">
                @for ($i = 1; $i < 4; $i++)
                    <div class="border border-r-gray-500 bg-black/60 p-3 letter-spacing-1 rounded-xl shadow-inner shadow-emerald-400">
                        <h4 class="text-start text-purple-400 font-bold uppercase">
                            # Offre N° {{$i}}
                        </h4>
                        <div class="text-gray-300 text-base md:text-lg">
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quisquam omnis blanditiis dolor, corrupti accusantium id perspiciatis alias labore molestias esse quos, mollitia molestiae placeat. Magnam cum nobis maiores necessitatibus amet.
                        </div>
                        <div class="my-3 flex justify-end gap-x-2">
                            <button wire:click="manageSchoolInfo({{$i}})" class="cursor-pointer shadow-sm bg-blue-500 hover:bg-blue-700 text-white p-2">
                                <span wire:loading.remove wire:target="manageSchoolInfo({{$i}})">
                                    <span class="fas fa-newspaper"></span>
                                    <span>Modifier</span>
                                </span>
                                <span wire:loading wire:target="manageSchoolInfo({{$i}})">
                                    <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                    <span>En cours...</span>
                                </span>
                            </button>
                            <button class="cursor-pointer shadow-sm bg-amber-500 hover:bg-amber-700 text-white p-2">
                                <span class="fas fa-eye-slash"></span>
                                <span>Masquer</span>
                            </button>
                            <button class="cursor-pointer shadow-sm bg-red-500 hover:bg-red-700 text-white p-2">
                                <span class="fas fa-trash"></span>
                                <span>Supprimer</span>
                            </button>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
    <div 
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-75"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-75"
        class="fixed inset-0 bg-black/85 flex flex-col items-center justify-center z-50"
        style="display: none;"
        @click="show = false"
    >
        <h5 class="mx-auto flex flex-col gap-y-1 text-lg w-auto text-center py-3 font-semibold letter-spacing-1 bg-gray-950 my-3" >
            <span class=" text-sky-500 uppercase" x-text="schoolName"></span>
            <span class=" text-yellow-500" x-text="simple_name"></span>
        </h5>
        <img :src="currentImage" alt="Zoom" class="w-screen md:max-w-xl max-h-[90vh] rounded shadow-xl border-2 border-white" @click.stop>
        
    </div>
</div>
