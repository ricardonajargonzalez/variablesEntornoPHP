

<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require_once "conexion/conexion.php";
require_once "respuestas.class.php";
require_once '../vendor/autoload.php'; // You have to require the library from your Composer vendor folder
use Firebase\JWT\JWT;
use Firebase\JWT\Key;




class login extends conexion{

    private $usuario;
    private $password; 
    private $token;
    private $key;

    private $email; 
    private $uuid; 
    private $cookie;


    function __construct($data){

         parent::__construct(); //SE NECESITA hacer esto en php 7.4
         $this->usuario =  isset($data['usuario']) ? $data['usuario'] : null;
         $this->password =  isset($data['password']) ? $data['password'] : null;
         $this->key = "bb694394ef1dab0ddce7c6e60cf4087c*$";

        //  $this->email =  isset($data['email']) ? $data['email'] : null;
        //  $this->uuid =  isset($data['uuid']) ? $data['uuid'] : null;

        //  $headers = apache_request_headers();
        //  if(isset($headers['Authorization'])){
        //     $array = explode("Bearer ", $headers['Authorization']);
        //     $token = $array[1];
        //     $this->token = $token;
        //  }

        //  $this->cookie = 'Cookie: .DWPLATFORMAUTH=F66715DF79F334B1FAC6BFAEC0AD754E3ECAFFE7D6264EF7CF0EA56601418E3D8C31720A00F1403D71A8237274622F982620BAFD92F53C8826A7697496824543D3D0369503DC2A41EB25B9597ABAD567A12AA063B766DC963C00A5A1B0350020212EA3559CEB4B80B1F330853A2B223EE2D7D51508AA5937DEB445FFC29C49BD0E3C27984F49965724ED1361A6232454D844BB3A9F8EE32A41DFD416DD3FE2215054579719607FA39E013D13F46280DFDF9B69C63C906FBE64189E95E8EC15CA53A15EDE4E9230E3E8E4EC203A2DD7CF26C569FDDFFB895E94CAFD3067E4A0E7812AAFE96EFE128A7E3767004BB1E01C08B7D31F679E90573F5290B80BEC2B0FAF9DBE0EC059DDA84C4D07FE8A7FB8A852C10499FD2BB97E565DDF60131C3822B5ADA43D1E7F1BB6771276F32596D09411DFDE6901A2361ED1AECF616D18A22B5491B7285E80DDE7513E09F6FC53981491D7E3168FAC436BEA1BD76DE28DA9F5D0141BC4E530400C08050C6BBD8E1842757538046FDEE96D67C24E00C2DC832B; DWPLATFORMBROWSERID=60C46209E4D86CE0DD25AC6FB6C08D91E8F28ED37A2CD2A8BBBB4A8BCD1088E414C65E4D90976D4F0E77A31BF28F6A68FBBBBFE9EA309B783F7AC99D1FB834D76DF9AE8B7508F279329F8CF0D49C24D54CA4CB1FFD3691F234D590DEA1EBE04625BD0B4EAB98E2A25EB2B0D538C1A6AFEC17AEAB2CD1D081C9FAC96F9610ACDE7E67E13FA0F982850D0B1FD544125C134D1026345194FDF22E28805C12D1CDE86FCB264DED1732F2ABE61C46A7FF712AAE93110F085E699A4FD2625B88A8281A; dwingressplatform=31c6bfa6e10e280455673f5a2970aad4|3d88ece282292b11759e1022eceb9b94';
    }

    public function token($id,$usuario,$email){
              $time = time();
              $time_exp = $time + (60 * 60 * 24); //token expiracion 24 hrs

              $token = array(
                "iat" => $time,
                "exp" => $time_exp, //token expiracion 24 hrs
                "data" => [
                    "id" => $id,
                    "rfc" => $usuario,
                    "email" => $email
                ]
              );

        $jwt = JWT::encode($token, $this->key, 'HS256');

        return array(
           "token" =>  $jwt,
           "exp"   =>  $time_exp
        );
    }

    // public function cambiar_contrasena($passa,$passn){
    //      $query = "SELECT * FROM ts_users WHERE rfc='$this->rfc' and email= '$this->email'";
    //      $row  = parent::nonQuery($query);

    //       if($row==1){
    //                $result = parent::obtenerDatos($query);
    //                $password = $result[0]['contrasena'];
    //                $id = $result[0]['id'];
    //                $verify = password_verify($passa, $password);
    //                if($verify){
    //                    $hash = password_hash($passn, PASSWORD_DEFAULT);
    //                    $query = "UPDATE ts_users set contrasena = '$hash' WHERE id='$id'";
    //                    $row  = parent::nonQuery($query);
    //                    if($row==1){
    //                      $result = array(
    //                             "ok" => true,
    //                             "msg" => "Se actualizo exitosamente!"
    //                       );
    //                    }else{
    //                    $result = array(
    //                           "ok" => false,
    //                           "msg" => "Ocurrio un error"
    //                     ); 
    //                     die(json_encode($result));
    //                    }
    //                }else{
    //                    $result = array(
    //                           "ok" => false,
    //                           "msg" => "Password incorrecto"
    //                     ); 
    //                    die(json_encode($result));
    //                }
    //       }else{
    //              $result = array(
    //                 "ok" => false,
    //                 "msg" => "Error al validar cuenta"
    //           ); 
    //              die(json_encode($result));
    //       }

    //        return $result;
    // }

    // public function validar_usuario($id,$token){

    //   $query = "SELECT * FROM ts_users WHERE id='$id'";
    //   $row  = parent::nonQuery($query);
    //   if($row==1){
    //      $result = parent::obtenerDatos($query);
    //      $result = $result[0];
    //      $token_bd = $result['token'];
    //      $id    = $result['id'];
    //      $email = $result['email'];
    //      $empresa = $result['empresa'];
    //      $rfc = $result['rfc'];
    //      if($token_bd==$token){
    //         //validar expiracion del token
    //         $time = time();
    //         $token_exp = $result['token_exp'];
    //         if($time < $token_exp){
    //           //token valido
    //           $result_valida = array(
    //                 "token_valido" => true,
    //                 "msg" => "token_valido",
    //                 "user" => [
    //                     "uid" => $id,
    //                     "email" => $email,
    //                     "empresa" => $empresa,
    //                     "rfc" => $rfc
    //                 ]
    //           );
    //         }else{
    //           //token vencido
    //           $result_valida = array(
    //                 "token_valido" => false,
    //                 "msg" => "token_vencido",
    //                 "user" => []
    //           );
    //         }
    //      }else{
    //           //token no coincide
    //           $result_valida = array(
    //                 "token_valido" => false,
    //                 "msg" => "token_invalido",
    //                 "user" => []
    //           ); 
    //      }
    //   }else{
    //      //token no le pertenece al usuario
    //           $result_valida = array(
    //                 "token_valido" => false,
    //                 "msg" => "token_invalido",
    //                 "user" => []
    //           ); 
    //   }

    //   return $result_valida;
    // }

    // public function autorizar_token(){
    //   if(isset($this->token)){
    //     try { 
                  
    //                   $decoded = JWT::decode($this->token, new Key($this->key, 'HS256'));
    //                   $decoded_array = (array) $decoded;
    //                   $data = $decoded_array['data'];
    //                   $id_user = $data->id;
    //                    if(isset($data->id)){
    //                       //BUSCAR USUARIO CON EL ID
    //                       $result = $this->validar_usuario($id_user,$this->token);
    //                       if($result['token_valido']){
    //                           $result_array = array(
    //                           "ok" => true,
    //                           "user" => $result['user'],
    //                           "msg" => $result['msg']
    //                         );
    //                       }else{
    //                           $result_array = array(
    //                           "ok" => false,
    //                           "user" => [],
    //                           "msg" => $result['msg']
    //                         );
    //                       }

    //                    }else{
    //                         $result_array = array(
    //                           "ok" => false,
    //                           "user" => [],
    //                           "msg" => "token no valido- no existe data id"
    //                         );
    //                    }
    //                } catch (\Exception $e) { // Also tried JwtException
    //                          $result_array = array(
    //                           "ok" => false,
    //                           "user" => [],
    //                           "msg" => "error validar token / jwt Exception"
    //                         );
    //               }
    //   }else{
    //                  $result_array = array(
    //                   "ok" => false,
    //                   "user" => [],
    //                   "msg" => "Falta token"
    //                 );
    //   }
     
         
    //     return $result_array;
    // }

    // public function update_token($id,$rfc,$email,$arraytoken){
    //     $token     = $arraytoken['token'];
    //     $token_exp = $arraytoken['exp'];
    //     $query = "UPDATE ts_users SET token = '$token', token_exp = '$token_exp' WHERE rfc='$rfc' and email='$email' and id='$id'";

    //     $result = parent::nonQuery($query);
    //     return $result;
    // }

     public function authetication(){

         $query = "SELECT * FROM usuarios WHERE usuario='$this->usuario'";
         $array_resultado = [];
         $count = parent::nonQuery($query);
         if($count>0){
            $datos['results'] = parent::obtenerDatos($query);
            $password = $datos['results'][0]['password'];
            $usuario = $datos['results'][0]['usuario'];
            $email = $datos['results'][0]['email'];
            $id = $datos['results'][0]['idusuarios'];
            $verify = password_verify($this->password, $password); 
            if($verify){

               $result['id'] = $id;
               $result['ok'] = true;
               $result['usuario'] = $usuario;
               $result['email'] = $email;
               $result['msg'] = "authenticated";
              
                http_response_code(200);
              
               $result_token =  $this->token($id,$usuario,$email);
                $result['token'] = $result_token['token'];

            //   $result_upd_token = $this->update_token($id,$rfc,$email,$result_token);
            //   if($result_upd_token>0){
            //     $result['id'] = $id;
            //     $result['ok'] = true;
            //     $result['rfc'] = $rfc;
            //     $result['email'] = $email;
            //     $result['empresa'] = $empresa;
            //     $result['msg'] = "authenticated";
            //     $result['token'] = $result_token['token'];
            //      http_response_code(200);
            //   }else{
            //     $result['id'] = null;
            //     $result['ok'] = false;
            //     $result['rfc'] = null;
            //     $result['email'] = null;
            //     $result['empresa'] = null;
            //     $result['msg'] = "error-generar-token";
            //     $result['token'] = null;
            //      http_response_code(401);
            //   }

            }else{
              $result['id'] = null;
              $result['ok'] = false;
              $result['rfc'] = null;
              $result['email'] = null;
              $result['empresa'] = null;
              $result['msg'] = "password-incorrect";
              $result['token'] = null;
               http_response_code(401);
            }

         }else{
              $result['id'] = null;
              $result['ok'] = false;
              $result['rfc'] = null;
              $result['email'] = null;
              $result['empresa'] = null;
              $result['msg'] = "user-incorrect";
              $result['token'] = null;
               http_response_code(401);
         }
         
        
         return  $result;
    }

    // private function rfc_valido($rfc){
    //      $valido = false;
    //      $query = "SELECT * FROM ts_users WHERE rfc='$rfc'";
    //      $count = parent::nonQuery($query);
    //      if($count>0){
    //         $valido = true;
    //      }

    //      return $valido;
    // }

//     public function register_user(){
//          //true = rfc ya registradi //false rfc valido
//          $user_valido = $this->rfc_valido($this->rfc); 

//           if(!$user_valido){ //registrar usuario
//             //validamos el UUID de la factura coincide con una factura reciente
//             $result_factura = $this->validarUUID();
//             if(!$result_factura){ 
//               $result = array(
//                             "ok" => false,
//                             "msg" => "El uuid '$this->uuid' no coincide con ninguna factura reciente!"
//                           );
//               die(json_encode($result));
//             }

//             $result_insert = $this->insert_usuario();

//             return $result_insert;
//           }else{
//             $result = array(
//                           "ok" => false,
//                           "msg" => "El RFC '$this->rfc' ya esta registrado"
//                         );
//             die(json_encode($result));
//           }
        
//           return  $result;
//     }

//    public function insert_usuario(){
//       $validarCampos = ($this->rfc=='' || $this->email=='' || $this->password=='' || $this->uuid=='') ? false : true;

//       if(!$validarCampos){
//             $result = array(
//                           "ok" => false,
//                           "msg" => "Todos los campos son obligatorios $this->uuid"
//                         );
//             die(json_encode($result));
//       }

//       $hash = password_hash($this->password, PASSWORD_DEFAULT);
//       $query = "INSERT INTO ts_users (rfc, contrasena, email) VALUES ('$this->rfc', '$hash','$this->email')";
//       $id = parent::nonQueryId($query);
//       if($id>0){
//              $result = array(
//                 "ok" => true,
//                 "msg" => "Usuario registrado exitosamente!"
//             );
//       }else{
//              $result = array(
//                 "ok" => false,
//                 "msg" => "Ocurrio un error al registrar el usuario!"
//             );
//       }


//       return $result;
//     }


//     private function validarUUID(){
//                    $curl = curl_init();
//                   curl_setopt_array($curl, array(
//                     CURLOPT_URL => 'https://grupog.docuware.cloud/docuware/platform/FileCabinets/1fc5b26b-d73b-44a9-a8a6-f79b07be271b/Query/DialogExpression?dialogId=9036e32d-969d-4d48-b664-283cebf2ce8c',
//                     CURLOPT_RETURNTRANSFER => true,
//                     CURLOPT_ENCODING => '',
//                     CURLOPT_MAXREDIRS => 10,
//                     CURLOPT_TIMEOUT => 0,
//                     CURLOPT_FOLLOWLOCATION => true,
//                     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                     CURLOPT_CUSTOMREQUEST => 'POST',
//                     CURLOPT_POSTFIELDS =>'{
//                    "Condition":[ {"DBName":"rfc", "Value":["'.$this->rfc.'"]}, {"DBName" : "DOCUMENT_TYPE" , "Value" : ["Factura Entrante"] }, {"DBName" : "FOLIO_FACTURA" , "Value" : ["'.$this->uuid.'"] }
//                                ],  
//                       "Operation": "And"

//                   }',
//                     CURLOPT_HTTPHEADER => array(
//                       'Accept: application/json',
//                       'Content-Type: application/json',
//                       $this->cookie
//                     ),
//                   ));

//                   $response = curl_exec($curl);
//                   $err = curl_error($curl);
//                   $retcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//                   curl_close($curl);


//                   if ($err) {
//                         $result = array(
//                                       "ok" => false,
//                                       "msg" => "Error al validar el UUID"
//                                     );
//                         die(json_encode($result));
//                   } else {
//                       $response = json_decode($response);
//                       return  $response->Count->Value > 0 ? true : false;
//                   }
//     }


} //class

?>