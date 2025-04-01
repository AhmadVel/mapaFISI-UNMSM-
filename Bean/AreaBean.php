<?php

class AreaBean {
    public $cod_area;
    public $nombre;
    public $abreviatura;
    public $descripcion;
    public $descripcion2;
    public $tipo;
    public $estado;
    //public $escuelas;
    private $imagen;

    // Getters
    public function getCod_area() {
        return $this->cod_area;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getAbreviatura() {
        return $this->abreviatura;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getDescripcion2() {
        return $this->descripcion2;
    }
    
    public function getTipo() {
        return $this->tipo;
    }

    public function getEstado() {
        return $this->estado;
    }

    // Setters
    public function setCod_area($cod_area) {
        $this->cod_area = $cod_area;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setAbreviatura($abreviatura) {
        $this->abreviatura = $abreviatura;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion=$descripcion;
    }

    public function setDescripcion2($descripcion2) {
        $this->descripcion2=$descripcion2;
    }
    
    public function setTipo($tipo) {
        $this->tipo=$tipo;
    }

    public function setEstado($estado) {
        $this->estado=$estado;
    }

    // Getter y setter para la imagen
    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }
    
}
?>
