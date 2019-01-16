<?php
global $routes;
$routes = array();

// Rotas relacionadas ao login
$routes['/users/login'] = '/users/login'; // Login usuário
$routes['/users/new'] = '/users/new_record'; // Cadastro usuário
$routes['/users/{id}'] = '/users/view/:id'; // Visualizar Usuário


// Rotas relacionadas aos Feeds
$routes['/users/feed/'] = '/users/feed/'; // Busca todos os prestadores, tela inicial de feed
$routes['/users/feed/{id}'] = '/users/feed/:id'; // Visualizar prestadores inicial VIEW: VAM_PRESTADORES_ESPECIALIDADES_LOCAL / POST(ID_AGENDA) 1
$routes['/users/feed_provider/{id_agenda}'] = '/users/feed_provider/:id_agenda'; 
$routes['/users/days_available{id}'] = '/users/days_available/:id'; // Visualizar informações para agendamento VIEW: VAM_DIAS_DISPONIVEIS

// Rotas relacionadas ao agendamento
$routes['/users/schedule/'] = '/users/schedule/'; // Passa os parâmetros p_id_agenda/p_id_usuario/p_dt_agenda/p_ds_obs/p_id_sucesso e finaliza o processo de agendamento

