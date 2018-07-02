<!--adicionar nuts nesta parte-->
<?php
require_once('./resources/classes/gerenuts.class.php');
$DAO=new GereNuts();
$DAO->inserir_nuts(new Nuts(0,'Nacional',1,true));
$DAO->inserir_nuts(new Nuts(0,'Região do Norte',1,true));
$DAO->inserir_nuts(new Nuts(0,'Região do Centro',1,true));
$DAO->inserir_nuts(new Nuts(0,'Região do Alentejo',1,true));
$DAO->inserir_nuts(new Nuts(0,'Região do Algarve',1,true));
$DAO->inserir_nuts(new Nuts(0,'Área Metropolitana de Lisboa',1,true));
$DAO->inserir_nuts(new Nuts(0,'Região Autónoma dos Açores',1,true));
$DAO->inserir_nuts(new Nuts(0,'Região Autónoma da Madeira',1,true));
?>
