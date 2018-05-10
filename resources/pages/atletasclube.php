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

<?php

$id_user_clube = $_SESSION['U_ID'];

require_once('./resources/classes/gereclube.class.php');
require_once('./resources/classes/gereatleta.class.php');

$DAO = new GereAtleta();


$DAO2 = new GereClube();
$obter_todos_os_clubes = $DAO2->obter_todas_clubes();


$clubeid= $DAO2->obter_clube_id_clube_userid($id_user_clube);

$obter_todos_os_atletas = $DAO->obter_todos_atletas_do_clube($clubeid);


 if($obter_todos_os_atletas == null){ ?>
  <h4>Não existem Atletas Disponiveis</h4><br><br>
<?php }else{ ?>
  <div class="row">
    <div class="col-md-12">
      <div class="card strpied-tabled-with-hover">
        <div class="card-header ">
          <h4 class="card-title">Lista de Atletas Disponiveis</h4>
          <p class="card-category">Detalhes dos atletas disponiveis na aplicação</p>
        </div>
        <div class="card-body table-full-width table-responsive">
          <table class="table table-hover table-striped">
            <thead>
              <th>ID</th>
              <th>Nome</th>
              <th>Nome Exibição</th>
              <th>Contacto</th>
              <th>Email</th>
              <th>Especialidade</th>
              <th>Nacionalidade</th>
              <th>Escalão</th>
              <th></th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              $tamanho = count($obter_todos_os_atletas);
              do{
                ?>
                <tr>
                  <?php
                  echo "<td>".$obter_todos_os_atletas[$i]->get_id()."</td>";
                  echo "<td>".$obter_todos_os_atletas[$i]->get_nome()."</td>";
                  echo "<td>".$obter_todos_os_atletas[$i]->get_nomeexibe()."</td>";
                  echo "<td>".$obter_todos_os_atletas[$i]->get_contacto()."</td>";
                  echo "<td>".$obter_todos_os_atletas[$i]->get_email()."</td>";
                  echo "<td>".$obter_todos_os_atletas[$i]->get_especialidade()."</td>";
                  echo "<td>".$obter_todos_os_atletas[$i]->get_nacionalidade()."</td>";
                  echo "<td>".$obter_todos_os_atletas[$i]->get_escalao()."</td>";
                  ?>
                </tr>
                <?php
                $i++;
              }while ($i<$tamanho);
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php }  ?>


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
