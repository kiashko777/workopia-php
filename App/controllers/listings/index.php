<?php

use Framework\Database;

$config = require basePath('config/db.php');
try {
    $db = new Database($config);
} catch (Exception $e) {
    throw new \RuntimeException ("DB not instantiated: {$e->getMessage()}");
}
try {
    $listings = $db->query('SELECT * FROM listings LIMIT 6')->fetchAll();
} catch (Exception $e) {
    throw new \RuntimeException ("Query failed to execute: {$e->getMessage()}");
}


loadView('listings/index', [
  'listings' => $listings
]);
