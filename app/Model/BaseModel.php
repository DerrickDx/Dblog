<?php

namespace App\Model;

use App\Config\Database;

abstract class BaseModel
{
    public Database $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function dateTimeDisplay($attr)
    {
        return is_null($attr) ?  $attr : date(DATE_TIME_FORMAT, strtotime($attr . ' UTC'));
    }
}