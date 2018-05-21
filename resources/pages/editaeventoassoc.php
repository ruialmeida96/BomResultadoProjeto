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

$DAO = new GereEvento();
$DAO2 = new GereProva();

$provasevento = $DAO2->obter_todas_provas_eventoid($eventoid);
$tamanho = count($provasevento);


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
        <div class="col-md-5 pr-1">
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

            function adicionaprovas_valores(num,nome,escalao,dist,time,sex){

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
              //sb_esc.setAttribute("value", " "+escalao);
              sb_esc.setAttribute("required","");
              for (var i = 0; i < array.length; i++) {
                var option = document.createElement("option");
                option.setAttribute("value", i+1);
                option.text = array[i];
                if(escalao==i+1){
                 option.setAttribute("selected", "");
                }
                sb_esc.appendChild(option);

              }



              var input_dist = document.createElement('input');
              input_dist.setAttribute("type", "number");
              input_dist.setAttribute("name", "distancia_provas"+num);
              input_dist.setAttribute("id", "distancia_provas"+num);
              input_dist.setAttribute("min", "0");
              input_dist.setAttribute("max", "42000");
              input_dist.setAttribute("value", " "+dist);
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
              input_time.setAttribute("step", "2");
              //input_time.setAttribute("value", ""+time);
              input_time.setAttribute("required","");

              var lbl_sexo = document.createElement('label');
              lbl_sexo.innerHTML = "Sexo:";

              var array2 = ["M","F"];
              var sb_sexo = document.createElement("select");
              sb_sexo.setAttribute("id", "sexo_prova"+num);
              sb_sexo.setAttribute("name", "sexo_prova"+num);
              //sb_sexo.setAttribute("value", ""+sex);
              sb_sexo.setAttribute("required","");
              for (var i = 0; i < array2.length; i++) {
                var option2 = document.createElement("option");
                option2.setAttribute("value", array2[i]);
                option2.text = array2[i];
                if(sex==array2[i]){
                  option2.setAttribute("selected", "");
                }
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

            <?php

            for($i=0;$i<$tamanho;$i++){
              ?>
             adicionaprovas_valores(  <?php echo ($i+1) ?>  ,   <?php echo $provasevento[$i]->get_nome()?>   ,   <?php echo $provasevento[$i]->get_escalao() ?>    ,    <?php echo $provasevento[$i]->get_distancia() ?>   ,   <?php echo $provasevento[$i]->get_hora() ?>  ,   <?php  echo $provasevento[$i]->get_sexo() ?>);
              <?php
            }
            ?>

            //adicionaprovas(1);

            subtrai_provas.addEventListener('click', function(){
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
            }, false);

            </script>
            <input type="hidden" id="total" name="total" value="<?php echo $tamanho ?>" >
          </div>






          <?php
          /*
          if($provasevento == null){ ?>
          <h4>Não existem provas disponiveis para este evento.</h4><br><br>
          <?php }else{ ?>
          <div class="row">
          <div class="col-md-12">
          <div class="card strpied-tabled-with-hover">
          <div class="card-header ">
          <h4 class="card-title">Lista de Provas</h4>
          <p class="card-category">Detalhes das provas disponiveis para este evento</p>
          </div>
          <div class="card-body table-full-width table-responsive">
          <table class="table table-hover table-striped">
          <thead>
          <th>ID</th>
          <th>Nome</th>
          <th>Escalão</th>
          <th>Distância</th>
          <th>Hora</th>
          <th>Sexo</th>
          </thead>
          <tbody>
          <?php
          $i = 0;
          $tamanho = count($provasevento);
          do{
          ?>
          <tr>
          <?php
          echo "<td>".$provasevento[$i]->get_id()."</td>";
          echo "<td>".$provasevento[$i]->get_nome()."</td>";
          echo "<td>".$provasevento[$i]->get_escalao()."</td>";
          echo "<td>".$provasevento[$i]->get_distancia()."</td>";
          echo "<td>".$provasevento[$i]->get_hora()."</td>";
          echo "<td>".$provasevento[$i]->get_sexo()."</td>";
          ?>
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
        <?php } */?>


      </div>
    </div>
    <br>
    <button type="submit" class="btn btn-success" name="btnConfirm" >Confirmar</button>
  </form>
</div>
</div>

<!--
<form name="formAddEvento"  method="POST" id="formAddEvento" action="">
<label>Nome do Evento</label>
<input type="text" name="nome" id="nome" class="form-control" placeholder="Nome do Evento..." maxlength="130" required >

<label>Data de Inicio</label>
<br>
<input type="date" id="datastart" name="datastart" required><br>

<label>Dias de Duração</label><br>
<input type="number" id="dias" name="dias" min="1" max="30" required ><br>

<label>Tipo de Evento</label>
<input type="text" name="tipo" id="tipo" class="form-control" placeholder="Prova de ... (ex:Estrada)" maxlength="25" required>

<label>Localização do Evento</label>
<input type="text" name="local" id="local" class="form-control" placeholder="Localização do Evento..." required>

<label>Detalhes</label>
<br>
<textarea rows="4" cols="50"  name="detalhes" id="detalhes"  maxlength="130" placeholder="Introduza algo..."> </textarea>

</div>
<div class="modal-footer">
<span></span>
<button type="submit" class="btn btn-success" name="btnAdd" >Adicionar</button>
</div>
</form>-->
