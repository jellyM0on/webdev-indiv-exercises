<?php include './includes/header.php'; ?>

<?php
require 'db.php';

$stmt = $pdo->query("SELECT * FROM contacts ORDER BY name ASC");
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($contacts as $contact): ?>
    <tr>
        <td><?= htmlspecialchars($contact['name']) ?></td>
        <td><?= htmlspecialchars($contact['email']) ?></td>
        <td><?= htmlspecialchars($contact['phone']) ?></td>
        <td>
            <a href="/edit.php?id=<?= $contact['id'] ?>">
                <button class="gen-btn">Edit</button>
            </a>
            <a href="/delete.php?id=<?= $contact['id'] ?>" onclick="return confirm('Are you sure?')">
                <button class="delete-btn">Delete</button>
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>


<?php include './includes/footer.php'; ?>