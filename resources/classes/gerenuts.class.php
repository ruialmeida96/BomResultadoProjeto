<?php
require_once('./resources/classes/basededados.class.php');
require_once('./resources/classes/nuts.class.php');

class GereNuts {
  private $listanuts = [];


  public function inserir_nuts(Nuts $nut) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("INSERT INTO nuts2 (N_REGIAO) values(?)");
    $STH->bindValue(1, $nut->get_regiao());
    $res = $STH->execute();
    $bd->desligar_bd();
    return $res;
  }

  /*public function editar_nuts(Nuts $nut) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("UPDATE nuts2 SET N_REGIAO = ? WHERE N_ID = ?");
    $STH->bindValue(1, $nut->get_regiao());
    $STH->bindValue(2, $nut->get_id());
    $res = $STH->execute();
    $bd->desligar_bd();
    return $res;
  }*/

  public function regiao_existe($regiao) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM nuts2 WHERE N_REGIAO LIKE '$regiao'");
    if($STH->rowCount() === 0){
      return false;
    }else{
      return true;
    }

  }

  /*public function regiao_existe($regiao) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("SELECT * FROM nuts2 WHERE N_REGIAO LIKE ?");
    $STH->bindParam(1, $regiao);
    $STH->execute();
    $bd->desligar_bd();
    return $STH->fetch(PDO::FETCH_ASSOC);
  }*/

  public function obter_todos_nuts() {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM nuts2");
    if($STH->rowCount() === 0){
      return null;
    }
    while($row = $STH->fetch(PDO::FETCH_NUM)){
      $this->listanuts[] = new Nuts($row[0], $row[1]);
    }
    $bd->desligar_bd();
    return $this->listanuts;
  }

}
