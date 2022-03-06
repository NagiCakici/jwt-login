<?php
header("Access-Control-Allow-Origin: http://kodnot.net/jwt-login/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once 'config/config.php';
//  json web token kütüphanesi
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

// php input datası
$data = json_decode(file_get_contents("php://input"));

// get jwt
$jwt=isset($data->jwt) ? $data->jwt : "";

// if jwt is not empty
if($jwt){

    // jwt çözümü başarılı ise kullanıcı bilgilerini gönder
    try {
        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));

      // http yanıt kodu
        http_response_code(200);

        echo json_encode(array(
            "message" => "Access granted.",
            "data" => $decoded->data
        ));

    }

        // kod çözme başarısız olursa, jwt'nin geçersiz olduğu anlamına gelir
    catch (Exception $e){

      // http yanıt kodu
        http_response_code(401);

        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }
}

// jwt boşsa hata gönder
else{

    // http yanıt kodu
    http_response_code(401);

    echo json_encode(array("message" => "Access denied."));
}
?>