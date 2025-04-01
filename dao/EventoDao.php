<?php
//require "../util/ConexionBD.php";
//require '../bean/EventoBean.php';

class EventoDao
{
    public function ListarEventos()
    {
        try {
            $sql = "SELECT * FROM eventos";
            $objc = new ConexionBD();
            $cn = $objc->getConexionBD();
            $rs = mysqli_query($cn, $sql);

            $lista = array();
            while ($fila = mysqli_fetch_assoc($rs)) {
                $lista[] = $fila;
            }
            mysqli_close($cn);
        } catch (Exception $e) {
            // Manejo de errores
        }
        return $lista;
    }


    public function EliminarEvento($cod_evento)
    {
        $objc = new ConexionBD();
        $cn = $objc->getConexionBD();

        $sql = "DELETE FROM eventos WHERE cod_evento = '$cod_evento'";

        $res = mysqli_query($cn, $sql);

        mysqli_close($cn);

        return $res;
    }

    public function EditarEvento($objEventoBean)
    {
        // Obtiene los valores del objeto EventoBean
        $codigo = $objEventoBean->getCod_evento();
        $nombre = $objEventoBean->getNombre();
        $detalle = $objEventoBean->getDetalle();
        $hora = $objEventoBean->getHora();
        $cod_area = $objEventoBean->getCod_area();

        // Utiliza la instancia de ConexionBD que ya tienes
        $objc = new ConexionBD();
        $cn = $objc->getConexionBD();

        // Construye y ejecuta la consulta SQL para actualizar el evento en la base de datos
        $sql = "UPDATE eventos 
                SET nombre = '$nombre', detalle = '$detalle', hora = '$hora', cod_area = '$cod_area'
                WHERE cod_evento = '$codigo'";

        // Ejecuta la consulta SQL
        $res = mysqli_query($cn, $sql);

        // Cierra la conexión
        mysqli_close($cn);
        // Devuelve el resultado de la ejecución (true o false, por ejemplo)
        return $res;
    }

    public function AgregarEventos($objEventoBean)
    {
        // Obtiene los valores del objeto EventoBean
        $codigo = $objEventoBean->getCod_evento();
        $nombre = $objEventoBean->getNombre();
        $detalle = $objEventoBean->getDetalle();
        $hora = $objEventoBean->getHora();
        $cod_area = $objEventoBean->getCod_area(); // Obtener el código del área del objeto EventoBean
    
        // Utiliza la instancia de ConexionBD que ya tienes
        $objc = new ConexionBD();
        $cn = $objc->getConexionBD();
    
        // Construye y ejecuta la consulta SQL para insertar el evento en la base de datos
        $sql = "INSERT INTO eventos (cod_evento, nombre, detalle, hora, cod_area) 
                VALUES ('$codigo', '$nombre', '$detalle', '$hora', '$cod_area')";
    
        // Ejecuta la consulta SQL
        $res = mysqli_query($cn, $sql);
    
        // Cierra la conexión
        mysqli_close($cn);
    
        // Devuelve el resultado de la ejecución (true o false, por ejemplo)
        return $res;
    }
    

    public function infoEvento($cod_evento)
    {
        try {
            $sql = "SELECT * FROM eventos WHERE cod_evento = '$cod_evento'";
            $objc = new ConexionBD();
            $cn = $objc->getConexionBD();
            $rs = mysqli_query($cn, $sql);

            $lista = array();
            while ($fila = mysqli_fetch_assoc($rs)) {
                $lista[] = $fila;
            }
            mysqli_close($cn);
        } catch (Exception $e) {
            // Manejo de errores
        }
        return $lista;
    }

    public function eventoDeArea($cod_area)
    {
        try {
            $sql = "SELECT * FROM eventos WHERE cod_area = '$cod_area'";
            $objc = new ConexionBD();
            $cn = $objc->getConexionBD();
            $rs = mysqli_query($cn, $sql);

            $lista = array();
            while ($fila = mysqli_fetch_assoc($rs)) {
                $lista[] = $fila;
            }
            mysqli_close($cn);
        } catch (Exception $e) {
            // Manejo de errores
        }
        return $lista;
    }
}
?>
