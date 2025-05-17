<?php
require 'db.php';
require 'utils.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);

    $errors = [];

    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    if (empty($email) || !validateEmail($email)) {
        $errors[] = "Valid email is required.";
    }

    if (empty($phone) || !validatePhone($phone)) {
        $errors[] = "Valid phone number is required.";
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, phone) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $phone]);

            header('Location: /index.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<?php if (!empty($errors)): ?>
    <div class="error-messages">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post">
    <label>Name: <input type="text" name="name"></label><br>
    <label>Email: <input type="text" name="email"></label><br>
    <label>Phone: <input type="text" name="phone"></label><br>
    <button class="gen-btn" type="submit">Add Contact</button>
</form>

<?php include 'includes/footer.php'; ?>
