<?php

namespace App\Model;

class Comment extends BaseModel
{

    public function addBlogComment($params): array
    {
        return $this->db->execute("INSERT INTO `comment` ( `name`, `post_id`, `message`, `is_anonymous`)
                VALUES (?, ?, ?, ?)",
            [
                $params['name'],
                $params['post_id'],
                $params['message'],
                $params['anonymous'],
            ]
        );

    }

    public function getCommentList(): array
    {
        $execRes = $this->db->execute("SELECT c.id as comment_id, c.post_id, c.name, c.message, c.created_at, c.is_anonymous, c.is_approved FROM comment c");
        if(checkExec($execRes)) {
            $results = $this->db->fetchList();
            foreach ($results as $res) {
                $res->created_at = $this->dateTimeDisplay($res->created_at);
            }
            $execRes['info'] = $results;
        }

        return $execRes;
    }


    public function removeComment($id): array
    {

        return $this->db->execute("DELETE FROM comment WHERE id = ?", [$id]);
    }

    public function removeCommentByPostId($id){

        $this->db->execute("DELETE FROM comment WHERE post_id = ?", [$id]);
    }

    public function updateComment($data): array
    {

        return $this->db->execute('UPDATE `comment` SET 
                  `is_approved` = ?
                  WHERE `id` = ?',
            [$data['is_approved'], $data['id']] );
    }


}