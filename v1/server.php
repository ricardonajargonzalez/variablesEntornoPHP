<?php

  //definimos los recurso disponibles
    $allowedResourceTypes = [
        'login'
    ];

  //validamos que el recurso este disponible
        $resourceType = $_GET['resource_type'];
        //si no encontramos ningun elemento que coincida del arreglo terminamos el script
        if( !in_array($resourceType, $allowedResourceTypes) ){
            header('Content-Type: application/json');
            $datosArray = $_respuestas->error_400();
            echo json_encode($datosArray);
            die;
        }

    switch( $resourceType ){
    case 'login':
        require 'resource_login/index.php';
    break;
   }

?>