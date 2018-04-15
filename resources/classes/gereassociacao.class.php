<?php
require_once('./resources/classes/basededados.class.php');
require_once('./resources/classes/associacao.class.php');

class GereAssociacao {
  private $listaassoc = [];


  public function inserir_associacao(Associacao $associacao) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("INSERT INTO associacao(U_ID, N_ID,A_ABREVIATURA) values(?, ?, ?)");
    $STH->bindValue(1, $associacao->get_userid());
    $STH->bindValue(2, $associacao->get_nutsid());
    $STH->bindValue(3, $associacao->get_abreviatura());
    $res = $STH->execute();
    $bd->desligar_bd();
    return $res;
  }

  public function associacao_existe($assoc) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM associacao WHERE A_ABREVIATURA LIKE '$assoc'");
    if($STH->rowCount() === 0){
      return false;
    }else{
      return true;
    }

  }

  public function obter_todas_assoc() {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM associacao");
    if($STH->rowCount() === 0){
      return null;
    }else{
      while($row = $STH->fetch(PDO::FETCH_NUM)){
        $this->listaassoc[] = new Associacao($row[0], $row[1],$row[2],$row[3]);
      }
      $bd->desligar_bd();
      return $this->listaassoc;
    }

  }



  /*public function editar_associacao(Associacao $associacao) {
  $bd = new BaseDados();
  $bd->ligar_bd();
  $STH = $bd->dbh->prepare("UPDATE associacao SET U_NOME = ?, U_EMAIL = ?, U_PASS = ?, U_CONTACTO = ? WHERE U_ID = ?");
  $STH->bindValue(1, $utilizador->get_nome());
  $STH->bindValue(2, $utilizador->get_email());
  $STH->bindValue(3, $utilizador->get_password());
  $STH->bindValue(4, $utilizador->get_contacto());
  $STH->bindValue(5, $utilizador->get_id());
  $res = $STH->execute();
  $bd->desligar_bd();
  return $res;
}*/

}