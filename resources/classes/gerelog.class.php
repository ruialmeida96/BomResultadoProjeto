<?php
require_once('./resources/classes/basededados.class.php');
require_once('./resources/classes/log.class.php');

class GereLog {
  private $listalog = [];

  public function inserir_log(Log $log) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("INSERT INTO log(L_ID,U_ID,L_DATA,L_HORA,L_DESCRICAO) values(?,?,?,?,?)");
    $STH->bindValue(1, $log->get_id());
    $STH->bindValue(2, $log->get_userid());
    $STH->bindValue(3, $log->get_data());
    $STH->bindValue(4, $log->get_hora());
    $STH->bindValue(5, $log->get_disc());
    $res = $STH->execute();
    $bd->desligar_bd();
    return $res;
  }

  public function obter_todos_logs() {
    $this->listalog=[];
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM log;");
    if($STH->rowCount() === 0){
      return null;
    }else{
      while($row = $STH->fetch(PDO::FETCH_NUM)){
        $this->listalog[] = new Log($row[0], $row[1],$row[2],$row[3],$row[4]);
      }
      $bd->desligar_bd();
      return $this->listahistorico;
    }
  }

}
?>
