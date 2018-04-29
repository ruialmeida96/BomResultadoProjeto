<h3>Clubes</h3>

Listar clubes, adicionar clubes(botao na parte de cima), e edita-los(editar info e eliminar)
<br>
<div class="row">
  <div >
    <a  class="nav-link" data-toggle="modal" data-target="#myModaladdClube" href="#">
      <span class="nc-icon nc-simple-add"> Adicionar Clube</span>
    </a>
  </div>
</div>

<?php
require_once('./resources/classes/gereclube.class.php');
require_once('./resources/classes/gereassociacao.class.php');
require_once('./resources/classes/gereutilizador.class.php');

$DAO = new GereClube();
$obter_todos_os_clubes = $DAO->obter_todas_clubes();

$DAO2 = new GereAssociacao();
$obter_todas_as_assoc = $DAO2->obter_todas_assoc();

$DAO3 = new GereUtilizador();
$iduserassoc = $_SESSION['U_ID'];
$associacaoid=$DAO2->obter_detalhes_associação_apartir_userid($iduserassoc);

 if($obter_todos_os_clubes == null){ ?>
  <h4>Não existem Clubes Disponiveis</h4><br><br>
<?php }else{ ?>
  <div class="row">
    <div class="col-md-12">
      <div class="card strpied-tabled-with-hover">
        <div class="card-header ">
          <h4 class="card-title">Lista de Clubes Disponiveis</h4>
          <p class="card-category">Detalhes dos clubes disponiveis na aplicação</p>
        </div>
        <div class="card-body table-full-width table-responsive">
          <table class="table table-hover table-striped">
            <thead>
              <th>ID</th>
              <th>Nome</th>
              <th>Associação</th>
              <th>Abreviatura</th>
              <th>Localização</th>
              <th></th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              $tamanho = count($obter_todos_os_clubes);
              do{
                ?>
                <tr>
                  <?php
                  echo "<td>".$obter_todos_os_clubes[$i]->get_id()."</td>";
                  echo "<td>".$DAO3->obter_nome_apartir_id($obter_todos_os_clubes[$i]->get_userid())."</td>";
                  echo "<td>".$DAO2->obter_nome_apartir_id($obter_todos_os_clubes[$i]->get_associd())."</td>";
                  echo "<td>".$obter_todos_os_clubes[$i]->get_abreviatura()."</td>";
                  echo "<td>".$obter_todos_os_clubes[$i]->get_localizacao()."</td>";
                  ?>
                  <td>
                    <button class="btn btn-info" onclick="location.href='?action=editaclubeassoc&id=<?php echo $obter_todos_os_clubes[$i]->get_id()?>'" >Editar</button>
                    <form method="POST" id="DelAssociacao" action="">
                      <button type="submit" class="btn btn-danger" name="btnDelete" value="<?php echo $obter_todos_os_clubes[$i]->get_id()?>">Eliminar</button>
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
<?php } ?>

<div class="modal fade modal-primary" id="myModaladdClube" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h4 class="modal-title" id="exampleModalLabel">Adicionar Clube</h4>
        <div style=" position:absolute;top:0;right:0;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body text-center">
        <form method="POST" id="AddAssociacao" action="">

          <label>Nome do Clube</label>
          <input type="text" name="nome" id="nome" class="form-control" placeholder="Sigla do Clube..." maxlength="130" required >

          <label>Sigla</label>
          <input type="text" name="sigla" id="sigla" class="form-control" placeholder="Sigla do Clube..." required >

          <label>Email</label>
          <input type="mail" class="form-control" name="email" id="email" placeholder="example@email.com" required>

          <label>Contacto</label>
          <input type="tel" class="form-control" name="contacto" id="contacto"  maxlength="9" required>

          <label>Localização</label>
          <input type="text" name="local" id="local" class="form-control" placeholder="Localização do Clube..." required>


        </div>
        <div class="modal-footer">
          <span></span>
          <button type="submit" class="btn btn-success" name="btnAdd" >Adicionar</button>
        </div>
      </form>
    </div>
  </div>
</div>

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

//nome,sigla,email,contacto,local
if($_SERVER['REQUEST_METHOD']==='POST'){
  require_once('./resources/configs/email.php');

  //Adicionar clube
  if(isset($_POST['btnAdd'])){
    if(isset($_POST['nome'],$_POST['email'],$_POST['contacto'],$_POST['sigla'],$_POST['local']) && !empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['contacto']) && !empty($_POST['sigla']) && !empty($_POST['local'])){

      if($DAO->clube_existe($_POST['sigla'])){
        echo '<script>alert("O clube com essa sigla que adicionou já se encontra registado.");</script>';
        header("Refresh:0");
      }else{
        if($DAO3->email_existe($_POST['email'])){
          echo '<script>alert("O email já existe como utilizador.");</script>';
          header("Refresh:0");
        }else{
          $nomeclube = $_POST['nome'];
          $passwordgera = gera_password();
          if($DAO3->inserir_utilizador(new Utilizador(0,$nomeclube,$_POST['email'],password_hash($passwordgera, PASSWORD_DEFAULT),$_POST['contacto'],1,2,1,true))){
            $valorid = $DAO3->obter_detalhes_utilizador_email_retorna_id($_POST['email']);
            if($DAO->inserir_clube(new Clube(0,$associacaoid,$valorid,$_POST['sigla'],$_POST['local'],1,true))){
              echo '<script>alert("O Clube foi criado com sucesso.");</script>';

              $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
              $corpomensagem = "Olá<br><br>A sua palavra passe para utilização na nossa aplicação é:$passwordgera.<br>Agradecemos pela disponibilizade<br>BomResultado";
              enviaMail($email, 'Password Inicial', $corpomensagem);

              header("Refresh:0");

            }else{
              echo '<script>alert("Erro ao criar clube depois de criar utilizador.");</script>';
              header("Refresh:0");
            }
          }else{
            echo '<script>alert("Erro ao criar o utilizador do clube.");</script>';
            header("Refresh:0");
          }
        }
      }
    }else{
      echo '<script>alert("Por favor preencha todos os campos.");</script>';
    }
  }

  if(isset($_POST['btnDelete'])){
    $idclube = $_POST['btnDelete'];

    $iduser = $DAO->obter_iduser_apartir_idclube($idclube);
    if($DAO->elimina_clube($idclube,$iduser)){
      echo '<script>alert("Clube eliminado com sucesso.");</script>';
      header("Refresh:0");
    }else{
      echo '<script>alert("Ocorreu um erro ao eliminar a associação");</script>';
    }
  }

}

 ?>
