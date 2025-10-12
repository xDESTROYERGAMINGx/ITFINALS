<?php

namespace app\Controllers;

use config\DBConnection;
use app\Models\SubjectAllocationModel;

class SubjectAllocationController
{
    private $SubjectAllocationModel;

    public function __construct()
    {
        $db = new DBConnection();
        $this->SubjectAllocationModel = new SubjectAllocationModel($db);
    }
    
    // Add your custom controllers below to handle business logic.
}