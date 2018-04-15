<h3>Editar Perfil</h3>

Editar informação do utilizador
<br>
<?php
require_once('./resources/classes/gereutilizador.class.php');
$DAO=new GereUtilizador();

if($DAO->obter_detalhes_utilizador_id($_SESSION['U_ID'])){
  $utilizador = $DAO->obter_detalhes_utilizador_id($_SESSION['U_ID']);
  $idutl = $_SESSION['U_ID'];
  $nomeutl = $utilizador->get_nome();
  $contactoutl = $utilizador->get_contacto();
  $emailutl = $utilizador->get_email();
  $tipoutl =$_SESSION['U_TIPO'];
}

echo $nomeutl;
echo "<br>".$contactoutl;
echo "<br>".$emailutl;
echo "<br>".$tipoutl;



?>
<br>
<h1>Acho que é preciso editar o nome, passe contacto, email (talvez mas acho que nao)</h1>
