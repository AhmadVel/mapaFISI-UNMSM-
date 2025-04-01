<?php 
session_start(); // la sesion se esta manteniendo activa
$lista = $_SESSION['LISTA'];
$listaAreas = $_SESSION['LISTA_AREAS'];
require_once '../../dao/AreaDao.php';
require_once '../../dao/EventoDao.php';
require_once '../../util/ConexionBD.php';

//array donde asociamos área y código
$areasMap = [];
foreach ($listaAreas as $area) {
    $areasMap[$area['cod_area']] = $area['nombre'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <link rel="stylesheet" href="../../public/css/estilo_evento.css">
    <!--Agregar BootStrap al proyecto (CSS)-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />
    <script>
        function eliminarCookies() {
            document.cookie = 'recordar_usuario=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
            document.cookie = 'recordar_contrasena=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        }
    
        function redirigir_eventos() {
            window.location.href = "../controlador/evento_controlador.php?op=1";
        }
        function redirigir_areas() {
            window.location.href = "../controlador/area_Controlador.php?op=1";
        }
        function redirigir_login() {
            window.location.href = "../controlador/usu_controlador.php?accion=navegar_a_login";
        }
        function abrirModal() {
            var modal = document.getElementById('modalAgregarEvento');
            modal.style.display = 'block';
        }
        function cerrarModal() {
            var modal = document.getElementById('modalAgregarEvento');
            modal.style.display = 'none';
        }
        function cargarD() {
            window.location.href = "../controlador/evento_Controlador.php?op=5";
        }
        function abrirEditar(button) {
            var modal = document.getElementById('modalEditarEvento');

            // Obtener los valores de los atributos de datos del botón
            var codigoEvento = button.getAttribute('data-codigo-evento');
            var nombreEvento = button.getAttribute('data-nombre-evento');
            var detalleEvento = button.getAttribute('data-detalle-evento');
            var horaEvento = button.getAttribute('data-hora-evento');

            // Rellenar los campos del modal con los valores
            document.getElementById('campo1').value = codigoEvento;
            document.getElementById('campo2').value = nombreEvento;
            document.getElementById('campo3').value = detalleEvento;
            document.getElementById('campo4').value = horaEvento;

            modal.style.display = 'block';
        }
        function cerrarEditar() {
            var modal = document.getElementById('modalEditarEvento');
            modal.style.display = 'none';
        }
    </script>
</head>
<body id="body">
<header>
    <div id="cabecera">
        <img src="../../public/img/unmsm.png" alt="Logo de San Marcos">
        <h3>Mapa UNMSM</h3>
        <button onclick="eliminarCookies(), redirigir_login()"><img src="../../public/img/usuario.png" alt="imagen">Cerrar sesión</button>   
    </div>
</header>
<div class="contenedor">
    <aside>
        <div class="boton-bloque" onclick="redirigir_eventos()" style="background-color: #68141C; color: white;">Eventos</div>
        <div class="boton-bloque" onclick="redirigir_areas()">Áreas</div>
    </aside>
    <article>
        <div>
            <h2 class="h2_aside">ADMINISTRACIÓN DE EVENTOS</h2>  
            <div class="boton-bloque-agregar" onclick="abrirModal()">Agregar Evento</div>       
        </div>
        <table class="tabla_aside">
            <center>
            <tr>
                <td>CÓDIGO</td>
                <td>NOMBRE DEL EVENTO</td>
                <td>DETALLE</td>
                <td>HORA</td>
                <td>ÁREA</td>
            </tr>
            <?php
            foreach ($lista as $reg) {
                echo '<tr id="fila">';
                echo '<td>' . $reg['cod_evento'] . '</td>';
                echo '<td>' . $reg['nombre'] . '</td>';
                echo '<td>' . $reg['detalle'] . '</td>';
                echo '<td>' . $reg['hora'] . '</td>';
                echo '<td>' . $reg['cod_area'] . '</td>';
                echo '<td> <button class="boton-editar" onclick="abrirEditar(this)" ' .
                    'data-codigo-evento="' . $reg['cod_evento'] . '" ' .
                    'data-nombre-evento="' . $reg['nombre'] . '" ' .
                    'data-detalle-evento="' . $reg['detalle'] . '" ' .
                    'data-hora-evento="' . $reg['hora'] . '" ' .
                    'data-area-evento="' . $reg['cod_area'] . '"><img src="../../public/img/editar.png" alt="Editar"></button>';
                echo '<td>' .
                    '<form method="POST" action="../controlador/evento_controlador.php?op=2" onsubmit="return confirm(\'¿Estás seguro de que deseas eliminar este evento?\');">' .
                    '<input type="hidden" name="cod_evento" value="' . $reg['cod_evento'] . '">' .
                    '<button type="submit" class="boton-eliminar"> <img src="../../public/img/eliminar.png" alt="Eliminar"></button>' .
                    '</form>' .
                    '</td>';
                echo '</tr>';
            }
            ?>
            </center>
        </table>
    </article>
</div>

<!-- Modal para editar eventos -->
<form method="POST" action="../controlador/evento_controlador.php?op=3">
    <div class="modal" id="modalEditarEvento">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="position: relative;left: 25%; font-size: 28px;">EDITAR EVENTO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarEditar()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <!-- <div class="modal-body">
                    <label for="campo1" id="campo1text">Código del Evento:</label>
                    <label for="campo2" style="position: relative;right: 5%" id="campo2text">Nombre:</label>
                    <br>
                    <input type="text" id="campo1" name="campo1" placeholder="Código del Evento" required oninput="this.value = this.value.toUpperCase();">
                    <input type="text" id="campo2" name="campo2" placeholder="Nombre" required oninput="this.value = this.value.toUpperCase();">
                    <br>
                    <label for="campo3" id="campo3text">Detalle:</label>
                    <input type="text" id="campo3" name="campo3" required oninput="this.value = this.value.toUpperCase();">
                    <label for="campo4" id="campo4text">Hora:</label>
                    <input type="text" id="campo4" name="campo4" required oninput="this.value = this.value.toUpperCase();">
                </div> -->

                <div class="modal-body">
                    <div class="form-group row">
                        <label for="campo1" class="col-sm-2 col-form-label">Código:</label>
                        <div class="col-sm-10">
                        <input type="text" id="campo1" name="campo1" required oninput="this.value = this.value.toUpperCase();">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="campo2" class="col-sm-2 col-form-label">Nombre:</label>
                        <div class="col-sm-10">
                        <input type="text" id="campo2" name="campo2" required oninput="this.value = this.value.toUpperCase();">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="campo3" class="col-sm-2 col-form-label">Detalle:</label>
                        <div class="col-sm-10">
                        <input type="text" id="campo3" name="campo3" required oninput="this.value = this.value.toUpperCase();">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="campo4" class="col-sm-2 col-form-label">Hora:</label>
                        <div class="col-sm-10">
                        <input type="text" id="campo4" name="campo4" required oninput="this.value = this.value.toUpperCase();">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="campo5" class="col-sm-2 col-form-label">Área:</label>
                        <div class="col-sm-10">
                            <select id="campo5" name="campo5" required>
                                <?php
                                // Usar la variable $areas para rellenar el select
                                foreach ($listaAreas as $reg) {
                                    $selected = ($reg['cod_area'] == $evento['cod_area']) ? 'selected' : '';
                                    echo '<option value="' . $reg['cod_area'] . '">' . $reg['nombre'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                </div>

                <br>
                <button type="submit" class="btn btn-primary" style="background-color: #68141C;position: relative;left: 42%; width:100px;bottom:10px" name="btnGuardar" value="ok">Guardar</button>
            </div>
        </div>
    </div>
</form>

<!-- Modal para agregar eventos -->
<form method="POST" action="../controlador/evento_controlador.php?op=4">
    <div class="modal" id="modalAgregarEvento">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="position: relative;left: 25%; font-size: 28px;">AGREGAR EVENTO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="campo1" class="col-sm-2 col-form-label">Código:</label>
                        <div class="col-sm-10">
                        <input type="text" id="campo1" name="campo1" placeholder="Código del Área" required oninput="this.value = this.value.toUpperCase();">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="campo2" class="col-sm-2 col-form-label">Nombre:</label>
                        <div class="col-sm-10">
                        <input type="text" id="campo2" name="campo2" placeholder="Nombre del área" required oninput="this.value = this.value.toUpperCase();">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="campo3" class="col-sm-2 col-form-label">Lugar:</label>
                        <div class="col-sm-10">
                        <input type="text" id="campo3" name="campo3" placeholder="FISI" required oninput="this.value = this.value.toUpperCase();">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="campo4" class="col-sm-2 col-form-label">Hora:</label>
                        <div class="col-sm-10">
                        <input type="text" id="campo4" name="campo4" placeholder="00:00:00" required oninput="this.value = this.value.toUpperCase();">
                        </div>
                    </div>

                    <div class="form-group row">
                            <label for="campo5" class="col-sm-2 col-form-label">Área:</label>
                            <div class="col-sm-10">
                                <select id="campo5" name="campo5" required>
                                <?php
                                // Usar la variable $listaAreas para rellenar el select
                                foreach ($listaAreas as $reg) {
                                    echo '<option value="' . $reg['cod_area'] . '">' . $reg['nombre'] . '</option>';
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                </div>
                
                
                <br>
                <button type="submit" class="btn btn-primary" style="background-color: #68141C;position: relative;left: 42%; width:100px;bottom:10px" name="btnagregar" value="ok">Listo</button>
            </div>
        </div>
    </div>
</form>

<footer>
</footer>
</body>
</html>
