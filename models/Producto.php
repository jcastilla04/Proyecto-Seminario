<?php

require_once 'Conexion.php';

class Producto extends Conexion{

  private $pdo;

  public function __CONSTRUCT(){
    $this -> pdo = parent::getConexion();
  }

  public function registrarProducto($params = []){
    try{
      $query = $this->pdo->prepare("CALL spu_registrar_productos(?,?,?,?,?)");
      $query->execute(
        (array(
          $params['idtipoproducto'],
          $params['idmarca'],
          $params['producto'],
          $params['descripcion'],
          $params['modelo']
        ))
      );
      return $query->fetchAll(PDO::FETCH_ASSOC);
      }
    catch(Exception $e){
      die($e->getMessage());
    }


  }

  public function listarproducto(){
    try{
      $consulta = $this->pdo->prepare("CALL spu_productos_listar()");
      $consulta->execute();
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
      die($e->getMessage());
    }
  }
}