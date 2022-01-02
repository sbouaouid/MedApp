<?php 

require $_SERVER['DOCUMENT_ROOT'].'/MedApp/vendor/autoload.php';

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;


    class Token {
        private static $key = "privateKey";


        public static function auth() {
            $iat = time();
            $exp = $iat + 60*60*5;
            $payload = array(
                "iss" => "http://localhost/",
                "aud" => "http://localhost/",
                "iat" => $iat,
                "exp" => $exp
            );

            $jwt = JWT::encode($payload, Token::$key, 'HS512');
            return array(
                'token' => $jwt,
                'expires' => $exp
            );
        }

        public static function verifier() {
            $headers = apache_request_headers();
            if (isset($headers['Authorization'])) {
                $token = str_replace('Bearer ', '', $headers['Authorization']);
                try {
                    $token = JWT::decode($token, Token::$key, array('HS512'));
                    return true;
    
                } catch (\Exception $e) {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
?>