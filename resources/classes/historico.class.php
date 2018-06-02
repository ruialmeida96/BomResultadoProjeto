<?php

class Historico {
  private $id, $provaid, $atletaid, $tempo,$local;

  public function __construct($id, $prova, $atleta, $temp,$loc) {
    $this->id = $id;
    $this->provaid = $prova;
    $this->atletaid = $atleta;
    $this->tempo = $temp;
    $this->local = $loc;
  }

  public function get_id() {
    return $this->id;
  }

  public function get_provaid() {
    return $this->provaid;
  }

  public function get_atletaid() {
    return $this->atletaid;
  }

  public function get_tempo() {
    return $this->tempo;
  }

  public function get_local() {
    return $this->local;
  }
}
?>
