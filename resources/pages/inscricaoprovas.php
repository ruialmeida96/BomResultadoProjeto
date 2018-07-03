<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=2){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Listagem de Inscrições</h3>
<?php
$id_user_clube = $_SESSION['U_ID'];

require_once('./resources/classes/gereclube.class.php');
require_once('./resources/classes/gereevento.class.php');
require_once('./resources/classes/gereatleta.class.php');
require_once('./resources/classes/gereprova.class.php');
require_once('./resources/classes/gereatletaprova.class.php');
require_once('./resources/classes/gerelog.class.php');
$DAO10 = new GereLog();
$DAO = new GereClube();
$DAO2 = new GereEvento();
$DAO3 = new GereAtleta();
$DAO5 = new GereProva();
$DAO4 = new GereAtletaProva();
$clube = $DAO->obter_detalhes_clube_userid($id_user_clube);

$atletas_clube = $DAO3->obter_todos_atletas_do_clube($clube->get_id());
$i=0;

$todas_as_inscricoes=$DAO4->obter_todos_atletas_provas();

if($todas_as_inscricoes == null){ ?>
  <h4>Não existem Inscrições em Eventos </h4><br><br>
<?php }else{
  $y=0;
  $a=0;
  do{
    if($DAO4->verificar_atleta_inscricao_geral($atletas_clube[$y]->get_id())){
      $a=1;
    }
    $y++;
  }while($y<count($atletas_clube));

  if($a==1){
    ?>
    <div class="row">
      <div class="col-md-12">
        <div class="card strpied-tabled-with-hover">
          <div class="card-header ">
            <h4 class="card-title">Lista de Inscrições Disponiveis</h4>
            <p class="card-category">Detalhes dos inscriçoes disponiveis para este Clube</p>
          </div>
          <div class="card-body table-full-width table-responsive">
            <table class="table table-hover table-striped">
              <thead>
                <th>Atleta ID</th>
                <th>Nome Atleta</th>
                <th>Prova ID</th>
                <th>Nome Prova</th>
                <th>Evento</th>
                <th></th>
              </thead>
              <tbody>
                <?php
                $i = 0;
                $tamanho = count($todas_as_inscricoes);
                do{
                  ?>
                  <tr>
                    <?php
                    if($DAO3->verificar_atleta_clube($todas_as_inscricoes[$i]->get_idatleta(),$clube->get_id())){
                      $detalhes_prova = $DAO5->obter_dados_provaid($todas_as_inscricoes[$i]->get_idprova());
                      $evento = $detalhes_prova->get_eventoid();
                      $infoevento = $DAO2->obter_info_evento($evento);
                      $data_hoje = date("Y-m-d");
                      $dataevento = $infoevento->get_data();

                      $hoje = strtotime($data_hoje);
                      $data =  strtotime($dataevento);

                      if(($infoevento->get_estado())==3){
                        if ($data > $hoje) {
                          echo "<td>".$todas_as_inscricoes[$i]->get_idatleta()."</td>";
                          echo "<td>".$DAO3->obter_nome_apartir_atleta_id($todas_as_inscricoes[$i]->get_idatleta())."</td>";
                          echo "<td>".$todas_as_inscricoes[$i]->get_idprova()."</td>";
                          echo "<td>".$DAO5->obter_nome_apartir_prova_id($todas_as_inscricoes[$i]->get_idprova())."</td>";
                          echo "<td>".$infoevento->get_nome()."</td>";?>
                          <td>
                            <form name="formAtletasProvas" method="POST" id="formAtletasProvas" action="">
                              <button type="submit" class="btn btn-danger" name="btnDel" value="<?php echo $todas_as_inscricoes[$i]->get_idatleta()."_".$todas_as_inscricoes[$i]->get_idprova() ?>">Cancelar Inscrição</button>
                            </form>
                          </td>
                          <?php
                        }
                      }

                    }
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

    <?php
  }else if($a==0){
    ?><h4>Não existem nenhum Atleta do Clube Inscrito em Eventos </h4><?php
  }
}
if($_SERVER['REQUEST_METHOD']==='POST'){

  if(isset($_POST['btnDel'])){
    $valor = $_POST['btnDel'];
    list($atleta, $prova) = explode("_", $valor);
    $DAO4->elimina_atleta_prova($atleta,$prova);
    $DAO10->inserir_log(new Log(0,$_SESSION['U_ID'],date("Y-m-d"),date("H:i:s"),"Eliminação de uma Inscrição de um Atleta"));
    header("Refresh:0");
  }
}

?>
