<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="./img/apple-icon.png">
  <link rel="icon" type="image/png" href="./img/favicon.ico">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>BomResultadoProjeto</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
  <!-- CSS Files -->
  <link href="./css/bootstrap.min.css" rel="stylesheet" />
  <link href="./css/light-bootstrap-dashboard.css?v=2.0.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="./css/demo.css" rel="stylesheet" />
</head>

<body>

  <!--verificar a existencia de javascript-->
  <noscript>
    <div class="alert alert-danger" role="alert" id="js_error">
      <strong>Erro!</strong> A nossa aplicação necessita de Javascript para funcionar. Veja <a href="https://www.enable-javascript.com/pt/" class="alert-link">aqui</a> como ativar esta funcionalidade no seu navegador.
    </div>
  </noscript>


  <?php

  require_once('resources/templates/menuinicial.php');


  ?>

</body>
<!--   Core JS Files   -->
<script src="./js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="./js/core/popper.min.js" type="text/javascript"></script>
<script src="./js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="./js/plugins/bootstrap-switch.js"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!--  Chartist Plugin  -->
<script src="./js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="./js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="./js/light-bootstrap-dashboard.js?v=2.0.1" type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="./js/demo.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  // Javascript method's body can be found in assets/js/demos.js
  demo.initDashboardPageCharts();

});
</script>

</html>
