<?php

namespace App\Model;

class User extends BaseModel
{

    public function getUserList(){
        $this->db->query("SELECT * FROM user");

        $results = $this->db->fetchList();



        return $results;
    }

}