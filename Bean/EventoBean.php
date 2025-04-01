<?php

class EventoBean {
    public $cod_evento;
    public $nombre;
    public $detalle;
    public $hora;
    public $cod_area;

    // Getters
    public function getCod_evento() {
        return $this->cod_evento;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDetalle() {
        return $this->detalle;
    }

    public function getHora() {
        return $this->hora;
    }

    public function getCod_area() {
        return $this->cod_area;
    }

    // Setters
    public function setCod_evento($cod_evento) {
        $this->cod_evento = $cod_evento;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDetalle($detalle) {
        $this->detalle = $detalle;
    }

    public function setHora($hora) {
        $this->hora = $hora;
    }

    public function SetCod_area($cod_area) {
        $this->cod_area = $cod_area;
    }
}
?>
