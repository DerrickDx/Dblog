<?php

namespace App\Model;

class User extends BaseModel
{

    public function getUserList()
    {
        $this->db->query("SELECT u.id , u.username, u.created_at, u.edited_at FROM user u");

        $results = $this->db->fetchList();

        return $results;
    }

    public function addUser($data)
    {
        // Prepare Query
        $this->db->query('INSERT INTO admin (username, email,password) 
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

    public function login(array $loginData)
    {

        $this->db->query('SELECT u.id , u.username , u.password
                                FROM `user` u
                                WHERE u.username = ?;',
                [$loginData['username']]);
        $result = $this->db->fetch();

        if($result) {
            if (password_verify($loginData['password'], $result->password)) {
                return $result;
            }
        }

        return false;

    }

}