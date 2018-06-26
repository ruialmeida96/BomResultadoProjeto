<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=2){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Atletas</h3>
Listar atletas, adicionar e edita-los(editar info e eliminar)

<br>
<div class="row">
  <div >
    <a  class="nav-link" data-toggle="modal" data-target="#myModaladdAtleta" href="#">
      <span class="nc-icon nc-simple-add"> Adicionar Atleta</span>
    </a>
  </div>
</div>

<?php

$id_user_clube = $_SESSION['U_ID'];

require_once('./resources/classes/gereclube.class.php');
require_once('./resources/classes/gereatleta.class.php');
require_once('./resources/classes/gereutilizador.class.php');
require_once('./resources/classes/gerelog.class.php');
$DAO10 = new GereLog();

$DAO = new GereAtleta();

$DAO2 = new GereClube();
$obter_todos_os_clubes = $DAO2->obter_todas_clubes();

$clubeid= $DAO2->obter_clube_id_clube_userid($id_user_clube);

$obter_todos_os_atletas = $DAO->obter_todos_atletas_do_clube($clubeid);

$DAO3 = new GereUtilizador();


$DAO10->inserir_log(new Log(0,$_SESSION['U_ID'],date("Y-m-d"),date("H:i:s"),"Listagem de Atletas ao Clube"));


if($obter_todos_os_atletas == null){ ?>
  <h4>Não existem Atletas Disponiveis</h4><br><br>
<?php }else{ ?>
  <div class="row">
    <div class="col-md-12">
      <div class="card strpied-tabled-with-hover">
        <div class="card-header ">
          <h4 class="card-title">Lista de Atletas Disponiveis</h4>
          <p class="card-category">Detalhes dos atletas disponiveis na aplicação</p>
        </div>
        <div class="card-body table-full-width table-responsive">
          <table class="table table-hover table-striped">
            <thead>
              <th>ID</th>
              <th>Nome</th>
              <th>Nome Exibição</th>
              <th>Contacto</th>
              <th>Email</th>
              <th>Especialidade</th>
              <th>Nacionalidade</th>
              <th>Escalão</th>
              <th></th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              $tamanho = count($obter_todos_os_atletas);
              do{
                ?>
                <tr>
                  <?php
                  echo "<td>".$obter_todos_os_atletas[$i]->get_id()."</td>";
                  echo "<td>".$obter_todos_os_atletas[$i]->get_nome()."</td>";
                  echo "<td>".$obter_todos_os_atletas[$i]->get_nomeexibe()."</td>";
                  echo "<td>".$obter_todos_os_atletas[$i]->get_contacto()."</td>";
                  echo "<td>".$obter_todos_os_atletas[$i]->get_email()."</td>";
                  echo "<td>".$obter_todos_os_atletas[$i]->get_especialidade()."</td>";
                  echo "<td>".$obter_todos_os_atletas[$i]->get_nacionalidade()."</td>";
                  echo "<td>".mostraescaloes($obter_todos_os_atletas[$i]->get_escalao())."</td>";
                  ?>
                  <td>
                    <button class="btn btn-info" onclick="location.href='?action=editaatleta&id=<?php echo $obter_todos_os_atletas[$i]->get_id()?>'" >Editar</button>
                    <form method="POST" id="DelAtleta" action="">
                      <button type="submit" class="btn btn-danger" name="btnDelete" value="<?php echo $obter_todos_os_atletas[$i]->get_id()?>">Eliminar</button>
                    </form>
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
<?php }  ?>


<div class="modal fade modal-primary" id="myModaladdAtleta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h4 class="modal-title" id="exampleModalLabel">Adicionar Atleta</h4>
        <div style=" position:absolute;top:0;right:0;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body text-center">
        <form name="formAddClube" onsubmit="return validaRegisto()" method="POST" id="formAddClube" action="">

          <label>Nome do Atleta</label>
          <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome do Atleta..." maxlength="130" required >

          <label>Nome de Exibição</label>
          <input type="text" name="nomeex" id="nomeex" class="form-control" placeholder="Nome de Exibição..." maxlength="80" required >

          <label>Email</label>
          <div id="erroemail" style="color:red;"></div>
          <input type="mail" class="form-control" name="email" id="email" placeholder="example@email.com" required>

          <label>Contacto</label>
          <div id="errocontacto" style="color:red;"></div>
          <input type="tel" class="form-control" name="contacto" id="contacto"  maxlength="9" placeholder="Contacto do Atleta..." required>

          <label>Especialidade</label>
          <input type="text" name="especialidade" id="especialidade" class="form-control" placeholder="Especialidade do Atleta..." required>

          <label>Nacionalidade</label>
          <input type="text" name="nacionalidade" id="nacionalidade" class="form-control" placeholder="Nacionalidade do Atleta..." required>

          <label>Escalão</label>
          <br>
          <select name="escalao" id="escalao" required>
            <option value="1" selected="selected">Benjamins A - 7 a 9 anos</option>
            <option value="2">Benjamins B - 10 e 11 anos</option>
            <option value="3">Infantis - 12 e 13 anos</option>
            <option value="4">Iniciados - 14 e 15 anos</option>
            <option value="5">Juvenis - 16 e 17 anos</option>
            <option value="6">Juniores - 18 e 19 anos</option>
            <option value="7">Sub-23 - 20 a 23 anos</option>
            <option value="8">Seniores - 24 a 34 anos</option>
            <option value="9">Veteranos 35 - 35 a 39 anos</option>
            <option value="10">Veteranos 40 - 40 a 44 anos</option>
            <option value="11">Veteranos 45 - 45 a 49 anos</option>
            <option value="12">Veteranos 50 - 50 a 54 anos</option>
            <option value="13">Veteranos 55 - 55 a 59 anos</option>
            <option value="14">Veteranos 60 - 60 a 64 anos</option>
            <option value="15">Veteranos 65 - 65 a 69 anos</option>
            <option value="16">Veteranos 70 - 70 a 74 anos</option>
            <option value="17">Veteranos 75 - 75 a 79 anos</option>
            <option value="18">Veteranos 80 - 80 a 84 anos</option>
            <option value="19">Veteranos 85 - 85 a 89 anos</option>
            <option value="20">Veteranos 90 - 90 anos em diante</option>
          </select>
          <br>
          <label>Sexo</label>
          <br>
          <input type="radio" name="sexo" id="sexo" value="M">M
          <input type="radio" name="sexo" value="F">F<br>

        </div>
        <div class="modal-footer">
          <span></span>
          <button type="submit" class="btn btn-success" name="btnAdd">Adicionar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function validaRegisto() {
  var res = true;
  var input = [document.forms["formAddClube"]["email"].value, document.forms["formAddClube"]["contacto"].value];

  var emailSplit = String(input[0]).split('@');

  //Expressões regulares para validar contacto, e-mail e password
  var regexContacto = /[0-9]{9}/;
  var regexEmail = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
  //  var regexPassword = /^(?=.*\d)(?=.*[A-Z])(?=.*[!#$%&()*+,-.:;<=>?@_{|}~])/;

  if(!regexContacto.test(String(input[1]))){
    document.getElementById("errocontacto").innerHTML="<strong>Erro!</strong> Por favor insira um contacto válido.";
    res = false;
  }else{
    document.getElementById("errocontacto").innerHTML="";
  }
  if(!regexEmail.test(String(input[0]).toLowerCase())){
    document.getElementById("erroemail").innerHTML="<strong>Erro!</strong> Por favor insira um <i>e-mail</i> válido.";
    res = false;
  }else{
    document.getElementById("erroemail").innerHTML="";
  }
  return res;
}
</script>


<?php

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



//nome,nomeex,email,contacto,especialidade,nacionalidade,escalao,sexo
if($_SERVER['REQUEST_METHOD']==='POST'){

  //Adicionar associação
  if(isset($_POST['btnAdd'])){

    if(isset($_POST['nome'],$_POST['nomeex'],$_POST['email'],$_POST['contacto'],$_POST['especialidade'],$_POST['nacionalidade'],$_POST['escalao'],$_POST['sexo']) && !empty($_POST['nome']) && !empty($_POST['nomeex']) && !empty($_POST['email']) && !empty($_POST['contacto']) && !empty($_POST['especialidade']) && !empty($_POST['nacionalidade']) && !empty($_POST['escalao']) && !empty($_POST['sexo'])){

      if($DAO3->email_existe($_POST['email'])){
        echo '<script>alert("O email já existe como utilizador.");</script>';
        header("Refresh:0");
      }else if($DAO->email_existe($_POST['email'])){
        echo '<script>alert("O email já se encontra registado como atleta.");</script>';
        header("Refresh:0");
      }else{
        if($DAO->inserir_atleta(new Atleta (0,$clubeid,$_POST['nome'],$_POST['nomeex'],$_POST['contacto'],$_POST['email'],$_POST['especialidade'],$_POST['nacionalidade'],$_POST['escalao'],$_POST['sexo'],1,true))){
          echo '<script>alert("Atleta criado com sucesso.");</script>';
          $DAO10->inserir_log(new Log(0,$_SESSION['U_ID'],date("Y-m-d"),date("H:i:s"),"Inserção de um novo Atleta"));
          header("Refresh:0");
        }
      }
    }else{
      echo '<script>alert("Por favor preencha todos os campos.");</script>';
      header("Refresh:0");
    }
  }

  if(isset($_POST['btnDelete'])){
    $idatleta = $_POST['btnDelete'];

    if($DAO->elimina_atleta($idatleta)){
      echo '<script>alert("Atleta eliminado com sucesso.");</script>';
      $DAO10->inserir_log(new Log(0,$_SESSION['U_ID'],date("Y-m-d"),date("H:i:s"),"Eliminação de um Atleta"));
      header("Refresh:0");
    }else{
      echo '<script>alert("Ocorreu um erro ao eliminar o atleta.");</script>';
    }
  }
}

?>
