<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=2){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Atletas</h3>
Listar atletas, adicionar e edita-los(editar info e eliminar)

<br>
<div class="row">
  <div >
    <a  class="nav-link" data-toggle="modal" data-target="#myModaladdAtleta" href="#">
      <span class="nc-icon nc-simple-add"> Adicionar Atleta</span>
    </a>
  </div>
</div>


<div class="modal fade modal-primary" id="myModaladdAtleta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h4 class="modal-title" id="exampleModalLabel">Adicionar Atleta</h4>
        <div style=" position:absolute;top:0;right:0;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body text-center">
        <form name="formAddClube" onsubmit="return validaRegisto()" method="POST" id="formAddClube" action="">

          <label>Nome do Atleta</label>
          <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome do Atleta..." maxlength="130" required >

          <label>Nome de Exibição</label>
          <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome de Exibição..." maxlength="80" required >

          <label>Email</label>
          <div id="erroemail" style="color:red;"></div>
          <input type="mail" class="form-control" name="email" id="email" placeholder="example@email.com" required>

          <label>Contacto</label>
          <div id="errocontacto" style="color:red;"></div>
          <input type="tel" class="form-control" name="contacto" id="contacto"  maxlength="9" required>

          <label>Especialidade</label>
          <input type="text" name="especialidade" id="especialidade" class="form-control" placeholder="Especialidade do Atleta..." required>

          <label>Nacionalidade</label>
          <input type="text" name="especialidade" id="especialidade" class="form-control" placeholder="Nacionalidade do Atleta..." required>

        </div>
        <div class="modal-footer">
          <span></span>
          <button type="submit" class="btn btn-success" name="btnAdd" >Adicionar</button>
        </div>
      </form>
    </div>
  </div>
</div>
