<?php
require_once(__DIR__.'/basededados.class.php');
require_once(__DIR__.'/nuts.class.php');

class GereNuts {


  public function inserir_nuts(Nuts $nut) {
		$bd = new BaseDados();
    $bd->ligar_bd();
		$STH = $bd->dbh->prepare("INSERT INTO nuts2 (N_REGIAO) values(?)");
		$STH->bindValue(1, $nut->get_regiao());
		$res = $STH->execute();
		$bd->desligar_bd();
		return $res;
	}

  public function editar_nuts(Nuts $nut) {
		$bd = new BaseDados();
    $bd->ligar_bd();
		$STH = $bd->dbh->prepare("UPDATE nuts2 SET N_REGIAO = ? WHERE N_ID = ?");
		$STH->bindValue(1, $nut->get_regiao());
		$STH->bindValue(2, $nut->get_id());
		$res = $STH->execute();
		$bd->desligar_bd();
		return $res;
	}

}
