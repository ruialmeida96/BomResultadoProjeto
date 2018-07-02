<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=0){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
require_once('./resources/classes/gereassociacao.class.php');
require_once('./resources/classes/gerenuts.class.php');
require_once('./resources/classes/gereutilizador.class.php');
require_once('./resources/classes/gerelog.class.php');
require_once('./resources/classes/gereatleta.class.php');
require_once('./resources/classes/gereevento.class.php');

$DAO4 = new GereAtleta();
$DAO5 = new GereEvento();
$DAO10 = new GereLog();
$DAO = new GereAssociacao();
$DAO2 = new GereNuts();
$obter_todas_as_assoc = $DAO->obter_todas_assoc();
$obter_todos_os_nuts = $DAO2->obter_todos_nuts();
$obter_todos_atletas_recentes = $DAO4->obter_todos_atletas_mais_recentes();
$obter_todos_eventos = $DAO5->obter_todos_eventos();

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
    <?php if($obter_todos_atletas_recentes == null){ ?>
      <h4>Não existem Atletas Disponiveis</h4><br><br>
    <?php }else{ ?>
      <div class="col-md-6">
        <div class="card ">
          <div class="card-header ">
            <h4 class="card-title">Atletas Recentes</h4>
            <p class="card-category">Conjunto de Atletas</p>
          </div>
          <div class="card-body " style="display: block; max-height: 400px; overflow-y: auto; -ms-overflow-style: -ms-autohiding-scrollbar;">
            <table class="table table-hover table-striped">
              <thead>
                <th>ID</th>
                <th>Nome</th>
                <th>Especialidade</th>
                <th>Nacionalidade</th>
                <th>Escalão</th>
              </thead>
              <tbody>
                <?php
                $i = 0;
                $tamanho = count($obter_todos_atletas_recentes);
                do{
                  ?>
                  <tr>
                    <?php
                    echo "<td>".$obter_todos_atletas_recentes[$i]->get_id()."</td>";
                    echo "<td>".$obter_todos_atletas_recentes[$i]->get_nome()."</td>";
                    echo "<td>".$obter_todos_atletas_recentes[$i]->get_especialidade()."</td>";
                    echo "<td>".$obter_todos_atletas_recentes[$i]->get_nacionalidade()."</td>";
                    echo "<td>".mostraescaloes($obter_todos_atletas_recentes[$i]->get_escalao())."</td>";
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
    <?php } ?>
    <?php if($obter_todos_eventos == null){ ?>
      <h4>Não existem Eventos Disponiveis</h4><br><br>
    <?php }else{ ?>
      <div class="col-md-6">
        <div class="card ">
          <div class="card-header ">
            <h4 class="card-title">Eventos deste Mês</h4>
            <p class="card-category">Conjunto de Regiões</p>
          </div>
          <div class="card-body " style="display: block; max-height: 400px; overflow-y: auto; -ms-overflow-style: -ms-autohiding-scrollbar;">
            <table class="table table-hover table-striped">
              <thead>
                <th>ID</th>
                <th>Nome</th>
                <th>Data</th>
                <th>Organizadores</th>
                <th>Estado</th>
              </thead>
              <tbody>
                <?php
                $i = 0;
                $tamanho = count($obter_todos_eventos);
                do{
                  $data_hoje = date("Y-m-d");
                  $pieces = explode("-", $data_hoje);
                  $dataprova = $obter_todos_eventos[$i]->get_data();
                  $hoje = strtotime($data_hoje);
                  $data =  strtotime($dataprova);
                  $pieces2 = explode("-", $dataprova);
                  if($pieces2[1]==$pieces[1]){
                    ?>
                    <tr>
                      <?php
                      echo "<td>".$obter_todos_eventos[$i]->get_id()."</td>";
                      echo "<td>".$obter_todos_eventos[$i]->get_nome()."</td>";
                      if ($data < $hoje) {
                        echo "<td> <p style=color:red;>".$obter_todos_eventos[$i]->get_data()."*</p></td>";
                      }else{
                        echo "<td>".$obter_todos_eventos[$i]->get_data()."</td>";
                      }
                      echo "<td>".$obter_todos_eventos[$i]->get_organizadores()."</td>";
                      echo "<td>".mostraEstado($obter_todos_eventos[$i]->get_estado())."</td>";
                      ?>
                    </tr>
                  <?php
                  }
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
    <?php } ?>

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

function mostraescaloes($num){
  if($num==1){
    return "Benjamins A";
  }else if($num==2){
    return "Benjamins B";
  }else if($num==3){
    return "Infantis";
  }else if($num==4){
    return "Iniciados";
  }else if($num==5){
    return "Juvenis";
  }else if($num==6){
    return "Juniores";
  }else if($num==7){
    return "Sub-23";
  }else if($num==8){
    return "Seniores";
  }else if($num==9){
    return "Veteranos 35";
  }else if($num==10){
    return "Veteranos 40";
  }else if($num==11){
    return "Veteranos 45";
  }else if($num==12){
    return "Veteranos 50";
  }else if($num==13){
    return "Veteranos 55";
  }else if($num==14){
    return "Veteranos 60";
  }else if($num==15){
    return "Veteranos 65";
  }else if($num==16){
    return "Veteranos 70";
  }else if($num==17){
    return "Veteranos 75";
  }else if($num==18){
    return "Veteranos 80";
  }else if($num==19){
    return "Veteranos 85";
  }else if($num==20){
    return "Veteranos 90";
  }
}

function mostraEstado($num){
  if($num==1){
    return "Ativo";
  }else if($num==0){
    return "Pendente";
  }else if($num==2){
    return "Recusado";
  }else if($num==4){
    return "Concluido";
  }else if($num==3){
    return "Com inscrições";
  }
}
?>

<br>
<h5>Como Administrador poderá ser possivel visualizar <strong>Regiões</strong>, <strong>Associações</strong>, <strong>Listagens</strong> e <strong>Logs</strong>.</h5><br>

<h5>No que diz respeito a <strong>Regiões</strong>, é possivel:</h5>
<p>-Adicionar Região<br>-Gerir informaçao de Região (Editar e Eliminar)</p><br>

<h5>No que diz respeito a <strong>Associações</strong>, é possivel:</h5>
<p>-Adicionar Associações<br>-Gerir informação de uma Associação (Editar, Desativar/Ativar e Eliminar)</p><br>

<h5>No que diz respeito a <strong>Listagens</strong>, é possivel:</h5>
<p>-Listar Clubes, Atletas e Eventos</p><br>

<h5>No que diz respeito a <strong>Logs</strong>, é possivel:</h5>
<p>-Listar as ações dos utilizadores</p><br>
<br>
