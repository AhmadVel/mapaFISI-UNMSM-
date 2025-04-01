<?php
//require "../util/ConexionBD.php";
//require '../bean/AreaBean.php';

class AreaDao
{
    public function ListarAreas()
    {
        try {
            //$sql = "SELECT cod_area, nombre, abreviatura, descripcion2, descripcion, tipo, estado FROM areas";
            $sql = "SELECT * FROM areas";
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
    //devuelve la lista pero con salto de linea
    public function ListAreas()
    {
        try {
            $sql = "SELECT cod_area, nombre, abreviatura, descripcion2, descripcion, tipo, estado FROM areas";
            //$sql = "SELECT * FROM areas";
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


    //devuelve la lista de areas de un tipo en especifico
    public function ListAreasTipo($tipo_area)
    {
        try {
            $sql = "SELECT cod_area, nombre, abreviatura, descripcion2, descripcion, tipo, estado FROM areas WHERE tipo = '$tipo_area'";
            //$sql = "SELECT * FROM areas";
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


    public function AreaImagen($cod_area)
{
    try {
        $sql = "SELECT imagen FROM areas WHERE cod_area = '$cod_area'";
        $objc = new ConexionBD();
        $cn = $objc->getConexionBD();
        $rs = mysqli_query($cn, $sql);

        if ($fila = mysqli_fetch_assoc($rs)) {
            $imagen = $fila['imagen'];
        } else {
            $imagen = null;
        }
        mysqli_close($cn);
    } catch (Exception $e) {
        // Manejo de errores
        $imagen = null;
    }
    return $imagen;
}

    public function EliminarAreas($cod_area)
    {
        $objc = new ConexionBD();
        $cn = $objc->getConexionBD();

        $sql = "DELETE FROM areas WHERE cod_area = '$cod_area'";

        $res = mysqli_query($cn, $sql);

        mysqli_close($cn);

        return $res;
    }



public function EditarAreas($objAreaBean)
{
    // Obtiene los valores del objeto AreaBean
    $codigo = $objAreaBean->getCod_area();
    $nombre = $objAreaBean->getNombre();
    $abreviatura = $objAreaBean->getAbreviatura();
    $descripcion2 = $objAreaBean->getDescripcion2();
    $descripcion = $objAreaBean->getDescripcion();
    $tipo = $objAreaBean->getTipo(); // Obtener el tipo de área del objeto
    $estado = "A";
    echo "Tipo recibido en DAO: " . $tipo . "<br>";

    // Verificar si se subió una nueva imagen
    if ($_FILES['campo7']['tmp_name'] != '') {
        $imagen = addslashes(file_get_contents($_FILES['campo7']['tmp_name'])); // Obtener la imagen en binario
        // Construye y ejecuta la consulta SQL para actualizar el área con nueva imagen en la base de datos
        $sql = "UPDATE areas 
                SET nombre = '$nombre', abreviatura = '$abreviatura',
                descripcion2 = '$descripcion2' , descripcion = '$descripcion',
                imagen = '$imagen', tipo = '$tipo', estado = '$estado'
                WHERE cod_area = '$codigo'";
    } else {
        // Construye y ejecuta la consulta SQL para actualizar el área sin cambiar la imagen
        $sql = "UPDATE areas 
                SET nombre = '$nombre', abreviatura = '$abreviatura',
                descripcion2 = '$descripcion2' , descripcion = '$descripcion',
                tipo = '$tipo', estado = '$estado'
                WHERE cod_area = '$codigo'";
    }

    // Utiliza la instancia de ConexionBD que ya tienes
    $objc = new ConexionBD();
    $cn = $objc->getConexionBD();

    // Ejecuta la consulta SQL
    $res = mysqli_query($cn, $sql);

    // Cierra la conexión
    mysqli_close($cn);

    // Devuelve el resultado de la ejecución (true o false, por ejemplo)
    return $res;
}



public function AgregarAreas($objAreaBean)
{
    // Obtiene los valores del objeto AreaBean
    $codigo = $objAreaBean->getCod_area();
    $nombre = $objAreaBean->getNombre();
    $abreviatura = $objAreaBean->getAbreviatura();
    $descripcion2 = $objAreaBean->getDescripcion2();
    $descripcion = $objAreaBean->getDescripcion();
    $tipo = $objAreaBean->getTipo();
    $estado = "A";

    // Obtener la imagen en binario
    $imagen = addslashes(file_get_contents($_FILES['campo6']['tmp_name']));

    // Utiliza la instancia de ConexionBD que ya tienes
    $objc = new ConexionBD();
    $cn = $objc->getConexionBD();

    // Construye y ejecuta la consulta SQL para insertar el área con imagen en la base de datos
    $sql = "INSERT INTO areas (cod_area, nombre, abreviatura, descripcion2, descripcion, imagen, tipo, estado) 
            VALUES ('$codigo', '$nombre', '$abreviatura', '$descripcion2', '$descripcion', '$imagen', '$tipo', '$estado')";

    // Ejecuta la consulta SQL
    $res = mysqli_query($cn, $sql);

    // Cierra la conexión
    mysqli_close($cn);

    // Devuelve el resultado de la ejecución (true o false, por ejemplo)
    return $res;
}

    public function infoArea($cod_area)
    {
        try {
            $sql = "SELECT cod_area, nombre, abreviatura, descripcion2, descripcion, tipo, estado FROM areas WHERE cod_area = '$cod_area'";
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
