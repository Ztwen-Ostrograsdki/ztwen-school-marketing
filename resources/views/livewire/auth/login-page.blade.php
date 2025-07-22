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
            <img 
                id="passport" 
                src="{{asset('icons/news/user-person-man.png')}}" 
                alt=""
                class="mx-auto h-20"  
            >
            <p class="py-2 relative inline-block text-transparent bg-clip-text text-xl sm:text-2xl uppercase font-bold letter-spacing-2 from-indigo-700 via-lime-500 to-blue-700 bg-linear-to-r"> 
                <span class="">
                    Connexion
                </span>
                <span class="absolute -bottom-1 left-0 w-full from-indigo-700 via-lime-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
            </p>
            
            <form wire:keydown.enter='login' @submit.prevent class="mt-5 text-left">
                <div class="flex gap-y-2 flex-col text-sm">
                    <div>
                    <label for="email" class="block text-left text-sm mb-2 cursor-pointer text-gray-300 ml-1">
                        <span class="fas fa-user-check mr-1.5"></span>
                        <span>Adresse mail</span>
                    </label>
                    <div class="relative">
                      <input wire:loading.attr='disabled' wire:target='login' placeholder="Renseignez votre adresse mail" wire:model='email' type="email" id="email" name="email" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-80 disabled:pointer-events-none bg-transparent dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600 disabled:text-yellow-300" required aria-describedby="con_email-error">
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
                    <label for="password" class="block text-sm mb-2 cursor-pointer text-gray-300 text-left ml-1">
                        <span class="fas fa-key mr-1.5"></span>
                        <span>Votre mot de passe</span>
                    </label>
                    <div class="relative">
                      <input wire:loading.attr='disabled' wire:target='login' placeholder="Renseignez votre mot de passe..." wire:model.live='password' type="password" id="password" name="password" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600 bg-transparent" required aria-describedby="password-error">
                      @error('password')
                      <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                        <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                        </svg>
                      </div>
                      @enderror
                    </div>
                    @error('password')
                      <p class="text-xs text-red-600 mt-2" id="password-error">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <button wire:click='login' wire:loading.attr='disabled' wire:target='login' class="p-2 bg-sky-500 hover:bg-sky-800 text-black text-center font-semibold letter-spacing-1 rounded-md w-full my-5 cursor-pointer"
                >
                    <span>
                        <span wire:loading.remove wire:target='login'>
                            <span class="fas fa-user-check mr-1"></span>
                            <span>Se connecter</span>
                        </span>
                        <span wire:loading wire:target='login'>
                            <span class="fas animate-spin fa-rotate"></span>
                            Authentification en cours...
                        </span>
                    </span>
                </button>            

            </form>
            <div class="flex flex-col gap-y-2">
                <p class="text-sm font-semibold letter-spacing-1">
                    Pas encore de compte, cliquer ici 
                    <a href="{{route('register')}}" class="underline hover:text-pink-300">
                        S'inscire
                    </a>
                </p>
                <p class="text-sm font-semibold letter-spacing-1 text-gray-400">
                    <a href="{{route('password.forgot')}}" class="underline hover:text-pink-300">
                        J'ai oublié mon mot de passe
                    </a>
                </p>
            </div>             
        </div>
        
    </section>
</div>