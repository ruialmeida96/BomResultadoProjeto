<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=1){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Info Clubes</h3>

Editar informação de um clube
<br>
<?php
$idclube = $_GET["id"];

require_once('./resources/classes/gereclube.class.php');
require_once('./resources/classes/gereutilizador.class.php');

$DAO = new GereClube();
$DAO2 = new GereUtilizador();

if($DAO->obter_detalhes_clube_id($idclube)){
  $clube = $DAO->obter_detalhes_clube_id($idclube);
  $iduserclube=$clube->get_userid();
  $abreviatura = $clube->get_abreviatura();
  $local = $clube->get_localizacao();
  if($DAO2->obter_detalhes_utilizador_id($iduserclube)){
    $utilizador = $DAO2->obter_detalhes_utilizador_id($iduserclube);
    $nome = $utilizador->get_nome();
    $email = $utilizador->get_email();
  }
}

//editar nome, email,abreviatura e localizacao

?>

<div class="card">
  <div class="card-header">
    <h4 class="card-title">Editar Informação Clube</h4>
  </div>
  <div class="card-body">
    <form name="formEditaClube" onsubmit="return validaEdicao()" method="POST" action="">
      <div class="row">
        <div class="col-md-5 pr-1">
          <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" maxlength="120" value ='<?php print($nome) ?>' required >
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
            <input type="mail" class="form-control" name="email" id="email" value ='<?php print($email) ?>' required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 pr-1">
          <div class="form-group">
            <label>Localização</label><br>
            <input type="text" class="form-control" name="local" id="local" maxlength="75" value ='<?php print($local) ?>' required>

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
  var input = [document.forms["formEditaClube"]["email"].value];

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
    if(isset($_POST['nome'],$_POST['abreviatura'],$_POST['email'],$_POST['local']) && !empty($_POST['nome']) && !empty($_POST['abreviatura']) && !empty($_POST['email']) && !empty($_POST['local'])){

      $nomeclubenovo = $_POST['nome'];
      $abreviaturanovo = $_POST['abreviatura'];
      $emailnovo = $_POST['email'];
      $localnovo = $_POST['local'];

      if(strcmp($abreviaturanovo,$abreviatura)===0){
        //abreviatura igual
        if(strcmp($email,$emailnovo)===0){
          if($DAO2->editar_utilizador_associacao_sem_email($iduserclube,$nomeclubenovo)){
            if($DAO->editar_clube_assoc($abreviatura,$localnovo,$idclube)){
              echo '<script>alert("A associação foi editada com sucesso.");</script>';
              //header("Refresh:0");
              header('Location:?action=clubesassoc');
              //showNotification('top','center','A associação foi editada com sucesso.');
            }else{
              echo '<script>alert("Erro ao editar a associação na tabela associação.");</script>';
              header("Refresh:0");
            }

          }else{
            echo '<script>alert("Erro ao editar a associação na tabela utilizador.");</script>';
            header("Refresh:0");
          }

        }else if (strcmp($email,$emailnovo)!==0){
          if($DAO2->email_existe($_POST['email'])){
            echo '<script>alert("O novo email já existe como email de um utilizador.");</script>';
            header("Refresh:0");
          }else{
            if($DAO2->editar_utilizador_associacao($iduserclube,$nomeclubenovo,$emailnovo)){
              if($DAO->editar_clube_assoc($abreviatura,$localnovo,$idclube)){
                echo '<script>alert("A associação foi editada com sucesso.");</script>';
                //header("Refresh:0");
                header('Location:?action=clubesassoc');
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
      }else if(strcmp($abreviaturanovo,$abreviatura)!==0){
        //abreviatura diferente
        if($DAO->clube_existe($_POST['abreviatura'])){
          echo '<script>alert("Um clube com essa abreviatura já se encontra registado.");</script>';
          header("Refresh:0");
        }else{
          if(strcmp($email,$emailnovo)===0){
            if($DAO2->editar_utilizador_associacao_sem_email($iduserclube,$nomeclubenovo)){
              if($DAO->editar_clube_assoc($abreviaturanovo,$localnovo,$idclube)){
                echo '<script>alert("A associação foi editada com sucesso.");</script>';
                //header("Refresh:0");
                header('Location:?action=clubesassoc');
              }else{
                echo '<script>alert("Erro ao editar a associação na tabela associação.");</script>';
                header("Refresh:0");
              }

            }else{
              echo '<script>alert("Erro ao editar a associação na tabela utilizador.");</script>';
              header("Refresh:0");
            }

          }else if (strcmp($email,$emailnovo)!==0){
            if($DAO2->email_existe($_POST['email'])){
              echo '<script>alert("O novo email já existe como email de um utilizador.");</script>';
              header("Refresh:0");
            }else{
              if($DAO2->editar_utilizador_associacao($iduserclube,$nomeclubenovo,$emailnovo)){
                if($DAO->editar_clube_assoc($abreviaturanovo,$localnovo,$idclube)){
                  echo '<script>alert("A associação foi editada com sucesso.");</script>';
                  //header("Refresh:0");
                  header('Location:?action=clubesassoc');
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
      }
    }else{
      echo '<script>alert("Por favor preencha todos os campos.");</script>';
      header("Refresh:0");
    }
  }
}
?>
