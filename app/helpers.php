<?php
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
                if ($habitacion[$keyFila][$i]["tipo"] == "espacio")
                {
                    // Se recorren los elementos restantes del array a partir del elemento detectado como 'espacio'
                    for ($j = ($i+1); $j < count($habitacion[$keyFila]); $j++)
                    {
                        // Si el elemento siguiente es de tipo 'espacio', se aumenta la cantidad de espacios que se podría iluminar si se coloca un foco dentro de este
                        if($habitacion[$keyFila][$j]["tipo"] == "espacio")
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
                if ($habitacion[$keyFila][$i]["tipo"] == "espacio")
                {
                    // Se recorren los elementos posteriores a la izquierda
                    for ($j = $i-1; $j >= 0; $j--)
                    {
                        // Si el elemento siguiente es de tipo 'espacio' se aumenta la cantidad de espacios que podría iluminar de colocarse un foco en este elemento
                        if($habitacion[$keyFila][$j]["tipo"] == "espacio")
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
                if($habitacion[$i][$col]["tipo"] == "espacio")
                {
                    // Se recorren los demás elementos de las otras filas en la misma columna
                    for ($j = $i-1; $j >= 0; $j--)
                    {
                        // Si el elemento también es de tipo 'espacio'
                        if ( $habitacion[$j][$col]["tipo"] == "espacio" )
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
                if($habitacion[$i][$col]["tipo"] == "espacio")
                {
                    // Se recorren los demás elementos de las otras filas en la misma columna
                    for ($j = $i+1; $j < $rows; $j++)
                    {
                        // Si el elemento también es de tipo 'espacio'
                        if ( $habitacion[$j][$col]["tipo"] == "espacio" )
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
