<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=2){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Inscrição de Atletas em Provas</h3>
<?php
$id_user_clube = $_SESSION['U_ID'];
$evento_id = $_GET["id"];

echo "evento id ".$evento_id;

require_once('./resources/classes/gereclube.class.php');
require_once('./resources/classes/gereevento.class.php');
require_once('./resources/classes/gereprova.class.php');
require_once('./resources/classes/gereatleta.class.php');

$DAO = new GereClube();
$DAO2 = new GereEvento();
$DAO3 = new GereProva();
$DAO4 = new GereAtleta();


$clube = $DAO->obter_detalhes_clube_userid($id_user_clube);

$provas_do_evento = $DAO3->obter_todas_provas_eventoid($evento_id);

$atletas_do_clube = $DAO4->obter_todos_atletas_do_clube($clube->get_id());

//agora é fazer um card com a lista de provas e correspondente a lista de provas e escalao e sexo, aparecerem os atletas dispostos a poderem ser inscritos numa determinada prova!
//tambem é necessario consultar se um determinado atleta ja se encontra inscrito numa determinada prova ou nao


 ?>
