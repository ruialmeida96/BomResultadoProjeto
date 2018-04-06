<?php

class Nuts {
  private $id, $regiao;

  public function __construct($id, $regiao) {
    $this->id = $id;
    $this->regiao = $regiao;
  }

  public function get_id() {
    return $this->id;
  }

  public function get_regiao() {
    return $this->regiao;
  }

}
?>
