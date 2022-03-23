<?php

namespace App\Model;

use App\App;
use App\Config\Database;

class BaseModel
{
    public Database $db;

    public function __construct()
    {
         $this->db = App::db();
    }

    // Convert UTC to Adelaide time for display purposes
    public function dateTimeDisplay($attr): ?string
    {
        return is_null($attr) ?  $attr : date(DATE_TIME_FORMAT, strtotime($attr . ' UTC'));
    }


}