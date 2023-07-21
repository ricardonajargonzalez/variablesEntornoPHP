
<?php

require_once 'class/respuestas.class.php';
require  '../vendor/autoload.php';

 $parentDir = dirname(__DIR__, 1); //una carpeta para atras
 $dotenv = Dotenv\Dotenv::createImmutable($parentDir);
 $dotenv->load();


  $_respuestas = new respuestas;
  $matches = [];

   /* 
    La expresiones regulares se encapsula con el comienzo de "/" y terminando con "/".
    Cada "\/" es un "/".
    Cada "([^\/]+)" es una expresion de texto.
    En esta empresion de tiene : / + texto + / + texto + / + texto + / + texto
    
    Base url "/ApiProveedores/v1/" +
    Metodo api "documentos"   +
    id       /1

   */

  
 if (preg_match('/\/([^\/]+)\/([^\/]+)\/([^\/]+)\/([^\/]+)/', $_SERVER["REQUEST_URI"], $matches)) {
    //Wizard en especifico con su id
     $_GET['resource_type'] = $matches[3];
     $_GET['resource_id'] = $matches[4];
     require 'server.php';
  }else if(preg_match('/\/([^\/]+)\/([^\/]+)\/([^\/]+)\//', $_SERVER["REQUEST_URI"], $matches)) {
    //Tods los wizard
     $_GET['resource_type'] = $matches[3];
     require 'server.php';
  }else{
      header('Content-Type: application/json');
      $datosArray = $_respuestas->error_400();
      echo json_encode($datosArray);
  }

?>