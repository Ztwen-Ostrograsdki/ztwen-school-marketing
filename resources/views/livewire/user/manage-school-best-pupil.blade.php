<div class="w-full max-w-6xl py-3 px-4 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2" >
    
    <div class="mt-10 flex justify-center flex-col items-center">
        <div class="w-full bg-black/80 rounded-lg border-amber-600 border-2 shadow-lg shadow-gray-600 mb-11">
            <h6 class="text-center py-2 letter-spacing-1 font-bold text-xl uppercase text-amber-600 my-2">
                Gestion des meilleurs apprenants et candidats
                <span class="font-semibold letter-spacing-1 ml-2 text-yellow-500">

                </span>
            </h6>
        </div>
        @if($school)
            <div class="w-full">
                @if($done)
                <div class="">
                    <div class="bg-green-400 shadow-lg pb-4 rounded-4xl flex flex-col justify-center">
                        <h4 class="text-center uppercase p-5 font-bold mb-4 text-black text-xl">Mise à jour réussie!</h4>
                        <h6 class="text-lg font-semibold letter-spacing-1 text-center text-green-900 p-2 pb-6">
                            L'apprenant(e) <span class="underline underline-offset-4 text-black">{{ $pupil_name }}</span> a été ajouté(e) à la liste des meilleurs élèves avec succès!
                        </h6>
                        <div class="my-4 w-1/3 justify-center mx-auto">
                            <span wire:click="undone"  class="text-gray-400 cursor-pointer flex justify-center items-center rounded-lg px-2 py-5 text-center bg-green-900 hover:bg-green-700  letter-spacing-1">
                                <span wire:loading.remove wire:target='undone'>
                                    <span class="fas fa-check mr-1.5"></span>
                                    Terminé
                                </span>
                                <span class="" wire:loading wire:target='undone'>
                                    <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                    <span>En cours...</span>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                @else
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
                            <span class="text-gray-400">
                                {{ $school->name }}
                            </span>
                        </div>
                    </div>
                    <form wire:submit.prevent="save" class="p-4 md:p-5">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2 items-center grid grid-cols-4 gap-1.5">
                                <label for="image">
                                    <div wire:loading.remove wire:target='image' class="col-span-1 flex items-center justify-center flex-col">
                                        @if ($image)
                                            <img class="h-20 w-20 md:h-32 md:w-32 rounded-full object-cover border-2 border-amber-500 cursor-pointer" src="{{ $image->temporaryUrl() }}" alt="Photo de l'apprenant ou du candidat">

                                            <span wire:click="removeImage"  class="text-black cursor-pointer flex w-full mx-auto justify-center items-center rounded-lg text-xs px-5 py-2 text-center bg-red-400 hover:bg-red-600 mt-1.5 letter-spacing-1 border border-gray-900">
                                                <span wire:loading.remove wire:target='removeImage'>
                                                    <span class="fas fa-trash mr-1.5"></span>
                                                    Suppr. Image
                                                </span>
                                                <span class="" wire:loading wire:target='removeImage'>
                                                    <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                    <span>Suppression en cours...</span>
                                                </span>
                                            </span>
                                        @else
                                            <div class="flex flex-col gap-y-1 items-center justify-center cursor-pointer hover:opacity-70">
                                                <img class="h-20 w-20 md:h-32 md:w-32 rounded-full object-cover border-2 border-amber-500 cursor-pointer" src="{{ asset('icons/news/user-person-man.png') }}" alt="Photo de l'apprenant ou du candidat">
                                                <span class="text-amber-500 font-semibold text-xs letter-spacing-1 text-center">
                                                    Cliquer pour ajouter une photo de l'apprenant!
                                                </span>
                                            </div>
                                        @endif

                                    </div>
                                    <span class="rounded-full border-2 p-3 border-amber-500 cursor-pointer flex text-amber-500 items-center text-center text-xs" wire:loading wire:target='image'>
                                        <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                        <span>Chargement en cours...</span>
                                    </span>
                                    <input wire:model.live="image" name="image" id="image" type="file" class="hidden" />
                                </label>
                                
                                <div class="col-span-3">
                                    <label for="pupil_name" class="block mb-2 text-sm text-amber-400 font-medium ">Nom et prénoms de l'apprenant ou candidat</label>
                                    <input wire:model.blur='pupil_name' type="text" name="pupil_name" id="pupil_name" class="bg-transparent border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5   dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner Le nom et prénoms de l'apprenant ou du candidat" >
                                    @error('pupil_name') 
                                        <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                                            {{ $message }}
                                        </span> 
                                    @enderror
                                    </div>
                            </div>

                            <div class="col-span-2 grid gap-4 mb-4 grid-cols-6 border border-gray-500 rounded-md p-2">
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
                                    <select wire:model.live='mention' id="mention" class="border border-sky-400 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400 text-gray-400 dark:focus:ring-primary-500 dark:focus:border-primary-500 bg-transparent">
                                        <option class="text-sm text-white py-1.5 bg-black" >Selectionner la mention</option>
                                        @foreach ($mentions as $k => $m)
                                            <option class="text-white py-1.5 bg-black px-2.5" value="{{$m}}">{{ $m }}</option>
                                        @endforeach
                                    </select>
                                    
                                    @error('mention') 
                                        <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                                            {{ $message }}
                                        </span> 
                                    @enderror
                                </div>
                                <div class="col-span-2">
                                    <label for="average" class="block mb-2 text-sm text-amber-400 font-medium ">Moyenne obtenue</label>
                                    <input wire:model.blur='average' type="text" name="average" id="average" class="bg-transparent border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5   dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="19" >
                                    @error('average') 
                                        <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                                            {{ $message }}
                                        </span> 
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-span-2 grid gap-4 mb-4 grid-cols-4 border border-gray-600 rounded-md p-2">
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
                                    <input wire:model.live='subject' type="text" name="subject" id="subject" class="bg-transparent border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5   dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner la matière" >
                                    @error('subject') 
                                        <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                                            {{ $message }}
                                        </span> 
                                    @enderror
                                </div>
                                <div class="col-span-2">
                                    <label for="mark" class="block mb-2 text-sm text-amber-400 font-medium ">La note obtenue</label>
                                    <input wire:model.live='mark' type="number" min="5" max="20" name="mark" id="mark" class="bg-transparent border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5   dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner la note obtenue" >
                                    @error('mark') 
                                        <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                                            {{ $message }}
                                        </span> 
                                    @enderror
                                </div>

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
                            </div>


                            <div class="col-span-2 grid gap-4 mb-4 grid-cols-4 border border-gray-600 rounded-md p-2">
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
                                <div class="col-span-2">
                                    <label for="zone" class="block mb-2 text-sm text-amber-400 font-medium ">Zone </label>
                                    <input wire:model.live='zone' type="text" name="zone" id="zone" class="bg-transparent border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5   dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner La zone .... Ex :  BAC D ATLANTIQUE" >
                                    @error('zone') 
                                        <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                                            {{ $message }}
                                        </span> 
                                    @enderror
                                </div>

                                <div class="col-span-2">
                                    
                                    <label for="rank" class="block mb-2 text-sm text-amber-400 font-medium ">Le rang</label>
                                    <input wire:model.live='rank' type="text" name="rank" id="rank" class="bg-transparent border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5   dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner Le rang .... Ex :  1" >
                                    @error('rank') 
                                        <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                                            {{ $message }}
                                        </span> 
                                    @enderror
                                </div>

                                @if($rank && $zone)
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

                                @if(count($ranks_table) > 0)
                                <div class="overflow-x-auto my-5 col-span-4">
                                    <table class="min-w-full divide-y text-xs sm:text-sm letter-spacing-1 divide-gray-200 border">
                                        <thead class="bg-black/50 text-sky-500 ">
                                            <tr>
                                                <th scope="col" class="px-2 py-1 uppercase tracking-wider text-left">
                                                    N°
                                                </th>
                                                <th scope="col" class="px-2 py-1 uppercase tracking-wider">
                                                    Zone
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
                                            @foreach($ranks_table as $zn => $rk)
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="px-2 py-1 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        {{ $loop->iteration }}
                                                    </div>
                                                </td>
                                                <td class="px-2 py-1 whitespace-nowrap">
                                                    <div class="">
                                                        {{ $zn }}
                                                    </div>
                                                </td>
                                                <td class="px-2 py-1 whitespace-nowrap">
                                                    <div class="">
                                                        {{ $rk }}
                                                    </div>
                                                </td>
                                                <td class="px-2 py-1 whitespace-nowrap">
                                                    <div class="">
                                                        <span wire:click="removeRankFrom('{{$zn}}')"  class="text-black cursor-pointer flex justify-center items-center rounded-lg text-sm px-2 py-2 text-center bg-red-400 hover:bg-red-700  letter-spacing-1 border border-red-600">
                                                            <span wire:loading.remove wire:target="removeRankFrom('{{$zn}}')">
                                                                <span class="fas fa-trash mr-1.5"></span>
                                                            </span>
                                                            <span class="" wire:loading wire:target="removeRankFrom('{{$zn}}')">
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

                                
                            </div>

                        </div>
                        @if($pupil_name && $exam && $average && $mention)
                            @if(!($rank || $subject || $mark))
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
                            @else
                            <span class="text-red-600 letter-spacing-2 text-center font-semibold animate-pulse text-xs block w-full">
                                Veuillez ajouter les données en cours afin de valider cet enregistrement !
                            </span>
                            @endif
                        @else
                            <span class="text-orange-500 letter-spacing-2 text-center font-semibold animate-pulse text-xs block w-full">
                                Veuillez renseigner les détails: @if(!$pupil_name) noms prénoms, @endif @if(!$exam) l'examen , @endif @if(!$average) moyenne obtenue @endif, @if(!$mention) mention obtenue, @endif @if(!$image) photo, @endif  de cet candidat ou apprenant !
                            </span>
                        @endif
                    </form>
                </div>
                @endif
            </div>
        @endif
    </div>
    <h6 class="text-center flex flex-col text-amber-400 letter-spacing-1 font-semibold my-3">
        @if(url()->previous() !== url()->current())
        <a class="bg-gray-900 hover:bg-gray-900 text-amber-500 hover:underline underline-offset-2 rounded-lg p-2 py-3 my-2 mb-3 border border-amber-500" href="{{url()->previous() ?? auth_user()->to_profil_route()}}">
            <span class="fas fa-hand-point-left"></span>
            <span>
                Retour page précédente
            </span>
        </a>
        @else
        <a class="bg-gray-900 hover:bg-gray-900 text-amber-500 hover:underline underline-offset-2 rounded-lg p-2 py-3 my-2 mb-3 border border-amber-500" href="{{auth_user()->to_profil_route()}}">
            <span class="fas fa-user"></span>
            <span>
                Retour à ma page de profil
            </span>
        </a>
        @endif
    </h6>
</div>
