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
      <input type="mail" class="form-control" name="emailresultados" id="emailresultados" placeholder="example@email.com" required>
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
    //document.getElementById("erroemail").innerHTML="<strong>Erro!</strong> Por favor insira um <i>e-mail</i> válido.";
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
require_once('./resources/classes/gereprova.class.php');
require_once('./resources/classes/gereevento.class.php');
require_once('./resources/classes/gerelog.class.php');
$DAO10 = new GereLog();
$DAO = new GereAtleta();
$DAO2 = new GereHistorico();
$DAO3 = new GereProva();
$DAO4 = new GereEvento();


if($_SERVER['REQUEST_METHOD']==='POST'){
  require_once('./resources/configs/email.php');

  //Adicionar associação
  if(isset($_POST['btnAdd'])){
    if(isset($_POST['emailresultados']) && !empty($_POST['emailresultados'])){

      $atleta = $DAO->obter_detalhes_atleta_email($_POST['emailresultados']);
      if($atleta==null){
        echo '<script>alert("Não existe nenhum atleta com esse email.");</script>';
        header("Refresh:0");
      }else{
        $resultados = $DAO2->obter_historicos_atletaid($atleta->get_id());

        if($resultados==null){
          $email = filter_var($_POST['emailresultados'], FILTER_SANITIZE_EMAIL);
          $corpomensagem = "Olá,<br><br>O seu Historico de Resultados encontra-se vazio.<br><br>Agradecemos pelo contacto.<br>BomResultado";
          enviaMail($email, 'Resultados Atleta: '.$atleta->get_nome(), $corpomensagem);
          echo '<script>alert("Dados enviados com sucesso via e-mail.");</script>';
          header("Refresh:0");
        }else{
          $tamanho = count($resultados);
          $x=0;
          $corpomensagem="Olá,<br><br>O seu Historico de Resultados é o seguinte:";
          do{
            $prova = $resultados[$x]->get_provaid();
            $tempo = $resultados[$x]->get_tempo();
            $lugar = $resultados[$x]->get_local();

            $prova_dados = $DAO3->obter_dados_provaid($prova);
            $evento_prova = $DAO4->obter_info_evento($prova_dados->get_eventoid());

            //nome do evento
            $nomeevento =$evento_prova->get_nome();
            //nome da prova
            $nomeprova = $prova_dados->get_nome();
            //tempo e lugar
            $corpomensagem.="<br>No Evento ".$nomeevento." na prova ".$nomeprova.", obteve o ".$lugar."º lugar com o tempo de:".$tempo.".";
            $x++;
          }while($x<$tamanho);
          $email = filter_var($_POST['emailresultados'], FILTER_SANITIZE_EMAIL);
          $corpomensagem.="<br><br>Agradecemos pelo contacto.<br>BomResultado";
          enviaMail($email, 'Resultados Atleta: '.$atleta->get_nome(), $corpomensagem);
          echo '<script>alert("Dados enviados com sucesso via e-mail.");</script>';
          $DAO10->inserir_log(new Log(0,0,date("Y-m-d"),date("H:i:s"),"Envio de Historico de Resultados para um Atleta"));
          header("Refresh:0");
        }
      }
    }else{
      echo '<script>alert("Por favor preencha todos os campos.");</script>';
      header("Refresh:0");
    }
  }
}
?>
