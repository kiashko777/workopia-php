<?php

namespace App\controllers;

use Exception;
use Framework\Database;

class HomeController
{
    protected Database $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        try {
            $this->db = new Database($config);
        } catch (Exception $e) {
            throw new \RuntimeException ("DB not instantiated: {$e->getMessage()}");
        }
    }

    public function index(): void
    {
        try {
            $listings = $this->db->query('SELECT * FROM listings ORDER BY created_at DESC LIMIT 6')->fetchAll();
        } catch (Exception $e) {
            throw new \RuntimeException ("Query failed to execute: {$e->getMessage()}");
        }

        loadView('home', [
          'listings' => $listings
        ]);
    }
}