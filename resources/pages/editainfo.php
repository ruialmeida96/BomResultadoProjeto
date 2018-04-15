<h3>Perfil</h3>

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
?>
Acho que é preciso editar o nome, passe contacto, email (talvez mas acho que nao)

<div class="card">
  <div class="card-header">
    <h4 class="card-title">Editar Perfil</h4>
  </div>
  <div class="card-body">
    <form name="formSaveInfo" onsubmit="return validaRegisto()" method="POST" action="">
      <div class="row">
        <div class="col-md-5 pr-1">
          <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" maxlength="120" value ='<?php print($nomeutl) ?>' required >
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 pr-1">
          <div class="form-group">
            <label>Contacto</label>
            <input type="tel" class="form-control" name="contacto" id="contacto"  maxlength="9"  value ='<?php print($contactoutl) ?>' required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 pr-1">
          <div class="form-group">
            <label>Email</label>
            <input type="mail" class="form-control" name="email" id="email" value ='<?php print($emailutl) ?>' required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 pr-1">
          <div class="form-group">
            <label>Palavra-Passe Antiga</label>
            <input type="password" class="form-control" name="passant" id="passant" required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 pr-1">
          <div class="form-group">
            <label>Nova Palavra-Passe</label>
            <input type="password" class="form-control" name="pass" id="pass" >
          </div>
        </div>
        <div class="col-md-2 px-1">
          <div class="form-group">
            <label>Confirmar Palavra-Passe</label>
            <input type="password" class="form-control" name="pass1" id="pass1" >
          </div>
        </div>
      </div>
      <small class="form-text text-muted">A palavra-passe deverá conter uma letra maiúscula, um número e um caractere especial</small>
      <br>
      <button type="submit" class="btn btn-success " name="btnSave" >Guardar</button>
    </form>
  </div>
</div>
