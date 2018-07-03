<?php
$time = date("H");

if ($time < "12") {
  echo "<h4>Bom dia</h4>";
} else  if ($time >= "12" && $time < "20") {
  echo "<h4>Boa tarde</h4>";
} else if ($time >= "20") {
  echo "<h4>Boa noite</h4>";
}


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
$obter_todos_eventos = $DAO4->obter_todos_eventos();

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
<div class="row">
  <div >
    <a  class="nav-link" style="text-decoration:none;"  href="?action=addeventoanonimo" >Pretendes registar um evento?
      <img src="img/click.png" alt="Trulli" width="24" height="24">
    </a>
  </div>
</div>
<br>
<div class="row">
  <?php if($obter_todos_eventos == null){ ?>
    <h4>Não existem Eventos Disponiveis</h4><br><br>
  <?php }else{ ?>
    <div class="col-md-8">
      <div class="card ">
        <div class="card-header ">
          <h4 class="card-title">Agenda <img src="img/calendar.png" alt="Trulli" width="24" height="24"></h4>
          <p class="card-category">Conjunto de Eventos deste Mês</p>
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
      </div>
    </div>
  <?php } ?>

</div>



<div class="row">
  <div>
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
<br>
<h4>Sobre Nós</h4>
<p>O Bom Resultado surgiu pela implementação de um projeto universitário em que o seu principal objetivo era satisfazer a necessidade de existência de inscrições de atletas em provas de Atletismo.<br>
Até a data, não existe nenhuma aplicação que implemente esse registo de inscrições de atletas em provas de atletismo, por isso foi decidido implementar algo que proporcionasse solução a este problema.<br>
Nesta aplicação é possível existirem diversas associações distritais e uma nacional que coordenem eventos e tambem clubes, sendo que os clubes irão poder inscrever os seus atletas nos diversos eventos distritais ou nacionais. Após a realização dos diferentes eventos, será então passível de identificar os diferentes resultados dos atletas nas determinadas provas e por conseguinte, poderá ser possível consultar os resultados através do clube ou tambem via email, sendo este o identificador do atleta. Este foi o nosso objetivo e motivação para que fosse possível implementar esta aplicação.<br> Esperemos que gostes. <br><br>Cumprimentos,<br>Bom Resultado.

<h6>Contacto:</h6><p>bomresultadoproj1718@gmail.com</p>
