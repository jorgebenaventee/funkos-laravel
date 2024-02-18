@extends('layout')
@section('content')
    <h1 class="text-2xl text-center font-bold text-white">Categorías</h1>
    <div class="flex max-w-2xl w-full m-auto justify-end">
        <a href="{{route('categories.create')}}"
           class="text-white  bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Crear
            categoría</a>
    </div>
    <div class="relative overflow-x-auto rounded mt-3">
        <table
            class="w-full max-w-2xl m-auto rounded text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="text-center px-6 py-3">
                    Nombre
                </th>
                <th scope="col" class="text-center px-6 py-3">
                    Activada
                </th>
                <th scope="col" class="text-center px-6 py-3">
                    Acciones
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row"
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                        {{$category->name}}
                    </th>
                    <td class="px-6 py-4 text-center">
                        @if($category->is_deleted)
                            <span class="text-red-600">No</span>
                        @else
                            <span class="text-green dark:text-green-400">Sí</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center flex gap-3 justify-center">
                        <a href="{{route('categories.edit', $category->id)}}"
                           class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Editar</a>
                        @if ($category->is_deleted)
                            <a href="{{route('categories.toggle-active', $category->id)}}"
                               class="font-medium text-green-600  hover:underline">Activar</a>
                        @else
                            <a href="{{route('categories.toggle-active', $category->id)}}"
                               class="font-medium text-gray-600  hover:underline">Desactivar</a>
                        @endif
                        @if($category->funkos->count() === 0)
                            <form action="{{route('categories.destroy', $category->id)}}" method="post">
                                @csrf
                                @method('DELETE')

                                <button
                                    onclick="return confirm('¿Estás seguro de que quieres borrar la categoría {{$category->name}}?')"
                                    class="font-medium text-red-600  hover:underline">Borrar
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="col-span-4 flex flex-col items-center w-full mt-4">
            {{$categories->links()}}
        </div>
    </div>

@endsection
