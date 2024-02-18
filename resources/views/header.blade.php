<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="{{route('funkos.index')}}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{asset('image.webp')}}"
                 class="h-8" alt="Funkos Logo"/>
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Funkos 2ºDAW</span>
        </a>
        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
            <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    <a href="{{route('funkos.index')}}"
                       class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-white md:p-0 dark:text-white md:dark:text-white"
                       aria-current="page">Funkos</a>
                </li>
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <li>
                        <a href="{{route('funkos.create')}}"
                           class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-white md:p-0 dark:text-white md:dark:text-white">Crear
                            funkos</a>
                    </li>
                    <li>
                        <a href="{{route('categories.index')}}"
                           class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-white md:p-0 dark:text-white md:dark:text-white">Categorías</a>
                    </li>
                @endif
                @if(auth()->check())

                    <li>
                        <a href="{{route('logout')}}"
                           class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-white md:p-0 dark:text-white md:dark:text-white">Cerrar
                            sesión</a>
                    </li>
                @else
                    <li>
                        <a href="{{route('login')}}"
                           class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-white md:p-0 dark:text-white md:dark:text-white">Iniciar
                            sesión</a>
                    </li>

                @endif
            </ul>
        </div>
    </div>
</nav>
