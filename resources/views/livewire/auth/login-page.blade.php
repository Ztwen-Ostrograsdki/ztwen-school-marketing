<div>
    <section class=" max-w-3xl mx-auto pt-[10%] relative items-center justify-center mt-10 rounded-lg py-5">
        <div class="top-blue w-[250px] h-[250px] bg-blue-400 rounded-full absolute top-[10%] left-[50%]"></div>
        <div class="bottom-pink w-[280px] h-[280px] rounded-full absolute top-[50%] left-[12%] lg:left-[30%]"></div>
        <div class="top-orange w-[300px] h-[300px] rounded-full absolute top-[5%] left-[5%] md:left-[23%] lg:left-[30%]"></div>
        <div class="container max-w-md border bg-black/60 backdrop-blur-lg border-sky-500 shadow-xl shadow-gray-800 m-auto text-center p-8 text-white z-10 mb-10" style="">
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
            
            <form class="mt-5">
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
                    Se connecter
                </button>            

            </form>
            <p class="text-sm font-semibold letter-spacing-1">Pas encore de compte, cliquer ici <a href="{{route('register')}}" class="underline hover:text-pink-300">S'inscire</a></p>             
        </div>
        
    </section>
</div>