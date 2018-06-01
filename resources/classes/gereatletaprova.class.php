<?php
require_once('./resources/classes/basededados.class.php');
require_once('./resources/classes/atletaprova.class.php');

class GereAtletaProva {
  private $listaatletaprova = [];

  public function inserir_atleta_prova(AtletaProva $atletaprova) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("INSERT INTO atleta_prova(AT_ID,P_ID) values(?,?)");
    $STH->bindValue(1, $atletaprova->get_idatleta());
    $STH->bindValue(2, $atletaprova->get_idprova());
    $res = $STH->execute();
    $bd->desligar_bd();
    return $res;
  }

  public function obter_todos_atletas_provas() {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM atleta_prova;");
    if($STH->rowCount() === 0){
      return null;
    }else{
      while($row = $STH->fetch(PDO::FETCH_NUM)){
        $this->listaatletaprova[] = new AtletaProva($row[0], $row[1]);
      }
      $bd->desligar_bd();
      return $this->listaatletaprova;
    }
  }

  public function verificar_atletas_provas($atleta,$prova) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM atleta_prova WHERE AT_ID='$atleta' AND P_ID='$prova';");
    if($STH->rowCount() === 0){
      return null;
    }else{
      return true;
    }
    $bd->desligar_bd();
  }

}
?>
