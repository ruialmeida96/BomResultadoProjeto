<?php

class Clube {
  private $id, $associd, $userid, $abreviatura,$localizacao;

  public function __construct($id, $assoc, $user, $abrev,$local) {
    $this->id = $id;
    $this->associd = $assoc;
    $this->userid = $user;
    $this->abreviatura = $abrev;
    $this->localizacao = $local;
  }

  public function get_id() {
    return $this->id;
  }

  public function get_associd() {
    return $this->associd;
  }

  public function get_userid() {
    return $this->userid;
  }

  public function get_abreviatura() {
    return $this->abreviatura;
  }

  public function get_localizacao() {
    return $this->localizacao;
  }

}
?>
