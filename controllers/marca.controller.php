<?php

require_once '../models/Marca.php';

$marca = new Marca();

if(isset($_GET['operacion'])){
  switch($_GET['operacion']){
    case 'getAll':
      echo json_encode($marca->getAll());
      break;
  }
}