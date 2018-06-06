<?php
require_once('./resources/classes/basededados.class.php');
require_once('./resources/classes/historico.class.php');

class GereHistorico {
  private $listahistorico = [];

  public function inserir_historico(Historico $hist) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("INSERT INTO historico(H_ID,P_ID,AT_ID,H_TEMPO,H_LUGAR) values(?,?,?,?,?)");
    $STH->bindValue(1, $hist->get_id());
    $STH->bindValue(2, $hist->get_provaid());
    $STH->bindValue(3, $hist->get_atletaid());
    $STH->bindValue(4, $hist->get_tempo());
    $STH->bindValue(5, $hist->get_local());
    $res = $STH->execute();
    $bd->desligar_bd();
    return $res;
  }

  public function obter_todos_historicos() {
    $this->listahistorico=[];
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM historico;");
    if($STH->rowCount() === 0){
      return null;
    }else{
      while($row = $STH->fetch(PDO::FETCH_NUM)){
        $this->listahistorico[] = new Historico($row[0], $row[1],$row[2],$row[3],$row[4]);
      }
      $bd->desligar_bd();
      return $this->listahistorico;
    }
  }

  public function obter_historicos_provaid($id) {
    $this->listahistorico=[];
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM historico WHERE P_ID='$id';");
    if($STH->rowCount() === 0){
      return null;
    }else{
      while($row = $STH->fetch(PDO::FETCH_NUM)){
        $this->listahistorico[] = new Historico($row[0], $row[1],$row[2],$row[3],$row[4]);
      }
      $bd->desligar_bd();
      return $this->listahistorico;
    }
  }

  public function historico_ja_existente($prova, $atleta) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("SELECT * FROM historico WHERE P_ID = '$prova' AND AT_ID= '$atleta';");
    $STH->execute();
    $bd->desligar_bd();
    $row = $STH->fetch(PDO::FETCH_ASSOC);
    if($STH->rowCount()>0){
      return true;
    }else{
      return false;
    }
  }
  /*
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
}*/

}
?>
