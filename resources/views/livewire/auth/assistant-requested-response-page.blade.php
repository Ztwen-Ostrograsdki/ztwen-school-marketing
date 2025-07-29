<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="hidden md:block">
        <div class="top-blue w-[100px] h-[100px] from-blue-300 to-gray-300 via-purple-300 bg-linear-90 rounded-full absolute  top-[33%] right-[8%]"></div>
        <div class="top-blue w-[100px] h-[100px] from-blue-300 to-gray-300 via-purple-300 bg-linear-90 rounded-full absolute  top-[40%] left-[5%]"></div>
        <div class="top-blue w-[100px] h-[100px] bg-blue-400 rounded-full absolute  bottom-[30%] right-[10%]"></div>
        <div class="top-blue w-[50px] h-[50px] bg-purple-400 rounded-full absolute  bottom-[70%] right-[2%]"></div>
        <div class="top-blue w-[100px] h-[100px] from-sky-300 to-indigo-300 via-green-300 bg-linear-90 rounded-full absolute  top-[12%] left-[14%]"></div>
        <div class="top-blue w-[100px] h-[100px] from-purple-300 to-gray-300 via-indigo-500 bg-linear-90 rounded-full absolute  top-[8%] left-[30%]"></div>
        <div class="top-blue w-[60px] h-[60px] from-purple-300 to-gray-300 via-sky-300 bg-linear-90 rounded-full absolute  bottom-[8%] left-[10%]"></div>
    </div>

    <div class="md:hidden">
        <div class="top-blue w-[50px] h-[50px] from-blue-300 to-gray-300 via-purple-300 bg-linear-90 rounded-full absolute  top-[-4%] right-[8%]"></div>
        <div class="top-blue w-[50px] h-[50px] from-blue-300 to-gray-300 via-purple-300 bg-linear-90 rounded-full absolute  top-[1%] left-[3%]"></div>
        <div class="top-blue w-[50px] h-[50px] bg-blue-400 rounded-full absolute  bottom-[0%] right-[10%]"></div>
        <div class="top-blue w-[50px] h-[50px] bg-purple-400 rounded-full absolute  bottom-[1%] right-[2%]"></div>
        <div class="top-blue w-[50px] h-[50px] from-sky-300 to-indigo-300 via-green-300 bg-linear-90 rounded-full absolute  top-[50%] left-[-4%]"></div>
        <div class="top-blue w-[50px] h-[50px] from-purple-300 to-gray-300 via-indigo-500 bg-linear-90 rounded-full absolute  top-[-3%] left-[55%]"></div>
        <div class="top-blue w-[80px] h-[80px] from-purple-300 to-gray-300 via-green-200 bg-linear-90 rounded-full absolute  top-[-4%] left-[35%]"></div>
        <div class="top-blue w-[60px] h-[60px] from-purple-300 to-gray-300 via-sky-300 bg-linear-90 rounded-full absolute  bottom-[-8%] left-[10%]"></div>
    </div>
    <div class="flex h-full items-center">
      <main class="w-full max-w-lg mx-auto p-6">
        <div class="mt-7 border border-sky-500 shadow-2xl shadow-gray-900 bg-black/60 backdrop-blur-lg">
          <div class="p-4 sm:p-7">
            <div class="text-center">
                <p class="py-2 mb-4 relative inline-block  text-sm uppercase font-bold letter-spacing-2 text-amber-500 border-b border-amber-500"> 
                    <span class="">
                        Validation de la demande d'assistance
                    </span>
                </p>
            </div>
            <div class="text-center font-semibold letter-spacing-1 my-3 text-xs"> 
              <h6>
                Demande pour la gestion de l'école 
                <span class="text-amber-400"> {{ $school->name }} </span> 
                envoyée par 
                <span class="text-green-500">{{ $sender->getFullName() }}</span>
              </h6>
            </div>
            <div class="mt-5">
              @if(!$request_approved_successfully)
              <!-- Form -->
              <form wire:submit.prevent='submit'>
                <div class="flex flex-col gap-y-3.5">
                  <!-- Form Group -->
                  @if(!request()->route('token'))
                  <div class="mb-4">
                    <label for="token" class="block text-sm mb-2 cursor-pointer font-semibold letter-spacing-1 text-gray-300">La clé</label>
                    <div class="relative">
                      <input placeholder="Renseignez la clé..." wire:model.live='token' type="text" id="token" name="token" class="py-3 px-4 block w-full border border-sky-400 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none bg-transparent dark:focus:ring-gray-600" required aria-describedby="token-error">
                      @error('token')
                      <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                        <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                        </svg>
                      </div>
                      @enderror
                    </div>
                    @error('token')
                      <p class="text-xs text-red-600 mt-2" id="token-error">{{ $message }}</p>
                    @enderror
                  @endif
                </div>
                <a type="button" wire:click='submit' wire:loading.class='opacity-50' wire:target='submit' class="cursor-pointer py-3 px-4 col-span-3 flex w-full justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-black from-blue-800 to-indigo-700 bg-linear-90 via-zinc-300 mx-auto hover:bg-gradient-to-r hover:from-indigo-500 hover:via-blue-800 hover:text-white hover:to-indigo-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    <span>
                        <span wire:loading.remove wire:target='submit'>
                            Approver la demande
                        </span>
                        <span wire:loading wire:target='submit'>
                            <span class="fas animate-spin fa-rotate"></span>
                            Validation en cours...
                        </span>
                    </span>
                  </a>
              </form>
              <!-- End Form -->
              @else

                <h6 class="text-center py-5 px-2 mb-4 text-gray-300 bg-green-600/80 rounded-lg shadow-lg shadow-gray-800">
                  Bravo, Vous avez approuvé la demande!
                  Vous avez désormais accès à la gestion de l'école 
                  <span class="text-amber-400"> {{ $school->name }} </span> 
                </h6>

                <a class="p-3 bg-blue-600 flex rounded-md my-3 justify-center items-center hover:bg-blue-800 text-white text-center font-semibold letter-spacing-1" href="{{$assistant->to_my_receiveds_assistants_requests_list_route()}}">
                  Ma page des requêtes
                </a>

              @endif
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>