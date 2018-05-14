<?php
require_once('./resources/classes/basededados.class.php');
require_once('./resources/classes/evento.class.php');

class GereEvento {
  private $listaeventos = [];


  public function inserir_evento(Evento $evento){
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("INSERT INTO evento(E_ID, A_ID,E_NOME,E_DATASTART,E_DIASDURACAO,E_TIPO,E_LOCAL,E_DETALHES,E_ORGANIZADORES,E_ESTADO) values(?, ?, ?,?,?,?,?,?,?,?)");
    $STH->bindValue(1, $evento->get_id());
    $STH->bindValue(2, $evento->get_associd());
    $STH->bindValue(3, $evento->get_nome());
    $STH->bindValue(4, $evento->get_data());
    $STH->bindValue(5, $evento->get_dias());
    $STH->bindValue(6, $evento->get_tipo());
    $STH->bindValue(7, $evento->get_local());
    $STH->bindValue(8, $evento->get_detalhes());
    $STH->bindValue(9, $evento->get_organizadores());
    $STH->bindValue(10, $evento->get_estado());
    $res = $STH->execute();
    $bd->desligar_bd();
    return $res;
  }

  public function obter_ultimo_evento_assoc($id){
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("SELECT E_ID FROM evento Where A_ID = '$id' ORDER BY E_ID DESC LIMIT 1");
    $STH->bindParam(1,$id);
    $STH->execute();
    $bd->desligar_bd();
    $row = $STH->fetch(PDO::FETCH_NUM);
    return $row[0];
  }

}
?>
