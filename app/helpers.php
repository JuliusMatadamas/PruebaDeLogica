<?php
if (! function_exists('obtenerEspacios'))
{
    function obtenerEspacios($habitacion)
    {
        // Se inicia por los espacios a la derecha de cada espacio
        $habitacion = obtenerEspaciosDerecha($habitacion);
        // Se continua con los espacios a la izquierda de cada espacio
        $habitacion = obtenerEspaciosIzquierda($habitacion);
        // Después con los espacios debajo de cada espacio
        $habitacion = obtenerEspaciosDeArribaHaciaAbajo($habitacion);
        // Y por último con los espacios arriba de cada espacio
        $habitacion = obtenerEspaciosDeAbajoHaciaArriba($habitacion);
        return $habitacion;
    }
}

if (! function_exists('obtenerEspaciosOrdenados'))
{
    function obtenerEspaciosOrdenados($habitacion)
    {
        // Se crea un array vacío que servirá para ordenar los espacios según la cantidad de espacios que se puedan iluminar vertical y horizontalmente
        $cantidadDeBombillas = array();
        // Se recorre el array
        foreach ($habitacion as $idFila => $fila)
        {
            for ($i = 0; $i < count($fila); $i++)
            {
                // Si el espacio tiene por lo menos 2 espacios horizontalmente o verticalmente que se puedan iluminar, se agrega la info al array
                if ($fila[$i]["cantidad"] >= 1)
                {
                    $cantidadDeBombillas[] = array('idfila' =>$idFila, 'idcelda' => $i, 'cantidad' => $fila[$i]["cantidad"]);
                }
            }
        }
        // Se ordena el array del espacio con mayor número de espacios que se puedan iluminar al espacio con la menor cantidad
        if ( count($cantidadDeBombillas) == 0 )
        {
            return array();
        }
        else
        {
            foreach ($cantidadDeBombillas as $key => $row)
            {
                $aux[$key] = $row['cantidad'];
            }
            array_multisort($aux, SORT_DESC, $cantidadDeBombillas);
            return $cantidadDeBombillas;
        }
    }
}

if (! function_exists('colocarBombilla'))
{
    function colocarBombilla($habitacion, $espacio)
    {
        // Se coloca el foco en el espacio y se le cambia el estado 'iluminado' a true
        $habitacion[$espacio["idfila"]][$espacio["idcelda"]]["bombilla"] = true;
        $habitacion[$espacio["idfila"]][$espacio["idcelda"]]["iluminado"] = true;

        return $habitacion;
    }
}

if(! function_exists('iluminarEspacios'))
{
    function iluminarEspacios($habitacion, $espacio)
    {
        // Se cambia el estado 'iluminado' a true en los espacios a la derecha del espacio donde se colocó la bombilla
        for ($i = $espacio["idcelda"] + 1; $i < count($habitacion[$espacio["idfila"]]); $i++)
        {
            if($habitacion[$espacio["idfila"]][$i]["tipo"] == "espacio" && $habitacion[$espacio["idfila"]][$i]["iluminado"] == false)
            {
                $habitacion[$espacio["idfila"]][$i]["iluminado"] = true;
            }
            else
            {
                break;
            }
        }

        // Se cambia el estado 'iluminado' a true en los espacios a la izquierda del espacio donde se colocó la bombilla
        if($espacio["idcelda"] > 0)
        {
            for ($i = $espacio["idcelda"] - 1; $i >= 0; $i--)
            {
                if($habitacion[$espacio["idfila"]][$i]["tipo"] == "espacio" && $habitacion[$espacio["idfila"]][$i]["iluminado"] == false)
                {
                    $habitacion[$espacio["idfila"]][$i]["iluminado"] = true;
                }
                else
                {
                    break;
                }
            }
        }

        // Se cambia el estado 'iluminado' a true en los espacios arriba del espacio donde se colocó la bombilla
        $rows = count($habitacion);
        for ($i = $espacio["idfila"]-1; $i >= 0; $i--)
        {
            if ($habitacion[$i][$espacio["idcelda"]]["tipo"] == "espacio" && $habitacion[$i][$espacio["idcelda"]]["iluminado"] == false)
            {
                $habitacion[$i][$espacio["idcelda"]]["iluminado"] = true;
            }
            else
            {
                break;
            }
        }

        // Se cambia el estado 'iluminado' a true en los espacios abajo del espacio donde se colocó la bombilla
        for ($i = $espacio["idfila"]+1; $i < $rows; $i++)
        {
            if ($habitacion[$i][$espacio["idcelda"]]["tipo"] == "espacio" && $habitacion[$i][$espacio["idcelda"]]["iluminado"] == false)
            {
                $habitacion[$i][$espacio["idcelda"]]["iluminado"] = true;
            }
            else
            {
                break;
            }
        }
        return $habitacion;
    }
}

if (! function_exists('resetearCantidad'))
{
    function resetearCantidad($habitacion)
    {
        for ($i = 0; $i < count($habitacion); $i++)
        {
            for ($j = 0; $j < count($habitacion[$i]); $j++)
            {
                $habitacion[$i][$j]["cantidad"] = 0;
            }
        }
        return $habitacion;
    }
}

if (! function_exists('obtenerEspaciosDerecha'))
{
    function obtenerEspaciosDerecha($habitacion)
    {
        // Se recorre cada una de las filas del array
        foreach ($habitacion as $keyFila => $valueFila)
        {
            // Primero se obtienen los espacios disponible a la derecha
            // Se comienza recoriendo cada uno de los elementos de la fila
            for ($i = 0; $i < count($habitacion[$keyFila]); $i++)
            {
                // Si un elemento es de tipo 'espacio', se determina cuantos 'espacios' tiene a su derecha
                if ($habitacion[$keyFila][$i]["tipo"] == "espacio" && $habitacion[$keyFila][$i]["iluminado"] == false)
                {
                    // Se recorren los elementos restantes del array a partir del elemento detectado como 'espacio'
                    for ($j = ($i+1); $j < count($habitacion[$keyFila]); $j++)
                    {
                        // Si el elemento siguiente es de tipo 'espacio', se aumenta la cantidad de espacios que se podría iluminar si se coloca un foco dentro de este
                        if($habitacion[$keyFila][$j]["tipo"] == "espacio" && $habitacion[$keyFila][$j]["iluminado"] == false)
                        {
                            $habitacion[$keyFila][$i]["cantidad"]++;
                        }
                        // Si el elemento siguiente es de tipo 'pared' se rompe el ciclo
                        else
                        {
                            break;
                        }
                    }
                }
            }
        }
        return $habitacion;
    }
}


if (! function_exists('obtenerEspaciosIzquierda'))
{
    function obtenerEspaciosIzquierda($habitacion)
    {
// Se recorre cada una de las filas del array
        foreach ($habitacion as $keyFila => $valueFila)
        {
            // Primero se obtienen los espacios disponible a la derecha
            // Se comienza recoriendo cada uno de los elementos de la fila
            $columns = count($habitacion[$keyFila])-1;
            for ($i = $columns; $i >= 0; $i--)
            {
                // Si es un elemento de tipo 'espacio'
                if ($habitacion[$keyFila][$i]["tipo"] == "espacio" && $habitacion[$keyFila][$i]["iluminado"] == false)
                {
                    // Se recorren los elementos posteriores a la izquierda
                    for ($j = $i-1; $j >= 0; $j--)
                    {
                        // Si el elemento siguiente es de tipo 'espacio' se aumenta la cantidad de espacios que podría iluminar de colocarse un foco en este elemento
                        if($habitacion[$keyFila][$j]["tipo"] == "espacio" && $habitacion[$keyFila][$j]["iluminado"] == false)
                        {
                            $habitacion[$keyFila][$i]["cantidad"]++;
                        }
                        // Si el elemento es de tipo 'pared' se rompe el ciclo
                        else
                        {
                            break;
                        }
                    }
                }
            }
        }
        return $habitacion;
    }
}


if (! function_exists('obtenerEspaciosDeAbajoHaciaArriba'))
{
    function obtenerEspaciosDeAbajoHaciaArriba($habitacion)
    {
        // Se obtiene el número de filas del array
        $rows = count($habitacion);
        // Se establece el número de columna
        $col = 0;

        // Se obtienen los espacios disponibles de abajo hacia arriba
        // Mientras la columna sea menor al número de columnas de la fila
        while ($col < count($habitacion[0]))
        {
            // Por cada fila en el array
            for ($i = $rows-1; $i >= 0; $i--)
            {
                // Si el elemento es de tipo 'espacio'
                if($habitacion[$i][$col]["tipo"] == "espacio" && $habitacion[$i][$col]["iluminado"] == false)
                {
                    // Se recorren los demás elementos de las otras filas en la misma columna
                    for ($j = $i-1; $j >= 0; $j--)
                    {
                        // Si el elemento también es de tipo 'espacio'
                        if ($habitacion[$j][$col]["tipo"] == "espacio" && $habitacion[$j][$col]["iluminado"] == false)
                        {
                            // Se incrementa el número de espacios que se puede iluminar si se coloca un foco en el elemento
                            $habitacion[$i][$col]["cantidad"]++;
                        }
                        // Si el elemento es de tipo 'pared' se rompe el ciclo
                        else
                        {
                            break;
                        }
                    }
                }
            }
            // Se incrementa la columna
            $col++;
        }

        return $habitacion;
    }
}


if (! function_exists('obtenerEspaciosDeArribaHaciaAbajo'))
{
    function obtenerEspaciosDeArribaHaciaAbajo($habitacion)
    {
        // Se obtiene el número de filas del array
        $rows = count($habitacion);
        // Se establece el número de columna
        $col = 0;

        // Se obtienen los espacios disponibles de arriba hacia abajo
        // Mientras la columna sea menor al número de columnas de la fila
        while ($col < count($habitacion[0]))
        {
            // Por cada fila en el array
            for ($i = 0; $i < $rows; $i++)
            {
                // Si el elemento es de tipo 'espacio'
                if($habitacion[$i][$col]["tipo"] == "espacio" && $habitacion[$i][$col]["iluminado"] == false)
                {
                    // Se recorren los demás elementos de las otras filas en la misma columna
                    for ($j = $i+1; $j < $rows; $j++)
                    {
                        // Si el elemento también es de tipo 'espacio'
                        if ($habitacion[$j][$col]["tipo"] == "espacio" && $habitacion[$j][$col]["iluminado"] == false)
                        {
                            // Se incrementa el número de espacios que se puede iluminar si se coloca un foco en el elemento
                            $habitacion[$i][$col]["cantidad"]++;
                        }
                        // Si el elemento es de tipo 'pared' se rompe el ciclo
                        else
                        {
                            break;
                        }
                    }
                }
            }
            // Se incrementa la columna
            $col++;
        }
        return $habitacion;
    }
}
