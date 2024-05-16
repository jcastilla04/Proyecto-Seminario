<?php require_once '../../header.php'; ?>

<div class="container-fluid px-4">
  <h1 class="mt-4">Usuarios</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
  </ol>
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-table me-1"></i>
      Complete los datos
    </div>

    <div class="card-body">
      <form action="" id="form-registrar-usuario" autocomplete="off">
        <div class="col-md mb-2">
          <div class="input-group">
            <div class="form-floating">
              <input type="text" class="form-control" maxlength="8" minlength="8" pattern="[0-9]+" title="Solo numeros" id="nrodocumento">
              <label for="nrodocumento">Numero Documento</label>
            </div>
            <button class="input-group-text bg-success text-light" type="button" id="buscarDni">
              <i class="fa-solid fa-magnifying-glass"></i>
            </button>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-floating">
              <input type="text" class="form-control" id="telefonoP" maxlength="9">
              <label for="telefonoP">Telefono Principal</label>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-floating">
              <input type="text" class="form-control" id="telefonoS" maxlength="9">
              <label for="telefonoS">Telefono Secundario</label>
            </div>
          </div>
        </div>

        <hr>

        <div class="row g-2">
          <div class="col-md-4 mb-2">
            <div class="form-floating">
              <input type="text" class="form-control" maxlength="50" id="apellidoP" required>
              <label for="apellidoP">Apellido Paterno</label>
            </div>
          </div>
    
          <div class="col-md-4 mb-2">
            <div class="form-floating">
              <input type="text" class="form-control" maxlength="50" id="apellidoM" required>
              <label for="apellidoM">Apellido Materno</label>
            </div>
          </div>
    
          <div class="col-md-4 mb-2">
            <div class="form-floating">
              <input type="text" class="form-control" maxlength="50" id="nombres" required>
              <label for="nombres">Nombres</label>
            </div>
          </div>
        </div>

        <div class="row g-2">
          <div class="col-md-6 mb-3">
            <div class="form-floating">
              <input type="text" id="usuario" maxlength="150" class="form-control" required>
              <label for="usuario">Nombre Usuario</label>
            </div>
          </div>
    
          <div class="col-md-6 mb-3">
            <div class="form-floating">
              <input type="password" id="password" maxlength="20" minlength="8" class="form-control" required>
              <label for="password">Contraseña Usuario</label>
            </div>
          </div>
        </div>

        <div class="col-md mb-3">
          <div class="form-floating">
            <select name="idRol" id="idRol" class="form-select" required>
              <option value="">Seleccione Roles</option>
            </select>
            <label for="idRol" class="form-label">Roles</label>
          </div>
        </div>

        <div>
          <button type="submit" id="registrarUsuario" class="btn btn-primary btn-sm">Registrar Usuario</button>
          <button type="reset" class="btn btn-secondary btn-sm">Cancelar proceso</button>
        </div>

      </form>

      <div class="table-responsive">
        <table id="table-usuarios" class="table table-bordered table-striped table-sm">
          <colgroup>
            <col style="width: 5px">
            <col style="width: 10px">
            <col style="width: 15px">
            <col style="width: 45px">
            <col style="width: 15px">
        </colgroup>
        <thead class="encabezado text-center">
          <tr>
            <th>#</th>
            <th>Id Colaborador</th>
            <th>Nombres</th>
            <th>Rol</th>
            <th>Nombre de Usuario</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php require_once '../../footer.php';?>

<script>
  document.addEventListener("DOMContentLoaded", () =>{
    const nrodocumento = document.querySelector("#nrodocumento");
    const listarRoles = document.querySelector("#idRol");
    let idpersona = -1;
    let datosN = true;

    //Funcion autoejecutable para poder listar mis colaboradores en mi tabla
    (() =>{
      fetch(`../../controllers/usuario.controller.php?operacion=listarPersona`)
        .then(response => response.json())
        .then(data =>{
          console.log(data);
          const ContentTable = document.querySelector("#table-usuarios tbody");
          data.forEach(row => {
            ContentTable.innerHTML += `
            <tr>
            <td class="text-center">${row.idcolaborador}</td>
            <td class="text-center">${row.nombres}</td>
            <td class="text-center">${row.rol}</td>
            <td class="text-center">${row.nomusuario}</td>
            </tr>
            `;
          });
        
        })
        .catch(error =>{
          console.log(error);
        })
    })();

  // Funcion autoejecutable para enlistar mis roles
  (() =>{
    const params = new URLSearchParams();
    params.append("operacion", "getAll");

    fetch(`../../controllers/roles.controller.php?${params}`)
      .then((respuesta) => respuesta.json())
      .then(data =>{
        data.forEach((element) =>{
          const listarRoles = document.querySelector("#idRol");
          const tagOption = document.createElement("option");
          tagOption.value = element.idrol;
          tagOption.innerText = `${element.rol}`;
          listarRoles.appendChild(tagOption);
        })
      })
      .catch((e) =>{
        console.log(e);
      })
  })();

    async function regisPersona(){
      const params = new FormData();

      params.append("operacion", "add");
      params.append("apepaterno", document.querySelector("#apellidoP").value);
      params.append("apematerno", document.querySelector("#apellidoM").value);
      params.append("nombres", document.querySelector("#nombres").value);
      params.append("nrodocumento", document.querySelector("#nrodocumento").value);
      params.append("telprincipal", document.querySelector("#telefonoP").value);
      params.append("telsecundario", document.querySelector("#telefonoS").value);

      //Objeto de configuracion (se necesita fetch)
      const options = {
        method: "POST",
        body: params
      };

      //En esta parte enviamos la petición
      const idpersona = await fetch(`../../controllers/persona.controller.php`, options);
      console.log(idpersona);
      return idpersona.json();
    }

    async function regisUsuario(idpersona){
      const params = new FormData();
      params.append("operacion", "add");
      params.append("idpersona", idpersona);
      params.append("idrol", document.querySelector("#idRol").value);
      params.append("nomusuario", document.querySelector("#usuario").value);
      params.append("passusuario", document.querySelector("#password").value);

      const options = {
        method: "POST",
        body: params
      };

      const idusuario = await fetch(`../../controllers/usuario.controller.php`, options);
      return idusuario.text();
    }

    async function buscarDni(){
      const params = new URLSearchParams();
      params.append("operacion", "buscarPorDni");
      params.append("nrodocumento", nrodocumento.value)
      const response = await fetch(`../../controllers/persona.controller.php?${params}`);
      console.log(response);
      return response.json();
    }

    function validarDni(response){
      if(response.length == 0){
        document.querySelector("#apellidoP").value = ``;
        document.querySelector("#apellidoM").value = ``;
        document.querySelector("#nombres").value = ``;
        document.querySelector("#telefonoP").value = ``;
        document.querySelector("#telefonoS").value = ``;
        adPersona(true);
        adUsuario(true);

        document.querySelector("#telefonoP").focus();
        document.querySelector("#telefonoS").focus();
      }else{
        datosN = false;
        idpersona = response[0].idpersona;
        document.querySelector("#apellidoP").value = response[0].apepaterno;
        document.querySelector("#apellidoM").value = response[0].apematerno;
        document.querySelector("#nombres").value = response[0].nombres;
        document.querySelector("#telefonoP").value = response[0].telprincipal;
        document.querySelector("#telefonoS").value = response[0].telsecundario;

        adPersona(false);

        if(response[0].idusuario === null){
          adUsuario(true);
        }else{
          adUsuario(false);
          alert("ESTA PERSONA YA CUENTA CON UN PERFIL")
        }
      }
    }

    nrodocumento.addEventListener("keypress", async(event) =>{
      if(event.keyCode == 13){
        const response = await buscarDni();
        validarDni(response);
      }
    });

    function adPersona(sw = false){
      if(!sw){
        document.querySelector("#usuario").setAttribute("disabled", true);
        document.querySelector("#password").setAttribute("disabled", true);
        document.querySelector("#idRol").setAttribute("disabled", true);
      }else{
        document.querySelector("#usuario").removeAttribute("disabled", true);
        document.querySelector("#password").removeAttribute("disabled", true);
        document.querySelector("#idRol").removeAttribute("disabled", true);      
      }
    }

    function adUsuario(sw = false){
      if(!sw){
        document.querySelector("#usuario").setAttribute("disabled", true);
        document.querySelector("#password").setAttribute("disabled", true);
        document.querySelector("#idRol").setAttribute("disabled", true);
        document.querySelector("#registrarUsuario").setAttribute("disabled", true);
      }else{
        document.querySelector("#usuario").removeAttribute("disabled", true);
        document.querySelector("#password").removeAttribute("disabled", true);
        document.querySelector("#idRol").removeAttribute("disabled", true);
        document.querySelector("#registrarUsuario").removeAttribute("disabled", true);        
      }
    }

    document.querySelector("#form-registrar-usuario").addEventListener("submit", async(event) =>{
      event.preventDefault();

      if(confirm("¿Estas seguro de proceder?")){
        let respuesta1;
        let respuesta2;

        if(datosN){
          respuesta1 = await regisPersona();
          idpersona = respuesta1.idpersona;
        }

        if(idpersona == -1){
          alert("No se puede guardar, verifica el DNI");
        }else{
          respuesta2 = await regisUsuario(idpersona);
          console.log(respuesta2)
          if(respuesta2.idusuario == -1){
            alert("No se puede crear su cuenta de usuario, verifica el nombre de usuario");
          }else{
            document.querySelector("#form-registrar-usuario").reset();
          }
        }
      }
    });

    adPersona(false);
  })
</script>

</body>
</html>