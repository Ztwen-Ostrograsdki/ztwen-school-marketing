<div class="w-full max-w-3xl py-3 px-4 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2" >
    
    <div class="mt-10 flex justify-center flex-col items-center">
        <div class="w-full">
            <h6 class="text-center py-2 letter-spacing-1 font-bold text-xl uppercase text-black my-2">
                Gestion des meilleurs apprenants et candidats
                <span class="font-semibold letter-spacing-1 ml-2 text-yellow-500">

                </span>
            </h6>
        </div>
        @if($school)
            <div class="w-full">
                <!-- Modal content -->
                <div class=" bg-black/80 border border-sky-500 rounded-lg shadow-2xl">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                        <div class="text-sm sm:text-lg font-semibold text-lime-500 letter-spacing-1">
                            @if($school_best_pupil)
                                <div class="col-span-2">
                                    <div class="border border-purple-500">
                                        <div class="aspect-square bg-gray-100 relative group card">
                                            <img class="w-full h-full object-cover border shadow-sm" src="{{url('storage', $school_best_pupil->image_path)}}" alt="Image du meilleur {{$school_best_pupil->exam}} de l'école">
                                            <div  class="absolute top-2 left-1 items-center cursor-pointer bg-black/90 text-white inline-flex p-3 text-center  justify-center bg-opacity-70 opacity-80 group-hover:text-amber-500 transition-all duration-200">
                                                <div class="flex space-x-4 cursor-pointer text-center letter-spacing-2 text-xs">
                                                    <span class="text-center"> {{ $school_best_pupil->pupil_name }} </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <span class="text-lime-600">
                                {{ $school->name }}
                            </span>
                        </div>
                    </div>
                    <form wire:submit.prevent="save" class="p-4 md:p-5">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="pupil_name" class="block mb-2 text-sm text-amber-400 font-medium ">Nom et prénoms de l'apprenant ou candidat</label>
                                <input wire:model.blur='pupil_name' type="text" name="pupil_name" id="pupil_name" class="bg-transparent border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5   dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner Le nom et prénoms de l'apprenant ou du candidat" >
                                @error('pupil_name') 
                                    <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                                        {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <div class="col-span-2 grid gap-4 mb-4 grid-cols-4 border border-gray-500 rounded-md p-2">
                                <div class="col-span-2">
                                    <label for="exam" class="block mb-2 text-sm text-amber-400 font-medium ">Examen</label>
                                    <input wire:model.blur='exam' type="text" name="exam" id="exam" class="bg-transparent border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5   dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="BAC C 2023" >
                                    @error('exam') 
                                        <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                                            {{ $message }}
                                        </span> 
                                    @enderror
                                </div>
                                <div class="col-span-2">
                                    <label for="mention" class="block mb-2 text-sm text-amber-400 font-medium ">La mention obtenue</label>
                                    <input wire:model.blur='mention' type="text" name="mention" id="mention" class="bg-transparent border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5   dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Très bien" >
                                    @error('mention') 
                                        <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                                            {{ $message }}
                                        </span> 
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-2">
                                <div class="flex items-center justify-center w-full">
                                {{-- Upload zone --}}
                                    @if(!$image)
                                    <div class="flex items-center justify-center w-full">
                                        <label for="image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed rounded-lg cursor-pointer  bg-transparent dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600 @error('image') shadow-red-500 shadow-sm @enderror">
                                            @if(!$image)
                                                <div wire:loading.remove wire:target='image' class="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <svg class="w-8 h-8 mb-4 text-gray-500" ...></svg>
                                                    <p class="mb-2 text-sm text-gray-500 text-center"><span class="font-semibold">Sélectionner l'image de l'apprenant</span> ou glisser-déposer</p>
                                                    <p class="text-xs text-gray-500 text-center">SVG, PNG, JPG ou GIF</p>
                                                </div>
                                            @endif
                                            <input wire:model.live="image" name="image" id="image" type="file" class="hidden" />
                                        </label>
                                    </div>
                                    @endif

                                    {{-- Thumbnails preview --}}
                                    @if($image)
                                        <div class="w-full flex flex-col gap-2 justify-between items-center">
                                            <div class="w-full grid grid-cols-1">
                                                <div class="group relative border rounded overflow-hidden" style="z-index: 2000 !important;" x-data="{ show: false }"
                                                    x-init="setTimeout(() => show = true, {{ 100 }})"
                                                    x-show="show"
                                                    x-transition:enter="transition ease-out duration-500"
                                                    x-transition:enter-start="opacity-0 scale-90"
                                                    x-transition:enter-end="opacity-100 scale-100">
                                                    <img src="{{ $image->temporaryUrl() }}" class="object-cover w-full h-60" alt="Preview">
                                                    <span wire:click="removeImage"
                                                        class="absolute inset-0 bg-red-600 bg-opacity-80 text-white text-xs font-semibold opacity-0 group-hover:opacity-70 transition duration-300 flex items-center justify-center cursor-pointer">
                                                        ✖ Supprimer et choisir une autre image
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div> 

                                <div class="bg-transparent w-full p-2 text-center py-6 my-2" wire:loading wire:target='image'>
                                    <span class=" text-yellow-400 text-center text-base letter-spacing-2">
                                    <span class="fas fa-rotate animate-spin"></span>
                                    Chargement de l'image en cours... Veuillez patientez!
                                    </span>
                                </div>

                                @error('image') 
                                    <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                                        {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <div class="col-span-2 grid gap-4 mb-4 grid-cols-4 border border-amber-500 rounded-md p-2">
                                <h6 class="col-span-4 border-b border-b-gray-500 text-gray-500 font-semibold letter-spacing-1 flex justify-between items-center py-1">
                                    <span>
                                        Ajouter des détails sur les notes obtenues
                                    </span>

                                    @if(count($details_table) > 0)
                                    <span wire:click="refreshDetails"  class="text-black cursor-pointer flex justify-center items-center rounded-lg text-sm px-2 py-2 text-center bg-red-400 hover:bg-red-700  letter-spacing-1 border border-red-600">
                                        <span wire:loading.remove wire:target='refreshDetails'>
                                            <span class="fas fa-trash mr-1.5"></span>
                                            Nettoyer
                                        </span>
                                        <span class="" wire:loading wire:target='refreshDetails'>
                                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                            <span>En cours...</span>
                                        </span>
                                    </span>
                                    @endif
                                </h6>
                                <div class="col-span-2">
                                    <label for="subject" class="block mb-2 text-sm text-amber-400 font-medium ">La matière</label>
                                    <input wire:model.blur='subject' type="text" name="subject" id="subject" class="bg-transparent border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5   dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner la matière" >
                                    @error('subject') 
                                        <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                                            {{ $message }}
                                        </span> 
                                    @enderror
                                </div>
                                <div class="col-span-2">
                                    <label for="mark" class="block mb-2 text-sm text-amber-400 font-medium ">La note obtenue</label>
                                    <input wire:model.blur='mark' type="number" min="5" max="20" name="mark" id="mark" class="bg-transparent border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5   dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner la note obtenue" >
                                    @error('mark') 
                                        <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                                            {{ $message }}
                                        </span> 
                                    @enderror
                                </div>


                                @if(count($details_table) > 0)
                                <div class="overflow-x-auto my-5 col-span-4">
                                    <table class="min-w-full divide-y text-xs sm:text-sm letter-spacing-1 divide-gray-200 border">
                                        <thead class="bg-black/50 text-sky-500 ">
                                            <tr>
                                                <th scope="col" class="px-2 py-1 uppercase tracking-wider text-left">
                                                    N°
                                                </th>
                                                <th scope="col" class="px-2 py-1 uppercase tracking-wider">
                                                    Matière
                                                </th>
                                                <th scope="col" class="px-2 py-1 uppercase tracking-wider">
                                                    Note
                                                </th>
                                                <th scope="col" class="px-2 py-1 uppercase tracking-wider">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y text-gray-200 divide-gray-200">
                                            @foreach($details_table as $sub => $mk)
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="px-2 py-1 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        {{ $loop->iteration }}
                                                    </div>
                                                </td>
                                                <td class="px-2 py-1 whitespace-nowrap">
                                                    <div class="">
                                                        {{ $sub }}
                                                    </div>
                                                </td>
                                                <td class="px-2 py-1 whitespace-nowrap">
                                                    <div class="">
                                                        {{ $mk }}
                                                    </div>
                                                </td>
                                                <td class="px-2 py-1 whitespace-nowrap">
                                                    <div class="">
                                                        <span wire:click="removeDetailFrom('{{$sub}}')"  class="text-black cursor-pointer flex justify-center items-center rounded-lg text-sm px-2 py-2 text-center bg-red-400 hover:bg-red-700  letter-spacing-1 border border-red-600">
                                                            <span wire:loading.remove wire:target="removeDetailFrom('{{$sub}}')">
                                                                <span class="fas fa-trash mr-1.5"></span>
                                                            </span>
                                                            <span class="" wire:loading wire:target="removeDetailFrom('{{$sub}}')">
                                                                <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                                <span>En cours...</span>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif



                                @if($subject && $mark)
                                <div class="col-span-4">
                                    <span wire:click="pushIntoDetails"  class="text-black cursor-pointer flex w-full mx-auto justify-center items-center rounded-lg text-sm px-5 py-2.5 text-center bg-amber-300 hover:bg-amber-700  letter-spacing-1 border border-amber-600">
                                        <span wire:loading.remove wire:target='pushIntoDetails'>
                                            <span class="fas fa-plus mr-1.5"></span>
                                            Ajouter cette donnée
                                        </span>
                                        <span class="" wire:loading wire:target='pushIntoDetails'>
                                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                            <span>Ajout en cours...</span>
                                        </span>
                                    </span>
                                </div>
                                @endif

                            </div>


                            <div class="col-span-2 grid gap-4 mb-4 grid-cols-4 border border-indigo-500 rounded-md p-2">
                                <h6 class="col-span-4 border-b border-b-gray-500 text-gray-500 font-semibold letter-spacing-1 flex justify-between items-center py-1">
                                    <span>
                                        Ajouter des records de rangs
                                    </span>

                                    @if(count($ranks_table) > 0)
                                    <span wire:click="refreshRanks"  class="text-black cursor-pointer flex justify-center items-center rounded-lg text-sm px-2 py-2 text-center bg-red-400 hover:bg-red-700  letter-spacing-1 border border-red-600">
                                        <span wire:loading.remove wire:target='refreshRanks'>
                                            <span class="fas fa-trash mr-1.5"></span>
                                            Nettoyer
                                        </span>
                                        <span class="" wire:loading wire:target='refreshRanks'>
                                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                            <span>En cours...</span>
                                        </span>
                                    </span>
                                    @endif
                                </h6>
                                <div class="col-span-4">
                                    <label for="rank" class="block mb-2 text-sm text-amber-400 font-medium ">Le rang</label>
                                    <input wire:model.blur='rank' type="text" name="rank" id="rank" class="bg-transparent border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5   dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner Le rang .... Ex :  Premier BAC D ATLANTIQUE" >
                                    @error('rank') 
                                        <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                                            {{ $message }}
                                        </span> 
                                    @enderror
                                </div>

                                @if(count($ranks_table) > 0)
                                <div class="overflow-x-auto my-5 col-span-4">
                                    <table class="min-w-full divide-y text-xs sm:text-sm letter-spacing-1 divide-gray-200 border">
                                        <thead class="bg-black/50 text-sky-500 ">
                                            <tr>
                                                <th scope="col" class="px-2 py-1 uppercase tracking-wider text-left">
                                                    N°
                                                </th>
                                                <th scope="col" class="px-2 py-1 uppercase tracking-wider">
                                                    Rang
                                                </th>
                                                <th scope="col" class="px-2 py-1 uppercase tracking-wider">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y text-gray-200 divide-gray-200">
                                            @foreach($ranks_table as $rk)
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="px-2 py-1 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        {{ $loop->iteration }}
                                                    </div>
                                                </td>
                                                <td class="px-2 py-1 whitespace-nowrap">
                                                    <div class="">
                                                        {{ $rk }}
                                                    </div>
                                                </td>
                                                <td class="px-2 py-1 whitespace-nowrap">
                                                    <div class="">
                                                        <span wire:click="removeRankFrom('{{$rk}}')"  class="text-black cursor-pointer flex justify-center items-center rounded-lg text-sm px-2 py-2 text-center bg-red-400 hover:bg-red-700  letter-spacing-1 border border-red-600">
                                                            <span wire:loading.remove wire:target="removeRankFrom('{{$rk}}')">
                                                                <span class="fas fa-trash mr-1.5"></span>
                                                            </span>
                                                            <span class="" wire:loading wire:target="removeRankFrom('{{$rk}}')">
                                                                <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                                <span>En cours...</span>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif

                                @if($rank)
                                <div class="col-span-4">
                                    <span wire:click="pushIntoRanks"  class="text-black cursor-pointer flex w-full mx-auto justify-center items-center rounded-lg text-sm px-5 py-2.5 text-center bg-indigo-400 hover:bg-indigo-700  letter-spacing-1 border border-indigo-600">
                                        <span wire:loading.remove wire:target='pushIntoRanks'>
                                            <span class="fas fa-plus mr-1.5"></span>
                                            Ajouter cette donnée
                                        </span>
                                        <span class="" wire:loading wire:target='pushIntoRanks'>
                                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                            <span>Ajout en cours...</span>
                                        </span>
                                    </span>
                                </div>
                                @endif
                            </div>

                        </div>
                        @if($pupil_name && $exam)
                        <span wire:click.prevent="save"  class="text-black cursor-pointer flex w-full mx-auto justify-center items-center focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-sky-500 hover:bg-sky-700 focus:ring-blue-800 letter-spacing-1 border border-sky-600">
                            <span wire:loading.remove wire:target='save'>
                                <span class="fas fa-save mr-1.5"></span>
                                Enregistrer
                            </span>
                            <span class="" wire:loading wire:target='save'>
                                <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                <span>Enregistrement en cours...</span>
                            </span>
                        </span>
                        @endif
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
