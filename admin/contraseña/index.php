<?php
    include ('../../app/config/config.php');
    include ('../../app/config/conexion.php');

    include ('../../layout/admin/session.php');
    include ('../../layout/admin/datos_session_user.php');
?>

<?php include ('../../layout/admin/parte1.php'); ?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Gestionar Contraseña</h1>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- Main content -->
      <section class="content">
        <div class="container">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- jquery validation -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">
                    <small>Cambio de Contraseña</small>
                  </h3>
                </div>
                <div class="container">
                  <div class="row justify-content-center">
                    <div class="col-8">
                      <form class="needs-validation mt-3 mb-3" novalidate id="passwordForm" method="POST" action="controller_update_password.php">
                        <div class="form-group">
                          <label for="newPassword">Contraseña Nueva</label>
                          <input type="password" class="form-control" name="pass" id="newPassword" required>
                          <div class="invalid-feedback" id="passwordError">Complete este campo.</div>
                        </div>

                        <div class="form-group">
                          <label for="repeatPassword">Repetir Contraseña</label>
                          <input type="password" class="form-control" name="pass_confir" id="repeatPassword" required>
                          <div class="invalid-feedback" id="repeatPasswordError">Complete este campo.</div>
                        </div>

                        <div class="form-group">
                          <label>Nivel de Seguridad de la Contraseña</label>
                          <div class="progress">
                            <div class="progress-bar" id="passwordStrengthBar" role="progressbar" style="width: 0%;"></div>
                          </div>
                        </div>

                        <div class="col-12">
                          <button class="btn btn-primary" type="submit">Guardar Contraseña</button>
                        </div>

                        <div class="row mt-3">
                          <div class="col" id="mensaje1">
                            <div class="callout callout-info">
                              <p class="text-info" id="respuesta">Puede utilizar cualquier carácter, símbolo o número para su contraseña. Recuerde que el sistema diferencia mayúsculas y minúsculas, y que la contraseña debe tener al menos 5 caracteres de longitud.</p>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container-fluid -->
  </div>
</div>
<?php include ('../../layout/admin/parte2.php'); ?>

<script>
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      var forms = document.getElementsByClassName('needs-validation');
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          var newPassword = document.getElementById('newPassword');
          var repeatPassword = document.getElementById('repeatPassword');
          var passwordError = document.getElementById('passwordError');
          var repeatPasswordError = document.getElementById('repeatPasswordError');

          if (newPassword.value.length <= 5) {
            newPassword.setCustomValidity('invalid');
            passwordError.textContent = 'La contraseña debe tener más de 5 caracteres.';
          } else {
            newPassword.setCustomValidity('');
            passwordError.textContent = 'Complete este campo.';
          }

          if (repeatPassword.value !== newPassword.value) {
            repeatPassword.setCustomValidity('invalid');
            repeatPasswordError.textContent = 'Las contraseñas no coinciden.';

            
          } else {
            repeatPassword.setCustomValidity('');
            repeatPasswordError.textContent = 'Complete este campo.';
          }

          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);

    // Barra de seguridad de la contraseña
    document.getElementById('newPassword').addEventListener('input', function() {
      var password = this.value;
      var strengthBar = document.getElementById('passwordStrengthBar');
      var strength = 0;

      if (password.length > 5) strength += 1;
      if (password.match(/[a-z]+/)) strength += 1;
      if (password.match(/[A-Z]+/)) strength += 1;
      if (password.match(/[0-9]+/)) strength += 1;
      if (password.match(/[!@#$%^&*(),.?":{}|<>[\]\\\/~`_+=-]+/)) strength += 1;

      switch(strength) {
        case 0:
          strengthBar.style.width = '0%';
          strengthBar.className = 'progress-bar';
          break;
        case 1:
          strengthBar.style.width = '20%';
          strengthBar.className = 'progress-bar bg-danger';
          break;
        case 2:
          strengthBar.style.width = '40%';
          strengthBar.className = 'progress-bar bg-warning';
          break;
        case 3:
          strengthBar.style.width = '60%';
          strengthBar.className = 'progress-bar bg-info';
          break;
        case 4:
          strengthBar.style.width = '80%';
          strengthBar.className = 'progress-bar bg-primary';
          break;
        case 5:
          strengthBar.style.width = '100%';
          strengthBar.className = 'progress-bar bg-success';
          break;
      }
    });
  })();
</script>
