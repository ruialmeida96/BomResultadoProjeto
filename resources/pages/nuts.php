<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=0){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Regiões</h3>

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
require_once('./resources/classes/gerelog.class.php');
$DAO10 = new GereLog();

$DAO = new GereNuts();
$obter_todos_os_nuts = $DAO->obter_todos_nuts();

$DAO10->inserir_log(new Log(0,$_SESSION['U_ID'],date("Y-m-d"),date("H:i:s"),"Listagem dos NUTS"));
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
                    <?php
                    if($obter_todos_os_nuts[$i]->get_id()>8){
                      ?>
                      <button class="btn btn-info" onclick="location.href='?action=editanuts&id=<?php echo $obter_todos_os_nuts[$i]->get_id()?>'" >Editar</button>
                      <form method="POST" id="DelNuts" action="">
                        <button type="submit" class="btn btn-danger" name="btnDelete" value="<?php echo $obter_todos_os_nuts[$i]->get_id()?>">Eliminar</button>
                      </form>
                      <?php
                    }
                     ?>
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
<?php }

if($_SERVER['REQUEST_METHOD']==='POST'){

  //Adicionar região
  if(isset($_POST['btnAdd'])){
    if(isset($_POST['nomeregiao']) && !empty($_POST['nomeregiao'])){

      require_once('./resources/classes/gerenuts.class.php');
      $DAO=new GereNuts();
      if($DAO->regiao_existe($_POST['nomeregiao'])){
        echo '<script>alert("A região que adicionou já se encontra registada.");</script>';
        header("Refresh:0");
      }else{

        if($DAO->inserir_nuts(new Nuts(0,$_POST['nomeregiao'],1,true))){
          echo '<script>alert("A Região foi criada com sucesso.");</script>';
          $DAO10->inserir_log(new Log(0,$_SESSION['U_ID'],date("Y-m-d"),date("H:i:s"),"Inserção de uma nova Região"));
          header("Refresh:0");
        }
      }
    }else{
      echo '<script>alert("Por favor preencha todos os campos.");</script>';
    }
  }

//eliminar regiao
  if(isset($_POST['btnDelete'])){
    $valorregelimina=$_POST['btnDelete'];
    if($DAO->elimina_nuts($valorregelimina)){
      echo '<script>alert("Nuts eliminado com sucesso.");</script>';
      $DAO10->inserir_log(new Log(0,$_SESSION['U_ID'],date("Y-m-d"),date("H:i:s"),"Eliminação de um Nuts"));
      header("Refresh:0");
    }else{
      echo '<script>alert("Ocorreu um erro ao eliminar o nuts!");</script>';
    }
  }


}


?>

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
