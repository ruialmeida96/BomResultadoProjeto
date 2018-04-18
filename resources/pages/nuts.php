
<h3>Regiões</h3>

Listar regioes, adicionar regioes(botao na parte de cima), e edita-las(editar info e eliminar)
<br>
<div class="row">
  <div >
    <a  class="nav-link" data-toggle="modal" data-target="#myModaladdNuts" href="#">
      <span class="nc-icon nc-simple-add"> Adicionar Região</span>
    </a>
  </div>

</div>

<?php
require_once('./resources/classes/gerenuts.class.php');
$DAO = new GereNuts();
$obter_todos_os_nuts = $DAO->obter_todos_nuts();
?>

<?php if($obter_todos_os_nuts == null){ ?>
  <h4>Não existem Regiões Disponiveis</h4><br><br>
<?php }else{ ?>
  <div class="row">
    <div class="col-md-12">
      <div class="card strpied-tabled-with-hover">
        <div class="card-header ">
          <h4 class="card-title">Lista de Regiões Disponiveis</h4>
          <p class="card-category">Detalhes das regiões disponiveis na aplicação</p>
        </div>
        <div class="card-body table-full-width table-responsive">
          <table class="table table-hover table-striped">
            <thead>
              <th>ID</th>
              <th>Nome</th>
              <th></th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              $tamanho = count($obter_todos_os_nuts);
              do{
                ?>
                <tr>
                  <?php
                  echo "<td>".$obter_todos_os_nuts[$i]->get_id()."</td>";
                  echo "<td>".$obter_todos_os_nuts[$i]->get_regiao()."</td>";
                  ?>
                  <td>
                    opção
                    <!--ver se precisar no criar gestor.php-->
                  </td>
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
<?php } ?>


<div class="modal fade modal-primary" id="myModaladdNuts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h4 class="modal-title" id="exampleModalLabel">Adicionar Região</h4>
        <div style=" position:absolute;top:0;right:0;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body text-center">
        <form method="POST" id="AddRegForm" action="">
          Nome da Região
          <input type="text" name="nomeregiao" id="nomeregiao" class="form-control" placeholder="Nome da região..." required ><br>
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
if($_SERVER['REQUEST_METHOD']==='POST'){

  //Adicionar região
  if(isset($_POST['btnAdd'])){
    if(isset($_POST['nomeregiao']) && !empty($_POST['nomeregiao'])){

      require_once('./resources/classes/gerenuts.class.php');
      $DAO=new GereNuts();
      if($DAO->regiao_existe($_POST['nomeregiao'])){
        echo '<script>alert("A região que adicionou já se encontra registada.");</script>';
      }else{

        if($DAO->inserir_nuts(new Nuts(0,$_POST['nomeregiao'],1,true))){
          echo '<script>alert("A Região foi criada com sucesso.");</script>';
          header("Refresh:0");
        }
      }
    }else{
      echo '<script>alert("Por favor preencha todos os campos.");</script>';
    }
  }
}


?>
