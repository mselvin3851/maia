<?php

/**
 *
 * @return void
 */

 require_once 'models/mantenimientos/reservas.model.php'; //SE INCLUYE EL ACCESO AL MODELO DE DATOS DONDE ESTAN LAS CATEGORIAS

function run()
{
    $arrViewData = array();
    $arrViewData['reservas'] = obtenerTodasReservas();

    renderizar('mantenimientos/reservas', $arrViewData);
}

run();

?>
