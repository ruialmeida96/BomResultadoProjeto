<h3>Info Associação</h3>

Editar informação da associação
<br>
<?php
$idassoc = $_GET["id"];
//echo $idassoc;
require_once('./resources/classes/gereassociacao.class.php');
require_once('./resources/classes/gereutilizador.class.php');
require_once('./resources/classes/gerenuts.class.php');

$DAO=new GereAssociacao();
$DAO2=new GereUtilizador();
$DAO3= new GereNuts();

$obter_todos_os_nuts = $DAO3->obter_todos_nuts();


if($DAO->obter_detalhes_associação_id($idassoc)){
  $associacao = $DAO->obter_detalhes_associação_id($idassoc);
  $idutl = $associacao->get_userid();
  $idnuts = $associacao->get_nutsid();
  $abreviatura = $associacao->get_abreviatura();
  if($DAO2->obter_detalhes_utilizador_id($idutl)){
    $utilizador = $DAO2->obter_detalhes_utilizador_id($idutl);
    $nomeass = $utilizador->get_nome();
    $emailass = $utilizador->get_email();
  }
}
?>

<div class="card">
  <div class="card-header">
    <h4 class="card-title">Editar Informação Associação</h4>
  </div>
  <div class="card-body">
    <form name="formEditAssoc" onsubmit="return validaRegisto()" method="POST" action="">
      <div class="row">
        <div class="col-md-5 pr-1">
          <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" maxlength="120" value ='<?php print($nomeass) ?>' required >
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 pr-1">
          <div class="form-group">
            <label>Abreviatura</label>
            <input type="text" class="form-control" name="abreviatura" id="abreviatura" maxlength="75" value ='<?php print($abreviatura) ?>' required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 pr-1">
          <div class="form-group">
            <label>Email</label>
            <input type="mail" class="form-control" name="email" id="email" value ='<?php print($emailass) ?>' required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 pr-1">
          <div class="form-group">
            <label>Região</label><br>
            <select name="regiao" id="regiao">
              <?php
              $i = 0;
              $tamanho2 = count($obter_todos_os_nuts);
              do{
                if($obter_todos_os_nuts[$i]->get_id()==$idnuts){
                  echo "<option selected='selected' value=".$obter_todos_os_nuts[$i]->get_id().">".$obter_todos_os_nuts[$i]->get_regiao()."</option>";
                }else{
                  echo "<option value=".$obter_todos_os_nuts[$i]->get_id().">".$obter_todos_os_nuts[$i]->get_regiao()."</option>";
                }
                $i++;
              }while ($i<$tamanho2);
              ?>
            </select>
          </div>
        </div>
      </div>
      <br>
      <button type="submit" class="btn btn-success " name="btnSave" >Guardar</button>
    </form>
  </div>
</div>
