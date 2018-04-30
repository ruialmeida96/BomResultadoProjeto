<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=0){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Info Associação</h3>

Editar informação da associação
<br>
<?php
$idassoc = $_GET["id"];
//echo $idassoc;
require_once('./resources/classes/gereassociacao.class.php');
require_once('./resources/classes/gereutilizador.class.php');
require_once('./resources/classes/gerenuts.class.php');

$DAO=new GereAssociacao();
$DAO2=new GereUtilizador();
$DAO3= new GereNuts();

$obter_todos_os_nuts = $DAO3->obter_todos_nuts();


if($DAO->obter_detalhes_associação_id($idassoc)){
  $associacao = $DAO->obter_detalhes_associação_id($idassoc);
  $idutl = $associacao->get_userid();
  $idnuts = $associacao->get_nutsid();
  $abreviatura = $associacao->get_abreviatura();
  if($DAO2->obter_detalhes_utilizador_id($idutl)){
    $utilizador = $DAO2->obter_detalhes_utilizador_id($idutl);
    $nomeass = $utilizador->get_nome();
    $emailass = $utilizador->get_email();
  }
}
?>

<div class="card">
  <div class="card-header">
    <h4 class="card-title">Editar Informação Associação</h4>
  </div>
  <div class="card-body">
    <form name="formEditAssoc" onsubmit="return validaEdicao()" method="POST" action="">
      <div class="row">
        <div class="col-md-5 pr-1">
          <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" id="btnSave" class="form-control" maxlength="120" value ='<?php print($nomeass) ?>' required >
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 pr-1">
          <div class="form-group">
            <label>Abreviatura</label>
            <input type="text" class="form-control" name="abreviatura" id="abreviatura" maxlength="75" value ='<?php print($abreviatura) ?>' required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 pr-1">
          <div class="form-group">
            <label>Email</label>
            <input type="mail" class="form-control" name="email" id="email" value ='<?php print($emailass) ?>' required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 pr-1">
          <div class="form-group">
            <label>Região</label><br>
            <select name="regiao" id="regiao" required >
              <?php
              $i = 0;
              $tamanho2 = count($obter_todos_os_nuts);
              do{
                if($obter_todos_os_nuts[$i]->get_id()==$idnuts){
                  echo "<option selected='selected' value=".$obter_todos_os_nuts[$i]->get_id().">".$obter_todos_os_nuts[$i]->get_regiao()."</option>";
                }else{
                  echo "<option value=".$obter_todos_os_nuts[$i]->get_id().">".$obter_todos_os_nuts[$i]->get_regiao()."</option>";
                }
                $i++;
              }while ($i<$tamanho2);
              ?>
            </select>
          </div>
        </div>
      </div>
      <br>
      <button type="submit" class="btn btn-success " name="btnSave" >Guardar</button>
    </form>
  </div>
</div>

<script>

/*funçao para mostrar notificaçoes*/
function showNotification(from, align,communication){
  color = Math.floor((Math.random() * 4) + 1);

  $.notify({
    icon: "pe-7s-gift",
    message:communication

  },{
    type: type[color],
    timer: 4000,
    placement: {
      from: from,
      align: align
    }
  });
}

function validaEdicao() {
  var res = true;
  var input = [document.forms["formEditAssoc"]["email"].value];

  var emailSplit = String(input[0]).split('@');

  //Expressões regulares para validar contacto, e-mail e password
  //var regexContacto = /[0-9]{9}/;
  var regexEmail = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
  //  var regexPassword = /^(?=.*\d)(?=.*[A-Z])(?=.*[!#$%&()*+,-.:;<=>?@_{|}~])/;

  if(!regexEmail.test(String(input[0]).toLowerCase())){
    showNotification('top','center','<strong>Erro!</strong> Por favor insira um <i>e-mail</i> válido.');
    res = false;
  }
  return res;
}
</script>
<?php

if($_SERVER['REQUEST_METHOD']==='POST'){

  //Adicionar associação
  if(isset($_POST['btnSave'])){
    if(isset($_POST['nome'],$_POST['abreviatura'],$_POST['email'],$_POST['regiao']) && !empty($_POST['nome']) && !empty($_POST['abreviatura']) && !empty($_POST['email']) && !empty($_POST['regiao'])){


      $nomeassocnovo = $_POST['nome'];
      $abreviaturanovo = $_POST['abreviatura'];
      $emailnovo = $_POST['email'];
      $regiaonova = $_POST['regiao'];
      //$idassoc é o id da associação e $idutl é o id do utilizador

      if($DAO->associacao_existe($_POST['abreviatura'])){
        echo '<script>alert("Uma associação com essa abreviatura já se encontra registada.");</script>';
        header("Refresh:0");
      }else{
        if(strcmp($emailass,$emailnovo)==0){
          echo 'email igual';
          if($DAO2->editar_utilizador_associacao_sem_email($idutl,$nomeassocnovo)){
            if($DAO->editar_associacao_admin($abreviaturanovo,$regiaonova,$idassoc)){
              echo '<script>alert("A associação foi editada com sucesso.");</script>';
              header("Refresh:0");
            }else{
              echo '<script>alert("Erro ao editar a associação na tabela associação.");</script>';
              header("Refresh:0");
            }

          }else{
            echo '<script>alert("Erro ao editar a associação na tabela utilizador.");</script>';
            header("Refresh:0");
          }

        }else if (strcmp($emailass,$emailnovo)!=0){
          echo 'email diferente';
          if($DAO2->email_existe($_POST['email'])){
            echo '<script>alert("O novo email já existe como email de um utilizador.");</script>';
            header("Refresh:0");
          }else{
            if($DAO2->editar_utilizador_associacao($idutl,$nomeassocnovo,$emailnovo)){
              if($DAO->editar_associacao_admin($abreviaturanovo,$regiaonova,$idassoc)){
                echo '<script>alert("A associação foi editada com sucesso.");</script>';
                header("Refresh:0");
              }else{
                echo '<script>alert("Erro ao editar a associação na tabela associação.");</script>';
                header("Refresh:0");
              }

            }else{
              echo '<script>alert("Erro ao editar a associação na tabela utilizador.");</script>';
              header("Refresh:0");
            }
          }
        }
      }
    }else{
      echo '<script>alert("Por favor preencha todos os campos.");</script>';
      header("Refresh:0");
    }
  }
}
?>
