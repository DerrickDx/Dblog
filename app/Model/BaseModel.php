<?php

namespace App\Model;

use App\Config\Database;

abstract class BaseModel
{
    public Database $db;

    public function __construct()
    {
//        echo "!!!!!!!!!!!!!!!!!!!!!!AT BaseModel" . "<br />";
        $this->db = new Database;
    }
}