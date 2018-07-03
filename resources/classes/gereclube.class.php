<?php
require_once('./resources/classes/basededados.class.php');
require_once('./resources/classes/clube.class.php');

class GereClube {
  private $listaclubes = [];


  public function inserir_clube(Clube $clube) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("INSERT INTO clube(A_ID, U_ID,C_ABREVIATURA,C_LOCALIZACAO) values(?, ?, ?,?)");
    $STH->bindValue(1, $clube->get_associd());
    $STH->bindValue(2, $clube->get_userid());
    $STH->bindValue(3, $clube->get_abreviatura());
    $STH->bindValue(4, $clube->get_localizacao());
    $res = $STH->execute();
    $bd->desligar_bd();
    return $res;
  }

  public function elimina_clube($idclube,$iduser) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("DELETE FROM clube WHERE C_ID = '$idclube';");
    $res = $STH->execute();
    $STH = $bd->dbh->prepare("DELETE FROM utilizador WHERE U_ID = '$iduser';");
    $res = $STH->execute();
    $bd->desligar_bd();
    return $res;
  }

  public function obter_todas_clubes() {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM clube");
    if($STH->rowCount() === 0){
      return null;
    }else{
      while($row = $STH->fetch(PDO::FETCH_NUM)){
        $this->listaclubes[] = new Clube($row[0], $row[1],$row[2],$row[3],$row[4]);
      }
      $bd->desligar_bd();
      return $this->listaclubes;
    }
  }

  public function obter_todas_clubes_apartir_da_associd($id) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM clube WHERE A_ID = '$id';");
    if($STH->rowCount() === 0){
      return null;
    }else{
      while($row = $STH->fetch(PDO::FETCH_NUM)){
        $this->listaclubes[] = new Clube($row[0], $row[1],$row[2],$row[3],$row[4]);
      }
      $bd->desligar_bd();
      return $this->listaclubes;
    }
  }



  public function clube_existe($clube) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM clube WHERE C_ABREVIATURA LIKE '$clube'");
    if($STH->rowCount() === 0){
      return false;
    }else{
      return true;
    }
  }

  public function obter_iduser_apartir_idclube($id) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("SELECT U_ID FROM clube WHERE C_ID = '$id';");
    $STH->execute();
    $bd->desligar_bd();
    $row = $STH->fetch(PDO::FETCH_NUM);
    return $row[0];
  }

  public function editar_clube_assoc($abreviatura,$local,$idclube) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("UPDATE clube SET C_ABREVIATURA = '$abreviatura',C_LOCALIZACAO = '$local' WHERE C_ID = $idclube;");
    $res = $STH->execute();
    $bd->desligar_bd();
    return $res;
  }

  public function obter_detalhes_clube_id($id) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("SELECT * FROM clube WHERE C_ID = ?");
    $STH->bindParam(1,$id);
    $STH->execute();
    $bd->desligar_bd();
    $row = $STH->fetch(PDO::FETCH_NUM);
    return new Clube($row[0], $row[1], $row[2], $row[3], $row[4]);
  }

  public function obter_clube_id_clube_userid($id) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("SELECT C_ID FROM clube WHERE U_ID = '$id';");
    $STH->execute();
    $bd->desligar_bd();
    $row = $STH->fetch(PDO::FETCH_NUM);
    return $row[0];
  }

  public function obter_detalhes_clube_userid($id) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("SELECT * FROM clube WHERE U_ID = ?");
    $STH->bindParam(1,$id);
    $STH->execute();
    $bd->desligar_bd();
    $row = $STH->fetch(PDO::FETCH_NUM);
    return new Clube($row[0], $row[1], $row[2], $row[3], $row[4]);
  }


  public function obter_nome_apartir_id($id) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("SELECT C_ABREVIATURA FROM clube WHERE C_ID = ?");
    $STH->bindParam(1,$id);
    $STH->execute();
    $bd->desligar_bd();
    $row = $STH->fetch(PDO::FETCH_NUM);
    return $row[0];
  }

}
?>
