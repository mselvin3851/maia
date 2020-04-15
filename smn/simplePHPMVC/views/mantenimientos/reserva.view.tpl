<section>
    <header>
        <h1>{{modedsc}}</h1>
    </header>

    <main>
        <form action="index.php?page=reserva&mode={{mode}}&parqueoid={{parqueoid}}" method="post"> <!-- action desde el index de la URL -->
            <!-- Se toman los datos a llenar respetando el tamanio del dato en la base. COMO NAME LOS MISMOS NOMBRES DE LA BASE -->

            <!-- ESTO PARA QUE LOS DATOS CON disabled readonly SE ENVIEN EN EL POST O GET OCULTOS, PORQUE LOS disabled readonly NO SE MANDAN.
                 SE LE PONE NOMBRE dummy a la que tiene el disabled o readonly porque ese no se ocupa.

                 Se manda tambien el mode porque pertenece a la URL del action del form. -->
            <input type="hidden" name="parqueoid" value="{{parqueoid}}"/>
            <input type="hidden" name="mode" value="{{mode}}"/>
            <input type="hidden" name="token" value="{{token}}"/> <!-- Para esconder el token de sesion unico  -->

            <fieldset>
                <label>Codigo Parqueo: &nbsp;</label>
                <input type="text" name="parqueocod" value="{{parqueoid}}" placeholder="Codigo" disabled readonly/> <!-- disabled readonly para que no se pueda modificar -->
            </fieldset>

            <fieldset>
                <label>Estado del Parqueo: &nbsp;</label>
                <select name="parqueoEst" {{if isReadOnly}} disabled readonly {{endif isReadOnly}}>
                    <!-- Los valores {{ctgEstACTTrue}}y {{ctgEstINATrue}} son para saber si estan seleccionados o no segun la BDD -->
                    <option value="ACT" {{parqueoEstACTTrue}}>Activo</option>
                    <option value="INA" {{parqueoEstINATrue}}>Inactivo</option>
                </select>
            </fieldset>

            <fieldset>
                <label>Parqueo Lote: &nbsp;</label>
                <input type="text" name="parqueoLot" value="{{parqueoLot}}" maxlength="45" placeholder="Parqueo Lote" {{if isReadOnly}} disabled readonly {{endif isReadOnly}}/>
            </fieldset>

            <fieldset>
                <label>Tipo Parqueo: &nbsp;</label>
                <select name="parqueoTip" {{if isReadOnly}} disabled readonly {{endif isReadOnly}}>
                    <!-- Los valores {{ctgEstACTTrue}}y {{ctgEstINATrue}} son para saber si estan seleccionados o no segun la BDD -->
                    <option value="CAR" {{parqueoTipCARTrue}}>Carro</option>
                    <option value="MTO" {{parqueoTipMTOTrue}}>Moto</option>
                    <option value="CMN" {{parqueoTipCMNTrue}}>Camion</option>

                </select>
            </fieldset>

            <fieldset>
                {{if hasAction}} <button type="submit" name="btnConfirmar">Guardar</button> {{endif hasAction}}
                &nbsp;
                &nbsp;
                <button type="submit" name="btnCancelar" id="botCancel">Cancelar</button>
            </fieldset>
        </form>
    </main>
</section>

<!-- QUE CUANDO LE DE CLIC A CANCELAR LE DEVUELVA A LAS CATEGORIAS -->
<script>

/* SOLO COMENTAR DENTRO DEL SCRIPT CON MULTILINEA, SINO NO FUNCIONA!!!!!!!!!!!!!!!!!! */


var botCancel = document.getElementById("botCancel");

botCancel.addEventListener("click", function(e)
{
    e.preventDefault();
    e.stopPropagation();

    window.location.assign("index.php?page=reservas");
});

</script>
