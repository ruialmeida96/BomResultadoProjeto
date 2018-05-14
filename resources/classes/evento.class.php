<?php

class Evento {
  private $id,$associd, $nome, $data, $dias,$tipo,$local,$detalhes,$organizadores,$estado;

  public function __construct($id, $assoc, $name,$date, $days,$type,$localiz,$details,$owns,$state) {
    $this->id = $id;
    $this->associd = $assoc;
    $this->nome = $name;
    $this->data = $date;
    $this->dias = $days;
    $this->tipo = $type;
    $this->local = $localiz;
    $this->detalhes = $details;
    $this->organizadores = $owns;
    $this->estado = $state;
  }

  public function get_id() {
    return $this->id;
  }

  public function get_associd() {
    return $this->associd;
  }

  public function get_nome() {
    return $this->nome;
  }

  public function get_data() {
    return $this->data;
  }

  public function get_dias() {
    return $this->dias;
  }

  public function get_tipo() {
    return $this->tipo;
  }

  public function get_local() {
    return $this->local;
  }

  public function get_detalhes() {
    return $this->detalhes;
  }

  public function get_organizadores() {
    return $this->organizadores;
  }

  public function get_estado() {
    return $this->estado;
  }

}
?>
