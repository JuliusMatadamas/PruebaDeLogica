@extends('layouts.app')

@section('content')
    <main class="container">
        <div class="centered">
            <div class="card">
                <div class="card-header text-center">
                    <h1>Prueba de Lógica</h1>
                </div>

                <div class="card-body text-center">
                    <p>Bienvenido</p>
                    <p>De clic en alguna de las opciones siguientes</p>

                    <div class="row">
                        <div class="col-12">
                            <a href="{{ route('file.upload') }}" class="btn btn-block btn-outline-dark btn-light">Cargar habitación</a>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-12">
                            <a href="{{ route('lighted.room') }}" class="btn btn-block btn-outline-dark btn-light">Mostrar colocación de Bombillos Óptimos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
