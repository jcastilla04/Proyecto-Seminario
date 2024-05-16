<?php

require_once '../models/TipoProducto.php';

$tipoproducto = new TipoProducto();

if(isset($_GET['operacion'])){
  switch($_GET['operacion']){
    case 'getAll':
      echo json_encode($tipoproducto->getAll());
      break;
  }
}