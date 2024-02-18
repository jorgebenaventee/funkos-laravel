@extends('layout')
@section('content')
    <main class="min-h-screen grid grid-cols-4 p-4 bg-gray-900 gap-4 items-center justify-center">
        <form class="col-span-4 flex flex-col items-center justify-center">
            <div class="max-w-96">
                <label for="search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Filtrar por
                    nombre</label>
                <input type="text" id="search" name="search" value="{{request('search')}}"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="John Cena"/>
                <button
                    class="items-center w-full my-2 px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Filtrar
                </button>
            </div>
        </form>
        @foreach($funkos as $funko)
            <div
                class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 m-auto min-h-[410px]">
                <a href="#" class="p-2">
                    <img class="rounded block m-auto size-[150px]" src="<?= $funko->getImageUrl() ?>"
                         alt=""/>
                </a>
                <div class="p-5 min-w-[400px]">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            <?= $funko->name ?>
                    </h5>
                    <small class="opacity-50 text-white"><?= $funko->category_name ?></small>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                            <?= $funko->price ?>€
                    </p>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                            <?= $funko->stock ?> unidades en stock
                    </p>
                    <div class="flex gap-1 flex-wrap">
                        <a href="{{route('funkos.show', $funko->id)}}"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Ver detalles
                        </a>
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <a href="{{route('funkos.edit', $funko->id)}}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-indigo-700 rounded-lg hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">
                                Actualizar
                            </a>
                            <a href="{{route('funkos.image', $funko->id)}}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-violet-700 rounded-lg hover:bg-violet-800 focus:ring-4 focus:outline-none focus:ring-violet-300 dark:bg-violet-600 dark:hover:bg-violet-700 dark:focus:ring-violet-800">
                                Actualizar imagen
                            </a>
                            <form action="{{route('funkos.destroy', $funko->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    onclick="return confirm('¿Seguro que quieres borrar el funko <?= $funko->name ?>?')"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                    Borrar
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-span-4 flex flex-col items-center w-full">

            {{$funkos->links()}}

        </div>
    </main>

@endsection
