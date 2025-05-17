<?php
require 'db.php';
require 'utils.php';


$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
$stmt->execute([$id]);
$contact = $stmt->fetch(PDO::FETCH_ASSOC);

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
            $stmt = $pdo->prepare("UPDATE contacts SET name = ?, email = ?, phone = ? WHERE id = ?");
            $stmt->execute([$name, $email, $phone, $id]);

            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<?php include './includes/header.php'; ?>

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
    <label>Name: <input type="text" name="name" value="<?= htmlspecialchars($contact['name']) ?>"></label><br>
    <label>Email: <input type="text" name="email" value="<?= htmlspecialchars($contact['email']) ?>"></label><br>
    <label>Phone: <input type="text" name="phone" value="<?= htmlspecialchars($contact['phone']) ?>"></label><br>
    <button class="gen-btn" type="submit">Update Contact</button>
</form>

<?php include './includes/footer.php'; ?>