<?php
if(isset($_SESSION['U_TIPO'])){
  ?>
  <footer class="footer" >
    <div class="container">
      <nav>
        <ul class="footer-menu">
          <li>
            <a href="?action=contactos">
              Contactos
            </a>
          </li>
          <li>
            <a href="?action=sobrenos">
              Sobre Nos
            </a>
          </li>
        </ul>
        <p class="copyright text-center">
          ©
          <script>
          document.write(new Date().getFullYear())
          </script>
          Bom Resultado
        </p>
      </nav>
    </div>
  </footer>

  <?php
} ?>
