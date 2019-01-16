<?php
namespace Controllers;

use \Core\Controller;
use Models\Feed;
use \Models\Users;
use \Models\Schedule;

class UsersController extends Controller {

    public function index() {

    }

    public function login(){
        $array = array('error' => '');
        $method = $this->getMethod();
        $data = $this->getRequestData();

        if ($method == 'POST') {
            if (!empty($data['ds_email']) && !empty($data['ds_senha'])) {
                $users = new Users();
                if ($users->checkCredentials($data['ds_email'], $data['ds_senha'])){
                // Gerar o JWT
                    $array['jwt'] = $users->createJwt();
                } else {
                    $array['error'] = 'Acesso negado!';
                }
            } else {
                $array['error'] = 'Email e/ou senha não preenchidos';
            }
        } else {
                $array['error'] = 'Método de requisição incompatível';
            }
        $this->returnJson($array);
    }

    public function new_record(){
        $array = array('error' => '');
        $method = $this->getMethod();
        $data = $this->getRequestData();

        if ($method == 'POST') {
            if (!empty($data['ds_email']) && !empty($data['ds_senha'])) {
                if (filter_var($data['ds_email'], FILTER_VALIDATE_EMAIL)) {
                    $users = new Users();
                    if ($users->create($data['ds_email'], $data['ds_senha'])) {
                        $array['jwt'] = $users->createJwt();
                    } else {
                        $array['error'] = 'Email já existente';
                    }
                } else {
                    $array['error'] = 'Email inválido';
                }
            } else {
                $array['error'] = 'Dados não preenchidos';
            }
        } else {
            $array['error'] = 'Método de requisição incompatível';
        }
        $this->returnJson($array);
    }

    public function feed($id){
        $array = array('error' =>'', 'logged' => false);

        $method = $this->getMethod();
        $data = $this->getRequestData();

        $users = new Users();
        $feed = new Feed();

        if (!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {
            $array['logged'] = true;

            if ($method == 'GET') {
                $offset = 0;
                if (!empty($data['offset'])) {
                    $offset = intval($data['offset']);
                }

                $per_page = 10;
                if (!empty($data['per_page'])) {
                    $per_page = intval($data['per_page']);
                }
                $array['data'] = $feed->getFeed($offset, $per_page);

            } else {
                $array['error'] = "Método não disponível";
            }

            } else {
              $array['error'] = 'Não disponível';
            }

        $this->returnJson($array);
    }

    public function feed_provider($id_agenda){
        $array = array('error' =>'', 'logged' => false);

        $method = $this->getMethod();
        $data = $this->getRequestData();

        $users = new Users();
        $feed = new Feed();

        if (!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {
            $array['logged'] = true;

            if ($method == 'GET') {
            
                 $array['data'] = $feed->getFeedProvider($id_agenda);
              
            } else {
                $array['error'] = "Método não disponível";
            }

            } else {
              $array['error'] = 'Não disponível';
            }

        $this->returnJson($array);
    }

    public function schedule(){
        $array = array('error' => '');
        $method = $this->getMethod();
        $data = $this->getRequestData();

        $users = new Users();
        $schedule = new Schedule();

        if ($method == 'POST') {
            if (!empty($data['p_id_agenda'] && $data['p_id_usuario'] && $data['p_dt_agenda'] && $data['p_ds_obs'])) {
                    $array['data'] = $schedule->scheduleRecording($data['p_id_agenda'], $data['p_id_usuario'], $data['p_dt_agenda'], $data['p_ds_obs'], $data['p_id_sucesso']);
                } else {
                    $array['error'] = 'Acesso negado!';
               }
                $this->returnJson($array);
            }
        }

    public function days_available($id){
        $array = array('error' =>'', 'logged' => false);

        $method = $this->getMethod();
        $data = $this->getRequestData();

        $users = new Users();
        $feed = new Feed();

        if (!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {

            $array['logged'] = true;

            // Verifica se o usuário é o mesmo da sessão
            $array['is_me'] = false;
            if ($id == $users->getId()){
                $array['is_me'] = true;
            }

            // Verificação do Método
            switch ($method) {
                case 'GET':

                    if (!empty($data['id_agenda'])){
                        $array['data'] = $feed->getDaysAvailable($id, $data['id_agenda']);
                    }

                    if (count($array['data']) === 0) {
                        $array['error'] = 'Usuário não existe';
                    }
                    break;
                case 'PUT':
                    break;
                case 'DELETE':
                    break;
                default:
                    $array['error'] = 'Método inválido';
                    break;
            }
        } else {
            $array['error'] = 'Acesso negado!';
        }

        $this->returnJson($array);
    }


    public function view($id){
        $array = array('error' =>'', 'logged' => false);

        $method = $this->getMethod();
        $data = $this->getRequestData();

        $users = new Users();

        if (!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {

            $array['logged'] = true;

            // Verifica se o usuário é o mesmo da sessão
            $array['is_me'] = false;
            if ($id == $users->getId()){
                $array['is_me'] = true;
            }

            // Verificação do Método
            switch ($method) {
                case 'GET':
                    $array['data'] = $users->getInfo($id);

                    if (count($array['data']) === 0) {
                        $array['error'] = 'Usuário não existe';
                    }
                    break;
                case 'PUT':
                    $array['error'] = $users->editInfo($id, $data);
                    break;
                case 'DELETE':
                    break;
                default:
                    $array['error'] = 'Método inválido';
                    break;
            }
        } else {
            $array['error'] = 'Acesso negado!';
        }

        $this->returnJson($array);
    }

   
}












