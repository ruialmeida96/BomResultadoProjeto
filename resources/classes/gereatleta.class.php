<?php
require_once('./resources/classes/basededados.class.php');
require_once('./resources/classes/atleta.class.php');

class GereAtleta {
  private $listaatleta = [];

  public function inserir_atleta(Atleta $atleta) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("INSERT INTO atleta(AT_ID, C_ID,AT_NOME,AT_NOMEEXIBE,AT_CONTACTO,AT_EMAIL,AT_ESPECIALIDADE,AT_NACIONALIDADE,AT_ESCALAO) values(?, ?, ?,?,?,?,?,?,?)");
    $STH->bindValue(1, $atleta->get_id());
    $STH->bindValue(2, $atleta->get_clube());
    $STH->bindValue(3, $atleta->get_nome());
    $STH->bindValue(4, $atleta->get_nomeexibe());
    $STH->bindValue(5, $atleta->get_contacto());
    $STH->bindValue(6, $atleta->get_email());
    $STH->bindValue(7, $atleta->get_especialidade());
    $STH->bindValue(8, $atleta->get_nacionalidade());
    $STH->bindValue(9, $atleta->get_escalao());
    $res = $STH->execute();
    $bd->desligar_bd();
    return $res;
  }

  public function obter_todos_atletas() {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM atleta");
    if($STH->rowCount() === 0){
      return null;
    }else{
      while($row = $STH->fetch(PDO::FETCH_NUM)){
        $this->listaatleta[] = new Atleta($row[0], $row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8]);
      }
      $bd->desligar_bd();
      return $this->listaatleta;
    }
  }

  public function obter_todos_atletas_do_clube($id) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM atleta WHERE C_ID = '$id';");
    if($STH->rowCount() === 0){
      return null;
    }else{
      while($row = $STH->fetch(PDO::FETCH_NUM)){
        $this->listaatleta[] = new Atleta($row[0], $row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8]);
      }
      $bd->desligar_bd();
      return $this->listaatleta;
    }
  }

  public function email_existe($email) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("SELECT 1 FROM atleta WHERE AT_EMAIL LIKE ?");
    $STH->bindParam(1, $email);
    $STH->execute();
    $bd->desligar_bd();
    return $STH->fetch(PDO::FETCH_ASSOC);
	}

  public function elimina_atleta($idatleta) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("DELETE FROM atleta WHERE AT_ID = '$idatleta';");
    $res = $STH->execute();
    $bd->desligar_bd();
    return $res;
  }

  //caso precise, ir ver a gereclube.class.php

}


?>
