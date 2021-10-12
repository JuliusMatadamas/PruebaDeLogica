<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2>Prueba de lógica</h2>
            </div>
            <div class="panel-body">
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
                    <img src="uploads/{{ Session::get('file') }}">
                @endif
            </div>
        </div>
    </div>
</body>
</html>
