@extends('layout')
@section('content')

    <form class="max-w-sm mx-auto" method="POST" action="{{route('funkos.update', $funko->id)}}">
        @csrf
        @method('PUT')
        <div class="mb-5">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
            <input type="text" id="name" name="name" value="{{$funko->name}}"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                   placeholder="John Cena" required/>
        </div>
        <div class="mb-5">
            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio</label>
            <input type="number" id="price" name="price" value="{{$funko->price}}"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                   placeholder="10" required/>
        </div>
        <div class="mb-5">
            <label for="stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock</label>
            <input type="number" id="stock" name="stock" value="{{$funko->stock}}"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                   placeholder="10" required/>
        </div>
        <div class="mb-5">
            <label for="category"
                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categoría</label>
            <select id="category" name="category_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required>
                <option value="" disabled selected>Selecciona una categoría</option>
                @foreach($categories as $category)
                    <option
                            value="{{$category->id}}" {{ $funko->category->id == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Crear funko
        </button>
    </form>
@endsection
