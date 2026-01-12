<?php
require_once "db.php";

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'All fields are required';
    } else {
        try {
            $sql = "INSERT INTO tickets 
                    (`customer_name`, `customer_email`, `subject`, `message`) 
                    VALUES (:name, :email, :subject, :message)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':subject' => $subject,
                ':message' => $message,
            ]);

            header("Location: add_ticket.php?success=1");
            exit;
        } catch (PDOException $e) {
            $error = "Something went wrong";
        }
    }
}
?>

<form method="POST">
    <label>Customer name</label>
    <input type="text" name="name" required><br>

    <label>Customer email</label>
    <input type="email" name="email" required><br>

    <label>Subject</label>
    <input type="text" name="subject" required><br>

    <label>Message</label>
    <textarea name="message" rows="4" required></textarea><br>

    <button type="submit">Submit</button>

    <?php if (isset($_GET['success'])): ?>
        <p style="color:green;">Added successfully!</p>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <a href="view_tickets.php">View data</a>
</form>
