@extends('layouts.app')

@section('content')
    <main class="container">
        <div class="centered">
            <div class="card">
                <div class="card-header text-center">
                    <h1>Prueba de Lógica</h1>
                </div>

                <div class="card-body text-center">
                    <p>Colocación de Bombillos Óptimos</p>

                    <div class="row">
                        <div class="col-12 room">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <p><strong>¡Ocurrió un error!</strong></p>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <table class="table table-bordered">
                                    @foreach($habitacion as $fila)
                                        <tr>
                                            @foreach($fila as $espacio)
                                                @if($espacio["tipo"] == "pared")
                                                    <td class="pared">
                                                        &nbsp;
                                                    </td>
                                                @else
                                                    @if($espacio["bombilla"])
                                                        <td class="iluminado text-center">
                                                            <i class="far fa-lightbulb"></i>
                                                        </td>
                                                    @else
                                                        @if($espacio["iluminado"])
                                                            <td class="iluminado">
                                                            </td>
                                                        @else
                                                            <td>
                                                            </td>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-12">
                            <a href="{{ route('home') }}" class="btn btn-outline-dark btn-light">Regresar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
