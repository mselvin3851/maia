<section>
    <header>
        <h1>Reservacion Parqueos La Esperanza</h1>
    </header>

    <main>
        <table>
            <thead>
                <tr>
                    <th>Codigo del Parqueo</th>
                    <th>Estado del Parqueo</th>
                    <th>Parque Lote</th>
                    <th>Tipo Parqueo</th>
                    <th> <button id="botAddNew">Add New</button> </th>
                </tr>
            </thead>

            <tbody>
                {{foreach reservas}} <!-- Metaetiqueta del id del array en controller -->
                <tr>
                    <td>{{parqueoid}}</td> <!-- SE MANDA A LLAMAR LOS NOMBRES DE LAS COLUMNAS EN LAS TABLAS -->
                    <td>{{parqueoEst}}</td>
                    <td>{{parqueoLot}}</td>
                    <td>{{parqueoTip}}</td>

                    <td>
                        <a href="index.php?page=reserva&mode=UPD&parqueoid={{parqueoid}}">Editar</a> &nbsp;
                        <a href="index.php?page=reserva&mode=DSP&parqueoid={{parqueoid}}">Ver</a> &nbsp;
                        <a href="index.php?page=reserva&mode=DEL&parqueoid={{parqueoid}}">Eliminar</a>
                    </td>
                </tr>
                {{endfor reservas}}
            </tbody>
        </table>
    </main>
</section>

<!-- QUE CUANDO LE DE CLIC AL BOTON "Add New" LO REDIRIGA A LA PAGINA DE CREACION DE UNA NUEVA CATEGORIA -->
<script>

 /* SOLO COMENTAR DENTRO DEL SCRIPT CON MULTILINEA, SINO NO FUNCIONA!!!!!!!!!!!!!!!!!! */

 var botAddNew = document.getElementById("botAddNew");

 botAddNew.addEventListener("click", function(e)
 {
    e.preventDefault();
    e.stopPropagation();

    /* Con la variable mode estamos indicando que accion queremos realizar cuando se abra el form,
       y cual es la variable con la que se identifican los registros de esa tabal den la BDD */
    window.location.assign("index.php?page=reserva&mode=INS&parqueoid=0");
 });

</script>
