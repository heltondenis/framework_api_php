<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;

class Feed extends Model
{

    // ------------------------------------------------------ //
    public function getDaysAvailable($id, $id_agenda){
        $array = array();
        $sql = "SELECT * FROM VAM_DIAS_DISPONIVEIS WHERE id_agenda = :id_agenda";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_agenda', $id_agenda);
        $sql->execute();

        if ($sql->rowCount() > 0){
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);

        }
        return $array;
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

    public function getFeedProvider($id_agenda){
        $array = array();

        $sql = "SELECT * FROM VAM_DIAS_DISPONIVEIS where id_agenda = :id_agenda";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_agenda', $id_agenda);
        $sql->execute();

        if ($sql->rowCount() > 0){
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $array;
    }

}

