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
            
            <form wire:keydown.enter='login' @submit.prevent class="mt-5">
                <div class="flex gap-y-2 flex-col text-sm">
                    <div class="text-left">
                        <label class="text-gray-300 cursor-pointer letter-spacing-2" for="email">
                            <span class="fas fa-user"></span>
                            <span>Votre identfiant</span>
                        </label>
                        <input autocomplete="false" type="text" id="email" placeholder="Username..." class="w-full mx-auto bg-transparent">
                    </div>
                    <div class="text-left">
                        <label class="text-gray-300 cursor-pointer letter-spacing-2" for="email">
                            <span class="fas fa-key"></span>
                            Votre mot de passe
                        </label>
                        <input type="password" id="password" placeholder="Password..." class="w-full mx-auto ">
                    </div>
                </div>
                <button type="submit" class="p-2 text-black cursor-pointer border from-blue-800 to-indigo-700 bg-linear-90 via-zinc-300 rounded-2xl m-8 w-36 mx-auto sm:w-48 hover:bg-gradient-to-r hover:from-indigo-500 hover:via-blue-800 hover:text-white hover:to-indigo-700"
                >
                    <span>
                        <span wire:loading.remove wire:target='login'>Se connecter</span>
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