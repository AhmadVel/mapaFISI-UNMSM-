<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

session_start(); // Me permite iniciar una sesión
require_once "../../util/ConexionBD.php";
require_once '../../dao/AreaDao.php';
require_once '../../bean/AreaBean.php';

$op = $_REQUEST['op'];

switch ($op) {
    case 1: { // Mostrar
            $objAreaDao = new AreaDao();
            $lista = $objAreaDao->ListarAreas();
            $_SESSION['LISTA'] = $lista; // Estoy guardado en sesión;
            header('Location:../vista/frm_areas.php');

            break;
        }

    case 2: { // Eliminar
            $objAreaDao = new AreaDao();

            $codArea = $_POST["cod_area"]; // Obtén el código del área a eliminar

            // Llama a un método en AreaDao para eliminar el área
            $res = $objAreaDao->EliminarAreas($codArea);

            if ($res) {
                $response["estado"] = "Área eliminada correctamente";
            } else {
                $response["estado"] = "Error al eliminar el área";
            }

            echo json_encode($response);

            // Redirige a la página frm_areas.php
            $objAreaDao = new AreaDao();
            $lista = $objAreaDao->ListarAreas();
            $_SESSION['LISTA'] = $lista;
            header('Location:../vista/frm_areas.php');
            break;
        }

        case 3: { // Editar
            $objAreaDao = new AreaDao();
        
            $codigo = $_POST["campo1"];
            $nombre = $_POST["campo2"];
            $abreviatura = $_POST["campo3"];
            $descripcion2 = $_POST["campo5"];
            $descripcion = $_POST["campo4"];

            $tipoArea = $_POST["tipoArea"]; // Obtener el tipo de área seleccionado desde el formulario
            echo "Tipo de área seleccionado: " . $tipoArea . "<br>";

    // Ajustar el valor de $tipo según el tipo de área seleccionado
    switch ($tipoArea) {
        case 'Facultad':
            $tipo = 'FAC';
            break;
        case 'Servicio':
            $tipo = 'SER';
            break;
        case 'Exterior':
            $tipo = 'EXT';
            break;
        case 'Interior':
            $tipo = 'INT';
            break;
        case 'Otros':
            $tipo = 'OTR';
            break;
        default:
            $tipo = 'OTR'; // Opción por defecto en caso de error
            break;
    }
        
            $objAreaBean = new AreaBean();
            $objAreaBean->setCod_area($codigo);
            $objAreaBean->setNombre($nombre);
            $objAreaBean->setAbreviatura($abreviatura);
            $objAreaBean->setDescripcion2($descripcion2);
            $objAreaBean->setDescripcion($descripcion);
            $objAreaBean->setTipo($tipo); // Asignar el tipo de área al objeto
        
            // Verificar si se subió una nueva imagen
            if ($_FILES['campo7']['tmp_name'] != '') {
                $objAreaBean->setImagen(file_get_contents($_FILES['campo7']['tmp_name']));
            }
        
            $res = $objAreaDao->EditarAreas($objAreaBean);
            $response["estado"] = $res;
            echo json_encode($response);
        
            $objAreaDao = new AreaDao();
            $lista = $objAreaDao->ListarAreas();
            $_SESSION['LISTA'] = $lista; // Estoy guardando en la sesión;
            header('Location:../vista/frm_areas.php');
        
            break;
        }
        

        case 4: { // Agregar
            $objAreaDao = new AreaDao();
        
            $codigo = $_POST["campo1"];
            $nombre = $_POST["campo2"];
            $abreviatura = $_POST["campo3"];
            $descripcion2 = $_POST["campo5"];
            $descripcion = $_POST["campo4"];

            $tipoArea = $_POST["tipoArea"]; // Obtener el tipo de área seleccionado desde el formulario

    // Ajustar el valor de $tipo según el tipo de área seleccionado
    switch ($tipoArea) {
        case 'Facultad':
            $tipo = 'FAC';
            break;
        case 'Servicio':
            $tipo = 'SER';
            break;
        case 'Exterior':
            $tipo = 'EXT';
            break;
        case 'Interior':
            $tipo = 'INT';
            break;
        case 'Otros':
            $tipo = 'OTR';
            break;
        default:
            $tipo = 'OTR'; // Opción por defecto en caso de error
            break;
    }
        
            $objAreaBean = new AreaBean();
            $objAreaBean->setCod_area($codigo);
            $objAreaBean->setNombre($nombre);
            $objAreaBean->setAbreviatura($abreviatura);
            $objAreaBean->setDescripcion($descripcion);
            $objAreaBean->setDescripcion2($descripcion2);
            $objAreaBean->setTipo($tipo); // Asignar el tipo de área al objeto
            $objAreaBean->setImagen(file_get_contents($_FILES['campo6']['tmp_name'])); // Asignar la imagen usando setImagen()
        
            $res = $objAreaDao->AgregarAreas($objAreaBean);
            $response["estado"] = $res;
            echo json_encode($response);
        
            $objAreaDao = new AreaDao();
            $lista = $objAreaDao->ListarAreas();
            $_SESSION['LISTA'] = $lista; // Guardar en sesión
        
            // Redirigir a la página frm_areas.php
            header('Location:../vista/frm_areas.php');
            break;
        }
        
        

    case 5: { // Mostrar personas
            $objAreaDao = new AreaDao();
            $lista = $objAreaDao->ListarPersonas();
            $_SESSION['LISTA'] = $lista; // Estoy guardado en sesión;
            header('Location:../vista/frm_mapa.php');
            break;
        }
    
    //END POINT LISTAR AREAS
    case 6:{
        $objAreaDao = new AreaDao();
        $lista = $objAreaDao->ListAreas();
        echo json_encode($lista);
        break;
    }

    case 7:{
        $cod_area=$_GET["cod_area"]; 
        $objAreaDao = new AreaDao();
        $lista = $objAreaDao->infoArea($cod_area);
        echo json_encode($lista);
        break;
    }

    //END POINT QUE DEBUELVE UNA IMAGEN
    case 8: {
        $cod_area = $_GET["cod_area"];
        $objAreaDao = new AreaDao();
        $imagen = $objAreaDao->AreaImagen($cod_area);
    
        if ($imagen) {
            // Enviar encabezados HTTP adecuados
            header("Content-Type: image/jpeg"); // Cambia esto si tus imágenes no son JPEG
            echo $imagen;
        } else {
            http_response_code(404);
            echo "Imagen no encontrada";
        }
        break;
    }

    case 9:{
        $tipo_area=$_GET["tipo_area"]; 
        $objAreaDao = new AreaDao();
        $lista = $objAreaDao->ListAreasTipo($tipo_area);
        echo json_encode($lista);
        break;
    }
}
?>
