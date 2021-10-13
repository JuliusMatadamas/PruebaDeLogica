<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\HabitacionServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use function Composer\Autoload\includeFile;

class LightedRoomController extends Controller
{
    public function index()
    {
        // Se abre el archivo txt cargado
        $file = fopen(public_path("uploads/habitacion.txt"), "r");

        // Se declara una variable para llevar el conteo de iteraciones
        $cont = 0;

        // Se declara la variable 'habitacion' de tipo array
        $habitacion = [];

        // Se lee el archivo txt
        while(!feof($file)) {
            // Se convierte en array cada fila
            $filaEnArray = str_split(fgets($file));

            // Se recorren los elementos de la fila convertida en array
            for($i = 0; $i < count($filaEnArray); $i++)
            {
                // Si el elemento no está vacío
                if( strlen(trim($filaEnArray[$i])) == 1)
                {
                    // Si el elemento tiene el valor '0' entonces es un espacio por iluminar de la habitación
                    if($filaEnArray[$i] == 0)
                    {
                        $habitacion[$cont][$i]["tipo"] = "espacio";
                    }
                    // En caso contrario se trata de una pared
                    else
                    {
                        $habitacion[$cont][$i]["tipo"] = "pared";
                    }
                    $habitacion[$cont][$i]["bombilla"] = false;
                    $habitacion[$cont][$i]["iluminado"] = false;
                    $habitacion[$cont][$i]["cantidad"] = 0;
                }
            }
            $cont++;
        }
        // Se cierra el archivo
        fclose($file);

        // Se determina la ubicación idonea de las bombillas en la habitación



        $habitacion = obtenerEspaciosDerecha($habitacion);
        $habitacion = obtenerEspaciosIzquierda($habitacion);
        $habitacion = obtenerEspaciosDeArribaHaciaAbajo($habitacion);
        $habitacion = obtenerEspaciosDeAbajoHaciaArriba($habitacion);

        echo "<pre>";
        var_dump($habitacion);
        echo "</pre>";

        // Se muestra la vista
        // return view('lightedroom', compact('habitacion'));
    }
}
