<?php

require_once 'models/mantenimientos/reservas.model.php';

/**
 * Controlador de Vista Formulario de Nueva Categoria
 *
 * @return void
 */

function run()
{
    $arrViewData = array();

    /******************* BUSCAMOS DETERMINAR EN QUE MODO ESTAMOS: SI VAMOS A INSERTAR, BORRAR, ACTUALIZAR O VER ************/

    //Descripcion de la accion para poner en el titulo del FORM
    $arrModeDsc = array(
        'INS' => "Crear Nuevos Parqueos",
        'UPD' => "Actualizando Parqueos %s - %s-%s",
        'DEL' => "Eliminando Parqueos  %s - %s",
        'DSP' => "Mostrando Parqueos %s - %s"
    );

    //Inicializando variables. LAS QUE VIENEN DEL FORM (VIEW)

    $arrViewData['parqueoid'] = 0;
    $arrViewData['parqueoEst'] = '';
    $arrViewData['parqueoEstACTTrue'] = '';
    $arrViewData['parqueoEstINATrue'] = '';
    $arrViewData['parqueoLot'] = '';
    $arrViewData['parqueoTip'] = '';
    $arrViewData['parqueoTipCARTrue'] = '';
    $arrViewData['parqueoTipMTOTrue'] = '';
    $arrViewData['parqueoTipCMNTrue'] = '';
    $arrViewData['mode'] = 'INS'; //Puede ser INS, UPD, DEL, DSP ---> CRUD //DEPENDE DE LO QUE SE QUIERA HACER CON EL FORM



    /** $_SERVER es DE SOLO LECTURA. Obtenemos la peticion que hace el proceso: GET o POST **/
    if($_SERVER["REQUEST_METHOD"] === "GET")
    {
        //Si existe el mode, si trae algo
        if(isset($_GET['mode']))
        {
            //se guarda la peticion que trae en el arreglo de datos a mostrar
            $arrViewData['mode'] = $_GET['mode'];

            //se extrae el codigo y se convierte a su tipo de dato. SOLO EL CODIGO PORQUE CON EL SE BUSCAN LOS DEMAS EN LA BDD
            $arrViewData['parqueoid'] = intval($_GET['parqueoid']);
        }

        //Si se escogio una categoria && el modo no es insertar (Porque si es Insertar, los textbox se tienen que mostrar vacios)
        if($arrViewData['parqueoid'] > 0 && $arrViewData['mode']!=='INS')
        {
            //Se va a buscar a la BDD lo datos de la categoria que se selecciono para mostrarlos
            $arrTempCategoria =  obtenerReservaPorCodigo($arrViewData['parqueoid']);

            //DESDE libs/utilities. Para llenar resultados de un arreglo de origen a uno de destino
            mergeFullArrayTo($arrTempCategoria, $arrViewData);
        }

    }

    if($_SERVER["REQUEST_METHOD"] === "POST")
    {
        //Si existe el token && Existe el token en la sesion && ambos son iguales
        if( isset($_POST['token']) && isset($_SESSION['token_categoria']) && $_POST['token'] === $_SESSION['token_categoria'] )
        {
            //Se refresca cada dato con lo que viene en el POST
            $arrViewData['parqueoid'] = intval($_POST['parqueoid']);
            $arrViewData['parqueoEst'] = $_POST['parqueoEst'];
            $arrViewData['parqueoLot'] = $_POST['parqueoLot'];
            $arrViewData['parqueoTip'] = $_POST['parqueoTip'];
            $arrViewData['mode'] = $_POST['mode'];

            //Se busca con que modo se esta trabajando y se buscan las funciones en el modelo
            switch($arrViewData['mode'])
            {
                case 'INS':
                    guardarNuevaReserva($arrViewData['parqueoEst'], $arrViewData['parqueoLot'],$arrViewData['parqueoTip']);
                    redirectWithMessage("Guardado Satisfactoriamente", "index.php?page=reservas"); //Funcion por defecto para redirigir con un mensaje
                    die(); //terminar proceso
                //break; Aqui no se ocupa porque ya hay un die();

                case 'UPD':
                     actualizarReserva($arrViewData['parqueoid'], $arrViewData['parqueoEst'], $arrViewData['parqueoLot'],$arrViewData['parqueoTip']);
                    redirectWithMessage("Actualizado Satisfactoriamente", "index.php?page=reservas");
                    die();

                case 'DEL':
                    eliminarReserva($arrViewData['parqueoid']);
                    redirectWithMessage("Eliminada Satisfactoriamente", "index.php?page=reservas");
                    die();
            }
        }
        else
        {
            error_log("Intento de XRS Attack ". $_SERVER['REMOTE_ADDR']); //Concatenar el Host que hizo la solicitud
        }

        //PROBAR SI SE ESTAN ENVIANDO LOS VALORES
        //print_r($_POST);
        //die();
    }



    ///////////////////////////// VARIABLES GLOBALES - No importa si es GET o POST ////////////////////////////////////////////////

    /******************    EVITAR UN ATAQUE DE USURPACION DE FORMULARIOS O FISHING   ***********************/

    //Al entrar con GET en la URL crea el token

    //md5() Devuelve un hash binario en la sesion, es diferente cada vez // time() devuelve el numero de seg desde 1970 //Un numero random //una palabra random
    $xrstoken = md5(time() . (random_int(0, 10000)) . "categ");

    $_SESSION['token_categoria'] = $xrstoken;
    $arrViewData['token'] = $xrstoken;

    //Asi creamos un codigo unico para la transaccion de esa sesion

    /*************************************************************************************************************/


    //No importa si es GET o POST siempre va a buscar el titulo para ponerlo
    $arrViewData['modedsc'] = sprintf($arrModeDsc[$arrViewData['mode']], $arrViewData['parqueoid'], $arrViewData['parqueoEst'],$arrViewData['parqueoLot'],$arrViewData['parqueoTip']);

    //Cual esta seleccionada en el Combobox Estado segun la BDD//
    $arrViewData['parqueoEstACTTrue'] = ($arrViewData['parqueoEst'] == 'ACT')? "selected": "";
    $arrViewData['parqueoEstINATrue'] = ($arrViewData['parqueoEst'] == 'INA')? "selected": "";
    $arrViewData['parqueoTipCARTrue'] = ($arrViewData['parqueoTip'] == 'CAR')? "selected": "";
    $arrViewData['parqueoTipMTOTrue'] = ($arrViewData['parqueoTip'] == 'MTO')? "selected": "";
    $arrViewData['parqueoTipCMNTrue'] = ($arrViewData['parqueoTip'] == 'CMN')? "selected": "";


    //Para que cuando sea Display o Delete no se pueden modificar campos
    $arrViewData['isReadOnly'] = true;

    if($arrViewData['mode'] === 'INS' || $arrViewData['mode'] === 'UPD')
    {
        $arrViewData['isReadOnly'] = false;
    }

    //Para que el Boton guardar no se vea en DSP
    $arrViewData['hasAction'] = true;

    if($arrViewData['mode'] === 'DSP')
    {
        $arrViewData['hasAction'] = false;
    }

    renderizar("mantenimientos/reserva", $arrViewData);
}

run();

?>
