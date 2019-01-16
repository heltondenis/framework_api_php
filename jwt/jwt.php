<?php
Class JWT
{
    private $secret;

    public function __construct() {
        $this->secret = "abC123";
    }

    public function create($data){

        $header = json_encode(array("typ"=>"JWT", "alg"=>"HS256"));

        $payload = json_encode($data);

        $hbase = $this->base64url_encode($header);
        $pbase = $this->base64url_encode($payload);

        $signature = hash_hmac("sha256", $hbase.".".$pbase, $this->secret, true);
        $bsig = $this->base64url_encode($signature);

        $jwt = $hbase.".".$pbase.".".$bsig;

        return $jwt;

    }

    private function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64url_decode($data) {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    public function validate($token){
        // Passo 1: Verificar se o Token tem 3 partes.
        // Passo 2: Bater as assinatura com os dados.
        $array = array();

        // Verificar o delimitador "." e contar
        $jwt_split = explode('.', $token);

        if (count($jwt_split) == 3) {
            $signature = hash_hmac("sha256", $jwt_split[0].".".$jwt_split[1], $this->secret, true);
            $bsig = $this->base64url_encode($signature);

            if ($bsig == $jwt_split[2]){
                $array = json_decode($this->base64url_decode($jwt_split[1]));
                return $array;
            }

        } else {
            return false;
        }
    }

}