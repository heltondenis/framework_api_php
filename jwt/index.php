<?php
    require 'jwt.php';
    $jwt = new JWT();

    $token = $jwt->create(array("id_user"=>12333, "Nome"=>"Helton"));

    echo $token;