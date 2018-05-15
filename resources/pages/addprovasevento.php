<?php
//Proteção da página
if(!isset($_SESSION['U_ID'],$_SESSION['U_TIPO']) || $_SESSION['U_TIPO']!=1){
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
  header("Location: $url");
  die();
}
?>
<h3>Atribuir Provas ao Evento</h3>

<?php

require_once('./resources/classes/gereprova.class.php');
$DAO = new GereProva();

$eventoid = $_GET["id"];


$valortotal=0;
?>



<div class="card">
  <div class="card-body">
    <form name="formAddProva"  method="POST" id="formAddProva" action="">
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

          var input_foto2 = document.createElement('input');
          input_foto2.setAttribute("type", "file");
          input_foto2.setAttribute("class", "form-control-file");

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

        adicionaprovas(1);

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
        <input type="hidden" id="total" name="total" value="1" >
      </div>

      <button type="submit" class="btn btn-success" name="btnAdd" >Adicionar</button>
    </form>
  </div>
</div>



<?php
if($_SERVER['REQUEST_METHOD']==='POST'){

  if(isset($_POST['btnAdd'])){
    $xd =  $_POST['total'];
    for($i=1;$i<=$xd;$i++){
      $nome = $_POST['nome_prova'.$i];
      $escalao = $_POST['escalao_prova'.$i];
      $dist = $_POST['distancia_provas'.$i];
      $hora = $_POST['hora_provas'.$i];
      $sexo = $_POST['sexo_prova'.$i];
      $DAO->inserir_prova(new Prova (0,$eventoid,$nome,$escalao,$dist,$hora,$sexo));
      if($i==($xd-1)){
        echo '<script>alert("As Provas foram criadas com sucesso.");</script>';
        header('Location:?action=eventosassoc');
      }
    }
  }
}

?>

<!--
<form name="formAddProva"  method="POST" id="formAddProva" action="">
<div class="form-group">
<label><b>Número de Provas</b></label><br>
<button type="button" class="btn btn-light" id="subtrai_provas"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
<label id="num_provas">1</label>
<button type="button" class="btn btn-light" id="adiciona_provas"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
<label id="aviso_max" style="color:red"></label>
<br><br>
<div id="provas" class="row">

</div>
<script>
var num_provas = document.getElementById('num_provas'),
subtrai_provas = document.getElementById('subtrai_provas'),
adiciona_provas = document.getElementById('adiciona_provas'),
num_provas_atual,
aviso_max = document.getElementById('aviso_max');

function adicionaprovas(num){
var div = document.createElement('div');
div.setAttribute("class", "col");
div.setAttribute("style", "margin: 3px; border: 1px solid rgba(192,192,192,0.6); border-radius: 5px")
div.setAttribute("id", "provas_"+num);

var lbl_num = document.createElement('label');
lbl_num.innerHTML = "<h5><b>provas "+num+"</b></h5>";

var lbl_detalhes = document.createElement('label');
lbl_detalhes.innerHTML = "<h5>Detalhes</h5>";

var lbl_renda = document.createElement('label');
lbl_renda.innerHTML = "Renda:";

var input_renda = document.createElement('input');
input_renda.setAttribute("type", "range");
input_renda.setAttribute("name", "renda_provas"+num);
input_renda.setAttribute("class", "form-control");
input_renda.setAttribute("style", "width: 200px");

var cb_wc = document.createElement('input');
cb_wc.setAttribute("type", "checkbox");
cb_wc.setAttribute("name", "caracteristicas_provas"+num)
cb_wc.setAttribute("value", "wc_privado");

var lbl_wc = document.createElement('label');
lbl_wc.innerHTML = "&nbsp;WC Privado";

var cb_varanda = document.createElement('input');
cb_varanda.setAttribute("type", "checkbox");
cb_varanda.setAttribute("name", "caracteristicas_provas"+num)
cb_varanda.setAttribute("value", "varanda");

var lbl_varanda = document.createElement('label');
lbl_varanda.innerHTML = "&nbsp;Possui varanda";

var lbl_fotos = document.createElement('label');
lbl_fotos.innerHTML = "Fotos do provas:";

var input_foto1 = document.createElement('input');
input_foto1.setAttribute("type", "file");
input_foto1.setAttribute("class", "form-control-file");

var input_foto2 = document.createElement('input');
input_foto2.setAttribute("type", "file");
input_foto2.setAttribute("class", "form-control-file");

div.appendChild(document.createElement('br'));
div.appendChild(lbl_num);
div.appendChild(document.createElement('br'));
div.appendChild(lbl_detalhes);
div.appendChild(document.createElement('br'));
div.appendChild(lbl_renda);
div.appendChild(input_renda);
div.appendChild(document.createElement('br'));
div.appendChild(cb_wc);
div.appendChild(lbl_wc);
div.appendChild(document.createElement('br'));
div.appendChild(cb_varanda);
div.appendChild(lbl_varanda);
div.appendChild(document.createElement('br'));
div.appendChild(lbl_fotos);
div.appendChild(document.createElement('br'));
div.appendChild(input_foto1);
div.appendChild(document.createElement('br'));
div.appendChild(input_foto2);
document.getElementById('provas').appendChild(div);
div.appendChild(document.createElement('br'));
}

adicionaprovas(1);

subtrai_provas.addEventListener('click', function(){
num_provas_atual = num_provas.innerHTML;
if(num_provas_atual > 1){
document.getElementById("provas_"+num_provas_atual).remove();
num_provas.innerHTML = num_provas_atual-1;
aviso_max.innerHTML = "";
}else aviso_max.innerHTML = "Atingiu valor mínimo de provas!";
}, false);

adiciona_provas.addEventListener('click', function(){
num_provas_atual = num_provas.innerHTML;
if(num_provas_atual < 6){
adicionaprovas(parseInt(num_provas_atual)+parseInt(1));
num_provas.innerHTML = parseInt(num_provas_atual)+parseInt(1);
aviso_max.innerHTML = "";
}else aviso_max.innerHTML = "Atingiu valor máximo de provas!";
}, false);
</script>
</div>

<button type="submit" class="btn btn-success" name="btnAdd" >Adicionar</button>
</form> -->
