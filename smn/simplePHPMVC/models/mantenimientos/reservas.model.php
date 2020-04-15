<?php

/**
 * Obtiene todas las categorias de las encuestas
 *
 * @return array Arreglo con los Registros de Categorias
 */

//Lbreria de acceso a base de datos
require_once 'libs/dao.php';

//Crear Funcion para obtener Todas las Categorias
function obtenerTodasReservas()
{
    $arrCategorias = array(); //Para guardar los datos
    $sqlSelect = "SELECT * FROM reservas;"; //Crear el query
    $arrCategorias = obtenerRegistros($sqlSelect); //Si no se manda usa la conexion por defecto, que ya establecimos nosotros arriba

    return $arrCategorias;
}

//Crear Funcion para GUARDAR NUEVA CATEGORIA
function guardarNuevaReserva($parqueoEst,$parqueoLot,$parqueoTip)
{
    $sqlIns = "INSERT into reservas (parqueoEst,parqueoLot,parqueoTip) VALUES ('%s', '%s','%s');"; //Crear el query
    $isOK = ejecutarNonQuery(
        sprintf($sqlIns, $parqueoEst,$parqueoLot,$parqueoTip) //Funcion por defecto para ejecutar querys. Se manda el query y los datos a llenar. RETORNA LA CANTIDAD DE FILAS AFECTADAS || 0 si no se afecto || false si hubo un error
    );

    return getLastInserId(); //Retorna el ultimo Id Autonumerico que se creo. SOLO PARA AUTONUMERICOS
}


//Funcion para obtener los datos de un regustro especifico
function obtenerReservaPorCodigo($parqueoid)
{
    $sqlSelect = "SELECT * FROM reservas WHERE parqueoid = %d;";

    // !!!!!!!!!!!!!!   RETORNAR ESE REGISTRO PARA MOSTRARLO   !!!!!!!!!!!!!!!!!!!!
    return obtenerUnRegistro(
        sprintf($sqlSelect, $parqueoid)
    );
}

//Actualizar una categoria
function actualizarReserva($parqueoid,$parqueoEst, $parqueoLot, $parqueoTip)
{
    $sqlUpdate = "UPDATE reservas set parqueoEst = '%s', parqueoLot = '%s',parqueoTip = '%s' WHERE parqueoid = %d;";

    return ejecutarNonQuery(
        sprintf($sqlUpdate,$parqueoEst,$parqueoLot,$parqueoTip,$parqueoid)
         //SE MANDAN EN EL ORDEN DE LA CADENA SQL
        // sprintf($sqlUpdate,$parqueoId,$parqueoEst, $parqueoLot, $parqueoTip)
    );
}

//Eliminar una categoria
function eliminarReserva($parqueoid)
{
    $sqlDelete = "DELETE from reservas WHERE parqueoid = %d;";

    return ejecutarNonQuery(
        sprintf($sqlDelete, $parqueoid)
    );
}
?>
