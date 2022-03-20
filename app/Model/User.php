<?php

namespace App\Model;

use DateTimeZone;

class User extends BaseModel
{

    public function getUserList()
    {
        $this->db->excute("SELECT u.id , u.username, u.created_at, u.edited_at FROM `user` u");

        $results = $this->db->fetchList();

        foreach ( $results as $res) {
            $res->created_at = $this->dateTimeDisplay($res->created_at);
            $res->edited_at = $this->dateTimeDisplay($res->edited_at);
        }

        return $results;
    }

    public function createUser($data)
    {
        // Prepare Query
        return $this->db->excute('INSERT INTO `user` (username, password) 
                            VALUES (?, ?)', [$data['username'], $data['password']]);

    }

    public function login(array $loginData)
    {

        $this->db->excute('SELECT u.id , u.username , u.password
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

    public function removeUser($id)
    {
        $this->db->excute("DELETE FROM `user` WHERE id = ?", [$id]);
    }

    public function getUserById($id)
    {
        $this->db->excute("SELECT u.id , u.username, u.created_at, u.edited_at FROM `user` u WHERE id = ?",
            [$id]);
        $results = $this->db->fetch();
        $results->created_at = $this->dateTimeDisplay($results->created_at);
        $results->edited_at = $this->dateTimeDisplay($results->edited_at);
        return $results;
    }

    public function getUserByName($name)
    {
        $this->db->excute("SELECT u.id FROM `user` u WHERE u.username = ?",
            [$name]);
        $results = $this->db->fetch();
        return $results;
    }

    public function updateUser(array $data)
    {
        $edited_at = (new \DateTime())->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d H:i:s ');

        return $this->db->excute('UPDATE `user` SET 
                  `username` = ?, `password` = ?, `edited_at` = ?
                  WHERE `id` = ?',
            [$data['username'], $data['password'], $edited_at, $data['id']] );
    }



}