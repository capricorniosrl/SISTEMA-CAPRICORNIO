 <!-- Control Sidebar -->
 <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      V 1.0.0
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2024-<?php echo $hoy = date("Y");?> <a target="_blank" href="https://www.importacionescapricorniosrl.com/">Capricornio S.R.L.</a></strong> Todos los Derechos Reservados.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- script para cambiar todos los imput a mayusculas nemos el imail -->
<script>
    document.addEventListener('input', function(event) {
        if (event.target.tagName === 'INPUT' && event.target.type !== 'email') {
            // event.target.value = event.target.value.toUpperCase();
        }
    });
    
</script>


<!-- Bootstrap 4 -->
<script src="<?php echo $URL;?>/public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap Switch -->
<script src="<?php echo $URL;?>/public/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>

<!-- AdminLTE App -->
<script src="<?php echo $URL;?>/public/dist/js/adminlte.min.js"></script>



<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Comprobar si el modo oscuro está activado en localStorage
    if (localStorage.getItem('dark-mode') === 'enabled') {
      document.body.classList.add('dark-mode');
      document.getElementById('dark-mode-icon').classList.replace('fa-sun', 'fa-moon'); // Cambia el icono a luna
    }

    // Manejador del botón de alternancia
    document.getElementById('dark-mode-toggle').addEventListener('click', () => {
      document.body.classList.toggle('dark-mode');
      if (document.body.classList.contains('dark-mode')) {
        localStorage.setItem('dark-mode', 'enabled');
        document.getElementById('dark-mode-icon').classList.replace('fa-sun', 'fa-moon'); // Cambia el icono a luna
      } else {
        localStorage.setItem('dark-mode', 'disabled');
        document.getElementById('dark-mode-icon').classList.replace('fa-moon', 'fa-sun'); // Cambia el icono a sol
      }
    });
  });
</script>



</body>
</html>
