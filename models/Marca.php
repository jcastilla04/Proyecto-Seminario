<?php

require_once 'Conexion.php';

class Marca extends Conexion{
  private $pdo;

  public function __CONSTRUCT(){
    $this->pdo = parent::getConexion();
  }

  public function getAll(){
    try{
      $query = $this->pdo->prepare("CALL spu_marca_listar()");
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }
}