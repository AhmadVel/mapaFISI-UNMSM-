<?php 
 session_start();// la sesion se esta manteniendo activa
 $lista=$_SESSION['LISTA'];
 require_once '../../dao/AreaDao.php';
 require_once '../../dao/EventoDao.php';
 require_once '../../util/ConexionBD.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Areas</title>
    <link rel="stylesheet" href="../../public/css/estilo_area.css">
    <!--Agregar BootStrap al proyecto (CSS)-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />
    <script>
        function eliminarCookies() {
            document.cookie = 'recordar_usuario=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
            document.cookie = 'recordar_contrasena=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        }

        function redirigir_eventos() {
            window.location.href = "../controlador/evento_Controlador.php?op=1";
        }

        function redirigir_areas() {
            window.location.href = "../controlador/area_Controlador.php?op=1";
        }

        function redirigir_login() {
            window.location.href = "../controlador/usu_controlador.php?accion=navegar_a_login";
        }

        function cargarD() {
            window.location.href = "../controlador/evento_Controlador.php?op=5";
        }

        function abrirModal() {
            var modal = document.getElementById('modalAgregarArea');
            modal.style.display = 'block';
        }

        function cerrarModal() {
            var modal = document.getElementById('modalAgregarArea');
            modal.style.display = 'none';
        }

        function abrirEditarA(button) {
            var modal = document.getElementById('modalEditarArea');

            // Obtener los valores de los atributos de datos del botón
            var codigoArea = button.getAttribute('data-codigo-area');
            var nombreArea = button.getAttribute('data-nombre-area');
            var abreviaturaArea = button.getAttribute('data-abreviatura-area');
            var descripcionArea = button.getAttribute('data-descripcion-area');
            var descripcion2Area = button.getAttribute('data-descripcion2-area');
            var imagenArea = button.getAttribute('data-imagen-area'); // Obtener la imagen en base64

            // Rellenar los campos del modal con los valores
            document.getElementById('editarCampo1').value = codigoArea;
            document.getElementById('editarCampo2').value = nombreArea;
            document.getElementById('editarCampo3').value = abreviaturaArea;
            document.getElementById('editarCampo4').value = descripcionArea;
            document.getElementById('editarCampo5').value = descripcion2Area;
            document.getElementById('imagenActualEditar').src = 'data:image/jpeg;base64,' + imagenArea; // Establecer la imagen

            modal.style.display = 'block';
        }

        function cerrarEditarA() {
            var modal = document.getElementById('modalEditarArea');
            modal.style.display = 'none';
        }
    </script>
</head>
<body id="body">
<header>
    <div id="cabecera">
        <img src="../../public/img/unmsm.png" alt="Logo UNMSM">
        <h3>Mapa UNMSM</h3>
        <button onclick="eliminarCookies(),redirigir_login()"><img src="../../public/img/usuario.png" alt="imagen">Cerrar sesión</button>   
    </div>
</header>
<div class="contenedor">
    <aside>
        <div class="boton-bloque" onclick="redirigir_eventos()">Eventos</div>
        <div class="boton-bloque" onclick="redirigir_areas()" style="background-color: #68141C; color: white;">Áreas</div>
    </aside>
    <article>
        <div>
            <h2 class="h2_aside">ADMINISTRACIÓN DE ÁREAS</h2>  
            <div class="boton-bloque-agregar" onclick="abrirModal()">Agregar Área</div>       
        </div>
        <table class="tabla_aside">
            <tr>
                <td>CÓDIGO ÁREA</td>
                <td>NOMBRE</td>
                <td>ABREVIATURA</td>
                <td>DESCRIPCION</td>
                <td>DESCRIPCION 2</td>
                <td>IMAGEN</td>
                <td>OPCIONES</td>
            </tr>
            <?php  
                foreach ($lista as $reg) {
                    echo '<tr id="fila">';
                    echo '<td>' . $reg['cod_area'] . '</td>';
                    echo '<td>' . $reg['nombre'] . '</td>';
                    echo '<td>' . $reg['abreviatura'] . '</td>';
                    echo '<td class="descripcion_area">' . $reg['descripcion'] . '</td>';
                    echo '<td>' . $reg['descripcion2'] . '</td>';                   
                    // Convertir los datos binarios de la imagen a base64
                    $imagenBase64 = base64_encode($reg['imagen']);
                    
                    // Crear la etiqueta <img> con los datos de la imagen en base64
                    echo '<td><img src="data:image/jpeg;base64,' . $imagenBase64 . '" alt="Imagen" style="width: 100px; height: auto;"></td>';
                    echo '<td> <button class="boton-editar" onclick="abrirEditarA(this)" ' .
                        'data-codigo-area="' . $reg['cod_area'] . '" ' .
                        'data-nombre-area="' . $reg['nombre'] . '" ' .
                        'data-abreviatura-area="' . $reg['abreviatura'] . '" ' .
                        'data-descripcion-area="' . $reg['descripcion'] . '"'.
                        'data-descripcion2-area="' . $reg['descripcion2'] . '" ' .
                        'data-imagen-area="' . $imagenBase64 . '"><img src="../../public/img/editar.png" alt="Editar"></button>';
                    echo '<td>' .
                    '<form method="POST" action="../controlador/area_controlador.php?op=2" onsubmit="return confirm(\'¿Estás seguro de que deseas eliminar esta área?\');">' .
                    '<input type="hidden" name="cod_area" value="' . $reg['cod_area'] . '">' .
                    '<button type="submit" class="boton-eliminar"> <img src="../../public/img/eliminar.png" alt="Eliminar"></button>' .
                    '</form>' .
                    '</td>';
                    echo '</tr>';
                }
            ?> 
        </table>
    </article>

    <!-- Modal para Editar áreas -->
    <form method="POST" action="../controlador/area_Controlador.php?op=3" enctype="multipart/form-data" id="areas">
        <div class="modal" id="modalEditarArea">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="position: relative; left: 25%; font-size: 28px;">DATOS DEL ÁREA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarEditarA()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="editarCampo1" class="col-sm-2 col-form-label">Código:</label>
                            <div class="col-sm-10">
                                <input type="text" id="editarCampo1" name="campo1" required oninput="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="editarCampo2" class="col-sm-2 col-form-label">Nombre:</label>
                            <div class="col-sm-10">
                                <input type="text" id="editarCampo2" name="campo2" required oninput="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="editarCampo3" class="col-sm-2 col-form-label">Abreviatura:</label>
                            <div class="col-sm-10">
                                <input type="text" id="editarCampo3" name="campo3" required oninput="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="editarCampo4" class="col-sm-4 col-form-label">Descripcion:</label>
                            <div class="col-sm-10">
                                <textarea type="text" id="editarCampo4" name="campo4" oninput="this.value = this.value.toUpperCase();">></textarea>
                                <!-- <input type="text" id="editarCampo4" name="campo4" required oninput="this.value = this.value.toUpperCase();"> -->
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="editarCampo5" class="col-sm-4">Descripcion 2:</label>
                            <div class="col-sm-10">
                                <textarea type="text" id="editarCampo5" name="campo5" oninput="this.value = this.value.toUpperCase();">></textarea>
                                <!-- <input type="text" id="editarCampo5" name="campo5" required oninput="this.value = this.value.toUpperCase();"> -->
                            </div>
                        </div>

                        <div class="form-group row">
                        <label for="tipoArea" class="col-sm-2 col-form-label">Tipo:</label>
                        
                        <div class="col-sm-10 col-form-label" style="margin-bottom: 5px;">
                            <select id="tipoArea" name="tipoArea" class="form-control">
                                <option value="Facultad">Facultad</option>
                                <option value="Servicio">Servicio</option>
                                <option value="Exterior">Exterior</option>
                                <option value="Interior">Interior</option>
                                <option value="Otros">Otros</option>
                            </select>
                        </div>
                    </div>

                        <div class="form-group row">
                            <label for="editarCampo6" class="col-sm-8">Imagen Actual:</label>
                            <div class="col-sm-10">
                                <img id="imagenActualEditar" src="" alt="Imagen Actual" style="width: 100%; height: auto; margin-bottom: 5px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="editarCampo7" class="col-sm-8 col-form-label">Nueva Imagen:</label>
                            <div class="col-sm-10">
                                <input type="file" id="editarCampo7" name="campo7">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrarEditarA()">Cerrar</button>
                        <button type="submit" class="btn btn-primary" style="background-color: #68141C">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal para Agregar áreas -->
    <form method="POST" action="../controlador/area_Controlador.php?op=4" enctype="multipart/form-data" id="areas">
        <div class="modal" id="modalAgregarArea">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="position: relative; left: 25%; font-size: 28px;">AGREGAR ÁREA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="agregarCampo1" class="col-sm-2 col-form-label">Código:</label>
                            <div class="col-sm-10">
                                <input type="text" id="agregarCampo1" name="campo1" required oninput="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="agregarCampo2" class="col-sm-2 col-form-label">Nombre:</label>
                            <div class="col-sm-10">
                                <input type="text" id="agregarCampo2" name="campo2" required oninput="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="agregarCampo3" class="col-sm-2 col-form-label">Abreviatura:</label>
                            <div class="col-sm-10">
                                <input type="text" id="agregarCampo3" name="campo3" required oninput="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="agregarCampo4" class="col-sm-2 col-form-label">Descripcion:</label>
                            <div class="col-sm-10">
                                <input type="text" id="agregarCampo4" name="campo4" required oninput="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="agregarCampo5" class="col-sm-2 col-form-label">Descripcion 2:</label>
                            <div class="col-sm-10">
                                <input type="text" id="agregarCampo5" name="campo5" required oninput="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                        <label for="tipoArea" class="col-sm-2 col-form-label">Tipo:</label>
                        <div class="col-sm-10">
                            <select id="tipoArea" name="tipoArea" class="form-control">
                                <option value="Facultad">Facultad</option>
                                <option value="Servicio">Servicio</option>
                                <option value="Exterior">Exterior</option>
                                <option value="Interior">Interior</option>
                                <option value="Otros">Otros</option>
                            </select>
                        </div>
                    </div>


                        <div class="form-group row">
                            <label for="agregarCampo6" class="col-sm-2 col-form-label">Imagen:</label>
                            <div class="col-sm-10">
                                <input type="file" id="agregarCampo6" name="campo6" required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrarModal()">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Agregar Área</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>
