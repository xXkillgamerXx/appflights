@extends('layouts.app')

@section('content')
    <div>
        <div class="bg-cover bg-center h-2 " style="background-image: url('{{ asset("/img/flights_dark_theme_3.svg") }}'); height: 350px">
        </div>
        <div class="container">
            <div class="text-center">
                <h1 class="mb-4 text-6xl leading-none tracking-tight text-gray-900 dark:text-white">Vuelo</h1>
            </div>

            <div class="p-3">
                <airport-search></airport-search>
            </div>
        </div>
    </div>

@endsection
