<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=1){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Informação de Evento</h3>
<?php

$eventoid = $_GET["id"];
require_once('./resources/classes/gereevento.class.php');
require_once('./resources/classes/gereprova.class.php');
require_once('./resources/classes/prova.class.php');
require_once('./resources/classes/gerelog.class.php');
$DAO10 = new GereLog();

$DAO = new GereEvento();
$DAO2 = new GereProva();


$provasevento = $DAO2->obter_todas_provas_eventoid($eventoid);
if($provasevento!=null){
  $tamanho = count($provasevento);
  for($i=0;$i<$tamanho;$i++){
    $ideventos[$i] = $provasevento[$i]->get_id();
  }
}else{
  $tamanho=0;
}



$eventoinfo=$DAO->obter_info_evento($eventoid);
$nome = $eventoinfo->get_nome();
$data =  $eventoinfo->get_data();
$dias =  $eventoinfo->get_dias();
$tipo =  $eventoinfo->get_tipo();
$local =  $eventoinfo->get_local();
$detalhes =  $eventoinfo->get_detalhes();
$organizadores =  $eventoinfo->get_organizadores();

?>
<div class="card">
  <div class="card-header">
    <h4 class="card-title">Info Evento</h4>
  </div>
  <div class="card-body">
    <form name="formEditEvento"  method="POST" id="formEditEvento" action="">
      <div class="row">
        <div class="col-md-5 pr-1">
          <label>Nome</label><br>
          <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome do Evento..." maxlength="130"  value="<?php  echo $nome;  ?>" required >
          <br>
        </div>
      </div>
      <div class="row">
        <div class="col-md-5 pr-1">
          <label>Data do Evento</label><br>
          <input type="date" id="datastart" name="datastart" value="<?php  echo $data;  ?>" required><br>
          <br>
        </div>
      </div>
      <div class="row">
        <div class="col-md-5 pr-1">
          <label>Dias de Duração</label><br>
          <input type="number" id="dias" name="dias" min="1" max="30" value="<?php  echo $dias;  ?>" required ><br>
          <br>
        </div>
      </div>
      <div class="row">
        <div class="col-md-5 pr-1">
          <label>Tipo de Evento</label><br>
          <input type="text" name="tipo" id="tipo" class="form-control" placeholder="Prova de ... (ex:Estrada)" maxlength="25" value="<?php  echo $tipo;  ?>" required>
          <br>
        </div>
      </div>
      <div class="row">
        <div class="col-md-5 pr-1">
          <label>Local do Evento</label><br>
          <input type="text" name="local" id="local" class="form-control" placeholder="Localização do Evento..." value="<?php  echo $local;  ?>" required>
          <br>
        </div>
      </div>
      <div class="row">
        <div class="col-md-5 pr-1">
          <label>Detalhes</label><br>
          <textarea rows="4" cols="50"  name="detalhes" id="detalhes"  maxlength="130" ><?php  echo $detalhes;  ?></textarea>

          <br>
        </div>
      </div>
      <div class="row">
        <div class="col-md-5 pr-1">
          <label>Organização</label><br>
          <?php  echo $organizadores;  ?>
          <br>
        </div>
      </div>

      <br><br>
      <div class="row">
        <div class="col-md-12 ">
          <label>Provas</label><br>

          <div class="form-group">
            <label><b>Número de Provas</b></label><br>
            <button type="button" class="btn btn-default btn-sm" id="subtrai_provas"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
            <label id="num_provas">1</label>
            <button type="button" class="btn btn-default btn-sm" id="adiciona_provas"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
            <label id="aviso_max" style="color:red"></label>
            <br><br>
            <div id="provas" class="row">
              <!--onde se pode adicionar as provas-->

            </div>
            <script>
            var num_provas = document.getElementById('num_provas'),subtrai_provas = document.getElementById('subtrai_provas'),adiciona_provas = document.getElementById('adiciona_provas'),num_provas_atual,aviso_max = document.getElementById('aviso_max');

            function adicionaprovas(num){

              var div = document.createElement('div');
              div.setAttribute("class", "col");
              div.setAttribute("style", "margin: 3px; border: 1px solid rgba(192,192,192,0.6); border-radius: 5px")
              div.setAttribute("id", "provas_"+num);

              var lbl_num = document.createElement('label');
              lbl_num.innerHTML = "<h5><b>prova "+num+"</b></h5>";

              var lbl_detalhes = document.createElement('label');
              lbl_detalhes.innerHTML = "<h5>Detalhes</h5>";

              var lbl_nome = document.createElement('label');
              lbl_nome.innerHTML = "Nome:";

              var input_nome = document.createElement('input');
              input_nome.setAttribute("type", "text");
              input_nome.setAttribute("name", "nome_prova"+num);
              input_nome.setAttribute("id", "nome_prova"+num);
              input_nome.setAttribute("class", "form-control");
              input_nome.setAttribute("maxlength", "120");
              input_nome.setAttribute("style", "width: 200px");
              input_nome.setAttribute("required","");


              var lbl_esc = document.createElement('label');
              lbl_esc.innerHTML = "Escalão:";


              var array = ["Benjamins A","Benjamins B","Infantis","Iniciados","Juvenis","Juniores","Sub-23","Seniores","Veteranos 35","Veteranos 40","Veteranos 45","Veteranos 50","Veteranos 55","Veteranos 60","Veteranos 65","Veteranos 70","Veteranos 75","Veteranos 80","Veteranos 85","Veteranos 90"];
              var sb_esc = document.createElement("select");
              sb_esc.setAttribute("id", "escalao_prova"+num);
              sb_esc.setAttribute("name", "escalao_prova"+num);
              sb_esc.setAttribute("required","");
              for (var i = 0; i < array.length; i++) {
                var option = document.createElement("option");
                option.setAttribute("value", i+1);
                option.text = array[i];
                sb_esc.appendChild(option);
              }



              var input_dist = document.createElement('input');
              input_dist.setAttribute("type", "number");
              input_dist.setAttribute("name", "distancia_provas"+num);
              input_dist.setAttribute("id", "distancia_provas"+num);
              input_dist.setAttribute("min", "0");
              input_dist.setAttribute("max", "42000");
              input_dist.setAttribute("value", "0");
              input_dist.setAttribute("required","");

              var lbl_dist = document.createElement('label');
              lbl_dist.innerHTML = "Distância:";

              var lbl_dist2 = document.createElement('label');
              lbl_dist2.innerHTML = "&nbsp;metros";


              var lbl_hora = document.createElement('label');
              lbl_hora.innerHTML = "Hora:";

              var input_time= document.createElement('input');
              input_time.setAttribute("type", "time");
              input_time.setAttribute("name", "hora_provas"+num);
              input_time.setAttribute("id", "hora_provas"+num);
              input_time.setAttribute("required","");

              var lbl_sexo = document.createElement('label');
              lbl_sexo.innerHTML = "Sexo:";

              var array2 = ["M","F"];
              var sb_sexo = document.createElement("select");
              sb_sexo.setAttribute("id", "sexo_prova"+num);
              sb_sexo.setAttribute("name", "sexo_prova"+num);
              sb_sexo.setAttribute("required","");
              for (var i = 0; i < array2.length; i++) {
                var option2 = document.createElement("option");
                option2.setAttribute("value", array2[i]);
                option2.text = array2[i];
                sb_sexo.appendChild(option2);
              }

              div.appendChild(document.createElement('br'));
              div.appendChild(lbl_num);
              div.appendChild(document.createElement('br'));
              div.appendChild(lbl_detalhes);
              div.appendChild(document.createElement('br'));
              div.appendChild(lbl_nome);
              div.appendChild(input_nome);
              div.appendChild(document.createElement('br'));
              div.appendChild(lbl_esc);
              div.appendChild(document.createElement('br'));
              div.appendChild(sb_esc);
              div.appendChild(document.createElement('br'));
              div.appendChild(lbl_dist);
              div.appendChild(document.createElement('br'));
              div.appendChild(input_dist);
              div.appendChild(lbl_dist2);
              div.appendChild(document.createElement('br'));
              div.appendChild(lbl_hora);
              div.appendChild(document.createElement('br'));
              div.appendChild(input_time);
              div.appendChild(document.createElement('br'));
              div.appendChild(lbl_sexo);
              div.appendChild(document.createElement('br'));
              div.appendChild(sb_sexo);
              document.getElementById('provas').appendChild(div);
              div.appendChild(document.createElement('br'));
            }

            function adicionaprovas_valores(num,nome,escalao,dist,time,sexo){
              var div = document.createElement('div');
              div.setAttribute("class", "col");
              div.setAttribute("style", "margin: 3px; border: 1px solid rgba(192,192,192,0.6); border-radius: 5px")
              div.setAttribute("id", "provas_"+num);

              var lbl_num = document.createElement('label');
              lbl_num.innerHTML = "<h5><b>prova "+num+"</b></h5>";

              var lbl_detalhes = document.createElement('label');
              lbl_detalhes.innerHTML = "<h5>Detalhes</h5>";

              var lbl_nome = document.createElement('label');
              lbl_nome.innerHTML = "Nome:";

              var input_nome = document.createElement('input');
              input_nome.setAttribute("type", "text");
              input_nome.setAttribute("name", "nome_prova"+num);
              input_nome.setAttribute("id", "nome_prova"+num);
              input_nome.setAttribute("class", "form-control");
              input_nome.setAttribute("maxlength", "120");
              input_nome.setAttribute("style", "width: 200px");
              input_nome.setAttribute("value", ""+nome);
              input_nome.setAttribute("required","");


              var lbl_esc = document.createElement('label');
              lbl_esc.innerHTML = "Escalão:";


              var array = ["Benjamins A","Benjamins B","Infantis","Iniciados","Juvenis","Juniores","Sub-23","Seniores","Veteranos 35","Veteranos 40","Veteranos 45","Veteranos 50","Veteranos 55","Veteranos 60","Veteranos 65","Veteranos 70","Veteranos 75","Veteranos 80","Veteranos 85","Veteranos 90"];
              var sb_esc = document.createElement("select");
              sb_esc.setAttribute("id", "escalao_prova"+num);
              sb_esc.setAttribute("name", "escalao_prova"+num);
              sb_esc.setAttribute("required","");
              for (var i = 0; i < array.length; i++) {
                var option = document.createElement("option");
                option.setAttribute("value", i+1);
                if((i+1)==escalao){
                  option.setAttribute("selected","");
                }
                option.text = array[i];
                sb_esc.appendChild(option);
              }

              var input_dist = document.createElement('input');
              input_dist.setAttribute("type", "number");
              input_dist.setAttribute("name", "distancia_provas"+num);
              input_dist.setAttribute("id", "distancia_provas"+num);
              input_dist.setAttribute("min", "0");
              input_dist.setAttribute("max", "42000");
              input_dist.setAttribute("value", ""+dist);
              input_dist.setAttribute("required","");

              var lbl_dist = document.createElement('label');
              lbl_dist.innerHTML = "Distância:";

              var lbl_dist2 = document.createElement('label');
              lbl_dist2.innerHTML = "&nbsp;metros";


              var lbl_hora = document.createElement('label');
              lbl_hora.innerHTML = "Hora:";

              var input_time= document.createElement('input');
              input_time.setAttribute("type", "time");
              input_time.setAttribute("name", "hora_provas"+num);
              input_time.setAttribute("id", "hora_provas"+num);
              input_time.setAttribute("value", ""+time);
              input_time.setAttribute("required","");

              var lbl_sexo = document.createElement('label');
              lbl_sexo.innerHTML = "Sexo:";

              var array2 = ["M","F"];
              var sb_sexo = document.createElement("select");
              sb_sexo.setAttribute("id", "sexo_prova"+num);
              sb_sexo.setAttribute("name", "sexo_prova"+num);
              sb_sexo.setAttribute("required","");
              for (var i = 0; i < array2.length; i++) {
                var option2 = document.createElement("option");
                option2.setAttribute("value", array2[i]);
                if(array2[i].localeCompare(sexo)===0){
                  option2.setAttribute("selected","");
                }
                option2.text = array2[i];
                sb_sexo.appendChild(option2);
              }

              div.appendChild(document.createElement('br'));
              div.appendChild(lbl_num);
              div.appendChild(document.createElement('br'));
              div.appendChild(lbl_detalhes);
              div.appendChild(document.createElement('br'));
              div.appendChild(lbl_nome);
              div.appendChild(input_nome);
              div.appendChild(document.createElement('br'));
              div.appendChild(lbl_esc);
              div.appendChild(document.createElement('br'));
              div.appendChild(sb_esc);
              div.appendChild(document.createElement('br'));
              div.appendChild(lbl_dist);
              div.appendChild(document.createElement('br'));
              div.appendChild(input_dist);
              div.appendChild(lbl_dist2);
              div.appendChild(document.createElement('br'));
              div.appendChild(lbl_hora);
              div.appendChild(document.createElement('br'));
              div.appendChild(input_time);
              div.appendChild(document.createElement('br'));
              div.appendChild(lbl_sexo);
              div.appendChild(document.createElement('br'));
              div.appendChild(sb_sexo);
              document.getElementById('provas').appendChild(div);
              div.appendChild(document.createElement('br'));

            }

            //adicionaprovas_valores(1,'Teste nome',3,800,'16:00:00','F');

            /*subtrai_provas.addEventListener('click', function(){
            num_provas_atual = num_provas.innerHTML;
            if(num_provas_atual > 1){
            document.getElementById("provas_"+num_provas_atual).remove();
            num_provas.innerHTML = num_provas_atual-1;
            document.getElementById('total').value=""+num_provas.innerHTML;
            aviso_max.innerHTML = "";
          }else aviso_max.innerHTML = "Atingiu valor mínimo de provas!";
        }, false);

        adiciona_provas.addEventListener('click', function(){
        num_provas_atual = num_provas.innerHTML;
        if(num_provas_atual < 24){
        adicionaprovas(parseInt(num_provas_atual)+parseInt(1));
        num_provas.innerHTML = parseInt(num_provas_atual)+parseInt(1);
        document.getElementById('total').value=""+num_provas.innerHTML;
        aviso_max.innerHTML = "";
      }else aviso_max.innerHTML = "Atingiu valor máximo de provas!";
    }, false);*/

    num_provas.innerHTML = <?php echo $tamanho;?>
    //
    </script>
    <input type="hidden" id="total" name="total" value="<?php echo $tamanho ?>" >
  </div>

  <?php

  for($i=0;$i<$tamanho;$i++){
    $valor = ($i+1);
    $nome = (string) $provasevento[$i]->get_nome();
    $escalao = $provasevento[$i]->get_escalao();
    $distancia = $provasevento[$i]->get_distancia();
    $hora=  $provasevento[$i]->get_hora_string();
    $sexo =$provasevento[$i]->get_sexo();
    //echo "adicionaprovas_valores(".$valor.",".$nome.",".$escalao.",".$distancia.",".$hora.",".$sexo.");</script>";
    echo "<script>adicionaprovas_valores($valor,'$nome',$escalao,$distancia,'$hora','$sexo');</script>";
  }?>
  <script>
  document.getElementById('total').value = <?php echo $tamanho;?>
  </script>

</div>
</div>
<br>

<button type="submit" class="btn btn-success" name="btnConfirm" >Guardar</button>
</form>
<button class="btn btn-primary" onclick="location.href='?action=eventosrecusados'">Voltar</button>

</div>
</div>
<?php
if($_SERVER['REQUEST_METHOD']==='POST'){

  if(isset($_POST['btnConfirm'])){
    if(isset($_POST['nome'],$_POST['datastart'],$_POST['dias'],$_POST['tipo'],$_POST['local']) && !empty($_POST['nome']) && !empty($_POST['datastart']) && !empty($_POST['dias']) && !empty($_POST['tipo']) && !empty($_POST['local'])){

      if($DAO->editar_evento(new Evento($eventoid,0,$_POST['nome'],$_POST['datastart'],$_POST['dias'],$_POST['tipo'],$_POST['local'],$_POST['detalhes'],'',1))){

        $xd =  $_POST['total'];
        if($xd>0){
          for($j=1;$j<=$xd;$j++){
            $idprovaeste= $ideventos[$j-1];
            $nome = $_POST['nome_prova'.$j];
            $escalao = $_POST['escalao_prova'.$j];
            $dist = $_POST['distancia_provas'.$j];
            $hora = $_POST['hora_provas'.$j];
            $sexo = $_POST['sexo_prova'.$j];
            $DAO2->editar_prova(new Prova ($idprovaeste,$eventoid,$nome,$escalao,$dist,$hora,$sexo));
            if($j==($xd)){
              $DAO10->inserir_log(new Log(0,$_SESSION['U_ID'],date("Y-m-d"),date("H:i:s"),"Edição de um Evento"));
              header('Location:?action=eventosrecusados');
            }
          }
        }else{
          header('Location:?action=eventosrecusados');
        }
      }
    }
  }
}

?>
