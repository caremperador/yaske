@extends('layouts.template')

@section('title', 'En Construcción')

@section('content')
<div class="flex items-center justify-center">
    <div class="max-w-4xl bg-gray-800 rounded-lg shadow-xl overflow-hidden p-8 m-4">
        <div class="text-center">
            <h2 class="text-3xl leading-9 font-bold text-white mb-8">
                <i class="fas fa-tools"></i>
                Sección en Construcción
            </h2>
            <p class="text-lg text-gray-300 mb-4">
                Estamos trabajando arduamente para mejorar nuestro sitio web. Mientras tanto, puedes disfrutar de nuestra aplicación en Android.
            </p>
            <a href="/apk/yaske v1.0.6 tv.apk" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition ease-in-out duration-150 mb-4">
                <i class="fab fa-android mr-1 text-2xl"></i>
 Descargar la APK <i class="fa fa-arrow-circle-down ml-1"></i>
            </a>
            <p class="text-gray-300 mb-4">
                Estamos comprometidos con agregar contenido de calidad totalmente gratis. Empezaremos agregando películas y después series, animes, doramas, novelas, y por último, contenido para adultos.
            </p>
            <p class="text-gray-300">
                Te invitamos a regresar pronto, ya que cada día estamos agregando nuevo contenido y realizando cambios en la web para mejorar tu experiencia.
            </p>
        </div>
    </div>
</div>
@endsection
