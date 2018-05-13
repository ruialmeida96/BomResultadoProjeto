<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=1){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Eventos</h3>

Adicionar, listar eventos, aceitar eventos, recusar, listar todos os eventos (que irao acontecer e que ja aconteceram)
<br>
<div class="row">
  <div >
    <a  class="nav-link" data-toggle="modal" data-target="#myModaladdEvento" href="#">
      <span class="nc-icon nc-simple-add"> Adicionar Evento</span>
    </a>
  </div>
</div>


<div class="modal fade modal-primary" id="myModaladdEvento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h4 class="modal-title" id="exampleModalLabel">Adicionar Clube</h4>
        <div style=" position:absolute;top:0;right:0;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body text-center">
        <form name="formAddClube" onsubmit="return validaRegisto()" method="POST" id="formAddClube" action="">


          <label>Nome do Evento</label>
          <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome do Evento..." maxlength="130" required >

          <label>Data de Inicio</label>
          <br>
          <input type="date" id="datastart" name="datastart" required><br>

          <label>Dias de Duração</label><br>
          <input type="number" min="1" max="30" /><br>

          <label>Tipo de Evento</label>
          <input type="text" name="tipo" id="tipo" class="form-control" placeholder="Prova de ... (ex:Estrada)" maxlength="25" required>

          <label>Localização do Evento</label>
          <input type="text" name="local" id="local" class="form-control" placeholder="Localização do Evento..." required>

          <label>Detalhes</label>
          <br>
          <!--não é necessario introduzir nada neste campo...! na parte de introduzir não devo verificar se foi introduzido algo neste campo ou não...-->
          <textarea rows="4" cols="50" name="comment" form="usrform" placeholder="Introduza algo..."></textarea>

          </div>
          <div class="modal-footer">
            <span></span>
            <button type="submit" class="btn btn-success" name="btnAdd" >Adicionar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
