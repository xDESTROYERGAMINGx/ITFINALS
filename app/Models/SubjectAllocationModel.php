<?php

namespace app\Models;

use config\DBConnection;
use PDO;

class SubjectAllocationModel
{
    private $db;

    public function __construct(DBConnection $db)
    {
        $this->db = $db->getConnection();
    }
    
    // Add your custom methods below to interact with the database.
}