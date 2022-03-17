<?php

namespace App\Model;

use Helper;

class Post extends BaseModel
{

    public function getPostList(){
        $this->db->query("SELECT p.id AS post_id, p.title, p.body, p.created_at AS post_created_at, u.username, u.id AS user_id, IFNULL(COUNT(c.post_id),0) AS comment_count
                                FROM `post` p 
                                LEFT JOIN user u ON p.user_id = u.id 
                                LEFT JOIN comment c ON c.post_id = p.id 
                                GROUP by p.id
                                ORDER BY `post_created_at` DESC;");

        $results = $this->db->fetchList();

        foreach ( $results as $res)
        {
            $res->post_created_at = $this->dateTimeDisplay($res->post_created_at);
        }
        return $results;
    }

    public function getPostById($postId)
    {

//        echo 'postId: ' . $postId . '<br />';
        $this->db->query('SELECT c.message, c.id AS comment_id, c.post_id AS post_id, c.name AS commenter, c.created_at AS comment_created_at, c.is_anonymous
                                FROM comment c
                                WHERE c.post_id = ?
                                ORDER BY c.created_at DESC;', [$postId]);

        $commentResults = $this->db->fetchList();

        $this->db->query('SELECT p.id AS post_id, p.title, p.body, p.created_at AS post_created_at, p.edited_at AS post_edited_at, u.username, u.id AS user_id
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


}