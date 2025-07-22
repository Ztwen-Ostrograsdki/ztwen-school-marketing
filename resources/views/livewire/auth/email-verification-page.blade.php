  <div>
    <section class=" max-w-3xl mx-auto pt-[10%] relative items-center justify-center mt-10 rounded-lg py-5">
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
        
        <div class="container max-w-md border bg-black/60 backdrop-blur-lg border-sky-500 shadow-xl shadow-gray-800 m-auto text-center p-8 text-white  mb-10" style="">
            
            <p class="py-2 relative text-transparent bg-clip-text text-sm sm:text-lg uppercase font-bold letter-spacing-2 from-indigo-700 via-lime-500 to-blue-700 bg-linear-to-r flex flex-col">
                <span class="fas fa-envelope text-6xl"></span> 
                <span class="">
                    Confirmation de l'adresse mail
                </span>
                <span class="absolute -bottom-1 left-0 w-full from-indigo-700 via-lime-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
            </p>
            
            <div class="mt-1">

              @if(session()->has('success'))
              <span class="text-dark bg-green-400 font-semibold text-sm letter-spacing-1 border block rounded-md p-2 border-green-950 text-center">
                {{ session('success')}}
              </span>
              @endif

              @if(session()->has('error'))
              <span class="text-dark text-sm font-semibold letter-spacing-1 bg-red-400 border block rounded-md p-2 border-red-950 text-center">
                {{ session('error')}}
              </span>
              @endif
              <!-- Form -->
              <form class="text-left my-4" wire:submit.prevent='confirmEmail'>
                @if(!$confirmed)
                <div class="grid gap-y-4">
                  <!-- Form Group -->
                  <div>
                    <label for="email" class="block text-left text-sm mb-2 cursor-pointer text-gray-300 ml-1">
                        <span class="fas fa-user-check mr-1.5"></span>
                        <span>Adresse mail</span>
                    </label>
                    <div class="relative">
                      <input placeholder="Renseignez votre adresse mail" wire:model='email' type="email" id="email" name="email" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-80 disabled:pointer-events-none bg-transparent dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600 disabled:text-yellow-300" required aria-describedby="con_email-error">
                      @error('email')
                      <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                        <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                        </svg>
                      </div>
                      @enderror
                    </div>
                    @error('email')
                      <p class="text-xs text-red-600 mt-2" id="con_email-error">{{ $message }}</p>
                    @enderror
                  </div>
  

                  <div>
                    <label for="email_verify_key" class="block text-sm mb-2 cursor-pointer text-gray-300 ml-1 text-left">
                        <span class="fas fa-key mr-1.5"></span>
                        <span>La clé</span>
                    </label>
                    <div class="relative">
                      <input placeholder="Renseignez la clé..." wire:model.live='email_verify_key' type="text" id="email_verify_key" name="email_verify_key" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600 bg-transparent" required aria-describedby="email_verify_key-error">
                      @error('email_verify_key')
                      <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                        <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                        </svg>
                      </div>
                      @enderror
                    </div>
                    @error('email_verify_key')
                      <p class="text-xs text-red-600 mt-2" id="email_verify_key-error">{{ $message }}</p>
                    @enderror
                  </div>

                  @if(!$key_expired)
                    @if(!$confirmed)
                    <div class="flex gap-4 text-center">
                      <a wire:loading.class='opacity-50' wire:target='confirmEmail' href="#" wire:click='confirmEmail' class="w-full cursor-pointer py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                        <span wire:loading.remove wire:target='confirmEmail'>Confirmez</span>
                        <span wire:loading wire:target='confirmEmail' class="">
                          Confirmation en cours...
                          <span class="fa fas fa-rotate animate-spin"></span>
                        </span>
                      </a>
                      <a wire:loading.class='opacity-50' wire:target='requestNewConfirmationKey' href="#" wire:click='requestNewConfirmationKey' class="w-full cursor-pointer py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-yellow-600 text-white hover:bg-yellow-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                        <span wire:loading.remove wire:target='requestNewConfirmationKey'>Demander une nouvelle clé</span>
                        <span wire:loading wire:target='requestNewConfirmationKey' class="">
                          Demande en cours...
                          <span class="fa fas fa-rotate animate-spin"></span>
                        </span>
                      </a>
                    </div>
                    @else
                    <a href="{{route('login')}}" class="w-full cursor-pointer py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-600 text-dark hover:bg-orange-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                      Se Connecter
                    </a>
                    @endif
                  @else
                  <a wire:loading.class='opacity-50' wire:target='requestNewConfirmationKey' href="#" wire:click='requestNewConfirmationKey' class="w-full cursor-pointer py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-yellow-600 text-white hover:bg-yellow-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    <span wire:loading.remove wire:target='requestNewConfirmationKey'>Demander une nouvelle clé</span>
                    <span wire:loading wire:target='requestNewConfirmationKey' class="">
                      Demande en cours...
                      <span class="fa fas fa-rotate animate-spin"></span>
                    </span>
                  </a>
                  @endif
                </div>
              </form>
              <!-- End Form -->
            </div>
            @else
            <div class="w-full flex flex-col items-center justify-between gap-y-2 p-1">
                <span class="text-black my-4 bg-green-400 border text-sm rounded-md p-2 border-green-950 text-center block w-full
                ">
                <b>Ce compte @if($email)  ... {{ $email }} ...  @endif <br> est déjà confirmé</b>
                </span>
                <a href="{{route('login')}}" class="cursor-pointer py-3 px-4 bg-amber-500 hover:bg-amber-600 text-black text-center font-semibold letter-spacing-1 rounded-md w-full">
                    <span class="fas fa-user-check mr-1"></span>
                    <span>Se Connecter</span>
                </a>
            </div>
            @endif    
        </div>
        
    </section>
</div>