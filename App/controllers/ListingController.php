<?php

namespace App\controllers;

use Exception;
use Framework\Database;

class ListingController
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
            $listings = $this->db->query('SELECT * FROM listings')->fetchAll();
        } catch (Exception $e) {
            throw new \RuntimeException ("Query failed to execute: {$e->getMessage()}");
        }

        loadView('listings/index', [
          'listings' => $listings
        ]);
    }

    public function create(): void
    {
        loadView('listings/create');
    }

    public function show($params): void
    {
        $id = $params['id'] ?? '';

        $params = [
          'id' => $id
        ];

        try {
            $listing = $this->db->query("SELECT * FROM listings WHERE id=:id", $params)->fetch();
            if (!$listing) {
                ErrorController::notFound('Listing not found!');
                return;
            }
        } catch (Exception $e) {
            throw new \RuntimeException ("Query failed to execute: {$e->getMessage()}");
        }

        loadView('listings/show', [
          'listing' => $listing
        ]);
    }
}