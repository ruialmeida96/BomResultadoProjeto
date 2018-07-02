<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=0){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
require_once('./resources/classes/gerenuts.class.php');
require_once('./resources/classes/gereassociacao.class.php');
require_once('./resources/classes/gerenuts.class.php');
require_once('./resources/classes/gereutilizador.class.php');
require_once('./resources/classes/gerelog.class.php');
$DAO10 = new GereLog();
$DAO = new GereAssociacao();
$obter_todas_as_assoc = $DAO->obter_todas_assoc();

$DAO2 = new GereNuts();
$obter_todos_os_nuts = $DAO2->obter_todos_nuts();

$DAO3 = new GereUtilizador();
if($DAO->obter_todas_assoc()==null){
  ?>

  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Inserir Associação Nacional</h4>
    </div>
    <div class="card-body">
      <form  name="formAddAssoc" onsubmit="return validaRegisto()" method="POST" id="AddAssociacao" action="">
        <div class="col-md-5 pr-1">
          <div class="form-group">
            <label>Nome da Associação(Abreviatura)</label>
            <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome da associação..." required >
          </div>
        </div>
        <div class="col-md-5 pr-1">
          <div class="form-group">
            <label>Email</label>
            <div id="erroemail" style="color:red;"></div>
            <input type="mail" class="form-control" name="email" id="email" placeholder="example@email.com" required>
          </div>
        </div>
        <div class="col-md-2 pr-1">
          <div class="form-group">
            <label>Contacto</label>
            <div id="errocontacto" style="color:red;"></div>
            <input type="tel" class="form-control" name="contacto" id="contacto"  maxlength="9" required>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" name="btnAdd" >Adicionar</button>
      </div>
    </form>
  </div>
</div>

<?php
}else{


  $time = date("H");

  if ($time < "12") {
    echo "<h3>Bom dia,</h3>";
  } else  if ($time >= "12" && $time < "20") {
    echo "<h3>Boa tarde,</h3>";
  } else if ($time >= "20") {
    echo "<h3>Boa noite,</h3>";
  }


  ?>

  <h4>Nesta interface poderá ser visualizar Funcionários, Produtos/Serviços, Equipas de Venda e Tarefas para cada Equipa.</h4>

  <h4>No que diz respeito a Funcionários, é possivel:</h4>
  <p>-Adicionar Funcionário<br>-Editar Informação de Funcionário<br>-Desativar/Ativar um Funcionário<br>-Eliminar Funcionário</p><br>

  <h4>No que diz respeito a Produtos/Serviços, é possivel:</h4>
  <p>-Adicionar Produtos/Serviços<br>-Editar Informação de um Produto/Serviço<br>-Desativar/Ativar Produto/Serviço<br>Eliminar Produto/Serviço</p><br>

  <h4>No que diz respeito a Equipas de Venda, é possivel:</h4>
  <p>-Adicionar Equipa de Venda<br>-Editar Informação de uma Equipa de Venda<br>-Desativar/Ativar Equipa de Venda</p><br>

  <h4>No que diz respeito a Tarefas, é possivel:</h4>
  <p>-Visualizar Toda a Informação das Várias Tarefas Indicadas a Uma Equipa<br>-Desativar/Ativar Tarefas para Equipa(Apenas o Administrador Pode Desativar/Ativar Tarefas)</p><br>
  <br>
  <div class="row">
    <?php if($obter_todos_os_nuts == null){ ?>
      <h4>Não existem Regiões Disponiveis</h4><br><br>
    <?php }else{ ?>
      <div class="col-md-4">
        <div class="card ">
          <div class="card-header ">
            <h4 class="card-title">Regiões</h4>
            <p class="card-category">Conjunto de Regiões</p>
          </div>
          <div class="card-body " style="display: block; max-height: 400px; overflow-y: auto; -ms-overflow-style: -ms-autohiding-scrollbar;">
            <table class="table table-hover table-striped" >
              <thead>
                <th>ID</th>
                <th>Nome</th>
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
                  </tr>
                  <?php
                  $i++;
                }while ($i<$tamanho);
                ?>
              </tbody>
            </table>
          </div>
          <div class="card-footer ">
            <br>
            <hr>
            <a class="stats" href="?action=nuts">
              Mais informações >>
            </a>
          </div>
        </div>
      </div>

      <?php
    }
    if($obter_todas_as_assoc == null){ ?>
      <h4>Não existem Associações Disponiveis</h4><br><br>
    <?php }else{?>
      <div class="col-md-8">
        <div class="card ">
          <div class="card-header ">
            <h4 class="card-title">Associações</h4>
            <p class="card-category">Conjunto de Associações</p>
          </div>
          <div class="card-body" style="display: block; max-height: 400px; overflow-y: auto; -ms-overflow-style: -ms-autohiding-scrollbar;">
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
                    echo "<td> <div class='form-check'>".$obter_todas_as_assoc[$i]->get_id()." </div></td>";
                    echo "<td>".$DAO3->obter_nome_apartir_id($obter_todas_as_assoc[$i]->get_userid())."</td>";
                    echo "<td>".$DAO2->obter_nome_apartir_id($obter_todas_as_assoc[$i]->get_nutsid())." (".$obter_todas_as_assoc[$i]->get_nutsid().")</td>";
                    echo "<td>".$obter_todas_as_assoc[$i]->get_abreviatura()."</td>";
                    ?>
                  </tr>
                  <?php
                  $i++;
                }while ($i<$tamanho);
                ?>
              </tbody>
            </table>
          </div>
          <div class="card-footer ">
            <br>
            <hr>
            <a class="stats" href="?action=associacoesadmin">
              Mais informações >>
            </a>
          </div>
        </div>
      </div>
    <?php }
    ?>
  </div>
  <br>
  <div class="row">
    <div class="col-md-6">
      <div class="card ">
        <div class="card-header ">
          <h4 class="card-title">Atletas Recentes</h4>
          <p class="card-category">Conjunto de Atletas</p>
        </div>
        <div class="card-body " style="display: block; max-height: 400px; overflow-y: auto; -ms-overflow-style: -ms-autohiding-scrollbar;">
          <table class="table table-hover table-striped" >
            <thead>
              <th>ID</th>
              <th>Nome</th>
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
                </tr>
                <?php
                $i++;
              }while ($i<$tamanho);
              ?>
            </tbody>
          </table>
        </div>
        <div class="card-footer ">
          <br>
          <hr>
          <a class="stats" href="?action=atletasadmin">
            Mais informações >>
          </a>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card ">
        <div class="card-header ">
          <h4 class="card-title">Eventos Proximos</h4>
          <p class="card-category">Conjunto de Regiões</p>
        </div>
        <div class="card-body " style="display: block; max-height: 400px; overflow-y: auto; -ms-overflow-style: -ms-autohiding-scrollbar;">
          <table class="table table-hover table-striped" >
            <thead>
              <th>ID</th>
              <th>Nome</th>
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
                </tr>
                <?php
                $i++;
              }while ($i<$tamanho);
              ?>
            </tbody>
          </table>
        </div>
        <div class="card-footer ">
          <br>
          <hr>
          <a class="stats" href="?action=eventosadmin">
            Mais informações >>
          </a>
        </div>
      </div>
    </div>

  </div>

<?php } ?>

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
    if(isset($_POST['nome'],$_POST['email'],$_POST['contacto']) && !empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['contacto'])){


      if($DAO->associacao_existe($_POST['nome'])){
        echo '<script>alert("A associação que adicionou já se encontra registada.");</script>';
        header("Refresh:0");
      }else{
        if($DAO3->email_existe($_POST['email'])){
          echo '<script>alert("O email já existe como utilizador.");</script>';
          header("Refresh:0");
        }else{
          $nomeassoc = $_POST['nome'];
          $passwordgera = gera_password();
          if($DAO3->inserir_utilizador(new Utilizador(0,$nomeassoc,$_POST['email'],password_hash($passwordgera, PASSWORD_DEFAULT),$_POST['contacto'],1,1,1,true))){
            $valorid = $DAO3->obter_detalhes_utilizador_email_retorna_id($_POST['email']);
            if($DAO->inserir_associacao(new Associacao(0,$valorid,1,$_POST['nome'],1,true))){
              echo '<script>alert("A associação foi criada com sucesso.");</script>';

              $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
              $corpomensagem = "Olá<br><br>,A sua palavra passe para utilização na nossa aplicação é:$passwordgera.<br>Agradecemos pela disponibilizade<br>BomResultado";
              enviaMail($email, 'Password Inicial', $corpomensagem);
              $DAO10->inserir_log(new Log(0,$_SESSION['U_ID'],date("Y-m-d"),date("H:i:s"),"Inserção de uma nova Associação"));
              header('Location:index.php');
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

}

?>
