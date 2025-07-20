<div class="w-full max-w-[85rem] py-3 px-4 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2">
    <div class="mt-10">
        <div>
            <h5 class="card letter-spacing-1 flex bg-black/70 text-center mx-auto flex-col gap-y-2 text-gray-200 border rounded-sm">
                <p class="py-2 relative inline-block text-transparent bg-clip-text text-sm sm:text-lg uppercase font-bold letter-spacing-2 from-indigo-700 via-lime-500 to-blue-700 bg-linear-to-r"> 
                    <span class="uppercase ml-3">
                        Page d'administration 
                        <span class="fas fa-chevron-right text-indigo-500"></span>
                        Les assistants
                    </span>
                    <span class="card absolute -bottom-1 left-0 w-full from-indigo-700 via-lime-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
                </p>
            
            </h5>
        </div>
        <div class="flex justify-end my-2">
            <button type="button" class="collapse-toggle text-white cursor-pointer border rounded-md bg-sky-600 hover:bg-indigo-800 flex gap-x-2 py-3 px-4" data-drawer-target="drawer-admin-navigation" data-drawer-show="drawer-admin-navigation" aria-controls="drawer-admin-navigation">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span>Ouvrir le menu</span>
            </button>
        </div>
        <div class="w-full bg-transparent pt-12">
            <div class="w-full bg-black/60 shadow-2xl border border-sky-500 shadow-gray-900 flex items-center justify-center min-h-full py-5 px-5">
                <div class="container max-w-6xl">
                    <div class="overflow-hidden">
                    <!-- Table Header -->
                        <div class="relative py-2">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="text-amber-500/65 font-semibold letter-spacing-1">
                                    <h2 class="text-sm sm:text-xl font-bold uppercase text-shadow shadow-amber-400">La liste des assistants</h2>
                                </div>
                                <div class="text-xs sm:text-base mt-4 md:mt-0 flex gap-x-2 justify-end">
                                    
                                    <button class="bg-red-600 cursor-pointer hover:bg-red-800 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                                        <span class="fas fa-trash mr-1"></span>
                                        Suppr. les assistants.
                                    </button>
                                </div>
                            </div>
                            <span class="card absolute -bottom-1 left-0 w-full from-indigo-700 via-lime-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
                        </div>
                        <div class="mt-6 grid sm:grid-cols-5 gap-4">
                            <div class="relative flex-grow  sm:col-span-3">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" class="pl-10 pr-4 py-2 border border-sky-600 bg-transparent rounded-lg w-full " placeholder="Search members...">
                            </div>
                            <div class="sm:col-span-2">
                                <select class="border border-sky-500 rounded-lg px-4 py-2  w-full bg-transparent">
                                    <option value="">All Departments</option>
                                    <option value="engineering">Engineering</option>
                                    <option value="design">Design</option>
                                    <option value="marketing">Marketing</option>
                                    <option value="sales">Sales</option>
                                </select>
                            </div>
                            </div>
                        </div>
                        
                        <!-- Table -->
                        <div class="overflow-x-auto my-5">
                            <table class="min-w-full divide-y text-xs sm:text-sm letter-spacing-1 divide-gray-200 border">
                                <thead class="bg-black/50 text-sky-500 ">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
                                            Assistants
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

