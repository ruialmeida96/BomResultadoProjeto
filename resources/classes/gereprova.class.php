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

  public function obter_todas_provas_eventoid($id) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM prova WHERE E_ID = '$id';");
    if($STH->rowCount() === 0){
      return null;
    }else{
      while($row = $STH->fetch(PDO::FETCH_NUM)){
        $this->listaprova[] = new Prova($row[0], $row[1],$row[2],$row[3],$row[4],$row[5],$row[6]);
      }
      $bd->desligar_bd();
      return $this->listaprova;
    }
  }

  public function editar_prova(Prova $prova) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("UPDATE prova SET P_NOME = ?, P_ESCALAO = ?, P_DISTANCIA = ?, P_HORA = ?, P_SEXO = ? WHERE P_ID = ?");
    $STH->bindValue(1, $prova->get_nome());
    $STH->bindValue(2, $prova->get_escalao());
    $STH->bindValue(3, $prova->get_distancia());
    $STH->bindValue(4, $prova->get_hora());
    $STH->bindValue(5, $prova->get_sexo());
    $STH->bindValue(6, $prova->get_id());
    $res = $STH->execute();
    $bd->desligar_bd();
    return $res;
  }

  public function elimina_provas_evento($idevento) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("DELETE FROM prova WHERE E_ID = '$idevento';");
    $res = $STH->execute();
    $bd->desligar_bd();
    return $res;
  }

  public function obter_dados_provaid($id) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM prova WHERE P_ID = '$id';");
    $row = $STH->fetch(PDO::FETCH_NUM);
    if($STH->rowCount() === 0){
      return null;
    }else{
      return new Prova($row[0], $row[1],$row[2],$row[3],$row[4],$row[5],$row[6]);
    }
  }

  public function obter_nome_apartir_prova_id($id){
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("SELECT P_NOME FROM prova WHERE P_ID = ?");
    $STH->bindParam(1,$id);
    $STH->execute();
    $bd->desligar_bd();
    $row = $STH->fetch(PDO::FETCH_NUM);
    return$row[0];
  }

}


?>
