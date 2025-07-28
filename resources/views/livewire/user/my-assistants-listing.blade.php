<div class="w-full max-w-[85rem] py-3 px-4 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2">
    <div class="mt-10">
        <div>
            <h5 class="card letter-spacing-1 flex bg-black/70 text-center mx-auto flex-col gap-y-2 text-gray-200 border rounded-sm">
                <p class="py-2 relative inline-block text-transparent bg-clip-text text-xl  uppercase font-bold letter-spacing-2 from-indigo-700 via-lime-500 to-blue-700 bg-linear-to-r"> 
                    <span class="">
                        La liste de mes assistants: <span class="uppercase text-orange-500">
                            {{ __zero(count($my_assistants)) }}
                        </span>
                    </span>
                    <span class="card absolute -bottom-1 left-0 w-full from-indigo-700 via-lime-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
                </p>
            
            </h5>
        </div>
        <div class="w-full bg-transparent pt-12">
            <div class="w-full bg-black/60 shadow-2xl border border-sky-500 shadow-gray-900 flex items-center justify-center min-h-full py-5 px-5">
                <div class="container max-w-6xl">
                    <div class="overflow-hidden">
                    <!-- Table Header -->
                        <div class="relative py-2">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="text-amber-500/65 font-semibold letter-spacing-1">
                                    <h2 class="text-sm sm:text-xl font-bold uppercase text-shadow shadow-amber-400">La liste de vos assistants</h2>
                                    <p class="text-gray-400 mt-1">Vous pouvez gérer vos différents assistants. </p>
                                </div>
                                <div class="text-xs sm:text-sm mt-4 md:mt-0 flex gap-x-2 justify-end">
                                    <a href="{{$user->to_profil_route()}}" class="block text-black cursor-pointer bg-yellow-300 focus:ring-4 focus:outline-none font-medium rounded-lg px-5 py-2 text-center hover:bg-yellow-500 focus:ring-yellow-800" type="button">
                                        <span>
                                            <span class="fas fa-home mr-1"></span>
                                            Mon profil
                                        </span>
                                    </a>
                                    <button wire:click='generateAssistantTokenFor' class="block text-black cursor-pointer bg-green-400 focus:ring-4 focus:outline-none font-medium rounded-lg px-5 py-2 text-center hover:bg-green-800 focus:ring-green-800" type="button">
                                        <span wire:loading.remove wire:target='generateAssistantTokenFor'>
                                            <span class="fas fa-key mr-1"></span>
                                            Générer une clé
                                        </span>
                                        <span wire:loading wire:target='generateAssistantTokenFor'>
                                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                            <span>Un instant, en cours...</span>
                                        </span>
                                    </button>
                                    <button wire:click='openAddAssistantModal' class="block text-white cursor-pointer bg-blue-600 focus:ring-4 focus:outline-none font-medium rounded-lg px-5 py-2 text-center hover:bg-blue-800 focus:ring-blue-800" type="button">
                                        <span wire:loading.remove wire:target='openAddAssistantModal'>
                                            <span class="fas fa-user-plus mr-1"></span>
                                            Ajouter un assistant
                                        </span>
                                        <span wire:loading wire:target='openAddAssistantModal'>
                                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                            <span>Un instant, chargement...</span>
                                        </span>
                                    </button>
                                    
                                    <button class="bg-red-600 cursor-pointer hover:bg-red-800 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                                        <span class="fas fa-trash mr-1"></span>
                                        Suppr. les assistants.
                                    </button>
                                </div>
                            </div>
                            <span class="card absolute -bottom-1 left-0 w-full from-indigo-700 via-lime-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
                            
                        </div>
                        
                        <!-- Table -->
                        <div class="overflow-x-auto my-5">
                            <table class="min-w-full divide-y text-xs sm:text-sm letter-spacing-1 divide-gray-200 border">
                                <thead class="bg-black/50 text-sky-500 ">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                            Role
                                        </th>
                                        <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                            Department
                                        </th>
                                        <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y text-gray-200 divide-gray-200">
                                    <!-- Row 1 -->
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full object-cover border-sky-500 border" src="{{asset('icons/news/user-person-man.png')}}" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="">Tom Cook</div>
                                            <div class="text-sm text-gray-500">tom.cook@example.com</div>
                                        </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="">Senior Developer</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="">Engineering</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                                    </td>
                                    </tr>
                                    
                                    <!-- Row 2 -->
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full object-cover border-sky-500 border" src="{{asset('icons/news/user-person-man.png')}}" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="">Sarah Johnson</div>
                                            <div class="text-sm text-gray-500">sarah.johnson@example.com</div>
                                        </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="">Product Designer</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="">Design</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                                    </td>
                                    </tr>
                                    
                                    <!-- Row 3 -->
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full object-cover border-sky-500 border" src="{{asset('icons/news/user-person-man.png')}}" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="">Michael Roberts</div>
                                            <div class="text-sm text-gray-500">michael.roberts@example.com</div>
                                        </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="">Marketing Manager</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="">Marketing</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        On Leave
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                                    </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

