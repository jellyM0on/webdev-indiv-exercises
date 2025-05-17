<?php

require 'db.php';

$migrationDir = __DIR__ . '/migrations/';
$files = scandir($migrationDir);

foreach ($files as $file) {
    if (substr($file, -4) === '.php') {
        $migration = include $migrationDir . $file;
        if (is_callable($migration)) {
            echo "Running migration: $file...\n";
            try {
                $migration($pdo);
                echo "Migration $file applied successfully.\n";
            } catch (PDOException $e) {
                echo "Error applying migration $file: " . $e->getMessage() . "\n";
            }
        }
    }
}

echo "All migrations applied.\n";
