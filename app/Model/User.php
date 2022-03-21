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
        return $this->db->excute('INSERT INTO `user` (username, password) 
                            VALUES (?, ?)', [$data['username'], $data['password']]);

    }

    public function login(array $loginData)
    {

        $execRes = $this->db->excute('SELECT u.id , u.username , u.password
                                FROM `user` u
                                WHERE u.username = ?;',
                [$loginData['username']]);

        if($execRes['succeeded']) {
            $result = $this->db->fetch();
            if($result) {
                if (password_verify($loginData['password'], $result->password)) {
                    $execRes['info'] = $result;
                } else {
                    $execRes['succeeded'] = false;
                    $execRes['info'] = 'Incorrect username or password';
                }
                return $execRes;
            }
        }

        return $execRes;

    }

    public function removeUser($id)
    {
        return $this->db->excute("DELETE FROM `user` WHERE id = ?", [$id]);
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
                 `password` = ?, `edited_at` = ?
                  WHERE `id` = ?',
            [$data['password'], $edited_at, $data['id']] );
    }



}