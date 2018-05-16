<h3>Adicionar Evento</h3>
<h3>Falta organizadores e escolher associação<br> ver como fazer da parte de ir buscar o id do evento</h3>

<?php
require_once('./resources/classes/gereevento.class.php');
require_once('./resources/classes/gereassociacao.class.php');

$DAO = new GereEvento();
$DAO2= new GereAssociacao();


?>
<div class="card">
  <div class="card-header">
    <h4 class="card-title">Novo Evento</h4>
  </div>
  <div class="card-body">
    <form name="formAddEvento"  method="POST" id="formAddEvento" action="">

      <div class="row">
        <div class="col-md-4 pr-1">
          <label>Nome do Evento</label>
          <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome do Evento..." maxlength="130" required >
          <br>
        </div>
      </div>
      <div class="row">
        <div class="col-md-5 pr-1">
          <label>Data de Inicio</label><br>
          <input type="date" id="datastart" name="datastart" required><br>
          <br>
        </div>
      </div>
      <div class="row">
        <div class="col-md-5 pr-1">
          <label>Dias de Duração</label><br>
          <input type="number" id="dias" name="dias" min="1" max="30" required ><br>
          <br>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 pr-1">
          <label>Tipo de Evento</label>
          <input type="text" name="tipo" id="tipo" class="form-control" placeholder="Prova de ... (ex:Estrada)" maxlength="25" required>
          <br>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 pr-1">
          <label>Localização do Evento</label><br>
          <input type="text" name="local" id="local" class="form-control" placeholder="Localização do Evento..." required>
          <br>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 pr-1">
          <label>Detalhes</label>
          <br>
          <!--não é necessario introduzir nada neste campo...! na parte de introduzir não devo verificar se foi introduzido algo neste campo ou não...-->
          <textarea rows="4" cols="50"  name="detalhes" id="detalhes"  maxlength="130" placeholder="Introduza algo..."> </textarea>
          <br>
        </div>
      </div>
      <button type="submit" class="btn btn-success" name="btnAdd" >Adicionar</button>

    </form>
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
