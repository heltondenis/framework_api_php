<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;
use Monolog\Handler\IFTTTHandler;

class Users extends Model {

    // Propriedades
    private $id_user;

    public function create($ds_email, $ds_senha){
        if (!$this->emailExists($ds_email)) {

            $hash = password_hash($ds_senha, PASSWORD_DEFAULT);

            $sql = "INSERT INTO AM_USUARIOS (ds_email, ds_senha) VALUES (:ds_email, :ds_senha)";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(':ds_email', $ds_email);
            $sql->bindValue(':ds_senha', $hash);
            $sql->execute();

            $this->id_user = $this->db->lastInsertId(); // Pega o último id inserido no banco

            return true;
        } else {
            return false;
        }
    }

    public function checkCredentials($ds_email, $ds_senha){
        $sql = "SELECT id_usuario, ds_senha FROM AM_USUARIOS WHERE ds_email = :ds_email";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':ds_email', $ds_email);
        $sql->execute();


        if ($sql->rowCount() > 0){
            $info = $sql->fetch();

            if (password_verify($ds_senha, $info['ds_senha'])) {
                $this->id_user = $info['id_usuario'];

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getId(){
        return $this->id_user;
    }

    public function getInfo($id){
        $array = array();

        $sql = "SELECT * FROM AM_USUARIOS WHERE ID_USUARIO = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if ($sql->rowCount() > 0){
            $array = $sql->fetch(\PDO::FETCH_ASSOC);

            if (!empty($array['IMG_AVATAR'])){
                $array['IMG_AVATAR'] = BASE_URL.'media/avatar/'.$array['IMG_AVATAR'];
                } else {
                $array['IMG_AVATAR'] = BASE_URL.'media/avatar/default.jpg';
            }

        }

        return $array;
    }

    public function editInfo($id, $data){
        if ($id === $this->getId()) {

            $toChange = array();

            if (!empty($data['nm_usuario'])){
                $toChange['nm_usuario'] = $data['nm_usuario'];
            }
            if(!empty($data['ds_email'])) {
                if (filter_var($data['ds_email'], FILTER_VALIDATE_EMAIL)) {
                    if (!$this->emailExists($data['ds_email'])){
                        $toChange['ds_email'] = $data['ds_email'];
                    } else {
                        return 'E-mail já existente!';
                    }
                } else {
                    return 'E-mail inválido!';
                }
            }
            if(!empty($data['ds_senha'])) {
                $toChange['ds_senha'] = password_hash($data['ds_senha'], PASSWORD_DEFAULT);
            }

            if (count($toChange) > 0){

            } else {
                return 'Preencha os dados corretamente';
            }

        } else {
            return 'Não é permitido editar outro usuário';
        }
    }

    public function createJwt(){
        $jwt = new Jwt();
        return $jwt->create(array('id_user' => $this->id_user));
    }

    public function validateJwt($token){
        $jwt = new Jwt();
        $info = $jwt->validate($token);

        if (isset($info->id_user)){
            $this->id_user = $info->id_user;
            return true;
        } else {
            return false;
        }
    }

    private function emailExists($ds_email) {
        $sql = "SELECT id_usuario FROM AM_USUARIOS WHERE ds_email = :ds_email";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':ds_email', $ds_email);
        $sql->execute();

        if ($sql->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

    // ------------------------------------------------------ //
    public function getFeed($offset = 0, $per_page = 10){
        $array = array();

        $sql = "SELECT * FROM VAM_DIAS_DISPONIVEIS";
        $sql = $this->db->prepare($sql);
        $sql->execute();

        if ($sql->rowCount() > 0){
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $array;
    }

}