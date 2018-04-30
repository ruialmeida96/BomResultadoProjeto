<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO'])){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Perfil</h3>

Editar informação do utilizador
<br>
<?php
require_once('./resources/classes/gereutilizador.class.php');
$DAO=new GereUtilizador();

if($DAO->obter_detalhes_utilizador_id($_SESSION['U_ID'])){
  $utilizador = $DAO->obter_detalhes_utilizador_id($_SESSION['U_ID']);
  $idutl = $_SESSION['U_ID'];
  $nomeutl = $utilizador->get_nome();
  $contactoutl = $utilizador->get_contacto();
  $emailutl = $utilizador->get_email();
  $tipoutl =$_SESSION['U_TIPO'];
  $emailant = $emailutl;
}
?>

<div class="card">
  <div class="card-header">
    <h4 class="card-title">Editar Perfil</h4>
  </div>
  <div class="card-body">
    <form name="formSaveInfo" onsubmit="return validaRegisto()" method="POST" action="">
      <div class="row">
        <div class="col-md-5 pr-1">
          <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" maxlength="120" value ='<?php print($nomeutl) ?>' required >
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 pr-1">
          <div class="form-group">
            <label>Contacto</label>
            <input type="tel" class="form-control" name="contacto" id="contacto"  maxlength="9"  value ='<?php print($contactoutl) ?>' required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 pr-1">
          <div class="form-group">
            <label>Email</label>
            <input type="mail" class="form-control" name="email" id="email" value ='<?php print($emailutl) ?>' required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 pr-1">
          <div class="form-group">
            <label>Palavra-Passe Antiga</label>
            <input type="password" class="form-control" name="passant" id="passant" required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 pr-1">
          <div class="form-group">
            <label>Nova Palavra-Passe</label>
            <input type="password" class="form-control" name="pass" id="pass" >
          </div>
        </div>
        <div class="col-md-2 px-1">
          <div class="form-group">
            <label>Confirmar Palavra-Passe</label>
            <input type="password" class="form-control" name="pass1" id="pass1" >
          </div>
        </div>
      </div>
      <small class="form-text text-muted">A palavra-passe deverá conter uma letra maiúscula, um número e um caractere especial</small>
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


function validaRegisto() {
  var res = true;
  var input = [document.forms["formSaveInfo"]["contacto"].value, document.forms["formSaveInfo"]["email"].value, document.forms["formSaveInfo"]["pass"].value, document.forms["formSaveInfo"]["pass1"].value,document.forms["formSaveInfo"]["passant"].value];

  var emailSplit = String(input[1]).split('@');

  //Expressões regulares para validar contacto, e-mail e password
  var regexContacto = /[0-9]{9}/;
  var regexEmail = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
  var regexPassword = /^(?=.*\d)(?=.*[A-Z])(?=.*[!#$%&()*+,-.:;<=>?@_{|}~])/;

  if(!regexContacto.test(String(input[0]))){
    showNotification('top','center','<strong>Erro!</strong> Por favor insira um contacto válido.');
    res = false;
  }
  if(!regexEmail.test(String(input[1]).toLowerCase())){
    showNotification('top','center','<strong>Erro!</strong> Por favor insira um <i>e-mail</i> válido.');
    res = false;
  }
  if(String(input[2]) != ""){
    if(!regexPassword.test(String(input[2]))){
      showNotification('top','center','<strong>Erro!</strong> A palavra-passe deverá conter uma letra maiúscula, um número e um caractere especial.');
      res = false;
    }
  }
  if (input[2] != input[3]) {
    showNotification('top','center','<strong>Erro!</strong> As palavras-passe introduzidas não são iguais.');
    res = false;
  }
  if(!input[4]){
    showNotification('top','center','<strong>Erro!</strong>Por favor insira a palavra-passe antiga.');
    return false;
  }
  return res;
}
</script>

<?php

if($_SERVER['REQUEST_METHOD']==='POST'){

  //Ediçao da informaçao
  if(isset($_POST['btnSave'])){
    if(isset($_POST['nome'], $_POST['contacto'], $_POST['email'], $_POST['passant']) && !empty($_POST['nome']) && !empty($_POST['contacto']) && !empty($_POST['email']) && !empty($_POST['passant'])){

      require_once('./resources/classes/gereutilizador.class.php');
      $DAO = new GereUtilizador();

      //Ver se a password antiga está correta
      if($DAO->password_correta($emailant, $_POST['passant'])){

        //Ver se o e-mail existe
        if($DAO->email_existe($_POST['email']) && $_POST['email'] != $utilizador->get_email()){
          echo '<script>alert("O e-mail já se encontra registado no sistema.");</script>';
        }else{
          //Também pretende alterar a palavra-passe
          if(isset($_POST['pass'], $_POST['pass1']) && !empty($_POST['pass']) && !empty($_POST['pass1'])){
            if($_POST['pass'] != $_POST['pass1']){
              echo '<script>alert("As palavras-passe não são iguais.");</script>';
              return;
            }else
            $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
          }else
          $password = $utilizador->get_password();

          if($DAO->editar_utilizador(new Utilizador($idutl, $_POST['nome'], $_POST['email'], $password, $_POST['contacto'],$tipoutl,1,true))){

            echo '<script>alert("Ediçao feita com sucesso.");</script>';
            echo '<script>document.location.href = "?action=editainfo";</script>';
          }
        }
      }else{
        echo '<script>alert("A palavra-passe antiga não é a correta.");</script>';
      }
    }
  }else
  echo '<script>alert("Por favor preencha todos os campos.");</script>';
}
?>
