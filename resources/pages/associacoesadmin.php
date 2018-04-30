<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=0){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Associações</h3>

Listar associações, adicionar associaçoes(botao na parte de cima), e edita-las(editar info e eliminar)
<br>
<div class="row">
  <div >
    <a  class="nav-link" data-toggle="modal" data-target="#myModaladdAssoc" href="#">
      <span class="nc-icon nc-simple-add"> Adicionar Associação</span>
    </a>
  </div>
</div>

<?php
require_once('./resources/classes/gereassociacao.class.php');
require_once('./resources/classes/gerenuts.class.php');
require_once('./resources/classes/gereutilizador.class.php');

$DAO = new GereAssociacao();
$obter_todas_as_assoc = $DAO->obter_todas_assoc();

$DAO2 = new GereNuts();
$obter_todos_os_nuts = $DAO2->obter_todos_nuts();

$DAO3 = new GereUtilizador();

?>

<?php if($obter_todas_as_assoc == null){ ?>
  <h4>Não existem Associações Disponiveis</h4><br><br>
<?php }else{ ?>
  <div class="row">
    <div class="col-md-12">
      <div class="card strpied-tabled-with-hover">
        <div class="card-header ">
          <h4 class="card-title">Lista de Associações Disponiveis</h4>
          <p class="card-category">Detalhes das associções disponiveis na aplicação</p>
        </div>
        <div class="card-body table-full-width table-responsive">
          <table class="table table-hover table-striped">
            <thead>
              <th>ID</th>
              <th>Nome</th>
              <th>Região</th>
              <th>Abreviatura</th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              $tamanho = count($obter_todas_as_assoc);
              do{
                ?>
                <tr>
                  <?php
                  echo "<td>".$obter_todas_as_assoc[$i]->get_id()."</td>";
                  echo "<td>".$DAO3->obter_nome_apartir_id($obter_todas_as_assoc[$i]->get_userid())."</td>";
                  echo "<td>".$DAO2->obter_nome_apartir_id($obter_todas_as_assoc[$i]->get_nutsid())."</td>";
                  echo "<td>".$obter_todas_as_assoc[$i]->get_abreviatura()."</td>";
                  ?>
                  <td>
                    <button class="btn btn-info" onclick="location.href='?action=editaassoc&id=<?php echo $obter_todas_as_assoc[$i]->get_id()?>'" >Editar</button>
                    <form method="POST" id="DelAssociacao" action="">
                      <button type="submit" class="btn btn-danger" name="btnDelete" value="<?php echo $obter_todas_as_assoc[$i]->get_id()?>">Eliminar</button>
                    </form>
                    <?php
                    if($DAO3->obter_estado_utilizador_id($obter_todas_as_assoc[$i]->get_userid())==1){
                     ?>
                    <form method="POST" id="DesativaAssociacao" action="">
                      <button type="submit" class="btn btn-default" name="btnDesativa" value="<?php echo $obter_todas_as_assoc[$i]->get_id()?>">Desativar</button>
                    </form>
                    <?php

                  }else if ($DAO3->obter_estado_utilizador_id($obter_todas_as_assoc[$i]->get_userid())==0){ ?>
                    <form method="POST" id="AtivaAssociacao" action="">
                      <button type="submit" class="btn btn-success" name="btnAtiva" value="<?php echo $obter_todas_as_assoc[$i]->get_id()?>">Ativar</button>
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
<?php } ?>


<!--email,contacto, nuts id e abreviatura-->

<div class="modal fade modal-primary" id="myModaladdAssoc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h4 class="modal-title" id="exampleModalLabel">Adicionar Associação</h4>
        <div style=" position:absolute;top:0;right:0;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body text-center">
        <form  name="formAddAssoc" onsubmit="return validaRegisto()" method="POST" id="AddAssociacao" action="">
          <label>Nome da Associação(Abreviatura)</label>
          <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome da associação..." required >

          <label>Email</label>
          <div id="erroemail" style="color:red;"></div>
          <input type="mail" class="form-control" name="email" id="email" placeholder="example@email.com" required>

          <label>Contacto</label>
          <div id="errocontacto" style="color:red;"></div>
          <input type="tel" class="form-control" name="contacto" id="contacto"  maxlength="9" required>

          <label>Região</label><br>
          <select name="regiao" id="regiao">
            <?php
            $i = 0;
            $tamanho2 = count($obter_todos_os_nuts);
            do{
              echo "<option value=".$obter_todos_os_nuts[$i]->get_id().">".$obter_todos_os_nuts[$i]->get_regiao()."</option>";
              $i++;
            }while ($i<$tamanho2);
            ?>
          </select>
        </div>
        <div class="modal-footer">
          <span></span>
          <button type="submit" class="btn btn-success" name="btnAdd" >Adicionar</button>
        </div>
      </form>

    </div>
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
  var input = [document.forms["formAddAssoc"]["nome"].value, document.forms["formAddAssoc"]["email"].value, document.forms["formAddAssoc"]["contacto"].value];

  var emailSplit = String(input[1]).split('@');

  //Expressões regulares para validar contacto, e-mail e password
  var regexContacto = /[0-9]{9}/;
  var regexEmail = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
//  var regexPassword = /^(?=.*\d)(?=.*[A-Z])(?=.*[!#$%&()*+,-.:;<=>?@_{|}~])/;

  if(!regexContacto.test(String(input[2]))){
    showNotification('top','center','<strong>Erro!</strong> Por favor insira um contacto válido.');
    document.getElementById("errocontacto").innerHTML="<strong>Erro!</strong> Por favor insira um contacto válido.";
    res = false;
  }else{
    document.getElementById("errocontacto").innerHTML="";
  }
  if(!regexEmail.test(String(input[1]).toLowerCase())){
    showNotification('top','center','<strong>Erro!</strong> Por favor insira um <i>e-mail</i> válido.');
    document.getElementById("erroemail").innerHTML="<strong>Erro!</strong> Por favor insira um <i>e-mail</i> válido.";
    res = false;
  }else{
    document.getElementById("erroemail").innerHTML="";
  }
  return res;
}
</script>



<?php

function gera_password() {
  $maiusculas = range('A', 'Z');
  $minusculas = range('a', 'z');
  $numeros = range(1, 9);
  $especiais = str_split("!#$%&()*+,-.:;<=>?@_{|}~");

  $caracteres = array_merge($maiusculas, $minusculas, $numeros, $especiais);

  $password = "";
  $caracteres_len = count($caracteres);

  for($i = 0; $i < 8; $i++){
    $password .= $caracteres[mt_rand(0, $caracteres_len-1)];
  }

  return $password;
}


//  nomeassoc, email, contacto, regiao

if($_SERVER['REQUEST_METHOD']==='POST'){
  require_once('./resources/configs/email.php');

  //Adicionar associação
  if(isset($_POST['btnAdd'])){
    if(isset($_POST['nome'],$_POST['email'],$_POST['contacto'],$_POST['regiao']) && !empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['contacto']) && !empty($_POST['regiao'])){


      if($DAO->associacao_existe($_POST['nome'])){
        echo '<script>alert("A associação que adicionou já se encontra registada.");</script>';
        header("Refresh:0");
      }else{
        if($DAO3->email_existe($_POST['email'])){
          echo '<script>alert("O email já existe como utilizador.");</script>';
          header("Refresh:0");
        }else{
          $nomeassoc = "Associação ".$_POST['nome'];
          $passwordgera = gera_password();
          if($DAO3->inserir_utilizador(new Utilizador(0,$nomeassoc,$_POST['email'],password_hash($passwordgera, PASSWORD_DEFAULT),$_POST['contacto'],1,1,1,true))){
            $valorid = $DAO3->obter_detalhes_utilizador_email_retorna_id($_POST['email']);
            if($DAO->inserir_associacao(new Associacao(0,$valorid,$_POST['regiao'],$_POST['nome'],1,true))){
              echo '<script>alert("A associação foi criada com sucesso.");</script>';



              $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
              $corpomensagem = "Olá<br><br>,A sua palavra passe para utilização na nossa aplicação é:$passwordgera.<br>Agradecemos pela disponibilizade<br>BomResultado";
              enviaMail($email, 'Password Inicial', $corpomensagem);

              header("Refresh:0");

            }else{
              echo '<script>alert("Erro ao criar associação depois de criar utilizador.");</script>';
              header("Refresh:0");
            }
          }else{
            echo '<script>alert("Erro ao criar o utilizador da associação.");</script>';
            header("Refresh:0");
          }
        }
      }
    }else{
      echo '<script>alert("Por favor preencha todos os campos.");</script>';
      header("Refresh:0");
    }
  }

  if(isset($_POST['btnDelete'])){
    $idassoc = $_POST['btnDelete'];
    $iduser = $DAO->obter_iduser_apartir_idassoc($idassoc);
    if($DAO->elimina_associacao($idassoc,$iduser)){
      echo '<script>alert("Associação eliminada com sucesso.");</script>';
      header("Refresh:0");
    }else{
      echo '<script>alert("Ocorreu um erro ao eliminar a associação");</script>';
    }
  }

  if(isset($_POST['btnDesativa'])){
    $idassoc = $_POST['btnDesativa'];
    $iduser = $DAO->obter_iduser_apartir_idassoc($idassoc);
    if($DAO3->desativa_conta($iduser)){
      //echo '<script>alert("Associação desativa com sucesso.");</script>';
      header("Refresh:0");
    }else{
      echo '<script>alert("Ocorreu um erro ao desativar a associação");</script>';
    }
  }

  if(isset($_POST['btnAtiva'])){
    $idassoc = $_POST['btnAtiva'];
    $iduser = $DAO->obter_iduser_apartir_idassoc($idassoc);
    if($DAO3->ativa_conta($iduser)){
      //echo '<script>alert("Associação ativa com sucesso.");</script>';
      header("Refresh:0");
    }else{
      echo '<script>alert("Ocorreu um erro ao ativar a associação");</script>';
    }
  }



}




?>
