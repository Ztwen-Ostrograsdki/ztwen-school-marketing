<div class="w-full max-w-6xl py-3 px-4 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2" x-data="{ show: false, currentImage: '', schoolName: '', simple_name: '' }">
    <div class="card mx-auto mt-10">
        <h5 class="text-amber-500 bg-black/75 py-4 px-2 rounded-lg letter-spacing-1 font-bold text-xl flex items-center justify-between gap-y-1">
            <span># Liste des écoles</span>
            <span class="text-sm text-green-500 ml-4"> {{ numberZeroFormattor(count($schools)) }} </span>
        </h5>
    </div>
    <div class="card mx-auto mt-5 shadow-gray-900 border border-sky-400 bg-black/70 rounded-lg shadow-2xl">
        
        <div class="">
            <div class="font-semibold letter-spacing-1 text-gray-300 text-xs md:text-lg flex flex-col mx-auto p-5 text-left gap-y-3">
                @foreach ($schools as $school)
                    <div class="shadow-sm shadow-amber-400 bg-black/75 p-3 rounded-md">
                        <h5 class="text-amber-600 py-2 flex justify-between"> 
                            <span class="text-indigo-500">
                                <span>Ecole </span>
                                <span>#{{ $loop->iteration }}</span>
                            </span>
                            <a class="hover:text-pink-300" href="{{$school->to_profil_route()}}">
                                <span class="">{{ $school->name }}</span>
                            </a>
                        </h5>
                        <div class="w-full ">
                            <h5 class="flex justify-between">
                                <span class="text-yellow-300">Ecole:</span> 
                                <span class="text-gray-400">
                                    <span class="mr-2.5">{{ $school->name }}</span>
                                    (<span class="text-sky-500">{{ $school->simple_name }}</span>)
                                </span>
                            </h5>
                            <div class="my-2 italic">
                                <p>
                                    Située au {{ $school->geographic_position }} du {{ $school->country }} dans le département de {{ $school->department }}, plus précisement dans la ville de {{ $school->city }}, l'école (<span class="lowercase">{{ $school->getSchoolType() }}</span>) <a href="{{$school->to_profil_route()}}" class="text-yellow-400 font-bold">{{ $school->name }}</a> a été fondée en {{ $school->creation_year }} par <span class="text-sky-500 font-bold">{{ $school->created_by }}</span>.
                                    <br>
                                </p>
                                <p>
                                    L'école, dépuis sa création acceuille en moyenne plus de <span class="text-amber-500 font-semibold">{{ __formatNumber3($school->capacity) }}</span> apprenants.
                                    Reconnue par ses <a href="{{$school->to_profil_route()}}" class="underline underline-offset-3 hover:text-rose-300">statistiques remarquables aux différents examens</a>, il va sans doute, que <a href="{{$school->to_profil_route()}}" class="text-yellow-400 font-bold">{{ $school->name }}</a> est une école de reférence pour garantir un avenir meillleur à la jeunesse de la nation.
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
                            
                            <h5 >
                                <h6 class="py-1.5">Des images de l'école {{ $school->simple_name }} : </h6>
                                <div class="w-full grid grid-cols-2 md:grid-cols-3 gap-2">
                                    @foreach ($school->images as $key => $image)
                                        <div class="aspect-square bg-gray-100 relative group card">
                                            <img class="w-full h-full object-cover border shadow-sm" src="{{url('storage', $image)}}" alt="Image N° {{$loop->iteration}} de l'école">
                                            <div  @click="currentImage = '{{ url('storage', $image) }}'; schoolName = 'image N° {{$loop->iteration}} de {{ $school->name }}'; simple_name = '{{ $school->simple_name }}'; show = true" class="absolute cursor-pointer inset-0 bg-black/75 bg-opacity-0 group-hover:bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200">
                                                <div class="flex space-x-4 cursor-pointer text-sky-600 text-center letter-spacing-1 font-semibold text-xs">
                                                    <span class="text-center">Cliquer pour agrandir cette image</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </h5>
                        </div>
                    </div>
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
        </h5>
        <img :src="currentImage" alt="Zoom" class="w-screen md:max-w-xl max-h-[90vh] rounded shadow-xl border-2 border-white" @click.stop>
        
    </div>
</div>
