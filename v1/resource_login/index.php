
<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    require_once 'class/login.class.php';
    require_once 'class/respuestas.class.php';

    $inputdata = json_decode(file_get_contents("php://input"),true);
    $_respuestas = new respuestas();
    $_login = new login($inputdata);


    $subrecurso =  array_key_exists('resource_id', $_GET) ? $_GET['resource_id'] : '';
   

   //Generamos las respuesta
   switch( strtoupper($_SERVER['REQUEST_METHOD']) ){
    case 'POST':
       IF(empty($subrecurso) ){
            $results = $_login->authetication();
            header("Content-Type: application/json");
            echo json_encode($results);
       }ELSE{ //autorizar token
               if($subrecurso=="autorizar_token"){
                  $results = $_login->autorizar_token();
                  if($results['ok']){
                      http_response_code(202);
                  }else{
                    http_response_code(202);
                  }
                  header("Content-Type: application/json");
                  echo json_encode($results);
              }else if($subrecurso=="register"){
                  $results = $_login->register_user();
                  header("Content-Type: application/json");
                  echo json_encode($results);
              }else if($subrecurso=="changepassword"){
                  $results = $_login->cambiar_contrasena($inputdata['passa'],$inputdata['passn']);
                  header("Content-Type: application/json");
                  echo json_encode($results);
              }else{
                    $results = array(
                      "ok" => false,
                      "user" => [],
                      "msg" => "Datos enviados incompletos o con formato incorrecto"
                    );
                 header("Content-Type: application/json");
                 http_response_code(404);
                 echo json_encode($results);
              }  
       }
      // echo "login";
    break;
    default:
      header('Content-Type: application/json');
      $datosArray = $_respuestas->error_400();
      echo json_encode($datosArray);
   }
?>