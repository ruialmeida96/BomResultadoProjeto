<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=2){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Listagem de Inscrições</h3>
<?php
$id_user_clube = $_SESSION['U_ID'];

require_once('./resources/classes/gereclube.class.php');
require_once('./resources/classes/gereevento.class.php');
require_once('./resources/classes/gereatleta.class.php');
require_once('./resources/classes/gereatletaprova.class.php');

$DAO = new GereClube();
$DAO2 = new GereEvento();
$DAO3 = new GereAtleta();
$DAO4 = new GereAtletaProva();
$clube = $DAO->obter_detalhes_clube_userid($id_user_clube);

$atletas_clube = $DAO3->obter_todos_atletas_do_clube($clube->get_id());
$i=0;
$numatletas = count($atletas_clube);
do{
$DAO4->verificar_atleta_inscricao_geral($atletas_clube[$i]->get_id());


  $i++;
}while ($i<$numatletas);


?>
<p>neste aqui temos de ver se existem Eventos, temos de ver se esses eventos tem inscriçoes (estado = 3 acho), verificar se existem atletas inscritos em provas e quais...
</p>
