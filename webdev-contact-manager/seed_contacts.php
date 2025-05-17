<?php

require 'db.php';

$contacts = [
    ['name' => 'John Doe', 'email' => 'john@example.com', 'phone' => '123-456-7890'],
    ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'phone' => '987-654-3210'],
    ['name' => 'Alice Johnson', 'email' => 'alice@example.com', 'phone' => '555-123-4567'],
    ['name' => 'Bob Williams', 'email' => 'bob@example.com', 'phone' => '222-333-4444'],
    ['name' => 'Charlie Brown', 'email' => 'charlie@example.com', 'phone' => '777-888-9999'],
];

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO contacts (name, email, phone) VALUES (?, ?, ?)");

    foreach ($contacts as $contact) {
        $stmt->execute([$contact['name'], $contact['email'], $contact['phone']]);
        echo "Inserted: {$contact['name']} ({$contact['email']})\n";
    }

    $pdo->commit();
    echo "Seeding completed successfully.\n";

} catch (PDOException $e) {
    $pdo->rollBack();
    echo "Error seeding data: " . $e->getMessage() . "\n";
}
