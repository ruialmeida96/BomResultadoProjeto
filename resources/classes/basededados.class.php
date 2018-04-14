<?php
require_once('./resources/configs/basededados.php');

class BaseDados {
  public $dbh;

  function __construct(){}

  function ligar_bd(){
    global $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS;
    $options = array(PDO::ATTR_PERSISTENT => true,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    try{
      $this->dbh = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8",$DB_USER,$DB_PASS,$options);
    }catch(PDOException $e){
      die();
    }
  }

  function desligar_bd(){
    $this->dbh = null;
  }
}
