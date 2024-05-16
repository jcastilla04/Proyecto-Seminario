<?php

require_once '../models/Producto.php';

$producto = new Producto();

if(isset($_POST['operacion'])){
  switch($_POST['operacion']){
    case 'registrarProducto':
      $datos = [
        "idtipoproducto" => $_POST['idtipoproducto'],
        "idmarca" => $_POST['idmarca'],
        "producto" => $_POST['producto'],
        "descripcion" => $_POST['descripcion'],
        "modelo" => $_POST['modelo']
      ];
      $gretel = $producto->registrarProducto($datos);
      echo json_encode($gretel);
      break;
  }
}

if(isset($_GET['operacion'])){
  switch($_GET['operacion']){
    case'listarproducto':
      echo json_encode($producto->listarproducto());
      break;
  }
}