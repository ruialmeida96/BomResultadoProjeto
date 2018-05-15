<?php
class Prova {
  private $id, $eventoid, $nome, $escalao, $distancia, $hora,$sexo;

  public function __construct($id, $evento, $name, $escal ,$dist,$time,$sex) {
    $this->id = $id;
    $this->eventoid = $evento;
    $this->nome = $name;
    $this->escalao = $escal;
    $this->distancia = $dist;
    $this->hora = $time;
    $this->sexo = $sex;
  }

  public function get_id() {
    return $this->id;
  }

  public function get_eventoid() {
    return $this->eventoid;
  }

  public function get_nome() {
    return $this->nome;
  }

  public function get_escalao() {
    return $this->escalao;
  }

  public function get_distancia() {
    return $this->distancia;
  }

  public function get_hora() {
    return $this->hora;
  }

  public function get_sexo() {
    return $this->sexo;
  }
}
?>
