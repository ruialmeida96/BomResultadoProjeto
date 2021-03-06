<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=2){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Info Atletas</h3>
<br>
<?php
$idatleta = $_GET["id"];

require_once('./resources/classes/gereclube.class.php');
require_once('./resources/classes/gereatleta.class.php');
require_once('./resources/classes/gereutilizador.class.php');
require_once('./resources/classes/gerelog.class.php');
$DAO10 = new GereLog();


$DAO = new GereAtleta();


if($DAO->obter_detalhes_atleta_id($idatleta)){
  $atleta = $DAO->obter_detalhes_atleta_id($idatleta);
  $nome = $atleta->get_nome();
  $nomeexibe = $atleta->get_nomeexibe();
  $contacto = $atleta->get_contacto();
  $email = $atleta->get_email();
  $especialidade = $atleta->get_especialidade();
  $nacionalidade = $atleta->get_nacionalidade();
  $escalao = $atleta->get_escalao();
}

$DAO2 = new GereClube();
$obter_todos_os_clubes = $DAO2->obter_todas_clubes();

$DAO3 = new GereUtilizador();

?>

<div class="card">
  <div class="card-header">
    <h4 class="card-title">Editar Informação Atleta</h4>
  </div>
  <div class="card-body">
    <form name="formEditaAtleta" onsubmit="return validaEdicao()" method="POST" action="">
      <div class="row">
        <div class="col-md-5 pr-1">
          <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" maxlength="120" value ='<?php print($nome) ?>' required >
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-5 pr-1">
          <div class="form-group">
            <label>Nome de Exibição</label>
            <input type="text" name="nomeex" id="nomeex" class="form-control" maxlength="120" value ='<?php print($nomeexibe) ?>' required >
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 pr-1">
          <div class="form-group">
            <label>Contacto</label>
            <input type="text" class="form-control" name="contacto"  id="contacto" maxlength="75" value ='<?php print($contacto) ?>' required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 pr-1">
          <div class="form-group">
            <label>Email</label>
            <input type="mail" class="form-control" name="email" id="email" value ='<?php print($email) ?>' required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 pr-1">
          <div class="form-group">
            <label>Especialidade</label><br>
            <input type="text" class="form-control" name="especialidade" id="especialidade" maxlength="75" value ='<?php print($especialidade) ?>' required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 pr-1">
          <div class="form-group">
            <label>Nacionalidade</label><br>
            <input type="text" class="form-control" name="nacionalidade" id="nacionalidade"  maxlength="75" value ='<?php print($nacionalidade) ?>' required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 pr-1">
          <div class="form-group">
            <label>Escalão</label><br>
            <br>
            <select name="escalao" id="escalao" required>
              <?php if($escalao==1){
                ?><option value="1" selected="selected">Benjamins A - 7 a 9 anos</option><?php
              }else{?>
                <option value="1">Benjamins A - 7 a 9 anos</option><?php
              }

              if($escalao==2){
                ?><option value="2" selected="selected">Benjamins B - 10 e 11 anos</option><?php
              }else{?>
                <option value="2">Benjamins B - 10 e 11 anos</option><?php
              }

              if($escalao==3){
                ?><option value="3" selected="selected">Infantis - 12 e 13 anos</option><?php
              }else{?>
                <option value="3">Infantis - 12 e 13 anos</option><?php
              }

              if($escalao==4){
                ?><option value="4" selected="selected">Iniciados - 14 e 15 anos</option><?php
              }else{?>
                <option value="4">Iniciados - 14 e 15 anos</option><?php
              }

              if($escalao==5){
                ?><option value="5" selected="selected">Juvenis - 16 e 17 anos</option><?php
              }else{?>
                <option value="5">Juvenis - 16 e 17 anos</option><?php
              }

              if($escalao==6){
                ?><option value="6" selected="selected">Juniores - 18 e 19 anos</option><?php
              }else{?>
                <option value="6">Juniores - 18 e 19 anos</option><?php
              }

              if($escalao==7){
                ?><option value="7" selected="selected">Sub-23 - 20 a 23 anos</option><?php
              }else{?>
                <option value="7">Sub-23 - 20 a 23 anos</option><?php
              }

              if($escalao==8){
                ?><option value="8" selected="selected">Seniores - 24 a 34 anos</option><?php
              }else{?>
                <option value="8">Seniores - 24 a 34 anos</option><?php
              }

              if($escalao==9){
                ?><option value="9" selected="selected">Veteranos 35 - 35 a 39 anos</option><?php
              }else{?>
                <option value="9">Veteranos 35 - 35 a 39 anos</option><?php
              }

              if($escalao==10){
                ?><option value="10" selected="selected">Veteranos 40 - 40 a 44 anos</option><?php
              }else{?>
                <option value="10">Veteranos 40 - 40 a 44 anos</option><?php
              }

              if($escalao==11){
                ?><option value="11" selected="selected">Veteranos 45 - 45 a 49 anos</option><?php
              }else{?>
                <option value="11">Veteranos 45 - 45 a 49 anos</option><?php
              }

              if($escalao==12){
                ?><option value="12" selected="selected">Veteranos 50 - 50 a 54 anos</option><?php
              }else{?>
                <option value="12">Veteranos 50 - 50 a 54 anos</option><?php
              }

              if($escalao==13){
                ?><option value="13" selected="selected">Veteranos 55 - 55 a 59 anos</option><?php
              }else{?>
                <option value="13">Veteranos 55 - 55 a 59 anos</option><?php
              }

              if($escalao==14){
                ?><option value="14" selected="selected">Veteranos 60 - 60 a 64 anos</option><?php
              }else{?>
                <option value="14">Veteranos 60 - 60 a 64 anos</option><?php
              }

              if($escalao==15){
                ?><option value="15" selected="selected">Veteranos 65 - 65 a 69 anos</option><?php
              }else{?>
                <option value="15">Veteranos 65 - 65 a 69 anos</option><?php
              }

              if($escalao==16){
                ?><option value="16" selected="selected">Veteranos 70 - 70 a 74 anos</option><?php
              }else{?>
                <option value="16">Veteranos 70 - 70 a 74 anos</option><?php
              }

              if($escalao==17){
                ?><option value="17" selected="selected">Veteranos 75 - 75 a 79 anos</option><?php
              }else{?>
                <option value="17">Veteranos 75 - 75 a 79 anos</option><?php
              }

              if($escalao==18){
                ?><option value="18" selected="selected">Veteranos 80 - 80 a 84 anos</option><?php
              }else{?>
                <option value="18">Veteranos 80 - 80 a 84 anos</option><?php
              }

              if($escalao==19){
                ?><option value="19" selected="selected">Veteranos 85 - 85 a 89 anos</option><?php
              }else{?>
                <option value="19">Veteranos 85 - 85 a 89 anos</option><?php
              }

              if($escalao==20){
                ?><option value="20" selected="selected">Veteranos 90 - 90 anos em diante</option><?php
              }else{?>
                <option value="20">Veteranos 90 - 90 anos em diante</option><?php
              }
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
  var input = [document.forms["formEditaAtleta"]["email"].value, document.forms["formEditaAtleta"]["contacto"].value];

  var emailSplit = String(input[0]).split('@');

  //Expressões regulares para validar contacto, e-mail e password
  var regexContacto = /[0-9]{9}/;
  var regexEmail = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
  //  var regexPassword = /^(?=.*\d)(?=.*[A-Z])(?=.*[!#$%&()*+,-.:;<=>?@_{|}~])/;

  if(!regexContacto.test(String(input[1]))){
    showNotification('top','center','<strong>Erro!</strong> Por favor insira um contacto válido.');
    //document.getElementById("errocontacto").innerHTML="<strong>Erro!</strong> Por favor insira um contacto válido.";
    res = false;
  }else{
    //document.getElementById("errocontacto").innerHTML="";
  }
  if(!regexEmail.test(String(input[0]).toLowerCase())){
    showNotification('top','center','<strong>Erro!</strong> Por favor insira um <i>e-mail</i> válido.');
    //document.getElementById("erroemail").innerHTML="<strong>Erro!</strong> Por favor insira um <i>e-mail</i> válido.";
    res = false;
  }else{
    //document.getElementById("erroemail").innerHTML="";
  }
  return res;
}
</script>
<?php

if($_SERVER['REQUEST_METHOD']==='POST'){

  //Adicionar associação
  if(isset($_POST['btnSave'])){

    if(isset($_POST['nome'],$_POST['nomeex'],$_POST['email'],$_POST['contacto'],$_POST['especialidade'],$_POST['nacionalidade'],$_POST['escalao']) && !empty($_POST['nome']) && !empty($_POST['nomeex']) && !empty($_POST['email']) && !empty($_POST['contacto']) && !empty($_POST['especialidade']) && !empty($_POST['nacionalidade']) && !empty($_POST['escalao'])){

      //caso seja o mesmo email
      if(strcmp($email,$_POST['email'])===0){
        //atualizamos apenas os dados
        if($DAO->editar_atleta($idatleta,$_POST['nome'],$_POST['nomeex'],$_POST['contacto'],$email,$_POST['especialidade'],$_POST['nacionalidade'],$_POST['escalao'])){
          echo '<script>alert("O Atleta foi editado com sucesso.");</script>';
          $DAO10->inserir_log(new Log(0,$_SESSION['U_ID'],date("Y-m-d"),date("H:i:s"),"Edição de um Atleta"));
          header('Location:?action=atletasclube');
        }else{
          echo '<script>alert("Erro ao editar o Atleta.");</script>';
          header("Refresh:0");
        }
      }else if(strcmp($email,$_POST['email'])!==0){
        //se for diferente é que é necessario verificar nos utilizadores e atletas
        if($DAO3->email_existe($_POST['email'])){
          echo '<script>alert("O email já existe como utilizador.");</script>';
          header("Refresh:0");
        }else if($DAO->email_existe($_POST['email'])){
          echo '<script>alert("O email já se encontra registado como atleta.");</script>';
          header("Refresh:0");
        }else{
          if($DAO->editar_atleta($idatleta,$_POST['nome'],$_POST['nomeex'],$_POST['contacto'],$_POST['email'],$_POST['especialidade'],$_POST['nacionalidade'],$_POST['escalao'])){
            echo '<script>alert("O Atleta foi editado com sucesso.");</script>';
            $DAO10->inserir_log(new Log(0,$_SESSION['U_ID'],date("Y-m-d"),date("H:i:s"),"Edição de um Atleta"));
            header('Location:?action=atletasclube');
          }else{
            echo '<script>alert("Erro ao editar o Atleta.");</script>';
            header("Refresh:0");
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
