<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

session_start(); // me permite iniciar una sesión
require_once "../../util/ConexionBD.php";
require_once '../../dao/EventoDao.php';
require_once '../../bean/EventoBean.php';
require_once '../../dao/AreaDao.php';

$op = $_REQUEST['op'];

switch ($op) {
    case 1: // Mostrar eventos
        $objEventoDao = new EventoDao();
        $lista = $objEventoDao->ListarEventos();
        $_SESSION['LISTA'] = $lista; // Estoy guardado en sesión
        header('Location:../vista/frm_eventos.php');

        
        // Obtener la lista de áreas disponibles y guardarla en la sesión
        $objAreaDao = new AreaDao();
        $listaAreas = $objAreaDao->ListarAreas();
        $_SESSION['LISTA_AREAS'] = $listaAreas;

        header('Location:../vista/frm_eventos.php');
        break;
        break;

    case 2: // Eliminar lógicamente
        if (isset($_POST["cod_evento"])) {
            $codigo = $_POST["cod_evento"]; // Obtén el código del evento a eliminar
            $objEventoDao = new EventoDao();

            // Llama a un método en EventoDao para eliminar el evento
            $res = $objEventoDao->EliminarEvento($codigo);

            if ($res) {
                $response["estado"] = "Evento eliminado lógicamente correctamente";
            } else {
                $response["estado"] = "Error al eliminar el evento";
            }

            echo json_encode($response);

            // Redirige a la página frm_eventos.php
            $lista = $objEventoDao->ListarEventos();
            $_SESSION['LISTA'] = $lista;
            header('Location:../vista/frm_eventos.php');
        } else {
            echo json_encode(["estado" => "Código de evento no proporcionado"]);
        }
        break;

    case 3: // Editar evento
        if (isset($_POST["campo1"]) && isset($_POST["campo2"]) && isset($_POST["campo3"]) && isset($_POST["campo4"])) {
            $codigo = $_POST["campo1"];
            $nombre = $_POST["campo2"];
            $detalle = $_POST["campo3"];
            $hora = $_POST["campo4"];
            $cod_area = $_POST["campo5"]; // Código del área seleccionada

            $objEventoBean = new EventoBean();
            $objEventoBean->setCod_evento($codigo);
            $objEventoBean->setNombre($nombre);
            $objEventoBean->setDetalle($detalle);
            $objEventoBean->setHora($hora);
            $objEventoBean->setCod_area($cod_area); // Asignar el código del área al evento

            $objEventoDao = new EventoDao();
            $res = $objEventoDao->EditarEvento($objEventoBean);

            if ($res) {
                $response["estado"] = "Evento editado correctamente";
            } else {
                $response["estado"] = "Error al editar el evento";
            }

            echo json_encode($response);

            // Redirige a la página frm_eventos.php
            $lista = $objEventoDao->ListarEventos();
            $_SESSION['LISTA'] = $lista; // Estoy guardado en sesión
            header('Location:../vista/frm_eventos.php');
        } else {
            echo json_encode(["estado" => "Datos incompletos para editar el evento"]);
        }
        break;

    case 4: // Agregar un evento
        if (isset($_POST["campo1"]) && isset($_POST["campo2"]) && isset($_POST["campo3"]) && isset($_POST["campo4"])) {
            $codigo = $_POST["campo1"];
            $nombre = $_POST["campo2"];
            $detalle = $_POST["campo3"];
            $hora = $_POST["campo4"];
            $cod_area = $_POST["campo5"]; 

            $objEventoBean = new EventoBean();
            $objEventoBean->setCod_evento($codigo);
            $objEventoBean->setNombre($nombre);
            $objEventoBean->setDetalle($detalle);
            $objEventoBean->setHora($hora);
            $objEventoBean->setCod_area($cod_area);

            $objEventoDao = new EventoDao();
            $res = $objEventoDao->AgregarEventos($objEventoBean);

            if ($res) {
                $response["estado"] = "Evento agregado correctamente";
            } else {
                $response["estado"] = "Error al agregar el evento";
            }

            echo json_encode($response);

            // Redirige a la página frm_eventos.php
            $lista = $objEventoDao->ListarEventos();
            $_SESSION['LISTA'] = $lista; // Estoy guardado en sesión
            header('Location:../vista/frm_eventos.php');
        } else {
            echo json_encode(["estado" => "Datos incompletos para agregar el evento"]);
        }
        break;

    case 5:{ // Listar códigos de eventos
        $objEventoDao = new EventoDao();
        $lista1 = $objEventoDao->ListarCod();
        $_SESSION['LISTA1'] = $lista1; // Estoy guardado en sesión
        header('Location:../vista/frm_eventos.php');
        break;
    //END POINT LISTAR AREAS
    }
    //Devuelve todos los datos de un Evento
    case 6:{
        $objEventoDao = new EventoDao();
        $lista = $objEventoDao->ListarEventos();
        echo json_encode($lista);
        break;
    }
    
    //DATOS DE UN AREA POR SU CODIGO
    case 7:{
        $cod_evento=$_GET["cod_evento"]; 
        $objEventoDao = new EventoDao();
        $lista = $objEventoDao->infoEvento($cod_evento);
        echo json_encode($lista);
        break;
    }

    //Mostrar todos los eventos que se desarrollan en un area
    case 8:{
        $cod_area=$_GET["cod_area"]; 
        $objEventoDao = new EventoDao();
        $lista = $objEventoDao->eventoDeArea($cod_area);
        echo json_encode($lista);
        break;
    }
}


?>
