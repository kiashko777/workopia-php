<?php

$config = require basePath('config/db.php');
try {
    $db = new Database($config);
} catch (Exception $e) {
    throw new \RuntimeException ("DB not instantiated: {$e->getMessage()}");
}

$id = $_GET['id'] ?? '';

$params = [
  'id' => $id
];

try {
    $listing = $db->query("SELECT * FROM listings WHERE id=:id", $params)->fetch();
} catch (Exception $e) {
    throw new \RuntimeException ("Query failed to execute: {$e->getMessage()}");
}

loadView('listings/show', [
  'listing' => $listing
]);
