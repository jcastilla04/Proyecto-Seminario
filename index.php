<?php 
session_start();
//Si el usuario ya inicio seccion.. no deberia estar aqui
if(isset($_SESSION['login']) && $_SESSION['login']['permitido'] == true){
    header('Location:dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Seguridad App</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="bg-primary">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                <div class="card-body">
                  <form autocomplete="off" id="login">
                    <div class="form-floating mb-3">
                      <input class="form-control" id="usuario" type="text" autofocus placeholder="correo@gmail.com" required/>
                      <label for="inputEmail">Nombre Usuario</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input class="form-control" id="contraseña" type="password" placeholder="Password" required/>
                      <label for="inputPassword">Contraseña</label>
                    </div>
                    <div class="form-check mb-3">
                      <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                      <label class="form-check-label" for="inputRememberPassword">Recordar contraseña</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                      <a class="small" href="password.html">¿Olvido su acceso?</a>
                      <button class="btn btn-primary" type="submit">Login</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center py-3">
                  <div class="small"><a href="register.html">Crear cuenta nueva</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
    <div id="layoutAuthentication_footer">
      <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
          <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Your Website 2023</div>
            <div>
              <a href="#">Privacy Policy</a>
              &middot;
              <a href="#">Terms &amp; Conditions</a>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", () =>{
      document.querySelector("#login"),addEventListener("submit", (event) =>{
        event.preventDefault();

      const params = new URLSearchParams();
      params.append("operacion","login");
      params.append("nomusuario", document.querySelector("#usuario").value);
      params.append("passusuario", document.querySelector("#contraseña").value);
      
      fetch(`./controllers/usuario.controller.php?${params}`)
          .then(response => response.json())
          .then(acceso =>{
            console.log(acceso);
            if(!acceso.permitido){
              alert(acceso.status);
            }else{
              window.location.href = './dashboard.php';
            }
          })
      })
    })
  </script>
</body>
</html>