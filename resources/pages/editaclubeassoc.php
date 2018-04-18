<h3>Info Clubes</h3>

Editar informação de um clube
<br>
<?php
$idclube = $_GET["id"];

require_once('./resources/classes/gereclube.class.php');
require_once('./resources/classes/gereutilizador.class.php');

$DAO = new GereClube();
$DAO2 = new GereUtilizador();

if($DAO->obter_detalhes_clube_id($idclube)){
  $clube = $DAO->obter_detalhes_clube_id($idclube);
  $iduserclube=$clube->get_userid();
  $abreviatura = $clube->get_abreviatura();
  $local = $clube->get_localizacao();
  if($DAO2->obter_detalhes_utilizador_id($iduserclube)){
    $utilizador = $DAO2->obter_detalhes_utilizador_id($iduserclube);
    $nome = $utilizador->get_nome();
    $email = $utilizador->get_email();
  }
}

//editar nome, email,abreviatura e localizacao

?>

<div class="card">
  <div class="card-header">
    <h4 class="card-title">Editar Informação Clube</h4>
  </div>
  <div class="card-body">
    <form name="formEditAssoc" onsubmit="return validaRegisto()" method="POST" action="">
      <div class="row">
        <div class="col-md-5 pr-1">
          <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" maxlength="120" value ='<?php print($nome) ?>' required >
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
            <input type="mail" class="form-control" name="email" id="email" value ='<?php print($email) ?>' required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 pr-1">
          <div class="form-group">
            <label>Localização</label><br>
            <input type="text" class="form-control" name="abreviatura" id="abreviatura" maxlength="75" value ='<?php print($local) ?>' required>

          </div>
        </div>
      </div>
      <br>
      <button type="submit" class="btn btn-success " name="btnSave" >Guardar</button>
    </form>
  </div>
</div>
