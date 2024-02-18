@extends('layout')
@section('content')

<div class="grid grid-cols-2 min-h-screen items-center justify-center bg-gray-900 text-white">
    <div class="flex flex-col items-center">
        <dl class="flex flex-col gap-3">
            <div class="flex flex-col">
                <dt class="font-semibold">Nombre</dt>
                <dd>{{$funko->name}}</dd>
            </div>

            <div class="flex flex-col">
                <dt class="font-semibold">Categoría</dt>
                <dd>{{$funko->category->name}}</dd>
            </div>

            <div class="flex flex-col">
                <dt class="font-semibold">Precio</dt>
                <dd>{{$funko->price}}€</dd>
            </div>

            <div class="flex flex-col">
                <dt class="font-semibold">Stock</dt>
                <dd>{{$funko->stock}} unidades</dd>
            </div>
        </dl>

        <a href="{{route('funkos.index')}}"
           class="text-white my-4 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Volver</a>
    </div>
    <div class="">
        <img src="{{$funko->getImageUrl()}}" class="w-full max-w-96 rounded"
             alt="Foto del funko {{$funko->name}}">
    </div>
</div>
@endsection
