<?php

class ConexionBD
{
  const servidor="localhost";
  const usuario="root";//usuario de su base de datos
  const password="";//coloquen la contra de su base de datos Mysql
  const basedatos="mapaunmsm";
  public $cn=null;

  public function  getConexionBD()
  {
    try {
       
        $this->cn=mysqli_connect(self::servidor,self::usuario,self::password,self::basedatos);

      } catch (Exception  $e)
     {
     }
     return $this->cn;
  }
}

?>