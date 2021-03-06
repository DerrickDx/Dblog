<?php

namespace App\Model;

use DateTimeZone;

class Post extends BaseModel
{

    public function getBLogPostList()
    {
        $this->db->execute("SELECT p.id AS post_id, p.title, p.body, p.created_at AS post_created_at, p.edited_at AS post_edited_at, u.username, u.id AS user_id, IFNULL(COUNT(c.post_id),0) AS comment_count
                                FROM `post` p 
                                LEFT JOIN user u ON p.user_id = u.id 
                                LEFT JOIN (SELECT * from comment WHERE is_approved = 1) c ON c.post_id = p.id 
                                
                                GROUP by p.id
                                ORDER BY `post_created_at` DESC;");

        $results = $this->db->fetchList();

        foreach ( $results as $res)
        {
            $res->post_created_at = $this->dateTimeDisplay($res->post_created_at);
            $res->post_edited_at = $this->dateTimeDisplay($res->post_edited_at);
        }
        return $results;
    }

    public function getBlogPostById($postId)
    {

        $this->db->execute('SELECT c.message, c.id AS comment_id, c.post_id AS post_id, c.name AS commenter, c.created_at AS comment_created_at, c.is_anonymous
                                FROM comment c
                                WHERE c.post_id = ? AND c.is_approved = 1
                                ORDER BY c.created_at DESC;', [$postId]);

        $commentResults = $this->db->fetchList();

        $this->db->execute('SELECT p.id AS post_id, p.title, p.body, p.created_at AS post_created_at, p.edited_at AS post_edited_at, u.username, u.id AS user_id
                                FROM `post` p
                                LEFT JOIN user u ON p.user_id = u.id
                                WHERE p.id = ?;', [$postId]);

        $postResult = $this->db->fetch();

        $postResult->post_created_at = $this->dateTimeDisplay($postResult->post_created_at);
        $postResult->post_edited_at = $this->dateTimeDisplay($postResult->post_edited_at);
        foreach ( $commentResults as $res)
        {
            $res->comment_created_at = $this->dateTimeDisplay($res->comment_created_at);
        }

        return ['post' => $postResult, 'comments' => $commentResults];
    }

    public function getPostList(): array
    {
        $execRes = $this->db->execute("SELECT p.id AS post_id, p.title, p.body, p.created_at AS post_created_at, p.edited_at AS post_edited_at, u.username, u.id AS user_id
                                FROM `post` p 
                                LEFT JOIN user u ON p.user_id = u.id 
                                GROUP by p.id
                                ORDER BY `post_created_at` ASC;");
        if(checkExec($execRes)) {
            $results = $this->db->fetchList();

            foreach ( $results as $res)
            {
                $res->post_created_at = $this->dateTimeDisplay($res->post_created_at);
                $res->post_edited_at = $this->dateTimeDisplay($res->post_edited_at);
            }
            $execRes['info'] = $results;
        }
        return $execRes;
    }

    public function removePost($id): array
    {
        return $this->db->execute("DELETE FROM `post` WHERE id = ?", [$id]);
    }

    public function createPost($data): array
    {
        return $this->db->execute('INSERT INTO `post` (title, body, user_id) 
                            VALUES (?, ?, ?)', [$data['title'], $data['body'], $data['user_id']]);
    }

    public function updatePost($data): array
    {
        $edited_at = (new \DateTime())->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d H:i:s ');
        return $this->db->execute('UPDATE `post` SET 
                  `title` = ?, `body` = ?, `edited_at` = ?, `user_id` = ?
                  WHERE `id` = ?',
            [$data['title'], $data['body'], $edited_at, $data['user_id'], $data['id']] );
    }

    public function getPostById($id)
    {
        $this->db->execute("SELECT p.id , p.title, p.body, p.user_id, p.created_at, p.edited_at FROM `post` p WHERE id = ?",
            [$id]);
        $results = $this->db->fetch();
        $results->created_at = $this->dateTimeDisplay($results->created_at);
        $results->edited_at = $this->dateTimeDisplay($results->edited_at);
        return $results;
    }


}