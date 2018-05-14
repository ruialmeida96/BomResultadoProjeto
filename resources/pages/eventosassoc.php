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

<?php

require_once('./resources/classes/gereevento.class.php');
require_once('./resources/classes/gereassociacao.class.php');




$DAO = new GereEvento();
$DAO2= new GereAssociacao();

$associacaoid = $DAO2->obter_detalhes_associação_apartir_userid($_SESSION['U_ID']);
$associacao = $DAO2->obter_detalhes_associação_id($associacaoid);
$nomeAssoc = $associacao->get_abreviatura();
 ?>

<div class="modal fade modal-primary" id="myModaladdEvento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h4 class="modal-title" id="exampleModalLabel">Adicionar Evento</h4>
        <div style=" position:absolute;top:0;right:0;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body text-center">
        <form name="formAddClube"  method="POST" id="formAddClube" action="">
          <label>Nome do Evento</label>
          <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome do Evento..." maxlength="130" required >

          <label>Data de Inicio</label>
          <br>
          <input type="date" id="datastart" name="datastart" required><br>

          <label>Dias de Duração</label><br>
          <input type="number" id="dias" name="dias" min="1" max="30" required ><br>

          <label>Tipo de Evento</label>
          <input type="text" name="tipo" id="tipo" class="form-control" placeholder="Prova de ... (ex:Estrada)" maxlength="25" required>

          <label>Localização do Evento</label>
          <input type="text" name="local" id="local" class="form-control" placeholder="Localização do Evento..." required>

          <label>Detalhes</label>
          <br>
          <!--não é necessario introduzir nada neste campo...! na parte de introduzir não devo verificar se foi introduzido algo neste campo ou não...-->
          <textarea rows="4" cols="50"  name="detalhes" id="detalhes"  maxlength="130" placeholder="Introduza algo..."> </textarea>

          </div>
          <div class="modal-footer">
            <span></span>
            <button type="submit" class="btn btn-success" name="btnAdd" >Adicionar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php

  //nome,datastart,dias,tipo,local,detalhes
  if($_SERVER['REQUEST_METHOD']==='POST'){

    if(isset($_POST['btnAdd'])){
      if(isset($_POST['nome'],$_POST['datastart'],$_POST['dias'],$_POST['tipo'],$_POST['local']) && !empty($_POST['nome']) && !empty($_POST['datastart']) && !empty($_POST['dias']) && !empty($_POST['tipo']) && !empty($_POST['local'])){

        if($DAO->inserir_evento(new Evento (0,$associacaoid,$_POST['nome'],$_POST['datastart'],$_POST['dias'],$_POST['tipo'],$_POST['local'],$_POST['detalhes'],$nomeAssoc,1,1,true))){
          echo '<script>alert("O Evento foi criado com sucesso.Vamos passar a proxima fase...");</script>';
            $ultimoidevento = $DAO->obter_ultimo_evento_assoc($associacaoid);
            header('Location:?action=addprovasevento&id='.$ultimoidevento);
        }else{
          echo '<script>alert("Erro ao criar o Evento.");</script>';
          header("Refresh:0");
        }
      }else{
        echo '<script>alert("Por favor preencha todos os campos.");</script>';
      }
    }
  }
?>
