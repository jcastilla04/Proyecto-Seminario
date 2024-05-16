<?php require_once '../../header.php'; ?>

<div class="container-fluid px-4">
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Registro de Productos</li>
  </ol>
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-table me-1"></i>
      Completar
    </div>

    <div class="card-body">
      <form action="" id="form-registrar-productos" autocomplete="off">
        <div class="row">
          <div class="col-md-6 mb-2">
            <div class="input-group">
              <div class="form-floating">
                <select name="idmarca" id="idMarca" class="form-select" required>
                  <option value="">Seleccione Marca</option>
                </select>
                <label for="idMarca" class="form-label">Marca</label>
              </div>
            </div>
          </div>

          <div class="col-md-6 mb-2">
            <div class="input-group">
              <div class="form-floating">
                <select name="tipoproducto" id="tipoproducto" class="form-select" required>
                  <option value="">Seleccione Tipo Productos</option>
                </select>
                <label for="tipoproducto" class="form-label">Tipo Producto</label>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 mb-2">
            <div class="input-group">
              <div class="form-floating">
                <input type="text" class="form-control" id="producto" autofocus required>
                <label for="producto" class="form-label">Producto</label>
              </div>
            </div>
          </div>

          <div class="col-md-12 mb-2">
            <div class="input-group">
              <div class="form-floating">
                <input type="text" class="form-control" id="descripcionProducto" autofocus required>
                <label for="descripcionProducto" class="form-label">Descripcion Producto</label>
              </div>
            </div>
          </div>

          <div class="col-md-12 mb-2">
            <div class="input-group">
              <div class="form-floating">
                <input type="text" class="form-control" id="modelo" autofocus required>
                <label for="modelo" class="form-label">Modelo</label>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <button type="submit" id="registar_producto" class="btn btn-primary btn-sm">Registrar Producto</button>
            <button type="reset" class="btn btn-secondary btn-sm">Cancelar proceso</button>
          </div>
        </div>
      </form>
      <hr>
      <!-- Table -->
      <div class="table-responsive">
        <table id="table-productos" class="table table-bordered table-striped table-sm">
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
              <th>Tipo de producto</th>
              <th>Marca</th>
              <th>Descripcion Producto</th>
              <th>Modelo</th>
            </tr>
          </thead>
          <tbody>
            <!-- Aquí se llenarán los datos dinámicamente -->
          </tbody>
        </table>
      </div>
      <!-- fin Table -->
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const listamarca = document.querySelector("#idMarca");
    const listatipoproducto = document.querySelector("#tipoproducto");

    (() => {
  fetch(`../../controllers/producto.controller.php?operacion=listarproducto`)
    .then(response => response.json()) // Cambiado de response.text() a response.json()
    .then(data => {
      console.log(data);
      const ContentTable = document.querySelector("#table-productos tbody");
      data.forEach(row => {
        ContentTable.innerHTML += `
          <tr>
            <td class="text-center">${row.idproducto}</td>
            <td class="text-center">${row.tipoproducto}</td>
            <td class="text-center">${row.marca}</td>
            <td class="text-center">${row.descripcion}</td>
            <td class="text-center">${row.modelo}</td>
          </tr>
        `;
      });
    })
    .catch(error => {
      console.error(error)
    })
})();


    (() => {
      const params = new URLSearchParams();
      params.append("operacion", "getAll");

      fetch(`../../controllers/tipoproducto.controller.php?${params}`)
        .then((respuesta) => respuesta.json())
        .then((data) => {
          data.forEach((element) => {
            const tagOption = document.createElement("option");
            tagOption.value = element.idtipoproducto;
            tagOption.innerText = `${element.tipoproducto}`;
            listatipoproducto.appendChild(tagOption);
          });
        })
        .catch((error) => {
          console.error(error);
        });
    })();

    (() => {
      const params = new URLSearchParams();
      params.append("operacion", "getAll");

      fetch(`../../controllers/marca.controller.php?${params}`)
        .then((respuesta) => respuesta.json())
        .then((data) => {
          data.forEach((element) => {
            const tagOption = document.createElement("option");
            tagOption.value = element.idmarca;
            tagOption.innerText = `${element.marca}`;
            listamarca.appendChild(tagOption);
          });
        })
        .catch((error) => {
          console.error(error);
        });
    })();

    function registrarProducto() {
      event.preventDefault();

      const params = new FormData();
      params.append("operacion", "registrarProducto");
      params.append("idtipoproducto", document.querySelector("#tipoproducto").value);
      params.append("idmarca", document.querySelector("#idMarca").value);
      params.append("producto", document.querySelector("#producto").value);
      params.append("descripcion", document.querySelector("#descripcionProducto").value);
      params.append("modelo", document.querySelector("#modelo").value);

      const options = {
        method: "POST",
        body: params
      };

      fetch(`../../controllers/producto.controller.php`, options)
        .then(response => response.text())
        .then(data => {
          // Aquí puedes manejar la respuesta, si es necesario
        })
        .catch(error => {
          console.error(error);
        });
    }

    document.querySelector("#form-registrar-productos").addEventListener("submit", (event) => {
      event.preventDefault();
      if (confirm("¿Desea guardar producto?")) {
        registrarProducto();
      } else {
        alert("Proceso cancelado");
      }
    });
  });
</script>
