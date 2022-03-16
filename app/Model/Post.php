<?php

namespace App\Model;

class Post extends BaseModel
{

    public function getPostList(){
        $this->db->query("SELECT p.id AS post_id, p.title, p.body, p.created_at AS post_created_at, u.username, u.id AS user_id, IFNULL(SUM(c.post_id),0) AS comment_count
                                FROM `post` p 
                                LEFT JOIN user u ON p.user_id = u.id 
                                LEFT JOIN comment c ON c.post_id = p.id 
                                GROUP by p.id
                                ORDER BY `post_id` ASC;");

        $results = $this->db->fetchList();

        return $results;
    }

    public function getPostById($postId)
    {

//        echo 'postId: ' . $postId . '<br />';
        $this->db->query('SELECT c.message, c.id AS comment_id, c.post_id AS post_id, u.username AS commenter, c.created_at AS comment_created_at, c.is_anonymous
                                FROM comment c
                                    LEFT JOIN user u ON c.user_id = u.id
                                WHERE c.post_id = ?
                                ORDER BY c.id ASC;', [$postId]);

        $commentResults = $this->db->fetchList();

        $this->db->query('SELECT p.id AS post_id, p.title, p.body, p.created_at AS post_created_at, p.edited_at AS post_edited_at, u.username, u.id AS user_id
                                FROM `post` p
                                         LEFT JOIN user u ON p.user_id = u.id
                                WHERE p.id = ?
                                ORDER BY `post_id` ASC;', [$postId]);

        $postResult = $this->db->fetch();

        return ['post' => $postResult, 'comments' => $commentResults];
    }


}