<?php
require 'jwt.php';
$jwt = new JWT();

if (!empty($_GET['jwt'])){
    $token = $_GET['jwt'];
    $info = $jwt->validate($token);

    if ($info){
        echo "Token válido!";
        print_r($info);
    } else {
        echo "Token inválido";
    }
} else {
    echo "Tolken não enviado!";
}
