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

  public function obter_ultimo_evento(){
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("SELECT * FROM evento ORDER BY E_ID DESC LIMIT 1;");
    $STH->execute();
    $bd->desligar_bd();
    $row = $STH->fetch(PDO::FETCH_NUM);
  return new Evento($row[0], $row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9]);
  }



  public function obter_todos_eventos_assoc($id) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM evento WHERE A_ID = '$id' AND E_ESTADO = 1;");
    if($STH->rowCount() === 0){
      return null;
    }else{
      while($row = $STH->fetch(PDO::FETCH_NUM)){
        $this->listaeventos[] = new Evento($row[0], $row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9]);
      }
      $bd->desligar_bd();
      return $this->listaeventos;
    }
  }


  public function obter_todos_eventos_assoc_especial_inscriçao($id) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM evento WHERE A_ID = '$id' AND E_ESTADO = 1 OR E_ESTADO=3;");
    if($STH->rowCount() === 0){
      return null;
    }else{
      while($row = $STH->fetch(PDO::FETCH_NUM)){
        $this->listaeventos[] = new Evento($row[0], $row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9]);
      }
      $bd->desligar_bd();
      return $this->listaeventos;
    }
  }


  public function obter_todos_eventos_ja_inscritos($id) {
    $this->listaeventos=[];
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM evento WHERE A_ID = '$id' AND E_ESTADO = 3;");
    if($STH->rowCount() === 0){
      return null;
    }else{
      while($row = $STH->fetch(PDO::FETCH_NUM)){
        $this->listaeventos[] = new Evento($row[0], $row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9]);
      }
      $bd->desligar_bd();
      return $this->listaeventos;
    }
  }

  public function obter_todos_eventos_assoc_inativos($id) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM evento WHERE A_ID = '$id' AND E_ESTADO = 0;");
    if($STH->rowCount() === 0){
      return null;
    }else{
      while($row = $STH->fetch(PDO::FETCH_NUM)){
        $this->listaeventos[] = new Evento($row[0], $row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9]);
      }
      $bd->desligar_bd();
      return $this->listaeventos;
    }
  }

  public function obter_todos_eventos_assoc_recusados($id) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->query("SELECT * FROM evento WHERE A_ID = '$id' AND E_ESTADO = 2;");
    if($STH->rowCount() === 0){
      return null;
    }else{
      while($row = $STH->fetch(PDO::FETCH_NUM)){
        $this->listaeventos[] = new Evento($row[0], $row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9]);
      }
      $bd->desligar_bd();
      return $this->listaeventos;
    }
  }

  public function obter_info_evento($id) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("SELECT * FROM evento WHERE E_ID = '$id';");
    $STH->bindParam(1,$id);
    $STH->execute();
    $bd->desligar_bd();
    $row = $STH->fetch(PDO::FETCH_NUM);
    return new Evento($row[0], $row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9]);
  }

  public function aceita_evento($id) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("UPDATE evento SET E_ESTADO = 1 WHERE E_ID = '$id';");
    $res = $STH->execute();
    $bd->desligar_bd();
    return $res;
  }

  public function recusa_evento($id) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("UPDATE evento SET E_ESTADO = 2 WHERE E_ID = '$id';");
    $res = $STH->execute();
    $bd->desligar_bd();
    return $res;
  }

  public function inscricao_em_evento($id) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("UPDATE evento SET E_ESTADO = 3 WHERE E_ID = '$id';");
    $res = $STH->execute();
    $bd->desligar_bd();
    return $res;
  }

  public function conclusao_do_evento($id) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("UPDATE evento SET E_ESTADO = 4 WHERE E_ID = '$id';");
    $res = $STH->execute();
    $bd->desligar_bd();
    return $res;
  }


}
?>
