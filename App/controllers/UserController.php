<?php

namespace App\controllers;

use Exception;
use Framework\Database;
use Framework\Validation;

class UserController
{
    protected Database $db;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    /**
     * Show the login form
     * @return void
     */

    public function login(): void
    {
        loadView('users/login');
    }

    /**
     * Show the register form
     * @return void
     */

    public function create(): void
    {
        loadView('users/create');
    }

}