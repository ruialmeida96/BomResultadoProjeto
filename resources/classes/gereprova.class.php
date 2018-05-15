<?php
require_once('./resources/classes/basededados.class.php');
require_once('./resources/classes/prova.class.php');

class GereProva {
  private $listaprova = [];

  public function inserir_prova(Prova $prova) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("INSERT INTO prova (P_ID, E_ID,P_NOME,P_ESCALAO,P_DISTANCIA,P_HORA,P_SEXO) values(?,?,?,?,?,?,?)");
    $STH->bindValue(1, $prova->get_id());
    $STH->bindValue(2, $prova->get_eventoid());
    $STH->bindValue(3, $prova->get_nome());
    $STH->bindValue(4, $prova->get_escalao());
    $STH->bindValue(5, $prova->get_distancia());
    $STH->bindValue(6, $prova->get_hora());
    $STH->bindValue(7, $prova->get_sexo());
    $res = $STH->execute();
    $bd->desligar_bd();
    return $res;
  }

}


?>
