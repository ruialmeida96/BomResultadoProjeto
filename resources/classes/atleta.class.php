<?php
class Atleta {
  private $id, $clubeid, $nome, $nomeexibe, $contacto, $email, $especialidade, $nacionalidade,$escalao,$sexo;

  public function __construct($id, $clube, $name, $exibe ,$contact,$mail, $espec, $nacio, $escal,$sex) {
    $this->id = $id;
    $this->clubeid = $clube;
    $this->nome = $name;
    $this->nomeexibe = $exibe;
    $this->contacto = $contact;
    $this->email = $mail;
    $this->especialidade = $espec;
    $this->nacionalidade = $nacio;
    $this->escalao = $escal;
    $this->sexo = $sex;
  }

  public function get_id() {
    return $this->id;
  }

  public function get_clube() {
    return $this->clubeid;
  }

  public function get_nome() {
    return $this->nome;
  }

  public function get_nomeexibe() {
    return $this->nomeexibe;
  }

  public function get_contacto() {
    return $this->contacto;
  }

  public function get_email() {
    return $this->email;
  }

  public function get_especialidade() {
    return $this->especialidade;
  }

  public function get_nacionalidade() {
    return $this->nacionalidade;
  }

  public function get_escalao() {
    return $this->escalao;
  }
  public function get_sexo() {
    return $this->sexo;
  }

}
?>
