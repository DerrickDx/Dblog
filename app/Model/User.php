<?php

namespace App\Model;

class User extends BaseModel
{

    public function getUserList(){
        $this->db->query("SELECT * FROM user");

        $results = $this->db->fetchList();


        return $results;
    }

    public function addUser($data){
        // Prepare Query
        $this->db->query('INSERT INTO users (username, email,password) 
      VALUES (:username, :email, :password)');

        // Bind Values
        $this->db->bindValue(':username', $data['username']);
        $this->db->bindValue(':password', $data['password']);

        //Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

}