<?php
// =================================================================== //
// =================================================================== //
// =================================================================== //

// Si el array tiene espacios donde se puede colocar un foco
if(!empty($focos))
{

    // Se realiza el ciclo foreach para colocar el foco e iluminar los espacios
    foreach ($focos as $key => $row)
    {
        // Se coloca el foco en el espacio y se le cambia el estado 'iluminado' a true
        $habitacion[$row["idfila"]][$row["idcelda"]]["bombilla"] = true;
        $habitacion[$row["idfila"]][$row["idcelda"]]["iluminado"] = true;

        break;
    }
}


// Se vuelve a obtener la cantidad de espacios sin iluminar aledaños a cada espacio
// Se inicia por los espacios a la derecha de cada espacio
$habitacion = obtenerEspaciosDerecha($habitacion);
// Se continua con los espacios a la izquierda de cada espacio
$habitacion = obtenerEspaciosIzquierda($habitacion);
// Después con los espacios debajo de cada espacio
$habitacion = obtenerEspaciosDeArribaHaciaAbajo($habitacion);
// Y por último con los espacios arriba de cada espacio
$habitacion = obtenerEspaciosDeAbajoHaciaArriba($habitacion);

// Luego se crea otro array vacío que servirá para ordenar los espacios según la cantidad de espacios que se puedan iluminar vertical y horizontalmente
$focosB = array();

// Se recorre el array
foreach ($habitacion as $idFila => $fila)
{
    for ($i = 0; $i < count($fila); $i++)
    {
        // Si el espacio tiene por lo menos 2 espacios horizontalmente o verticalmente que se puedan iluminar, se agrega la info al array
        if ($fila[$i]["cantidad"] >= 2)
        {
            $focosB[] = array('idfila' =>$idFila, 'idcelda' => $i, 'cantidad' => $fila[$i]["cantidad"]);
        }
    }
}
