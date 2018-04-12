
<div class="card">
  <div class="card-header">
    <h4 class="card-title">Criar Administrador Inicial</h4>
  </div>
  <div class="card-body">
    <form name="formAddAdmin" onsubmit="return validaRegisto()" method="POST" action="">
      <div class="row">
        <div class="col-md-5 pr-1">
          <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" maxlength="120" placeholder="Nome..." required >
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 pr-1">
          <div class="form-group">
            <label>Contacto</label>
            <input type="tel" class="form-control" name="contacto" id="contacto"  maxlength="9" required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 pr-1">
          <div class="form-group">
            <label>Email</label>
            <input type="mail" class="form-control" name="email" id="email" placeholder="example@email.com" required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 pr-1">
          <div class="form-group">
            <label>Palavra-Passe</label>
            <input type="password" class="form-control" name="pass" id="pass" required>
          </div>
        </div>
        <div class="col-md-2 px-1">
          <div class="form-group">
            <label>Confirmar Palavra-Passe</label>
            <input type="password" class="form-control" name="pass1" id="pass1" required>
          </div>
        </div>
      </div>
      <small class="form-text text-muted">A palavra-passe deverá conter uma letra maiúscula, um número e um caractere especial</small>
      <br>
      <button type="submit" class="btn btn-success " name="btnAdd" >Adicionar</button>
    </form>
  </div>
</div>

<!--Validação javascript-->
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

/*
* Função que valida os campos do fomulário de registo de senhorios
*/
function validaRegisto() {
  var res = true;
  var input = [document.forms["formAddAdmin"]["contacto"].value, document.forms["formAddAdmin"]["email"].value, document.forms["formAddAdmin"]["pass"].value, document.forms["formAddAdmin"]["pass1"].value];

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
  if(!regexPassword.test(String(input[2]))){
    showNotification('top','center','<strong>Erro!</strong> A palavra-passe deverá conter uma letra maiúscula, um número e um caractere especial.');
    res = false;
  }
  if (input[2] != input[3]) {
    showNotification('top','center','<strong>Erro!</strong> As palavras-passe introduzidas não são iguais.');
    res = false;
  }
  return res;
}
</script>

<!--Validação php-->
<?php
if($_SERVER['REQUEST_METHOD']==='POST'){

  if(isset($_POST['btnAdd'])){
    if(isset($_POST['nome'], $_POST['contacto'], $_POST['email'], $_POST['pass'], $_POST['pass1']) && !empty($_POST['nome']) && !empty($_POST['contacto']) && !empty($_POST['email']) && !empty($_POST['pass']) && !empty($_POST['pass1'])){
      require_once('resources/classes/gereutilizador.class.php');
      $DAO = new GereUtilizador();

        if($DAO->inserir_utilizador(new Utilizador(1,$_POST['nome'], $_POST['email'], password_hash($_POST['pass'], PASSWORD_DEFAULT), $_POST['contacto'], 1,0))){
        showNotification('top','center','Administrador criado com sucesso.');

          //Criar nuts
          //falta criar a pagina para serem inseridos os nuts logo na primeira execução
          //require_once('resources/pages/criaradmin_nuts.php');
          header('Location: index.php');
        }

    }else
      showNotification('top','center','<strong>Erro!</strong> Por favor preencha todos os campos.');
  }
}
 ?>
