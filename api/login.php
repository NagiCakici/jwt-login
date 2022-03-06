<?php
header("Access-Control-Allow-Origin: http://kodnot.net/jwt-login/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



// veri tabanından bilgiler
$user_db_data = [
  'firstname' => 'nagi',
  'lastname' => 'cakici',
  'email' => 'info@nagicakici.com.tr',
  'passwd' => '1234' 
];

// php input datası
$data = json_decode(file_get_contents("php://input"));

include_once 'config/config.php';
//  json web token kütüphanesi
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

// Kullanıcı adı Şifre kontrolü
if($user_db_data['email'] == $data->email && $data->passwd === $user_db_data['passwd'] && $user_db_data['passwd'] != ''){

    $token = array(
        "iat" => $issued_at,
        "exp" => $expiration_time,
        "iss" => $issuer,
        "data" => array(
            "firstname" => $user_db_data->firstname,
            "lastname" => $user_db_data->lastname,
            "email" => $user_db_data->email
        )
    );

  // http yanıt kodu
    http_response_code(200);

    // generate jwt
    $jwt = JWT::encode($token, $key);
    echo json_encode(
        array(
            "message" => "Successful login.",
            "jwt" => $jwt
        )
    );

}

// giriş başarısız
else{

    // http yanıt kodu
    http_response_code(401);

    echo json_encode(array("message" => "Login failed."));
}
?>