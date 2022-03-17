<?php

namespace App\Model;

use Helper;

class Comment extends BaseModel
{

    public function addComment($params){

        // TO-DO: Sanitize data

        $this->db->query("INSERT INTO `comment` ( `name`, `post_id`, `message`, `is_anonymous`) 
                VALUES (?, ?, ?, ?)",
            [
                $params['name'],
                $params['post_id'],
                $params['message'],
                $params['anonymous'],
            ]
        );

    }




}