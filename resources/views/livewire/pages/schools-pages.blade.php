<div class="w-full max-w-7xl py-3 px-4 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2" x-data="{ show: false, currentImage: '', schoolName: '', simple_name: '', title: '' }">
    <div class="card mx-auto mt-10">
        <h5 class="text-amber-500 bg-black/75 py-4 px-2 rounded-lg letter-spacing-1 font-bold text-xl flex items-center justify-between gap-y-1">
            <span># Liste des écoles</span>
            <span class="ml-4"> {{ numberZeroFormattor(count($schools)) }} </span>
        </h5>
    </div>
    <div class="card mx-auto mt-5 shadow-gray-900 border border-sky-400 bg-black/70 rounded-lg shadow-2xl">
        
        <div class="">
            <div class="font-semibold letter-spacing-1 text-gray-300 text-xs md:text-lg flex flex-col mx-auto p-5 text-left gap-y-16">
                @foreach ($schools as $school)
                    <div class="shadow-sm shadow-amber-400 bg-black/75 p-3 rounded-md">
                        <h5 class="text-amber-600 py-2 text-lg md:text-3xl"> 
                            <a class="hover:text-pink-300 hover:underline hover:underline-offset-2 flex justify-between" href="{{$school->to_profil_route()}}">
                                <span class="text-indigo-500 hover:text-pink-300">
                                    <span>Ecole </span>
                                    <span>#{{ $loop->iteration }}</span>
                                </span>
                                <span>
                                    <span class="">{{ $school->name }}</span>
                                    (<span class="text-amber-700">{{ $school->simple_name }}</span>)
                                </span>
                            </a>
                        </h5>
                        <div class="w-full ">
                            
                            <div class="my-2 italic">
                                <p>
                                    Située au {{ $school->geographic_position }} du {{ $school->country }} dans le département de {{ $school->department }}, plus précisement dans la ville de {{ $school->city }}, l'école (<span class="lowercase">{{ $school->getSchoolType() }}</span>) <a href="{{$school->to_profil_route()}}" class="text-yellow-400 font-bold">{{ $school->name }}</a> a été fondée en {{ $school->creation_year }} par <span class="text-sky-500 font-bold">{{ $school->created_by }}</span>.
                                    <br>
                                </p>
                                <p>
                                    L'école, dépuis sa création acceuille en moyenne plus de <span class="text-amber-500 font-semibold">{{ __formatNumber3($school->capacity) }}</span> apprenants.
                                    Reconnue par ses <a href="{{$school->to_profil_route()}}" class="underline underline-offset-3 hover:text-rose-300">statistiques remarquables aux différents examens</a>, il va sans doute, que <a href="{{$school->to_profil_route()}}" class="text-yellow-400 font-bold">{{ $school->name }}</a> est une école de reférence pour garantir un avenir meillleur à la jeunesse de la nation.
                                </p>

                                <p>
                                    {{ $school->description ? $school->description : ''}}
                                </p>


                            </div>
                            <h5 class="flex justify-end gap-x-1.5 ">
                                <span class="text-yellow-300">Contacts : </span> 
                                <span class="text-gray-400">
                                    <span class="fas fa-phone mr-1"></span>
                                    <span class="">{{ $school->contacts }}</span>
                                </span>
                            </h5>

                            <h5 class="flex justify-end gap-x-1.5 ">
                                <span class="text-yellow-300">Localisation : </span>
                                <span class="text-gray-400">
                                    <span class="fas fa-map-location-dot mr-1 text-gray-400"></span>
                                    <span>{{ $school->country }}</span> - 
                                    <span>{{ $school->department }}</span> - 
                                    <span>{{ $school->city }}</span>
                                </span>
                            </h5>
                            @if($school->user_id !== auth_user_id())
                            <div class="w-full flex justify-start my-2">
                                <button wire:click="likeAndFollow({{$school->id}})" class="bg-rose-400 cursor-pointer hover:bg-rose-700 text-black font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out w-full animate-pulse">
                                    <span wire:loading.remove wire:target="likeAndFollow({{$school->id}})">
                                            <span class="fas fa-thumbs-up mr-1 "></span>
                                            Aimer | Suivre 
                                            <span class="fas fa-quote-left"></span>
                                            {{ $school->name }}
                                            <span class="fas fa-quote-right"></span>
                                        </span>
                                        <span wire:loading wire:target="likeAndFollow({{$school->id}})">
                                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                            <span>En cours...</span>
                                        </span>
                                </button>
                            </div>
                            @endif
                            
                            <div class="mb-5">
                                <h6 class="text-amber-400 py-3 uppercase font-semibold letter-spacing-1
                                ">
                                    # Des images de l'école
                                </h6>
                                <div class="w-full grid grid-cols-2 md:grid-cols-3 gap-2">
                                    @foreach ($school->images()->orderBy('created_at', 'desc')->get() as $image)
                                        @if($image->subscription?->is_active)
                                            <div class="aspect-square bg-gray-100 relative group card">
                                                <img class="w-full h-full object-cover border shadow-sm" src="{{url('storage', $image->path)}}" alt="Image N° {{$loop->iteration}} de l'école">
                                                <div  class="absolute top-2 left-1 right-1 items-center cursor-pointer bg-black/90 text-white inline-flex p-3 text-center  justify-center bg-opacity-70 opacity-80  group-hover:text-sky-400 group-hover:opacity-100 group-hover:bg-opacity-100 transition-all duration-200">
                                                    <div class="flex space-x-4 cursor-pointer text-center letter-spacing-2 text-xs">
                                                        <span class="text-center"> 
                                                            @if($image->title)
                                                                {{ $image->title }} 
                                                            @else
                                                                Image N° {{ $loop->iteration }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                                <div  @click="currentImage = '{{ url('storage', $image->path) }}'; schoolName = 'image N° {{$loop->iteration}} de {{ $school->name }}'; simple_name = '{{ $school->simple_name }}' ; title = '{{ $image->title ? $image->title : "Aucun titre renseigné" }}'; show = true" class="absolute cursor-pointer inset-0 bg-black/75 bg-opacity-0 group-hover:bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200">
                                                    <div class="flex space-x-4 cursor-pointer text-sky-600 text-center letter-spacing-1 font-semibold text-xs">
                                                        <span class="text-center">Cliquer pour agrandir cette image</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            @if($school->hasVideos())
                                <div class="mb-5">
                                    <h6 class="text-amber-400 py-3 uppercase font-semibold letter-spacing-1
                                    ">
                                        # Des vidéos de l'école
                                    </h6>
                                    <div class="w-full grid grid-cols-2 md:grid-cols-3 gap-2">
                                        @foreach ($school->videos()->orderBy('created_at', 'desc')->get() as $video)
                                            @if($video->subscription?->is_active)
                                                <div class="aspect-square bg-gray-100 relative group card">
                                                    <video alt="Vidéo N° {{$loop->iteration}} de l'école" controls class="w-full h-full object-cover border shadow-sm">
                                                        <source src="{{url('storage', $video->path)}}" type="video/mp4">
                                                        Votre navigateur ne supporte pas la lecture vidéo.
                                                    </video>
                                                    
                                                    <div  class="absolute top-2 left-1 right-1 items-center cursor-pointer bg-black/90 text-white inline-flex p-3 text-center  justify-center bg-opacity-70 opacity-80  group-hover:text-sky-400 group-hover:opacity-100 group-hover:bg-opacity-100 transition-all duration-200">
                                                        <div class="flex space-x-4 cursor-pointer text-center letter-spacing-2 text-xs">
                                                            <span class="text-center"> 
                                                                @if($video->title)
                                                                    {{ $video->title }} 
                                                                @else
                                                                    Vidéo N° {{ $loop->iteration }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if($school->hasStats())
                            <div class="mx-auto w-full mb-5 shadow-lg rounded-lg">
                                <h6 class="text-amber-400 py-3 uppercase font-semibold letter-spacing-1
                                ">
                                    # Quelques statistiques de cette école
                                </h6>
                                <div class="flex flex-col gap-y-3 my-2 items-center justify-center">
                                    @foreach ($school->getStatsByYears() as $yr => $stats)
                                        <div class="w-full flex flex-col  my-2.5">
                                            <h5 class="text-center font-semibold letter-spacing-1 py-3 uppercase text-amber-500 rounded-lg border-y-2 border-y-sky-600">
                                                Les examens de l'année {{ $yr }}
                                            </h5>
                                            <div class="grid grid-cols-3 md:grid-cols-3 lg:grid-cols-6 gap-4 card my-3">
                                                @foreach($stats as $stat)
                                                    @if($stat->subscription?->is_active)
                                                        <div class="aspect-square shadow-inner shadow-sky-100 from-green-800 to-blue-900 via-sky-900 bg-linear-180 bg-black rounded-lg relative group card p-3 flex items-center justify-center flex-col font-bold letter-spacing-1 cursor-pointer hover:shadow-md hover:shadow-sky-400 gap-y-2 md:gap-y-1">
                                                            <div>
                                                                <h4 class="text-center text-sm md:text-lg animate-pulse mb-3">
                                                                    {{ $stat->exam }} {{ $stat->year }}
                                                                </h4>
                                                                <h3 class="text-xl md:text-3xl text-center text-transparent bg-clip-text from-blue-300 via-yellow-400 to-gray-500 bg-linear-to-bl">
                                                                    <span class="fas"> 
                                                                        {{ __formatDecimal($stat->stat_value) }} </span>
                                                                    <span class="fas fa-percent"></span>
                                                                </h3>
                                                            </div>
                                                            
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <div id="school_bests_pupils" class="mx-auto w-full mb-5 shadow-lg rounded-lg">
                                <h6 class="text-amber-400 py-3 uppercase font-semibold letter-spacing-1">
                                    # Les meilleurs élèves de tous les temps de cette école
                                </h6>
                                @php
                                    $school_bests_pupils = $school->bests_pupils()->where('hidden', false)->orderBy('created_at')->get()
                                @endphp
                                @if(count($school_bests_pupils) > 0)
                                    <div class="flex flex-col gap-y-7 card my-4">
                                        @foreach($school_bests_pupils as $pupil)
                                            <h5 class="text-center font-semibold letter-spacing-1 py-3 uppercase text-amber-500 rounded-lg border-y-2 border-y-sky-600">
                                                # EXAMEN : {{ $pupil->exam }} {{ $pupil->year }}
                                            </h5>
                                            @if(true)
                                                <div class="border border-r-gray-500 bg-black/60 p-3 letter-spacing-1 rounded-xl shadow-inner shadow-sky-400">
                                                    <div @if($pupil->hidden) title="Ce record est masqué" @endif class="text-gray-300 @if($pupil->hidden) opacity-35 @endif text-sm lg:text-lg grid grid-cols-3">
                                                        <div class="aspect-square bg-gray-100 relative group card col-span-3 sm:col-span-1">
                                                            <img class="w-full h-full object-cover border shadow-sm" src="{{url('storage', $pupil->image_path)}}" alt="photo de l'apprenant {{$pupil->pupil_name}}">
                                                            
                                                            <div  @click="currentImage = '{{ url('storage', $pupil->image_path) }}'; schoolName = 'Photo de {{ $pupil->pupil_name }}'; simple_name = '({{ $pupil->average }} / 20)'; title = 'Mention : {{ $pupil->mention }}'; show = true" class="absolute cursor-pointer inset-0 bg-black/75 bg-opacity-0 group-hover:bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200">
                                                                <div class="flex space-x-4 cursor-pointer text-sky-600 text-center letter-spacing-1 font-semibold text-xs">
                                                                    <span class="text-center">Cliquer pour agrandir cette photo</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3 col-span-3 sm:col-span-2 md:mt-0">
                                                            <div class="px-3 flex justify-center items-center flex-col">
                                                                <h2 class="text-left font-bold letter-spacing-1 py-3  rounded-lg border-y-2 border-y-sky-600 text-sm lg:text-lg w-full mb-3">
                                                                    <span class="ml-2 uppercase">
                                                                        <span class="fas fa-user"></span>
                                                                        Candidat {{$pupil->gender == 'Feminin' ? 'e' : '' }} : </span>
                                                                    <span class="text-sky-500 uppercase">
                                                                        {{$pupil->pupil_name}}
                                                                    </span>

                                                                    <small class="text-xs text-yellow-500 font-semibold lowercase letter-spacing-1">
                                                                        @if($pupil->gender && $pupil->gender == 'Masculin') 
                                                                        Homme
                                                                        @elseif($pupil->gender && $pupil->gender == 'Feminin') 
                                                                        Fille
                                                                        @endif
                                                                    </small>
                                                                </h2>
                                                                
                                                                <h3 class="text-sm md:text-lg uppercase text-center bg-green-400 shadow-2xl text-gray-900 w-full p-3 px-6 rounded-2xl">
                                                                    <span class="">{{ $pupil->mention }} </span>
                                                                </h3>
                                                                <h3 class="text-sm lg:text-lg text-center  mt-4">
                                                                    
                                                                    <span>Moyenne : </span>
                                                                    <span class="fas text-transparent bg-clip-text from-blue-300 via-yellow-400 to-gray-500 bg-linear-to-bl">{{ __formatDecimal($pupil->average) }} / 20 </span>
                                                                </h3>
                                                                <div class="w-full text-sm lg:text-lg mt-3">
                                                                    <h5 class="text-center font-semibold letter-spacing-1 py-1 uppercase text-amber-500 rounded-lg border-y-2 border-y-sky-600 w-full my-2">Quelques records et rangs de {{ $pupil->pupil_name }}</h5>
                                                                    <ul>
                                                                    @foreach ($pupil->ranks as $zone => $rank)
                                                                    <li>
                                                                        <span class="fas fa-circle text-amber-500"></span>
                                                                        <span> {{ $zone }} :  </span>
                                                                        <span class="text-green-400"> 
                                                                            {{ rankFormat($rank)['rank'] }}<sup>{{ rankFormat($rank)['sup'] }}</sup> 
                                                                        </span>
                                                                    </li> 
                                                                    @endforeach
                                                                    </ul>
                                                                    
                                                                </div>
                                                                <div class="w-full text-sm lg:text-lg">
                                                                    <h5 class="text-center font-semibold letter-spacing-1 py-1 uppercase text-amber-500 rounded-lg border-y-2 border-y-sky-600 w-full my-2">Quelques notes de {{ $pupil->pupil_name }}</h5>
                                                                    <ul>
                                                                    @foreach ($pupil->details as $subject => $mark)
                                                                    <li>
                                                                        <span class="fas fa-circle text-amber-500"></span>
                                                                        <span> {{ $subject }} :  </span>
                                                                        <span class="text-green-400"> {{ $mark }} </span>
                                                                    </li> 
                                                                    @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <h6 class="text-center font-semibold text-gray-500 italic text-lg py-3">Aucune donnée publiée</h6>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($school->user_id !== auth_user_id())
                        <div class="w-full flex justify-start my-2">
                            <button wire:click="likeAndFollow({{$school->id}})" class="bg-rose-400 cursor-pointer hover:bg-rose-700 text-black font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out w-full animate-pulse">
                                <span wire:loading.remove wire:target="likeAndFollow({{$school->id}})">
                                        <span class="fas fa-thumbs-up mr-1"></span>
                                        Aimer | Suivre 
                                        <span class="fas fa-quote-left"></span>
                                        {{ $school->name }}
                                        <span class="fas fa-quote-right"></span>
                                    </span>
                                    <span wire:loading wire:target="likeAndFollow({{$school->id}})">
                                        <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                        <span>En cours...</span>
                                    </span>
                            </button>
                        </div>
                    @endif
                @endforeach
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
        class="fixed inset-0 bg-black/95 flex flex-col items-center justify-center z-50"
        style="display: none;"
        @click="show = false"
    >
        <h5 class="mx-auto flex flex-col gap-y-1 text-sm text-center py-3 font-semibold letter-spacing-1 my-3 px-3" >
            <span class=" text-sky-500 uppercase" x-text="schoolName"></span>
            <span class=" text-yellow-500" x-text="simple_name"></span>
            <span class=" text-amber-500 underline underline-offset-2" x-text="title"></span>
        </h5>
        <img :src="currentImage" alt="Zoom" class="w-screen md:max-w-xl max-h-[90vh] shadow-md shadow-gray-600 border border-white" @click.stop>
        
    </div>
</div>
