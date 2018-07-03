<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=0){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Info Região</h3>
<br>
<?php
$idnuts = $_GET["id"];

require_once('./resources/classes/gerenuts.class.php');
require_once('./resources/classes/gerelog.class.php');
$DAO10 = new GereLog();

$DAO = new GereNuts();


if($DAO->obter_nuts_espec($idnuts)){
  $reg = $DAO->obter_nuts_espec($idnuts);
  $nome = $reg->get_regiao();
}
?>
<div class="card">
  <div class="card-header">
    <h4 class="card-title">Editar Informação Associação</h4>
  </div>
  <div class="card-body">
    <form name="formEditAssoc" method="POST" action="">
      <div class="row">
        <div class="col-md-5 pr-1">
          <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" id="btnSave" class="form-control" maxlength="120" value ='<?php print($nome) ?>' required >
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-success " name="btnSave" >Guardar</button>
    </form>
  </div>
</div>

<?php
if($_SERVER['REQUEST_METHOD']==='POST'){
  $novonome=$_POST['nome'];
  if(strcmp($nome,$novonome)===0){
    echo '<script>alert("O nome da região é igual.");</script>';
    header("Refresh:0");
  }else{
    if($DAO->regiao_existe($_POST['nome'])){
      echo '<script>alert("A região que adicionou já se encontra registada.");</script>';
      header("Refresh:0");
    }else{
      if($DAO->editar_nuts($idnuts,$novonome)){
        echo '<script>alert("A Região foi editada com sucesso.");</script>';
        $DAO10->inserir_log(new Log(0,$_SESSION['U_ID'],date("Y-m-d"),date("H:i:s"),"Edição de uma Região"));
        header('Location:?action=nuts');
      }else{
        echo '<script>alert("Erros ao editar a Região.");</script>';
        header('Location:?action=nuts');
      }
    }
  }

}
?>
