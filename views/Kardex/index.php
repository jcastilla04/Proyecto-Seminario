<?php require_once '../../header.php'; ?>

<div class="container-fluid px-4">
  <ol class="breadcrumb mb-4">
  <h1 class="mt-4">Kardex</h1>
  </ol>
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-table me-1"></i>
      Completar los campos
    </div>

  <div class="card-body">
  <form action="" id="#" autocomplete="off">
    <div class="row">
        <!-- Columna 1 -->
        <div class="col-md-6 mb-2">
            <!-- Tipo de producto y Stock Actual -->
            <div class="input-group">
                <div class="form-floating">
                    <select name="tipoproducto" id="tipoproducto" class="form-select" required>
                        <option value="">Tipo de producto</option>
                    </select>
                </div>
            </div>
            <div class="input-group mt-2">
                <div class="form-floating">
                    <input type="text" class="form-control" id="stockActual" autofocus required>
                    <label for="stockActual" class="form-label">Stock Actual</label>
                </div>
            </div>
        </div>
        <!-- Columna 2 -->
        <div class="col-md-6 mb-2">
            <!-- Tipo de movimiento y Cantidad -->
            <div class="input-group">
                <div class="form-floating">
                    <select name="tipomovimiento" id="tipomovimiento" class="form-select" required>
                        <option value="">Tipo de movimiento</option>
                    </select>
                </div>
            </div>
            <div class="input-group mt-2">
                <div class="form-floating">
                    <input type="text" class="form-control" id="cantidad" autofocus required>
                    <label for="cantidad" class="form-label">Cantidad</label>
                </div>
            </div>
        </div>
    </div>
</form>

  </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const listatipoproducto = document.querySelector("#tipoproducto");

    (()=>{ 
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
      .catch((e) => {
        console.error(e);
      });
  })();
  })
</script>