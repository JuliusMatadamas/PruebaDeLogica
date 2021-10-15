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
        try
        {
            $file = fopen(public_path("uploads/habitacion.txt"), "r");

            // Se declara una variable para llevar el conteo de iteraciones
            $cont = 0;

            // Se declara la variable 'habitacion' de tipo array
            $habitacion = [];
            // Se declara la variable 'espaciosOrdenados' de tipo array
            $espaciosOrdenados = [];

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

            $repetir = true;
            while ($repetir)
            {
                /**
                 * 1. Se recorre todo el array 'habitacion' para obtener la cantidad
                 * que cada espacio tiene de espacios a la derecha, izquierda
                 * arriba y abajo que se pueden iluminar
                 */
                $habitacion = obtenerEspacios($habitacion);

                /**
                 * 2. Se ordenan los elementos del array de acuerdo a la cantidad
                 * de espacios que se pueden iluminar si se coloca una bombilla
                 * si no hay espacios por iluminar se muestra la vista
                 */
                $espaciosOrdenados = obtenerEspaciosOrdenados($habitacion);
                if(count($espaciosOrdenados) == 0)
                {
                    // Se muestra la vista
                    return view('lightedroom', compact('habitacion'));
                }
                else
                {
                    /**
                     * 3. Se coloca la bombilla en el espacio que puede iluminar a más
                     * espacios contiguos
                     */
                    $habitacion = colocarBombilla($habitacion, $espaciosOrdenados[0]);

                    /**
                     * 4. Se iluminan los espacios contiguos al espacio en donde se colocó
                     * la bombilla
                     */
                    $habitacion = iluminarEspacios($habitacion, $espaciosOrdenados[0]);

                    /**
                     * 5. Se resetea la cantidad de espacios que se pueden iluminar por cada
                     * espacio en el array
                     */
                    $habitacion = resetearCantidad($habitacion);

                    /**
                     * 6. Se vuelve a recorrer todo el array 'habitacion' para obtener
                     * la cantidad que cada espacio tiene de espacios a la derecha,
                     * izquierda, arriba y abajo que se pueden iluminar
                     */
                    $habitacion = obtenerEspacios($habitacion);


                    /**
                     * 7. Se vuelven a ordenar los elementos del array de acuerdo a la cantidad
                     * de espacios que se pueden iluminar si se coloca una bombilla
                     * si no hay espacios por iluminar ******
                     */
                    $espaciosOrdenados = obtenerEspaciosOrdenados($habitacion);
                    if(count($espaciosOrdenados) == 0)
                    {
                        $repetir = false;
                    }
                }
            }

            // Se muestra la vista
            return view('lightedroom', compact('habitacion'));
        }
        catch(\Exception $e)
        {
            $error = $e;
            //"No se encontró o no se pudo leer el archivo txt, asegurese de cargar antes el archivo en formato .txt y con un contenido en forma de matriz de 1 y 0 unicamente.";
            return view('lightedroom')->withErrors($error);
        }
    }
}
