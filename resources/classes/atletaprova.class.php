<?php
class AtletaProva {
  private $idatleta, $idprova;

  public function __construct($atleta, $prova) {
    $this->idatleta = $atleta;
    $this->idprova = $prova;
  }

  public function get_idatleta() {
    return $this->idatleta;
  }

  public function get_idprova() {
    return $this->idprova;
  }
}
?>
