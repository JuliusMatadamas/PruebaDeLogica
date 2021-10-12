<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function fileUpload()
    {
        return view('fileupload');
    }

    public function fileUploadPost(Request $request)
    {
        // Validación del archivo
        $request->validate([
            'file' => 'required|mimes:txt|max:2048',
        ]);

        // Se renombra el archivo
        $fileName = time().'.'.$request->file->extension();

        // Se almacena en la carpeta 'uploads'
        $request->file->move(public_path('uploads'), $fileName);

        // Se devuelve la respuesta
        return back()
            ->with('success','El archivo ha sido cargado.')
            ->with('file',$fileName);

    }
}
