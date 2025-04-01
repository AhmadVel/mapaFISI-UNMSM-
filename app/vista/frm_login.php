<?php 
 session_start();// la sesion se esta manteniendo activa
 //$lista=$_SESSION['LISTA'];
 require_once '../../dao/AreaDao.php';
 require_once '../../dao/EventoDao.php';
 require_once '../../util/ConexionBD.php';

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="../../public/css/estilo_login.css">
    <!--Agregar BootStrap al proyecto (CSS)-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />

    <script>
        
    function mostrarinfo()
    {
        window.location.href = "../controlador/evento_controlador.php?op=1";      

    }
    </script>
    </head>

<body style="background-color: #FFF7E7;";>


    <!--Parte superior de la página -->
    <header>
        <div id="cabecera">
            <img src="../../public/img/unmsm.png" alt="Logo de san marquitos">
            <h3>Mapa UNMSM</h3>
        </div>
    </header>


     <!-- Login -->
     <div class="container_">
        <!--<form action="procesar_login.php" method="post">-->
        <form action="../../dao/LoginDao.php" method="post">

            <img src="../../public/img/unmsm.png" alt="Imagen UNMSM">
            <div>
                <label for="usuario">Usuario:</label> <br>
                <input type="text" id="usuario" name="usuario" placeholder="Administrador" required>
            </div>
            <div>
                <label for="contrasena">Contraseña:</label> <br>
                <input type="password" id="contrasena" name="contrasena" placeholder="********"  required>
            </div>
            <div class="recor">
                <input type="checkbox" id="recordar" name="recordar">
                <span for="recordar">Recordar cuenta</span>
            </div>
            <div>

            <input type="submit" value="Entrar" id="btn_enviar">
            <!--<input type="submit" value="Entrar" id="btn_enviar" >-->  
            </div>
        </form>        
     </div>
     <script src="../../public/js/login.js"></script>
</body>
<script type="text/javascript" src="../../public/js/mapa_config.js"></script> 


</html>