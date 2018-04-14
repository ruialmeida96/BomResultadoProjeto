<?php
require_once('./resources/classes/basededados.class.php');
require_once('./resources/classes/utilizador.class.php');

class GereUtilizador {
  private $utilizadores = [];


  public function inserir_utilizador(Utilizador $utilizador) {
		$bd = new BaseDados();
    $bd->ligar_bd();
		$STH = $bd->dbh->prepare("INSERT INTO utilizador(U_NOME, U_EMAIL, U_PASS, U_CONTACTO, U_ESTADO, U_TIPO) values(?, ?, ?, ?, ?, ?)");
		$STH->bindValue(1, $utilizador->get_nome());
		$STH->bindValue(2, $utilizador->get_email());
		$STH->bindValue(3, $utilizador->get_password());
		$STH->bindValue(4, $utilizador->get_contacto());
    $STH->bindValue(5, $utilizador->get_estado());
		$STH->bindValue(6, $utilizador->get_tipo());
		$res = $STH->execute();
		$bd->desligar_bd();
		return $res;
	}


  public function editar_utilizador(Utilizador $utilizador) {
		$bd = new BaseDados();
    $bd->ligar_bd();
		$STH = $bd->dbh->prepare("UPDATE utilizador SET U_NOME = ?, U_EMAIL = ?, U_PASS = ?, U_CONTACTO = ? WHERE U_ID = ?");
		$STH->bindValue(1, $utilizador->get_nome());
		$STH->bindValue(2, $utilizador->get_email());
		$STH->bindValue(3, $utilizador->get_password());
		$STH->bindValue(4, $utilizador->get_contacto());
    $STH->bindValue(5, $utilizador->get_id());
		$res = $STH->execute();
		$bd->desligar_bd();
		return $res;
	}


  public function email_existe($email) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("SELECT 1 FROM utilizador WHERE U_EMAIL LIKE ?");
    $STH->bindParam(1, $email);
    $STH->execute();
    $bd->desligar_bd();
    return $STH->fetch(PDO::FETCH_ASSOC);
	}


  public function password_correta($email, $password) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("SELECT U_ID, U_PASS, U_TIPO FROM utilizador WHERE U_EMAIL = ?");
    $STH->bindParam(1, $email);
    $STH->execute();
    $bd->desligar_bd();
    $row = $STH->fetch(PDO::FETCH_ASSOC);
    if($STH->rowCount()>0){
      if(password_verify($password, $row['U_PASS'])){
        $_SESSION['U_ID'] =(int)$row['U_ID'];
        $_SESSION['U_TIPO'] =(int)$row['U_TIPO'];
        return true;
      }
    }
    return false;
  }


  public function obter_detalhes_utilizador_email($email) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("SELECT * FROM utilizador WHERE U_EMAIL = ?");
    $STH->bindParam(1,$email);
    $STH->execute();
    $bd->desligar_bd();
    $row = $STH->fetch(PDO::FETCH_NUM);
    return new Utilizador($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
  }


  public function obter_detalhes_utilizador_id($id) {
    $bd = new BaseDados();
    $bd->ligar_bd();
    $STH = $bd->dbh->prepare("SELECT * FROM utilizador WHERE U_ID = ?");
    $STH->bindParam(1,$id);
    $STH->execute();
    $bd->desligar_bd();
    $row = $STH->fetch(PDO::FETCH_NUM);
    return new Utilizador($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
  }


  public function obter_admin() {
		$bd = new BaseDados();
    $bd->ligar_bd();
		$STH = $bd->dbh->query("SELECT * FROM utilizador WHERE U_TIPO = 0");
		if($STH->rowCount() === 0){
      return null;
    }
		while($row = $STH->fetch(PDO::FETCH_NUM)){
			$this->utilizadores[] = new Utilizador($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
		}
		$bd->desligar_bd();
		return $this->utilizadores;
	}

  public function obter_todas_associacoes() {
		$bd = new BaseDados();
    $bd->ligar_bd();
		$STH = $bd->dbh->query("SELECT * FROM utilizador WHERE U_TIPO = 1");
		if($STH->rowCount() === 0){
      return null;
    }
		while($row = $STH->fetch(PDO::FETCH_NUM)){
			$this->utilizadores[] = new Utilizador($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
		}
		$bd->desligar_bd();
		return $this->utilizadores;
	}

  public function obter_todos_clubes() {
		$bd = new BaseDados();
    $bd->ligar_bd();
		$STH = $bd->dbh->query("SELECT * FROM utilizador WHERE U_TIPO = 2");
		if($STH->rowCount() === 0){
      return null;
    }
		while($row = $STH->fetch(PDO::FETCH_NUM)){
			$this->utilizadores[] = new Utilizador($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
		}
		$bd->desligar_bd();
		return $this->utilizadores;
	}

  public function conta_ativa($email) {
		$bd = new BaseDados();
    $bd->ligar_bd();
		$STH = $bd->dbh->query("SELECT 1 FROM utilizador WHERE U_EMAIL = '$email' AND U_ESTADO=1");
		$bd->desligar_bd();
		return $STH->fetch(PDO::FETCH_NUM);
	}


/*  public function alterar_estado_utilizador($id) {
		$bd = new BaseDados();
    $bd->ligar_bd();
		$STH = $bd->dbh->prepare("UPDATE utilizador SET U_ESTADO = NOT U_ESTADO WHERE U_ID = ?");
    $STH->bindParam(1,$id);
		$res = $STH->execute();
		$bd->desligar_bd();
    return $res;
	}*/

  public function inativa_utilizador($id) {
		$bd = new BaseDados();
    $bd->ligar_bd();
		$STH = $bd->dbh->prepare("UPDATE utilizador SET U_ESTADO = 0 WHERE U_ID = ?");
    $STH->bindParam(1,$id);
		$res = $STH->execute();
		$bd->desligar_bd();
    return $res;
	}


  //FALTA PREPARAR ISTO PARA INSERIR LOG
  /*public function inserir_log(Log $log, Utilizador $utilizador) {
		$bd = new BaseDados();
    $bd->ligar_bd();
		$STH = $bd->dbh->prepare("INSERT INTO log(U_ID, L_DATA,L_HORA,L_DESCRICAO) values(?, ?, ?,?)");
		$STH->bindValue(1, $utilizador->get_id());
		$STH->bindValue(2, $log->get_acao());
		$STH->bindValue(3, $log->get_data_hora());
		$res = $STH->execute();
		$bd->desligar_bd();
		return $res;
	}*/
}
