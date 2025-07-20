<div class="w-full max-w-[85rem] py-3 px-4 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2" x-data="{ show: false, currentImage: '', userName: '', email: '' }">
    <div class="max-w-md card mx-auto mt-10 shadow-gray-900 bg-black/20 md:max-w-2xl">
        <h5 class="card letter-spacing-1 flex bg-black/70 text-center mx-auto flex-col gap-y-2 text-gray-200 rounded-sm">
            <p class="py-2 relative inline-block text-transparent bg-clip-text text-xl  uppercase font-bold letter-spacing-2 from-indigo-700 via-lime-500 to-blue-700 bg-linear-to-r"> 
                <span class="">
                    Profil de : <span class="uppercase text-orange-500"> {{$uuid}} </span>
                </span>
                <span class="card absolute -bottom-1 left-0 w-full from-indigo-700 via-lime-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
            </p>
        
        </h5>
    </div>
    <div class="max-w-md mx-auto mt-10 shadow-gray-900 border border-sky-400 bg-black/70 rounded-xl shadow-2xl overflow-hidden md:max-w-2xl">
        <div class="p-6 card">
            <div class="flex items-center space-x-4">
            <div class="flex-shrink-0" @click="currentImage = '{{ user_profil_photo() }}'; userName = '{{ $user_name }}'; email = '{{ $user_email }}'; show = true">
                <img class="h-16 w-16 rounded-full object-cover border-2 border-indigo-500" src="{{user_profil_photo()}}" alt="Profile picture">
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-lg font-bold text-sky-500 truncate">Sarah Johnson</p>
                <p class="text-sm text-gray-400 truncate">Photographer & Traveler</p>
                <div class="flex space-x-4 mt-2">
                <span class="text-sm font-medium text-gray-400">542 <span class="font-normal text-gray-400">posts</span></span>
                <span class="text-sm font-medium text-gray-400">12.8k <span class="font-normal text-gray-400">followers</span></span>
                <span class="text-sm font-medium text-gray-400">328 <span class="font-normal text-gray-400">following</span></span>
                </div>
            </div>
            </div>
            <div class="mt-4">
            <p class="text-indigo-500">Capturing moments around the world 🌍 | Based in NYC | Prints available</p>
            </div>
            
        </div>
    
        <!-- Menu -->
        <div class="px-6 pb-4 overflow-x-auto card">
            <div class="text-xs sm:text-sm mt-4 md:mt-0 flex gap-x-2 justify-center">
                <a href="{{route('user.profil', ['uuid' => "uudeuueueu"])}}" class="block text-black cursor-pointer bg-yellow-300 focus:ring-4 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-yellow-500 focus:ring-yellow-800" type="button">
                    <span>
                        <span class="fas fa-home mr-1"></span>
                        Mon profil
                    </span>
                </a>
                <a href="{{route('school.profil', ['uuid' => "uudeuueueu", 'slug' => "ECOLE-AER"])}}" class="block text-white cursor-pointer bg-purple-700 focus:ring-4 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-purple-900 focus:ring-purple-800" type="button">
                    <span>
                        <span class="fas fa-school mr-1"></span>
                        Mon école
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
                
                <button class="bg-red-600 cursor-pointer hover:bg-red-800 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                    <span class="fas fa-trash mr-1"></span>
                    Suppr. les assistants.
                </button>
                <button class="bg-green-600 cursor-pointer hover:bg-green-800 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                    <span class="fas fa-message mr-1"></span>
                    Message
                </button>
            </div>
        </div>
        <!-- end Menu -->
    
        <!-- Posts Grid -->
        <div class="grid grid-cols-3 gap-1 card">
            <div class="aspect-square bg-gray-100 relative group">
                <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1652057014611-3cded0a00d20?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Post">
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200">
                    <div class="flex space-x-4 text-white">
                        <span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" /></svg> 245</span>
                        <span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" /></svg> 31</span>
                    </div>
                </div>
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
            <span class=" text-sky-500 uppercase" x-text="userName"></span>
            <span class=" text-yellow-500" x-text="email"></span>
        </h5>
        <img :src="currentImage" alt="Zoom" class="w-screen md:max-w-xl max-h-[90vh] rounded shadow-xl border-2 border-white" @click.stop>
        
    </div>
</div>
