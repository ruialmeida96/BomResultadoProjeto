<h2>Pagina Inicial</h2>

<p>Falta meter conteudo para esta pagina inicial</p>

<div class="row">
  <div >
    <a  class="nav-link" href="?action=addeventoanonimo">
      <span class="nc-icon nc-simple-add"> Adicionar Evento</span>
    </a>
  </div>
</div>


<div class="row">
  <div><br><br><br><br>
    <p>Es atleta e pretendes receber os teus resultados via email?</p>
    <div id="erroemail" style="color:red;"></div>
    <form  name="formMail" onsubmit="return validaRegisto()" method="POST" id="AddAssociacao" action="">
      <input type="mail" class="form-control" name="email" id="email" placeholder="example@email.com" required>
      <button type="submit" class="btn btn-info" name="btnAdd" >Enviar</button>
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
  var input = [document.forms["formMail"]["email"].value];

  var emailSplit = String(input[0]).split('@');
  //Expressões regulares para validar contacto, e-mail e password
  var regexContacto = /[0-9]{9}/;
  var regexEmail = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
//  var regexPassword = /^(?=.*\d)(?=.*[A-Z])(?=.*[!#$%&()*+,-.:;<=>?@_{|}~])/;

  if(!regexEmail.test(String(input[0]).toLowerCase())){
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

require_once('./resources/classes/gereatleta.class.php');
require_once('./resources/classes/gerehistorico.class.php');
$DAO = new GereAtleta();
$DAO2 = new GereHistorico();


if($_SERVER['REQUEST_METHOD']==='POST'){
  require_once('./resources/configs/email.php');

  //Adicionar associação
  if(isset($_POST['btnAdd'])){
    if(isset($_POST['mail']) && !empty($_POST['mail'])){

       $atleta = $DAO->obter_detalhes_atleta_email($_POST['mail']);
       $resultados = $DAO2->obter_historicos_atletaid($atleta->get_id());

       if($resultados==null){
         $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
         $corpomensagem = "Olá,<br><br>O seu Historico de Resultados encontra-se vazio.<br><br>Agradecemos pela disponibilizade<br>BomResultado";
         enviaMail($email, 'Resultados Atleta: '.$atleta->get_nome(), $corpomensagem);
       }else{
         $tamanho = count($resultados);
         $x=0;
         $corpomensagem="Olá,<br><br>O seu Historico de Resultados é o seguinte:";
         do{
           
           $corpomensagem."";
         }while($x<$resultados);
         $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
         $corpomensagem = "<br><br>Agradecemos pela disponibilizade<br>BomResultado";
         enviaMail($email, 'Resultados Atleta: '.$atleta->get_nome(), $corpomensagem);
       }





/*
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

      */
    }else{
      echo '<script>alert("Por favor preencha todos os campos.");</script>';
      header("Refresh:0");
    }
  }
}
?>
