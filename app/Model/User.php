<?php

namespace App\Model;

use DateTimeZone;

class User extends BaseModel
{

    public function getUserList(): array
    {
        $execRes = $this->db->execute("SELECT u.id , u.username, u.created_at, u.edited_at FROM `user` u");
        if(checkExec($execRes)) {
            $results = $this->db->fetchList();
            foreach ( $results as $res) {
                $res->created_at = $this->dateTimeDisplay($res->created_at);
                $res->edited_at = $this->dateTimeDisplay($res->edited_at);
            }
            $execRes['info'] = $results;
        }

        return $execRes;
    }

    public function createUser($data): array
    {
        return $this->db->execute('INSERT INTO `user` (username, password) 
                            VALUES (?, ?)', [$data['username'], $data['password']]);

    }

    public function login(array $loginData): array
    {

        $execRes = $this->db->execute('SELECT u.id , u.username , u.password
                                FROM `user` u
                                WHERE u.username = ?;',
                [$loginData['username']]);

        if(checkExec($execRes)) {
            $result = $this->db->fetch();
            if($result) {
                if (password_verify($loginData['password'], $result->password)) {
                    $execRes['info'] = $result;
                    return $execRes;
                }
            }
        }
        $execRes['succeeded'] = false;
        $execRes['info'] =  'Incorrect username and password combination';;
        return $execRes;

    }

    public function removeUser($id): array
    {
        return $this->db->execute("DELETE FROM `user` WHERE id = ?", [$id]);
    }

    public function getUserById($id)
    {
        $this->db->execute("SELECT u.id , u.username, u.created_at, u.edited_at FROM `user` u WHERE id = ?",
            [$id]);
        $results = $this->db->fetch();
        $results->created_at = $this->dateTimeDisplay($results->created_at);
        $results->edited_at = $this->dateTimeDisplay($results->edited_at);
        return $results;
    }

    public function getUserByName($name): array
    {
        $execRes = $this->db->execute("SELECT u.id FROM `user` u WHERE u.username = ?",
            [$name]);
      if(checkExec($execRes)) {
          if($this->db->fetch()) {
              $execRes['succeeded'] = false;
              $execRes['info'] =  'User already exits';
          }
      }
      return $execRes;
    }

    public function updateUser(array $data): array
    {
        $edited_at = (new \DateTime())->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d H:i:s ');

        return $this->db->execute('UPDATE `user` SET 
                 `password` = ?, `edited_at` = ?
                  WHERE `id` = ?',
            [$data['password'], $edited_at, $data['id']] );
    }



}