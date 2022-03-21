<?php

namespace App\Model;

use Helper;

class Comment extends BaseModel
{

    public function addBlogComment($params)
    {
        // TO-DO: Sanitize data
        return $this->db->excute("INSERT INTO `comment` ( `name`, `post_id`, `message`, `is_anonymous`)
                VALUES (?, ?, ?, ?)",
            [
                $params['name'],
                $params['post_id'],
                $params['message'],
                $params['anonymous'],
            ]
        );

    }

    public function getCommentList()
    {
        $this->db->excute("SELECT c.id as comment_id, c.post_id, c.name, c.message, c.created_at, c.is_anonymous, c.is_approved FROM comment c");
        $results = $this->db->fetchList();
        foreach ( $results as $res) {
            $res->created_at = $this->dateTimeDisplay($res->created_at);
        }
        return $results;
    }


    public function removeComment($id){

        return $this->db->excute("DELETE FROM comment WHERE id = ?", [$id]);
    }

    public function removeCommentByPostId($id){

        $this->db->excute("DELETE FROM comment WHERE post_id = ?", [$id]);
    }

    public function updateComment($data)
    {

        return $this->db->excute('UPDATE `comment` SET 
                  `is_approved` = ?
                  WHERE `id` = ?',
            [$data['is_approved'], $data['id']] );
    }


}