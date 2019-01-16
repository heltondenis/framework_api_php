<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;

class Schedule extends Model
{
    // ------------------------------------------------------ //
    public function scheduleRecording($p_id_agenda, $p_id_usuario, $p_dt_agenda, $p_ds_obs, $p_id_sucesso){

     try {

        $results = array();
        $sql = 'CALL GRAVA_AGENDAMENTO(:p_id_agenda, :p_id_usuario, :p_dt_agenda, :p_ds_obs, @p_id_sucesso)';
        $stm = $this->db->prepare($sql);
            $stm->bindValue("p_id_agenda", $p_id_agenda);
            $stm->bindValue("p_id_usuario", $p_id_usuario);
            $stm->bindValue("p_dt_agenda", $p_dt_agenda);
            $stm->bindValue("p_ds_obs", $p_ds_obs);
            $stm->execute(); 

            $sql = 'SELECT @p_id_sucesso as p_id_sucesso';
            $num = $this->db->query($sql);
            $return_error = $num->fetch(\PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $return_error;
        }
    }