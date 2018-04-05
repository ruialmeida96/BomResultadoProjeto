<?php

class Utilizador {
  private $id, $nome, $email, $password, $contacto, $estado,$tipo;

  public function __construct($id, $nome, $email, $password, $contacto, $estado, $tipo) {
    $this->id = $id;
    $this->nome = $nome;
    $this->email = $email;
    $this->password = $password;
    $this->contacto = $contacto;
    $this->estado = $estado;
    $this->tipo = $tipo;
  }

  public function get_id() {
    return $this->id;
  }

  public function get_nome() {
    return $this->nome;
  }

  public function get_email() {
    return $this->email;
  }

  public function get_password() {
    return $this->password;
  }

  public function get_contacto() {
    return $this->contacto;
  }

  public function get_estado() {
    return $this->estado;
  }

  public function get_tipo() {
    return $this->tipo;
  }
}
?>
