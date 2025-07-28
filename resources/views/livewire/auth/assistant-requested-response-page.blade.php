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
      <main class="w-full max-w-md mx-auto p-6">
        <div class="mt-7 border border-sky-500 shadow-2xl shadow-gray-900 bg-black/60 backdrop-blur-lg">
          <div class="p-4 sm:p-7">
            <div class="text-center">
                <p class="py-2 mb-4 relative inline-block text-transparent bg-clip-text text-sm uppercase font-bold letter-spacing-2 from-indigo-700 via-lime-500 to-blue-700 bg-linear-to-r"> 
                    <span class="">
                        Validation de la demande d'assistance
                    </span>
                    <span class="absolute -bottom-1 left-0 w-full from-indigo-700 via-lime-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
                </p>
            </div>
            <div class="mt-5">

              @if(session()->has('success'))
              <span class="text-dark letter-spacing-1 font-semibold bg-green-400 border block text-sm rounded-md p-2 border-green-950 text-center">
                {{ session('success')}}
              </span>
              @endif

              @if(session()->has('error'))
              <span class="text-dark text-sm letter-spacing-1 font-semibold bg-red-400 border block rounded-md p-2 border-red-950 text-center">
                {{ session('error')}}
              </span>
              @endif
              <!-- Form -->
              <form wire:submit.prevent='savePassword'>
                <div class="grid gap-y-4">
                  <!-- Form Group -->
                  @if(!$token)
                  <div>
                    <label for="password_reset_key" class="block text-sm mb-2 cursor-pointer font-semibold letter-spacing-1 text-gray-300">La clé</label>
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
                  </div>
                    @error('email')
                      <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                    @enderror
                  </div>
                  @endif

                  @if($key_expired)
                    <a  href="#" class="w-full cursor-pointer py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orande-600 text-white hover:bg-orange-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                        Cette requête est déjà expiré ou n'existe plus!
                    </a>
                  @else
                    @if($not_request_sent)
                    <a  class="w-full cursor-pointer py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                      Nous n'avons trouvé aucune requête correspondant à ce lien, elle a déjà dûe été supprimée! 
                    </a>
                    @else
                    <a type="button" wire:click='submit' wire:loading.class='opacity-50' wire:target='submit' class="cursor-pointer py-3 px-4 col-span-3 flex w-full justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-black from-blue-800 to-indigo-700 bg-linear-90 via-zinc-300 mx-auto hover:bg-gradient-to-r hover:from-indigo-500 hover:via-blue-800 hover:text-white hover:to-indigo-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                        <span>
                            <span wire:loading.remove wire:target='submit'>
                                Approver la demande
                            </span>
                            <span wire:loading wire:target='submit'>
                                <span class="fas animate-spin fa-rotate"></span>
                                Processus en cours...
                            </span>
                        </span>
                    </a>
                    @endif
                  @endif
                </div>
              </form>
              <!-- End Form -->
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>