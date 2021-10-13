@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="centered">
            <div class="card">
                <div class="card-header text-center">
                    <h1>Prueba de Lógica</h1>
                </div>

                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-12">
                            <h2>Cargar habitación</h2>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-12">
                            <form action="{{ route('file.upload.post') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="file" name="file" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-success">Cargar archivo</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-12">
                            <!-- Errores -->
                            @if (count($errors) > 0)
                                <hr>
                                <div class="alert alert-danger">
                                    <strong>¡Ocurrió un error!</strong> Estas son las causas.
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Se muestra el resultado -->
                            @if ($message = Session::get('success'))
                                <hr>
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
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
    </div>
@endsection
